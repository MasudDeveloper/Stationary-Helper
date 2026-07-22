@extends('layouts.admin')

@section('title', 'Add Typing Test - Smart Stationary')

@section('content')
<div class="container" style="padding: 20px;">
    <h2>Add New Typing Test Paragraph</h2>
    
    <div class="glass" style="padding: 30px; margin-top: 20px;">
        <form action="{{ route('admin.typing-test.store') }}" method="POST">
            @csrf
            
            <div class="grid-2" style="margin-bottom: 20px;">
                <div class="form-group">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. English Basics 1" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Language</label>
                    <select name="language" class="form-control" required>
                        <option value="English">English</option>
                        <option value="Bangla">Bangla</option>
                    </select>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label">Paragraph Content (Plain Text Only)</label>
                <div style="background: rgba(16, 185, 129, 0.1); padding: 10px; border-radius: 5px; margin-bottom: 15px; color: #10b981;">
                    <strong>Tip:</strong> Please ensure there are no extra spaces or newlines at the end. Use normal punctuation.
                </div>
                <textarea name="content" class="form-control" rows="8" required style="resize: vertical; font-size: 16px; font-family: inherit;"></textarea>
            </div>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: flex; align-items: center; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" checked style="margin-right: 10px;">
                    Is Active
                </label>
            </div>

            <button type="submit" class="btn btn-primary" style="padding: 12px 30px;">Save Paragraph</button>
        </form>
    </div>
</div>
@endsection
