@extends('layouts.admin')

@section('title', 'Typing Tests - Smart Stationary')

@section('content')
<div class="container" style="padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Typing Test Paragraphs</h2>
        <a href="{{ route('admin.typing-test.create') }}" class="btn btn-primary" style="padding: 10px 20px; border-radius: 8px;">
            <i class="material-icons-round" style="vertical-align: middle; font-size: 18px;">add</i> Add Paragraph
        </a>
    </div>

    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="glass" style="padding: 20px;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                    <th style="padding: 15px;">Title</th>
                    <th style="padding: 15px;">Language</th>
                    <th style="padding: 15px;">Status</th>
                    <th style="padding: 15px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($paragraphs as $paragraph)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <td style="padding: 15px;">{{ $paragraph->title }}</td>
                    <td style="padding: 15px;">
                        <span style="background: rgba(59, 130, 246, 0.2); padding: 4px 10px; border-radius: 20px; font-size: 0.85rem; color: #60a5fa;">
                            {{ $paragraph->language }}
                        </span>
                    </td>
                    <td style="padding: 15px;">
                        @if($paragraph->is_active)
                            <span style="color: #10b981; font-size: 0.9rem;">Active</span>
                        @else
                            <span style="color: #ef4444; font-size: 0.9rem;">Inactive</span>
                        @endif
                    </td>
                    <td style="padding: 15px; text-align: right;">
                        <a href="{{ route('admin.typing-test.edit', $paragraph->id) }}" class="btn" style="background: rgba(255,255,255,0.1); padding: 5px 10px; color: #fff;">
                            <i class="material-icons-round" style="font-size: 18px;">edit</i>
                        </a>
                        <form action="{{ route('admin.typing-test.destroy', $paragraph->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="background: rgba(239, 68, 68, 0.2); padding: 5px 10px; color: #ef4444;" onclick="return confirm('Are you sure you want to delete this paragraph?')">
                                <i class="material-icons-round" style="font-size: 18px;">delete</i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 20px; text-align: center; color: rgba(255,255,255,0.5);">
                        No paragraphs found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
