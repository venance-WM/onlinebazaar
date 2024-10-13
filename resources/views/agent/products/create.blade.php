@extends('layouts.admin_app')
@section('content')

<div class="card mb-4">
    <div class="card-header text-center">
        Create Products
    </div>
    <div class="card-body">
        @if ($errors->any())
        <ul class="alert alert-danger list-unstyled">
            @foreach ($errors->all() as $error)
            <li>- {{ $error }}</li>
            @endforeach
        </ul>
        @endif
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <input type="hidden" name="seller_id" value="{{ $seller->id }}">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Name:</label>
                    <input name="product_name" value="{{ old('product_name') }}" type="text" class="form-control" required>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 mb-3">
                    <label class="form-label">Category:</label>
                    <select name="category_id" class="form-control" required>
                        <option value="" hidden>Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 mb-3">
                    <label class="form-label">Price:</label>
                    <input name="price" value="{{ old('price') }}" type="number" class="form-control" required>
                </div>                              
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Image:</label>
                    <input class="form-control" type="file" name="image" id="fileUpload" accept="image/*" required>
                    <input type="hidden" name="cropped_image" id="croppedImage">
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
                    <label class="form-label">Stock Quantity:</label>
                    <input name="stock" value="{{ old('stock') }}" type="number" class="form-control" required>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
                    <label class="form-label">Unit:</label>
                    <select name="unit" class="form-control" required>
                        <option value="" hidden>Select Unit</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                {{ $unit->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center text-lg-start">
                    <button type="submit" name="submit" class="btn btn-primary text-white">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

@include('partials.crop_image_modal')

@endsection
