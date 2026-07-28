@extends('layouts.admin')

@section('title', 'Edit Typing Test - penghor.com')

@section('content')
<div class="container" style="padding: 20px;">
    <h2>Edit Typing Test Paragraph</h2>
    
    <div class="glass" style="padding: 30px; margin-top: 20px;">
        <form action="{{ route('admin.typing-test.update', $typing_test->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid-2" style="margin-bottom: 20px;">
                <div class="form-group">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $typing_test->title }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Language</label>
                    <select name="language" class="form-control" required>
                        <option value="English" {{ $typing_test->language == 'English' ? 'selected' : '' }}>English</option>
                        <option value="Bangla" {{ $typing_test->language == 'Bangla' ? 'selected' : '' }}>Bangla</option>
                    </select>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label">Paragraph Content (Plain Text Only)</label>
                <textarea name="content" class="form-control" rows="8" required style="resize: vertical; font-size: 16px; font-family: inherit;">{{ $typing_test->content }}</textarea>
            </div>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: flex; align-items: center; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ $typing_test->is_active ? 'checked' : '' }} style="margin-right: 10px;">
                    Is Active
                </label>
            </div>

            <button type="submit" class="btn btn-primary" style="padding: 12px 30px;">Update Paragraph</button>
        </form>
    </div>
</div>
@endsection
