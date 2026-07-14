@extends('layouts.admin')

@section('title', 'Add Category - Smart Stationary')

@section('content')
<div class="container" style="padding: 20px; max-width: 600px;">
    <h2>Add New Category</h2>
    
    <div class="glass" style="padding: 30px; margin-top: 20px;">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label" style="display: block; margin-bottom: 10px;">Category Name</label>
                <input type="text" name="name" class="form-control" style="width: 100%;" required>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: flex; align-items: center; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" checked style="margin-right: 10px;">
                    Is Active
                </label>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px;">Save Category</button>
        </form>
    </div>
</div>
@endsection
