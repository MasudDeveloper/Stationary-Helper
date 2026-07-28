@extends('layouts.admin')

@section('title', 'Add Template - penghor.com')

@section('content')
<!-- TinyMCE CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#templateContent',
        plugins: 'advlist autolink lists link image charmap preview anchor pagebreak',
        toolbar_mode: 'floating',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | pagebreak',
        height: 600,
        content_style: 'body { font-family: "Kalpurush", Arial, sans-serif; font-size: 14px; }',
    });
</script>

<div class="container" style="padding: 20px;">
    <h2>Add New Document Template</h2>
    
    <div class="glass" style="padding: 30px; margin-top: 20px;">
        <form action="{{ route('admin.templates.store') }}" method="POST">
            @csrf
            
            <div class="grid-2" style="margin-bottom: 20px;">
                <div class="form-group">
                    <label class="form-label">Template Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. মুসলিম বিবাহ (নিকাহ) নিবন্ধন" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid-2" style="margin-bottom: 20px;">
                <div class="form-group">
                    <label class="form-label">Language</label>
                    <select name="language" class="form-control" required>
                        <option value="বাংলা">বাংলা</option>
                        <option value="English">English</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Description (Optional)</label>
                    <input type="text" name="description" class="form-control" placeholder="Short description of this template">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label">Template Content (HTML/Rich Text)</label>
                <div style="background: rgba(16, 185, 129, 0.1); padding: 10px; border-radius: 5px; margin-bottom: 15px; color: #10b981;">
                    <strong>Tip:</strong> Use square brackets for variables/fields. For example: <code>[name]</code>, <code>[father-name]</code>, <code>[address]</code>. The system will automatically create an input form for these!
                </div>
                <!-- Need to make text dark for tinymce if we are in dark mode, but tinymce handles its iframe styling. -->
                <textarea id="templateContent" name="content"></textarea>
            </div>

            <hr style="border-top-color: rgba(255,255,255,0.1); margin: 30px 0;">
            <h4 style="margin-bottom: 20px; color: #fff;">Page Settings (For Printing & PDF)</h4>

            <div class="grid-2" style="margin-bottom: 20px;">
                <div class="form-group">
                    <label class="form-label">Page Size</label>
                    <select name="page_size" class="form-control">
                        <option value="a4">A4</option>
                        <option value="legal">Legal</option>
                        <option value="letter">Letter</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Orientation</label>
                    <select name="page_orientation" class="form-control">
                        <option value="portrait">Portrait</option>
                        <option value="landscape">Landscape</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 30px;">
                <div class="form-group">
                    <label class="form-label">Top Margin (mm)</label>
                    <input type="number" name="margin_top" class="form-control" value="10" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Bottom Margin (mm)</label>
                    <input type="number" name="margin_bottom" class="form-control" value="20" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Left Margin (mm)</label>
                    <input type="number" name="margin_left" class="form-control" value="20" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Right Margin (mm)</label>
                    <input type="number" name="margin_right" class="form-control" value="20" required>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 30px;">
                <label class="form-label">Credit Cost</label>
                <input type="number" name="credit_cost" class="form-control" value="5" min="0" style="width: 200px;">
                <small style="color: var(--text-muted); display: block; margin-top: 5px;">কত ক্রেডিট কাটবে প্রতি ডাউনলোডে/প্রিন্টে</small>
            </div>

            <button type="submit" class="btn btn-primary" style="padding: 12px 30px;">Save Template</button>
        </form>
    </div>
</div>
@endsection
