const express = require('express');
const { Client, LocalAuth, MessageMedia } = require('whatsapp-web.js');
const cors = require('cors');
const qrcode = require('qrcode');
const http = require('http');
const { Server } = require('socket.io');

const app = express();
const server = http.createServer(app);
const io = new Server(server, {
    cors: {
        origin: '*',
        methods: ['GET', 'POST']
    }
});

app.use(cors());
app.use(express.json({ limit: '50mb' })); // Support for large base64 attachments

const sessions = {}; // Store WhatsApp clients per user ID

// Socket.io for real-time QR code updates
io.on('connection', (socket) => {
    console.log('A client connected:', socket.id);

    socket.on('create_session', (data) => {
        const { userId } = data;
        socket.join(userId); // Join room for this user
        createSession(userId);
    });

    socket.on('disconnect', () => {
        console.log('Client disconnected:', socket.id);
    });
});

function createSession(userId) {
    if (sessions[userId]) {
        console.log(`Session already exists for user ${userId}`);
        // If it's already authenticated, we should probably emit ready. 
        // But let's just let the /status API handle the initial state on page load.
        return;
    }

    console.log(`Creating session for user ${userId}`);

    const client = new Client({
        authStrategy: new LocalAuth({ clientId: `user_${userId}` }),
        puppeteer: {
            headless: true,
            timeout: 60000, // 60 seconds (double the default)
            protocolTimeout: 60000,
            args: [
                '--no-sandbox',
                '--disable-setuid-sandbox',
                '--disable-dev-shm-usage',
                '--disable-accelerated-2d-canvas',
                '--no-first-run',
                '--no-zygote',
                '--disable-gpu',
                '--single-process', // Extremely important for CloudLinux limits
                '--disable-extensions',
                '--disable-software-rasterizer',
                '--disable-background-networking',
                '--disable-background-timer-throttling',
                '--disable-backgrounding-occluded-windows',
                '--disable-breakpad',
                '--disable-client-side-phishing-detection',
                '--disable-default-apps',
                '--disable-features=TranslateUI,BlinkGenPropertyTrees',
                '--disable-hang-monitor',
                '--disable-ipc-flooding-protection',
                '--disable-prompt-on-repost',
                '--disable-renderer-backgrounding',
                '--disable-sync',
                '--metrics-recording-only',
                '--mute-audio',
                '--safebrowsing-disable-auto-update'
            ]
        }
    });

    client.on('qr', async (qr) => {
        console.log(`QR Code generated for user ${userId}`);
        try {
            const qrDataUrl = await qrcode.toDataURL(qr);
            io.to(userId).emit('qr', { userId, qr: qrDataUrl });
        } catch (err) {
            console.error('Error generating QR code:', err);
        }
    });

    client.on('ready', () => {
        console.log(`Client ready for user ${userId}`);
        io.to(userId).emit('ready', { userId, status: 'CONNECTED' });
    });

    client.on('authenticated', () => {
        console.log(`Client authenticated for user ${userId}`);
        io.to(userId).emit('authenticated', { userId });
    });

    client.on('auth_failure', (msg) => {
        console.error(`Auth failure for user ${userId}:`, msg);
        io.to(userId).emit('auth_failure', { userId, error: msg });
        delete sessions[userId];
    });

    client.on('disconnected', (reason) => {
        console.log(`Client disconnected for user ${userId}:`, reason);
        io.to(userId).emit('disconnected', { userId, reason });
        client.destroy();
        delete sessions[userId];
    });

    sessions[userId] = client;
    client.initialize().catch(err => {
        console.error(`Error initializing client for user ${userId}:`, err);
        io.to(userId).emit('qr_error', { userId, error: 'সার্ভারে ক্রোম/পাপেটিয়ার রান করতে সমস্যা হয়েছে: ' + (err.message || 'Unknown error') });
        delete sessions[userId];
    });
}

// Root check route for cPanel health check
app.get('/', (req, res) => {
    res.status(200).send('WhatsApp Server is Live and Running!');
});

// Check session status API
app.get('/status/:userId', (req, res) => {
    const userId = req.params.userId;
    if (sessions[userId] && sessions[userId].info) {
        res.json({ success: true, status: 'CONNECTED', pushname: sessions[userId].info.pushname, wid: sessions[userId].info.wid });
    } else if (sessions[userId]) {
        res.json({ success: true, status: 'INITIALIZING' });
    } else {
        res.json({ success: true, status: 'DISCONNECTED' });
    }
});

// Logout API
app.post('/logout', async (req, res) => {
    const { userId } = req.body;
    if (sessions[userId]) {
        try {
            await sessions[userId].logout();
            delete sessions[userId];
            res.json({ success: true, message: 'Logged out successfully' });
        } catch (err) {
            res.status(500).json({ success: false, error: err.message });
        }
    } else {
        res.status(404).json({ success: false, error: 'Session not found' });
    }
});

// Send Message API
app.post('/send', async (req, res) => {
    const { userId, phone, message, mediaBase64, mediaMime, mediaName } = req.body;

    if (!userId || !phone) {
        return res.status(400).json({ success: false, error: 'userId and phone are required' });
    }

    if (!sessions[userId] || !sessions[userId].info) {
        return res.status(400).json({ success: false, error: 'User is not connected to WhatsApp' });
    }

    try {
        const client = sessions[userId];
        
        // Format phone number to WhatsApp ID
        let chatId = phone.replace(/[^0-9]/g, '');
        if (chatId.length === 11 && chatId.startsWith('01')) {
            chatId = '88' + chatId; // BD country code
        }
        chatId = `${chatId}@c.us`;

        let mediaMessage = null;
        if (mediaBase64 && mediaMime) {
            mediaMessage = new MessageMedia(mediaMime, mediaBase64, mediaName || 'Document');
        }

        let result;
        if (mediaMessage) {
            result = await client.sendMessage(chatId, mediaMessage, { caption: message });
        } else {
            result = await client.sendMessage(chatId, message);
        }

        res.json({ success: true, messageId: result ? (result.id ? result.id._serialized : 'sent') : 'sent' });
    } catch (err) {
        console.error('Send message error:', err);
        res.status(500).json({ success: false, error: err.message });
    }
});

const PORT = process.env.PORT || 3001;
server.listen(PORT, () => {
    console.log(`WhatsApp Server running on port ${PORT}`);
});
