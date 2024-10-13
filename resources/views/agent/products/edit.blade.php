@extends('layouts.admin_app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Edit Product</h1>

            <form action="{{ route('products.update', $productRequest->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $productData['name'] ?? '' }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Category</label>
                        <select name="category_id" class="form-control" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ ($productData['category_id'] ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" name="price" class="form-control" value="{{ $productData['price'] ?? '' }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control">{{ $productData['description'] ?? '' }}</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" id="fileUpload" accept="image/*">
                        <input type="hidden" name="cropped_image" id="croppedImage">
                        @if(!empty($productData['image']))
                            <img src="{{ asset('storage/' . $productData['image']) }}" alt="{{ $productData['name'] }}" width="100">
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Submit Product Request</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

@include('partials.crop_image_modal')

@endsection
