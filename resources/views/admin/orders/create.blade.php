@extends('layouts.admin')

@section('title', 'নতুন অর্ডার তৈরি করুন')

@section('content')
<div class="content-header">
    <div>
        <h2 class="content-title">নতুন অর্ডার তৈরি করুন</h2>
        <p class="content-subtitle">কোনো বিজনেস একাউন্টকে কাজ এসাইন করুন</p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary" style="background: transparent; color: var(--text-muted); border: 1px solid rgba(255,255,255,0.1); padding: 8px 16px; border-radius: 8px;">
        <i class="material-icons-round" style="vertical-align: middle;">arrow_back</i> ফিরে যান
    </a>
</div>

<div class="glass" style="padding: 30px; max-width: 800px;">
    @if(session('error'))
        <div class="alert alert-danger" style="margin-bottom: 20px; background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #ef4444; padding: 15px; border-radius: 8px;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.orders.store') }}" method="POST">
        @csrf

        <div class="mb-4" style="margin-bottom: 20px;">
            <label class="form-label" style="color: #fff; margin-bottom: 8px; display: block;">শপকিপারের Account ID <span style="color: #ef4444;">*</span></label>
            <input type="text" name="shopkeeper_account_id" class="form-control" placeholder="যেমন: UID-A1B2C3" value="{{ old('shopkeeper_account_id') }}" required style="background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); color: #fff; width: 100%; padding: 10px; border-radius: 8px;">
            <small style="color: var(--text-muted); font-size: 0.85rem; margin-top: 5px; display: block;">যাকে কাজ দিতে চান তার একাউন্ট আইডি দিন। একাউন্টটি অবশ্যই 'Business' হতে হবে।</small>
        </div>

        <div class="mb-4" style="margin-bottom: 20px;">
            <label class="form-label" style="color: #fff; margin-bottom: 8px; display: block;">কাজের বিবরণ <span style="color: #ef4444;">*</span></label>
            <textarea name="order_details" class="form-control" rows="5" placeholder="কাজ সম্পর্কে বিস্তারিত লিখুন..." required style="background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); color: #fff; width: 100%; padding: 10px; border-radius: 8px;">{{ old('order_details') }}</textarea>
        </div>

        <div class="mb-4" style="margin-bottom: 30px;">
            <label class="form-label" style="color: #fff; margin-bottom: 8px; display: block;">পেমেন্ট অ্যামাউন্ট (৳) <span style="color: #ef4444;">*</span></label>
            <input type="number" name="amount" class="form-control" placeholder="0.00" value="{{ old('amount') }}" required min="0" step="0.01" style="background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); color: #fff; width: 100%; padding: 10px; border-radius: 8px;">
            <small style="color: var(--text-muted); font-size: 0.85rem; margin-top: 5px; display: block;">কাজ সম্পন্ন হলে কত টাকা পেমেন্ট করা হবে।</small>
        </div>

        <div style="text-align: right;">
            <button type="submit" class="btn btn-primary" style="padding: 12px 24px;">
                <i class="material-icons-round" style="vertical-align: middle;">send</i> অর্ডার পাঠান
            </button>
        </div>
    </form>
</div>
@endsection
