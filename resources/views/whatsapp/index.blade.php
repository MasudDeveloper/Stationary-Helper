@extends('layouts.app')

@section('title', 'WhatsApp Device Linking')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="glass p-5 text-center">
                <h2 style="color: var(--primary-color); margin-bottom: 30px;"><i class="material-icons-round" style="font-size: 2.5rem; vertical-align: middle;">whatsapp</i> WhatsApp কানেক্ট করুন</h2>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if($status === 'CONNECTED')
                    <div class="mb-4">
                        <i class="material-icons-round" style="font-size: 5rem; color: #10b981;">check_circle</i>
                        <h3 class="mt-3 text-success">WhatsApp সংযুক্ত আছে!</h3>
                        <p class="text-light mt-2" style="font-size: 1.1rem;">অ্যাকাউন্টের নাম: <strong>{{ $pushname }}</strong></p>
                        <p class="text-muted">আপনার WhatsApp থেকে এখন সরাসরি কাস্টমারকে ডকুমেন্ট এবং মেসেজ পাঠানো যাবে।</p>
                    </div>
                    <form action="{{ route('whatsapp.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger px-4 py-2" onclick="return confirm('আপনি কি নিশ্চিত যে আপনি WhatsApp ডিসকানেক্ট করতে চান?');">
                            <i class="material-icons-round" style="vertical-align: middle;">logout</i> ডিসকানেক্ট করুন
                        </button>
                    </form>
                @elseif($status === 'SERVER_OFFLINE')
                    <div class="mb-4">
                        <i class="material-icons-round" style="font-size: 5rem; color: #ef4444;">error</i>
                        <h3 class="mt-3 text-danger">সার্ভার অফলাইন!</h3>
                        <p class="text-light mt-2">বর্তমানে WhatsApp সার্ভারটি বন্ধ আছে। দয়া করে অ্যাডমিনের সাথে যোগাযোগ করুন।</p>
                    </div>
                @else
                    <div id="qr-container" style="display: none; background: #fff; padding: 20px; border-radius: 10px; width: fit-content; margin: 0 auto 30px;">
                        <img id="qr-image" src="" alt="QR Code" style="width: 250px; height: 250px;">
                    </div>
                    
                    <div id="loading-container" class="mb-4">
                        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
                        <p class="text-light mt-3">QR Code জেনারেট হচ্ছে... অনুগ্রহ করে অপেক্ষা করুন।</p>
                    </div>

                    <div id="instructions" style="text-align: left; background: rgba(0,0,0,0.2); padding: 20px; border-radius: 10px; margin-top: 30px;">
                        <h4 class="mb-3" style="color: #6366f1;">কীভাবে স্ক্যান করবেন?</h4>
                        <ol style="color: #ddd; line-height: 1.8; font-size: 1.1rem;">
                            <li>আপনার মোবাইলে <strong>WhatsApp</strong> ওপেন করুন।</li>
                            <li>উপরে ডানদিকে থাকা <strong>মেনু (⋮)</strong> অথবা সেটিংসে (⚙️) ট্যাপ করুন।</li>
                            <li><strong>Linked devices</strong> অপশনটি নির্বাচন করুন।</li>
                            <li><strong>Link a device</strong> বাটনে ক্লিক করে উপরের QR Code টি স্ক্যান করুন।</li>
                        </ol>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($status !== 'CONNECTED' && $status !== 'SERVER_OFFLINE')
<!-- Socket.IO for Real-time QR updates -->
<script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isLocal = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';
        const serverUrl = isLocal ? 'http://localhost:3001' : `${window.location.protocol}//whatsapp.${window.location.hostname.replace(/^www\./, '')}`;
        const socket = io(serverUrl);
        const userId = '{{ $userId }}';

        socket.on('connect', () => {
            console.log('Connected to WhatsApp Node Server');
            socket.emit('create_session', { userId: userId });
        });

        socket.on('qr', (data) => {
            if (data.userId === userId) {
                document.getElementById('loading-container').style.display = 'none';
                document.getElementById('qr-container').style.display = 'block';
                document.getElementById('qr-image').src = data.qr;
            }
        });

        socket.on('ready', (data) => {
            if (data.userId === userId) {
                Swal.fire({
                    title: 'সফল!',
                    text: 'আপনার WhatsApp সফলভাবে কানেক্ট হয়েছে।',
                    icon: 'success'
                }).then(() => {
                    window.location.reload();
                });
            }
        });

        socket.on('authenticated', (data) => {
            if (data.userId === userId) {
                document.getElementById('loading-container').innerHTML = '<div class="spinner-border text-success" role="status"></div><p class="text-success mt-2">অ্যাপ্রুভ করা হচ্ছে...</p>';
                document.getElementById('qr-container').style.display = 'none';
            }
        });

        socket.on('connect_error', (err) => {
            console.error('Socket connection error:', err);
            document.getElementById('loading-container').innerHTML = `<div class="alert alert-danger" style="max-width: 550px; margin: 0 auto;"><i class="material-icons-round" style="vertical-align: middle;">error</i> <strong>সার্ভার কানেকশন এরর:</strong> হোয়াটসঅ্যাপ সার্ভারে কানেক্ট করা যাচ্ছে না (${err.message})। আপনার হোস্টিং থেকে Node.js সার্ভারটি চালু আছে কিনা এবং <code>${serverUrl}</code> ইউআরএলটি ঠিকমতো কাজ করছে কিনা নিশ্চিত করুন।</div>`;
        });

        socket.on('qr_error', (data) => {
            if (data.userId === userId) {
                document.getElementById('loading-container').innerHTML = `<div class="alert alert-danger" style="max-width: 550px; margin: 0 auto;"><i class="material-icons-round" style="vertical-align: middle;">error</i> <strong>QR Code জেনারেট সমস্যা:</strong> ${data.error}</div>`;
            }
        });
    });
</script>
@endif

@endsection
