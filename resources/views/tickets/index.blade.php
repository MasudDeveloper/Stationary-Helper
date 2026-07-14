@extends('layouts.app')

@section('title', 'যোগাযোগ ও পার্সোনাল হায়ার - সহজ কাজ')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <h2 style="color: var(--primary-color); margin-bottom: 10px; text-align: center;">যোগাযোগ ও পার্সোনাল হায়ার</h2>
    <p style="text-align: center; color: var(--text-muted); margin-bottom: 30px;">হেল্প পোস্ট, টিকিট অথবা পার্সোনাল হায়ার এর জন্য যোগাযোগ করুন</p>

    <div style="display: flex; gap: 30px; flex-wrap: wrap;">
        <!-- Ticket Form -->
        <div class="glass" style="flex: 1; min-width: 320px; padding: 30px; height: fit-content;">
            <h3 style="margin-bottom: 20px; color: var(--primary-color);">নতুন রিকোয়েস্ট তৈরি করুন</h3>
            
            <form action="{{ route('tickets.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">ক্যাটাগরি <span style="color:red">*</span></label>
                    <select name="category" class="form-control" required>
                        <option value="help">হেল্প ও সাপোর্ট (Help & Support)</option>
                        <option value="hiring">পার্সোনাল হায়ার / কাস্টম কাজ (Personal Hiring)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">বিষয় (Subject) <span style="color:red">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="রিকোয়েস্টের বিষয়" required>
                </div>

                <div class="form-group">
                    <label class="form-label">বিস্তারিত বিবরণ <span style="color:red">*</span></label>
                    <textarea name="description" class="form-control" rows="6" placeholder="আপনার সমস্যা বা হায়ার করার কাজের বিবরণ লিখুন..." required></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">রিকোয়েস্ট সাবমিট করুন</button>
            </form>
        </div>

        <!-- Ticket List -->
        <div class="glass" style="flex: 1.5; min-width: 400px; padding: 30px;">
            <h3 style="margin-bottom: 20px;">আপনার রিকোয়েস্টসমূহ</h3>

            <div style="overflow-y: auto; max-height: 500px;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <th style="padding: 15px;">বিষয়</th>
                            <th style="padding: 15px;">ক্যাটাগরি</th>
                            <th style="padding: 15px;">স্ট্যাটাস</th>
                            <th style="padding: 15px;">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <td style="padding: 15px; color: var(--text-main); font-weight: bold;">{{ $ticket->title }}</td>
                            <td style="padding: 15px;">
                                @if ($ticket->category == 'hiring')
                                    <span style="background: rgba(245, 158, 11, 0.2); color: var(--primary-color); padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">Hiring</span>
                                @else
                                    <span style="background: rgba(59, 130, 246, 0.2); color: #3b82f6; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">Help</span>
                                @endif
                            </td>
                            <td style="padding: 15px;">
                                @if ($ticket->status == 'open')
                                    <span style="color: #f59e0b; font-weight: bold;">Open</span>
                                @elseif ($ticket->status == 'in_progress')
                                    <span style="color: #3b82f6; font-weight: bold;">In Progress</span>
                                @else
                                    <span style="color: #10b981; font-weight: bold;">Closed</span>
                                @endif
                            </td>
                            <td style="padding: 15px;">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn" style="background: rgba(255,255,255,0.05); color: #fff; border: 1px solid var(--border-color); padding: 6px 12px; font-size: 0.9rem;">চ্যাট করুন</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="padding: 30px; text-align: center; color: var(--text-muted);">আপনার কোনো রিকোয়েস্ট টিকিট নেই।</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
