@extends('layouts.app')

@section('title', 'চ্যাটরুম - সহজ কাজ')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px; max-width: 800px;">
    <div class="glass" style="padding: 30px;">
        <!-- Ticket Header -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px; border-bottom: 1px solid var(--border-color); padding-bottom: 20px;">
            <div>
                <h2 style="color: var(--text-main); margin-bottom: 10px;">{{ $ticket->title }}</h2>
                <p style="color: var(--text-muted); font-size: 0.95rem;">
                    ক্যাটাগরি: <strong>{{ $ticket->category == 'hiring' ? 'পার্সোনাল হায়ার' : 'হেল্প ও সাপোর্ট' }}</strong> | 
                    তারিখ: {{ $ticket->created_at->format('d M, Y h:i A') }}
                </p>
                <div style="margin-top: 15px; background: rgba(0,0,0,0.1); padding: 15px; border-radius: 8px; border-left: 3px solid var(--primary-color);">
                    {{ $ticket->description }}
                </div>
            </div>
            <div style="text-align: right;">
                <div style="margin-bottom: 15px;">
                    @if ($ticket->status == 'open')
                        <span style="background: #f59e0b; color: #000; padding: 6px 12px; border-radius: 4px; font-weight: bold; font-size: 0.85rem;">Open</span>
                    @elseif ($ticket->status == 'in_progress')
                        <span style="background: #3b82f6; color: #fff; padding: 6px 12px; border-radius: 4px; font-weight: bold; font-size: 0.85rem;">In Progress</span>
                    @else
                        <span style="background: #10b981; color: #fff; padding: 6px 12px; border-radius: 4px; font-weight: bold; font-size: 0.85rem;">Closed</span>
                    @endif
                </div>
                @if ($ticket->status !== 'closed')
                <form action="{{ route('tickets.close', $ticket->id) }}" method="POST" onsubmit="return confirm('টিকিটটি কি ক্লোজ করতে চান?');">
                    @csrf
                    <button type="submit" class="btn" style="background: rgba(239, 68, 68, 0.2); color: #ef4444; border: 1px solid #ef4444; padding: 6px 12px; font-size: 0.85rem;">টিকিট ক্লোজ করুন</button>
                </form>
                @endif
            </div>
        </div>

        <!-- Chat / Message History -->
        <h3 style="margin-bottom: 15px; color: var(--primary-color);">মেসেজ হিস্টোরি</h3>
        
        <div id="chat-box" style="background: rgba(0, 0, 0, 0.2); border: 1px solid var(--border-color); border-radius: 8px; height: 350px; overflow-y: auto; padding: 20px; display: flex; flex-direction: column; gap: 15px; margin-bottom: 25px;">
            @forelse ($ticket->messages as $msg)
                <div style="max-width: 75%; padding: 12px 16px; border-radius: 12px; line-height: 1.5; 
                    {{ $msg->sender_id === Auth::id() ? 'align-self: flex-end; background: var(--primary-color); color: #000;' : 'align-self: flex-start; background: rgba(255,255,255,0.05); color: var(--text-main); border: 1px solid var(--border-color);' }}">
                    <div style="font-size: 0.8rem; font-weight: bold; margin-bottom: 5px; opacity: 0.7;">
                        {{ $msg->sender->name }} ({{ $msg->sender->role }})
                    </div>
                    <div>{{ $msg->message }}</div>
                    <div style="font-size: 0.7rem; text-align: right; margin-top: 5px; opacity: 0.6;">
                        {{ $msg->created_at->format('h:i A') }}
                    </div>
                </div>
            @empty
                <p style="text-align: center; color: var(--text-muted); margin-top: 150px;">এখানে মেসেজ লিখে চ্যাট শুরু করুন।</p>
            @endforelse
        </div>

        <!-- Reply Form -->
        @if ($ticket->status !== 'closed')
        <form action="{{ route('tickets.message', $ticket->id) }}" method="POST">
            @csrf
            <div style="display: flex; gap: 10px;">
                <input type="text" id="chat-input" name="message" class="form-control" placeholder="আপনার বার্তা এখানে লিখুন..." required autocomplete="off" style="flex: 1;">
                <button type="submit" class="btn btn-primary">পাঠান</button>
            </div>
        </form>
        @else
        <div style="text-align: center; color: var(--text-muted); padding: 15px; background: rgba(0,0,0,0.1); border-radius: 8px;">
            এই টিকিটটি ক্লোজ করা হয়েছে। চ্যাট করতে নতুন একটি টিকিট তৈরি করুন।
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
