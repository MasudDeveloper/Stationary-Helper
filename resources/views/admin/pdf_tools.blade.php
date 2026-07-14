@extends('layouts.app')

@section('title', 'PDF Tools Manager - Admin')

@section('content')
<div class="container" style="padding: 40px 20px;">
    <h2 style="color: #fff; margin-bottom: 20px;"><i class="material-icons-round" style="vertical-align: middle;">build</i> PDF Tools Management</h2>

    @if (session('success'))
        <div style="background: rgba(16, 185, 129, 0.2); color: #10b981; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid rgba(16, 185, 129, 0.3);">
            {{ session('success') }}
        </div>
    @endif

    <div class="glass" style="padding: 0; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: rgba(255,255,255,0.05); border-bottom: 1px solid var(--border-color);">
                    <th style="padding: 15px 20px; font-weight: 600;">Icon</th>
                    <th style="padding: 15px 20px; font-weight: 600;">Tool Name</th>
                    <th style="padding: 15px 20px; font-weight: 600;">Hot Badge</th>
                    <th style="padding: 15px 20px; font-weight: 600;">Status</th>
                    <th style="padding: 15px 20px; font-weight: 600; text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tools as $tool)
                    <tr style="border-bottom: 1px solid var(--border-color); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px 20px;">
                            <div class="tool-squircle {{ $tool->gradient_class }}" style="width: 40px; height: 40px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="material-icons-round" style="font-size: 1.2rem; color: #fff;">{{ $tool->icon }}</i>
                            </div>
                        </td>
                        <td style="padding: 15px 20px; font-weight: 500;">
                            {{ $tool->title }}
                            <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $tool->route_name ?? 'N/A' }}</div>
                        </td>
                        <td style="padding: 15px 20px;">
                            @if($tool->is_hot)
                                <span style="background: #ef4444; color: #fff; padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; font-weight: bold;">HOT</span>
                            @else
                                -
                            @endif
                        </td>
                        <td style="padding: 15px 20px;">
                            @if ($tool->is_active)
                                <span style="color: #10b981; font-weight: bold; background: rgba(16, 185, 129, 0.1); padding: 4px 10px; border-radius: 20px; font-size: 0.85rem;">Active</span>
                            @else
                                <span style="color: #ef4444; font-weight: bold; background: rgba(239, 68, 68, 0.1); padding: 4px 10px; border-radius: 20px; font-size: 0.85rem;">Inactive</span>
                            @endif
                        </td>
                        <td style="padding: 15px 20px; text-align: right;">
                            <form action="{{ route('admin.pdf_tools.toggle', $tool->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn" style="padding: 8px 16px; font-size: 0.85rem; background: {{ $tool->is_active ? 'rgba(239, 68, 68, 0.1)' : 'rgba(16, 185, 129, 0.1)' }}; color: {{ $tool->is_active ? '#ef4444' : '#10b981' }}; border: 1px solid {{ $tool->is_active ? 'rgba(239, 68, 68, 0.3)' : 'rgba(16, 185, 129, 0.3)' }};">
                                    {{ $tool->is_active ? 'Disable Tool' : 'Enable Tool' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
