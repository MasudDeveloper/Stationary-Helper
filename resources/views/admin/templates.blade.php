@extends('layouts.admin')

@section('title', 'অ্যাডমিন - টেমপ্লেট ম্যানেজমেন্ট')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <h2 style="color: var(--primary-color); margin-bottom: 20px;">টেমপ্লেট ম্যানেজমেন্ট</h2>

    @if (session('success'))
        <div style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #10b981; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; gap: 40px; flex-wrap: wrap;">
        
        <!-- Add Template Form -->
        <div class="glass" style="flex: 1; min-width: 300px; padding: 30px; height: fit-content;">
            <h3 style="margin-bottom: 20px;">নতুন টেমপ্লেট যোগ করুন</h3>
            
            <form action="{{ route('admin.templates.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">টেমপ্লেটের নাম <span style="color:red">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="যেমন: সাধারণ সিভি, নোটিশ" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">ধরন (Type) <span style="color:red">*</span></label>
                    <select name="type" class="form-control" required>
                        <option value="document">Document (সাধারণ ডকুমেন্ট)</option>
                        <option value="cv">CV (জীবনবৃত্তান্ত)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">টেমপ্লেট কন্টেন্ট (HTML) <span style="color:red">*</span></label>
                    <textarea name="content" class="form-control" rows="8" placeholder="এখানে HTML কন্টেন্ট দিন..." required></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">টেমপ্লেট সেভ করুন</button>
            </form>
        </div>

        <!-- Template List -->
        <div class="glass" style="flex: 2; min-width: 400px; padding: 30px;">
            <h3 style="margin-bottom: 20px;">বিদ্যমান টেমপ্লেটসমূহ</h3>
            
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <th style="padding: 15px;">নাম</th>
                        <th style="padding: 15px;">ধরন</th>
                        <th style="padding: 15px;">তৈরির তারিখ</th>
                        <th style="padding: 15px;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($templates as $template)
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 15px; color: var(--text-main); font-weight: 500;">{{ $template->name }}</td>
                        <td style="padding: 15px;">
                            <span style="background: rgba(245, 158, 11, 0.2); color: var(--primary-color); padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold; text-transform: uppercase;">
                                {{ $template->type }}
                            </span>
                        </td>
                        <td style="padding: 15px;">{{ $template->created_at->format('d M, Y') }}</td>
                        <td style="padding: 15px;">
                            <form action="{{ route('admin.templates.delete', $template->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত?');">
                                @csrf
                                <button type="submit" style="background: #ef4444; color: #fff; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer;">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding: 30px; text-align: center; color: var(--text-muted);">কোনো টেমপ্লেট নেই।</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
