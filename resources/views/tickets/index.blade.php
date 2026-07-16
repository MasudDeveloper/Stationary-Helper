@extends('layouts.app')

@section('title', 'যোগাযোগ ও পার্সোনাল হায়ার - সহজ কাজ')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <h2 style="color: #fff; margin-bottom: 10px; text-align: center; font-weight: 700;">যোগাযোগ ও পার্সোনাল হায়ার</h2>
    <p style="text-align: center; color: var(--text-muted); margin-bottom: 30px;">হেল্প পোস্ট, টিকিট অথবা পার্সোনাল হায়ার এর জন্য যোগাযোগ করুন</p>

    <div style="display: flex; gap: 30px; flex-wrap: wrap;">
        <!-- Ticket Form -->
        <div class="glass" style="flex: 1; min-width: 320px; padding: 30px; height: fit-content; border-top: 4px solid #818cf8;">
            <h3 style="margin-bottom: 25px; color: #fff; font-weight: 700; font-size: 1.4rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px;">নতুন রিকোয়েস্ট তৈরি করুন</h3>
            
            <form action="{{ route('tickets.store') }}" method="POST">
                @csrf
                <div class="form-group mb-4">
                    <label class="form-label" style="color: #cbd5e1; font-weight: 600;">ক্যাটাগরি <span style="color: #f87171;">*</span></label>
                    <select name="category" class="form-control" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 12px; border-radius: 8px;" required>
                        <option value="help" style="background: #1e293b;">হেল্প ও সাপোর্ট (Help & Support)</option>
                        <option value="hiring" style="background: #1e293b;">পার্সোনাল হায়ার / কাস্টম কাজ (Personal Hiring)</option>
                    </select>
                </div>
                
                <div class="form-group mb-4">
                    <label class="form-label" style="color: #cbd5e1; font-weight: 600;">বিষয় (Subject) <span style="color: #f87171;">*</span></label>
                    <input type="text" name="title" class="form-control" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 12px; border-radius: 8px;" placeholder="রিকোয়েস্টের বিষয়" required>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" style="color: #cbd5e1; font-weight: 600;">বিস্তারিত বিবরণ <span style="color: #f87171;">*</span></label>
                    <textarea name="description" class="form-control" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 12px; border-radius: 8px;" rows="6" placeholder="আপনার সমস্যা বা হায়ার করার কাজের বিবরণ লিখুন..." required></textarea>
                </div>

                <button type="submit" class="btn" style="width: 100%; background: linear-gradient(135deg, #818cf8, #c084fc); color: #fff; font-weight: 700; border: none; border-radius: 8px; padding: 12px; box-shadow: 0 4px 15px rgba(129, 140, 248, 0.3);">রিকোয়েস্ট সাবমিট করুন</button>
            </form>
        </div>

        <!-- Ticket List -->
        <div class="glass" style="flex: 1.5; min-width: 400px; padding: 30px; border-radius: 16px;">
            <h3 style="margin-bottom: 25px; color: #fff; font-weight: 700; font-size: 1.4rem;">আপনার রিকোয়েস্টসমূহ</h3>

            <div style="overflow-y: auto; max-height: 500px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
                <table style="width: 100%; border-collapse: collapse; text-align: left; margin: 0;">
                    <thead style="background: rgba(255,255,255,0.05);">
                        <tr>
                            <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">বিষয়</th>
                            <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">ক্যাটাগরি</th>
                            <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">স্ট্যাটাস</th>
                            <th style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600;">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 15px; color: #fff; font-weight: 600;">{{ $ticket->title }}</td>
                            <td style="padding: 15px;">
                                @if ($ticket->category == 'hiring')
                                    <span style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; border: 1px solid rgba(245, 158, 11, 0.4);">Hiring</span>
                                @else
                                    <span style="background: rgba(59, 130, 246, 0.2); color: #60a5fa; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; border: 1px solid rgba(59, 130, 246, 0.4);">Help</span>
                                @endif
                            </td>
                            <td style="padding: 15px;">
                                @if ($ticket->status == 'open')
                                    <span style="color: #fbbf24; font-weight: 600; display: flex; align-items: center; gap: 5px;"><div style="width: 8px; height: 8px; border-radius: 50%; background: #fbbf24;"></div> Open</span>
                                @elseif ($ticket->status == 'in_progress')
                                    <span style="color: #60a5fa; font-weight: 600; display: flex; align-items: center; gap: 5px;"><div style="width: 8px; height: 8px; border-radius: 50%; background: #60a5fa;"></div> In Progress</span>
                                @else
                                    <span style="color: #34d399; font-weight: 600; display: flex; align-items: center; gap: 5px;"><div style="width: 8px; height: 8px; border-radius: 50%; background: #34d399;"></div> Closed</span>
                                @endif
                            </td>
                            <td style="padding: 15px;">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn" style="background: rgba(99, 102, 241, 0.1); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.3); padding: 6px 15px; font-size: 0.9rem; border-radius: 8px; font-weight: 600;">চ্যাট করুন</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="padding: 40px; text-align: center; color: var(--text-muted);">
                                <div style="font-size: 2rem; margin-bottom: 10px; opacity: 0.5;">💬</div>
                                আপনার কোনো রিকোয়েস্ট টিকিট নেই।
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
