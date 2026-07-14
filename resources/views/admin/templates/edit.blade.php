@extends('layouts.admin')

@section('title', 'Edit Template - Smart Stationary')

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
    <h2>Edit Document Template</h2>
    
    <div class="glass" style="padding: 30px; margin-top: 20px;">
        <form action="{{ route('admin.templates.update', $template->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid-2" style="margin-bottom: 20px;">
                <div class="form-group">
                    <label class="form-label">Template Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $template->name }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $template->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid-2" style="margin-bottom: 20px;">
                <div class="form-group">
                    <label class="form-label">Language</label>
                    <select name="language" class="form-control" required>
                        <option value="বাংলা" {{ $template->language == 'বাংলা' ? 'selected' : '' }}>বাংলা</option>
                        <option value="English" {{ $template->language == 'English' ? 'selected' : '' }}>English</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Description (Optional)</label>
                    <input type="text" name="description" class="form-control" value="{{ $template->description }}">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: flex; align-items: center; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ $template->is_active ? 'checked' : '' }} style="margin-right: 10px;">
                    Is Active
                </label>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label">Template Content (HTML/Rich Text)</label>
                <div style="background: rgba(16, 185, 129, 0.1); padding: 10px; border-radius: 5px; margin-bottom: 15px; color: #10b981;">
                    <strong>Tip:</strong> Use square brackets for variables/fields. For example: <code>[name]</code>, <code>[father-name]</code>, <code>[address]</code>. The system will automatically create an input form for these!
                </div>
                <textarea id="templateContent" name="content">{{ $template->content }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="padding: 12px 30px;">Update Template</button>
        </form>
    </div>
</div>
@endsection
