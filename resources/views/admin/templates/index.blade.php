@extends('layouts.admin')

@section('title', 'Document Templates - Smart Stationary')

@section('content')
<div class="container" style="padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Document Templates</h2>
        <a href="{{ route('admin.templates.create') }}" class="btn btn-primary">Add New Template</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background: #10b981; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="glass" style="padding: 20px;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                    <th style="padding: 10px;">Name</th>
                    <th style="padding: 10px;">Category</th>
                    <th style="padding: 10px;">Language</th>
                    <th style="padding: 10px;">Fields</th>
                    <th style="padding: 10px;">Status</th>
                    <th style="padding: 10px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($templates as $template)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                    <td style="padding: 10px; font-weight: bold;">{{ $template->name }}</td>
                    <td style="padding: 10px;">{{ $template->category->name ?? 'None' }}</td>
                    <td style="padding: 10px;">{{ $template->language }}</td>
                    <td style="padding: 10px;">{{ $template->total_fields }}</td>
                    <td style="padding: 10px;">
                        @if($template->is_active)
                            <span style="color: #10b981; font-weight: bold;">Active</span>
                        @else
                            <span style="color: #ef4444; font-weight: bold;">Inactive</span>
                        @endif
                    </td>
                    <td style="padding: 10px;">
                        <a href="{{ route('admin.templates.edit', $template->id) }}" class="btn btn-sm btn-outline" style="padding: 5px 10px;">Edit</a>
                        <form action="{{ route('admin.templates.destroy', $template->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this template?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="background: #ef4444; color: white; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
