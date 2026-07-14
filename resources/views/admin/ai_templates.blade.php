@extends('layouts.admin')

@section('title', 'অ্যাডমিন - এআই টেমপ্লেট')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <h2 style="color: var(--primary-color); margin-bottom: 25px;">এআই টেমপ্লেট ম্যানেজমেন্ট</h2>

    @if (session('success'))
        <div style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #10b981; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; gap: 30px; flex-wrap: wrap;">
        <!-- Add Template Form -->
        <div class="glass" style="flex: 1.2; min-width: 350px; padding: 30px; height: fit-content;">
            <h3 style="margin-bottom: 20px; color: var(--primary-color);">নতুন টেমপ্লেট যোগ করুন</h3>
            
            <form action="{{ route('admin.ai_templates.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">টেমপ্লেট শিরোনাম <span style="color:red">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="যেমন: Argentina Poster with background" required>
                </div>

                <div class="form-group">
                    <label class="form-label">ক্যাটাগরি <span style="color:red">*</span></label>
                    <select name="category" class="form-control" required>
                        <option value="world_cup">ফুটবল বিশ্বকাপ ২০২৬</option>
                        <option value="creative">ক্রিয়েটিভ ফটোস</option>
                        <option value="restore">ফটো পুনরুদ্ধার</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">ব্যানার টেমপ্লেট ব্যাকগ্রাউন্ড ইমেজ (Thumbnail) <span style="color:red">*</span></label>
                    <input type="file" name="thumbnail" class="form-control" accept="image/*" required>
                </div>

                <!-- Custom Fields Selector -->
                <div style="margin-bottom: 25px; background: rgba(0,0,0,0.1); padding: 15px; border-radius: 8px; border: 1px solid var(--border-color);">
                    <h4 style="margin-bottom: 15px; color: var(--text-main);">কাস্টম ইনপুট কনফিগারেশন</h4>
                    
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <label class="radio-container">
                            <input type="checkbox" name="field_name" checked> নাম ইনপুট (User Name)
                        </label>
                        <label class="radio-container">
                            <input type="checkbox" name="field_number" checked> জার্সি নম্বর ইনপুট (Jersey Number)
                        </label>
                        <label class="radio-container">
                            <input type="checkbox" name="field_photo" checked> ইউজার ছবি ইনপুট (User Photo Overlay)
                        </label>
                    </div>
                </div>

                <!-- Overlay Settings -->
                <div style="margin-bottom: 25px; background: rgba(0,0,0,0.1); padding: 15px; border-radius: 8px; border: 1px solid var(--border-color);">
                    <h4 style="margin-bottom: 15px; color: var(--text-main);">পজিশন ও কোঅর্ডিনেটস (X, Y)</h4>
                    
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div>
                            <label class="form-label" style="font-size: 0.8rem;">ইউজার ছবি (Photo Offset & Size)</label>
                            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 8px;">
                                <input type="number" name="photo_x" class="form-control" value="150" placeholder="X" title="X Position">
                                <input type="number" name="photo_y" class="form-control" value="200" placeholder="Y" title="Y Position">
                                <input type="number" name="photo_w" class="form-control" value="180" placeholder="W" title="Width">
                                <input type="number" name="photo_h" class="form-control" value="220" placeholder="H" title="Height">
                            </div>
                        </div>

                        <div>
                            <label class="form-label" style="font-size: 0.8rem;">ইউজার নাম (Name Offset, Size & Color)</label>
                            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 8px;">
                                <input type="number" name="name_x" class="form-control" value="200" placeholder="X" title="X Position">
                                <input type="number" name="name_y" class="form-control" value="500" placeholder="Y" title="Y Position">
                                <input type="number" name="name_size" class="form-control" value="36" placeholder="Size" title="Font Size">
                                <input type="text" name="name_color" class="form-control" value="#ffffff" placeholder="Color" title="Hex Color">
                            </div>
                        </div>

                        <div>
                            <label class="form-label" style="font-size: 0.8rem;">জার্সি নম্বর (Number Offset, Size & Color)</label>
                            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 8px;">
                                <input type="number" name="number_x" class="form-control" value="200" placeholder="X" title="X Position">
                                <input type="number" name="number_y" class="form-control" value="420" placeholder="Y" title="Y Position">
                                <input type="number" name="number_size" class="form-control" value="72" placeholder="Size" title="Font Size">
                                <input type="text" name="number_color" class="form-control" value="#f59e0b" placeholder="Color" title="Hex Color">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="radio-container">
                        <input type="checkbox" name="is_premium" value="1" checked> এটি প্রিমিয়াম টেমপ্লেট
                    </label>
                </div>

                <div class="form-group">
                    <label class="form-label">ক্রেডিট খরচ (Credits Cost)</label>
                    <input type="number" step="0.01" name="credits_cost" class="form-control" value="5.00">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">টেমপ্লেট আপলোড করুন</button>
            </form>
        </div>

        <!-- List existing templates -->
        <div class="glass" style="flex: 1.5; min-width: 400px; padding: 30px;">
            <h3 style="margin-bottom: 20px;">বিদ্যমান টেমপ্লেটসমূহ</h3>
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <th style="padding: 15px;">থাম্বনেইল</th>
                            <th style="padding: 15px;">শিরোনাম</th>
                            <th style="padding: 15px;">ক্যাটাগরি</th>
                            <th style="padding: 15px;">খরচ</th>
                            <th style="padding: 15px;">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($templates as $tmpl)
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <td style="padding: 15px;">
                                <img src="{{ $tmpl->thumbnail_path }}" alt="Thumbnail" style="max-height: 50px; border-radius: 4px; border: 1px solid var(--border-color);">
                            </td>
                            <td style="padding: 15px; color: var(--text-main); font-weight: bold;">{{ $tmpl->title }}</td>
                            <td style="padding: 15px; text-transform: uppercase; font-size: 0.85rem;">{{ $tmpl->category }}</td>
                            <td style="padding: 15px; font-weight: bold; color: var(--primary-color);">
                                {{ $tmpl->is_premium ? '৳' . number_format($tmpl->credits_cost, 2) . ' Cr' : 'ফ্রি' }}
                            </td>
                            <td style="padding: 15px;">
                                <form action="{{ route('admin.ai_templates.delete', $tmpl->id) }}" method="POST" onsubmit="return confirm('টেমপ্লেটটি মুছে ফেলতে চান?');">
                                    @csrf
                                    <button type="submit" style="background: transparent; border: none; color: #ef4444; cursor: pointer;">মুছুন</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="padding: 30px; text-align: center; color: var(--text-muted);">কোনো টেমপ্লেট পাওয়া যায়নি।</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
