@extends('layouts.admin')

@section('title', 'অ্যাডমিন চ্যাট - সহজ কাজ')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px; max-width: 800px;">
    <div class="glass" style="padding: 30px; border-radius: 16px; border-top: 4px solid #818cf8;">
        <!-- Ticket Header -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 20px;">
            <div>
                <h2 style="color: #fff; margin-bottom: 10px; font-weight: 700;">অ্যাডমিন কন্ট্রোল - {{ $ticket->title }}</h2>
                <p style="color: var(--text-muted); font-size: 0.95rem;">
                    ইউজার: <strong style="color: #e2e8f0;">{{ $ticket->user->name }} ({{ $ticket->user->email }})</strong> | 
                    ক্যাটাগরি: <strong style="color: #cbd5e1;">{{ $ticket->category == 'hiring' ? 'পার্সোনাল হায়ার' : 'হেল্প ও সাপোর্ট' }}</strong>
                </p>
                <div style="margin-top: 15px; background: rgba(0,0,0,0.2); padding: 15px; border-radius: 12px; border-left: 4px solid #818cf8; color: #e2e8f0; font-size: 1.05rem; line-height: 1.6;">
                    {{ $ticket->description }}
                </div>
            </div>
            <div style="text-align: right;">
                <div style="margin-bottom: 15px;">
                    @if ($ticket->status == 'open')
                        <span style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; padding: 6px 15px; border-radius: 20px; font-weight: 700; font-size: 0.85rem; border: 1px solid rgba(245, 158, 11, 0.4);">Open</span>
                    @elseif ($ticket->status == 'in_progress')
                        <span style="background: rgba(59, 130, 246, 0.2); color: #60a5fa; padding: 6px 15px; border-radius: 20px; font-weight: 700; font-size: 0.85rem; border: 1px solid rgba(59, 130, 246, 0.4);">In Progress</span>
                    @else
                        <span style="background: rgba(16, 185, 129, 0.2); color: #34d399; padding: 6px 15px; border-radius: 20px; font-weight: 700; font-size: 0.85rem; border: 1px solid rgba(16, 185, 129, 0.4);">Closed</span>
                    @endif
                </div>
                @if ($ticket->status !== 'closed')
                <form action="{{ route('tickets.close', $ticket->id) }}" method="POST" onsubmit="return confirm('টিকিটটি কি ক্লোজ করতে চান?');">
                    @csrf
                    <button type="submit" class="btn" style="background: rgba(239, 68, 68, 0.1); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3); padding: 6px 15px; font-size: 0.85rem; border-radius: 8px; font-weight: 600;">টিকিট ক্লোজ করুন</button>
                </form>
                @endif
            </div>
        </div>

        <!-- Chat / Message History -->
        <h3 style="margin-bottom: 20px; color: #fff; font-weight: 700;">বার্তা চালাচালি</h3>
        
        <div id="chat-box" style="background: rgba(0, 0, 0, 0.2); border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; height: 400px; overflow-y: auto; padding: 25px; display: flex; flex-direction: column; gap: 20px; margin-bottom: 25px;">
            @forelse ($ticket->messages as $msg)
                <div style="max-width: 80%; padding: 15px; border-radius: 16px; line-height: 1.6; position: relative;
                    {{ $msg->sender_id === Auth::id() ? 'align-self: flex-end; background: linear-gradient(135deg, #818cf8, #c084fc); color: #fff; border-bottom-right-radius: 4px; box-shadow: 0 4px 15px rgba(129, 140, 248, 0.2);' : 'align-self: flex-start; background: rgba(255,255,255,0.05); color: #e2e8f0; border: 1px solid rgba(255,255,255,0.1); border-bottom-left-radius: 4px;' }}">
                    <div style="font-size: 0.85rem; font-weight: 700; margin-bottom: 8px; opacity: 0.9; display: flex; align-items: center; gap: 5px;">
                        <i class="material-icons-round" style="font-size: 16px;">person</i>
                        {{ $msg->sender->name }} ({{ $msg->sender->role }})
                    </div>
                    <div style="font-size: 1.05rem;">{{ $msg->message }}</div>
                    <div style="font-size: 0.75rem; text-align: right; margin-top: 8px; opacity: 0.7;">
                        {{ $msg->created_at->format('h:i A') }}
                    </div>
                </div>
            @empty
                <div style="text-align: center; margin-top: 150px; color: var(--text-muted);">
                    <i class="material-icons-round" style="font-size: 48px; opacity: 0.3; margin-bottom: 10px;">chat_bubble_outline</i>
                    <p>এখানে মেসেজ লিখে চ্যাট শুরু করুন।</p>
                </div>
            @endforelse
        </div>

        <!-- Reply Form -->
        @if ($ticket->status !== 'closed')
        <form action="{{ route('tickets.message', $ticket->id) }}" method="POST">
            @csrf
            <div style="display: flex; gap: 10px; background: rgba(0,0,0,0.2); padding: 10px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
                <input type="text" id="chat-input" name="message" class="form-control" placeholder="আপনার বার্তা এখানে লিখুন..." required autocomplete="off" style="flex: 1; background: transparent; border: none; color: #fff; padding: 12px; box-shadow: none;">
                <button type="submit" class="btn" style="background: linear-gradient(135deg, #818cf8, #c084fc); color: #fff; font-weight: 600; border: none; border-radius: 8px; padding: 10px 25px; box-shadow: 0 4px 15px rgba(129, 140, 248, 0.3);">পাঠান</button>
            </div>
        </form>
        @else
        <div style="text-align: center; color: var(--text-muted); padding: 15px; background: rgba(0,0,0,0.1); border-radius: 8px;">
            এই টিকিটটি ক্লোজ করা হয়েছে।
        </div>
        @endif
    </div>
</div>

<script>
    // Scroll chat box to bottom
    const chatBox = document.getElementById('chat-box');
    chatBox.scrollTop = chatBox.scrollHeight;

    // Simulate real-time by polling/reloading page every 7 seconds
    // Only reload if user is not actively typing in the chat input
    const chatInput = document.getElementById('chat-input');
    
    if (chatInput) {
        setInterval(() => {
            if (document.activeElement !== chatInput && chatInput.value === "") {
                window.location.reload();
            }
        }, 7000);
    }
</script>
@endsection
