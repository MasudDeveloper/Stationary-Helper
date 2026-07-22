@extends('layouts.app')

@section('title', 'ক্রেডিট রিচার্জ - সহজ কাজ')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <div class="glass" style="max-width: 800px; margin: 0 auto; padding: 40px;">
        <h2 style="color: var(--primary-color); margin-bottom: 10px; text-align: center; font-weight: 700;">ক্রেডিট রিচার্জ করুন</h2>
        <p style="text-align: center; color: var(--text-muted); margin-bottom: 30px;">আপনার প্রয়োজনীয় প্যাকেজটি নির্বাচন করুন এবং বিকাশের মাধ্যমে পেমেন্ট করুন</p>
        
        @if (session('success'))
            <div style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #10b981; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div style="background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #ef4444; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('recharge') }}" id="rechargeForm">
            @csrf
            
            <h4 style="margin-bottom: 15px; color: #fff;">১. প্যাকেজ নির্বাচন করুন <span style="color:red">*</span></h4>
            
            <div class="package-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 30px;">
                @foreach($packages as $package)
                    <div class="package-card" data-id="{{ $package->id }}" onclick="selectPackage(this, {{ $package->id }})" style="background: rgba(255,255,255,0.05); border: 2px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 20px; text-align: center; cursor: pointer; transition: all 0.3s ease; position: relative;">
                        
                        <div class="check-icon" style="display: none; position: absolute; top: 10px; right: 10px; color: #10b981;">
                            <i class="material-icons-round">check_circle</i>
                        </div>
                        
                        <h3 style="color: #fff; margin-bottom: 5px; font-size: 1.2rem;">{{ $package->title }}</h3>
                        
                        <div style="margin: 15px 0;">
                            <span style="font-size: 2.5rem; font-weight: 800; color: #a5b4fc;">{{ $package->credits }}</span>
                            <span style="color: var(--text-muted); font-size: 0.9rem;">ক্রেডিট</span>
                        </div>
                        
                        <div style="background: rgba(0,0,0,0.3); padding: 8px; border-radius: 6px; font-weight: 600; color: #34d399;">
                            মূল্য: ৳{{ number_format($package->price, 0) }}
                        </div>
                    </div>
                @endforeach
            </div>
            
            <input type="hidden" name="package_id" id="package_id" value="" required>
            @error('package_id')
                <div class="text-danger" style="margin-bottom: 15px; margin-top: -15px;">দয়া করে একটি প্যাকেজ নির্বাচন করুন।</div>
            @enderror

            @if($packages->count() > 0)
            <div id="payment-details" style="display: none; transition: all 0.3s ease;">
                <div style="background: rgba(245, 158, 11, 0.1); border: 1px dashed var(--primary-color); padding: 20px; border-radius: 8px; margin-bottom: 30px; text-align: center;">
                    <h4 style="margin-bottom: 10px; color: #fff;">২. বিকাশে পেমেন্ট করুন</h4>
                    <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 15px;">নিচের পার্সোনাল নম্বরে <strong id="displayPrice" style="color: #f59e0b;"></strong> টাকা <strong>Send Money</strong> করুন।</p>
                    <h2 style="color: var(--text-main); letter-spacing: 2px; font-size: 2rem; margin: 0; display: inline-flex; align-items: center; justify-content: center; gap: 10px;">
                        017XX-XXXXXX 
                        <button type="button" onclick="navigator.clipboard.writeText('017XXXXXXXX').then(() => Swal.fire('নম্বর কপি হয়েছে!'))" style="background: rgba(255,255,255,0.1); border: none; color: #fff; padding: 5px 10px; border-radius: 6px; cursor: pointer;">
                            <i class="material-icons-round" style="font-size: 1rem;">content_copy</i>
                        </button>
                    </h2>
                </div>

                <h4 style="margin-bottom: 15px; color: #fff;">৩. পেমেন্ট তথ্য দিন</h4>
                <div class="form-group">
                    <label class="form-label">যে নম্বর থেকে টাকা পাঠিয়েছেন <span style="color:red">*</span></label>
                    <input type="text" name="sender_number" class="form-control" placeholder="আপনার বিকাশ নম্বর" value="{{ old('sender_number') }}" required>
                    @error('sender_number')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">ট্রানজেকশন আইডি (TrxID) <span style="color:red">*</span></label>
                    <input type="text" name="transaction_id" class="form-control" placeholder="TrxID দিন" value="{{ old('transaction_id') }}" required>
                    @error('transaction_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 20px; padding: 14px; font-size: 1.1rem; font-weight: 600;">রিকোয়েস্ট সাবমিট করুন</button>
            </div>
            @else
                <div style="text-align: center; padding: 40px; background: rgba(255,255,255,0.02); border-radius: 8px;">
                    <i class="material-icons-round" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 10px;">inventory_2</i>
                    <h4 style="color: var(--text-muted);">বর্তমানে কোনো রিচার্জ প্যাকেজ অ্যাক্টিভ নেই।</h4>
                </div>
            @endif
        </form>
    </div>
</div>

<script>
    // Store packages in JS for easy access
    const packages = @json($packages);

    function selectPackage(element, packageId) {
        // Reset all cards
        document.querySelectorAll('.package-card').forEach(card => {
            card.style.borderColor = 'rgba(255,255,255,0.1)';
            card.style.background = 'rgba(255,255,255,0.05)';
            card.style.transform = 'scale(1)';
            card.querySelector('.check-icon').style.display = 'none';
        });

        // Highlight selected
        element.style.borderColor = '#10b981';
        element.style.background = 'rgba(16, 185, 129, 0.05)';
        element.style.transform = 'scale(1.02)';
        element.querySelector('.check-icon').style.display = 'block';

        // Set hidden input
        document.getElementById('package_id').value = packageId;

        // Show payment details section
        document.getElementById('payment-details').style.display = 'block';

        // Update display price
        const selectedPkg = packages.find(p => p.id === packageId);
        if(selectedPkg) {
            document.getElementById('displayPrice').innerText = selectedPkg.price;
        }
    }

    // Retain selection on validation error
    document.addEventListener("DOMContentLoaded", function() {
        const oldPackageId = "{{ old('package_id') }}";
        if(oldPackageId) {
            const card = document.querySelector(`.package-card[data-id="${oldPackageId}"]`);
            if(card) {
                selectPackage(card, parseInt(oldPackageId));
            }
        }
    });
</script>
@endsection
