@extends('layouts.admin_app')
@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Service</h4>
            <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Name of service:</label>
                    <input type="text" name="name" class="form-control" id="name"
                        value="{{ old('name', $service->name) }}" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" class="form-control" id="description" rows="5" required>{{ old('description', $service->description) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" name="price" class="form-control" id="price"
                        value="{{ old('price', $service->price) }}" required>
                </div>
                <div class="form-group">
                    <label for="image">Image:</label>
                    <input class="form-control" type="file" name="image" id="fileUpload" accept="image/*" required>
                    <input type="hidden" name="cropped_image" id="croppedImage">
                    @if ($service->image)
                        <div class="mt-2">
                            <img src="{{ asset('images/services/' . $service->image) }}" alt="{{ $service->title }}"
                                class="img-fluid" width="200">
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Update service</button>
            </form>
        </div>
    </div>
@endsection
