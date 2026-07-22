@extends('layouts.admin')

@section('title', 'রিচার্জ প্যাকেজ ম্যানেজমেন্ট')

@section('content')
<div class="content-header">
    <div>
        <h2 class="content-title">রিচার্জ প্যাকেজ ম্যানেজমেন্ট</h2>
        <p class="content-subtitle">ইউজারদের জন্য রিচার্জ প্যাকেজ তৈরি এবং আপডেট করুন</p>
    </div>
    <button type="button" class="btn btn-primary" onclick="openCreateModal()">
        <i class="material-icons-round">add</i> নতুন প্যাকেজ
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success" style="margin-bottom: 20px; background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #10b981; padding: 15px; border-radius: 8px;">
        {{ session('success') }}
    </div>
@endif

<div class="glass" style="padding: 20px;">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>প্যাকেজের নাম</th>
                    <th>ক্রেডিট</th>
                    <th>মূল্য (টাকা)</th>
                    <th>সর্ট অর্ডার</th>
                    <th>স্ট্যাটাস</th>
                    <th>অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @foreach($packages as $package)
                <tr>
                    <td><strong>{{ $package->title }}</strong></td>
                    <td><span style="color: #34d399; font-weight: bold;">{{ $package->credits }}</span></td>
                    <td>৳{{ number_format($package->price, 2) }}</td>
                    <td>{{ $package->sort_order }}</td>
                    <td>
                        @if($package->is_active)
                            <span style="background: rgba(16, 185, 129, 0.15); color: #10b981; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Active</span>
                        @else
                            <span style="background: rgba(239, 68, 68, 0.15); color: #ef4444; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <button onclick="openEditModal({{ $package }})" class="btn" style="background: rgba(59, 130, 246, 0.2); color: #60a5fa; padding: 6px 12px; margin-right: 5px;">
                            <i class="material-icons-round" style="font-size: 1.1rem;">edit</i>
                        </button>
                        <form action="{{ route('admin.recharge-packages.destroy', $package->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('আপনি কি নিশ্চিত?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="background: rgba(239, 68, 68, 0.2); color: #f87171; padding: 6px 12px;">
                                <i class="material-icons-round" style="font-size: 1.1rem;">delete</i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($packages->count() == 0)
                <tr>
                    <td colspan="6" class="text-center" style="padding: 30px;">কোনো প্যাকেজ পাওয়া যায়নি।</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- Modal for Create/Edit -->
<div id="packageModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 1000; justify-content: center; align-items: center; backdrop-filter: blur(5px);">
    <div class="glass" style="width: 100%; max-width: 500px; padding: 30px; position: relative;">
        <button type="button" onclick="closeModal()" style="position: absolute; right: 20px; top: 20px; background: transparent; border: none; color: var(--text-muted); cursor: pointer;">
            <i class="material-icons-round">close</i>
        </button>
        <h3 id="modalTitle" style="margin-top: 0; margin-bottom: 20px; color: #fff;">নতুন প্যাকেজ</h3>
        
        <form id="packageForm" method="POST" action="{{ route('admin.recharge-packages.store') }}">
            @csrf
            <div id="methodField"></div>
            
            <div class="form-group">
                <label class="form-label">প্যাকেজের নাম (যেমন: Basic Package)</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            
            <div class="grid-2" style="gap: 15px;">
                <div class="form-group">
                    <label class="form-label">ক্রেডিট পরিমাণ</label>
                    <input type="number" name="credits" id="credits" class="form-control" min="1" required>
                </div>
                <div class="form-group">
                    <label class="form-label">মূল্য (টাকা)</label>
                    <input type="number" name="price" id="price" class="form-control" min="1" step="0.01" required>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">সর্ট অর্ডার (ঐচ্ছিক)</label>
                <input type="number" name="sort_order" id="sort_order" class="form-control" value="0">
            </div>
            
            <div class="form-group" style="display: flex; align-items: center; gap: 10px;">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked style="width: 18px; height: 18px;">
                <label for="is_active" style="margin: 0; color: #fff;">অ্যাক্টিভ (Active)</label>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 15px;">সেভ করুন</button>
        </form>
    </div>
</div>

<script>
    function openCreateModal() {
        document.getElementById('modalTitle').innerText = 'নতুন প্যাকেজ তৈরি করুন';
        document.getElementById('packageForm').action = "{{ route('admin.recharge-packages.store') }}";
        document.getElementById('methodField').innerHTML = '';
        
        document.getElementById('title').value = '';
        document.getElementById('credits').value = '';
        document.getElementById('price').value = '';
        document.getElementById('sort_order').value = '0';
        document.getElementById('is_active').checked = true;
        
        document.getElementById('packageModal').style.display = 'flex';
    }

    function openEditModal(package) {
        document.getElementById('modalTitle').innerText = 'প্যাকেজ এডিট করুন';
        document.getElementById('packageForm').action = `/admin/recharge-packages/${package.id}`;
        document.getElementById('methodField').innerHTML = '@method("PUT")';
        
        document.getElementById('title').value = package.title;
        document.getElementById('credits').value = package.credits;
        document.getElementById('price').value = package.price;
        document.getElementById('sort_order').value = package.sort_order;
        document.getElementById('is_active').checked = package.is_active == 1;
        
        document.getElementById('packageModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('packageModal').style.display = 'none';
    }
</script>
@endsection
