@extends('layouts.admin_app')
@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add Service</h4>
            <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="seller_id" value="{{ $seller->id }}">
                <div class="form-group">
                    <label for="name">Name of service:</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                </div>
                <div class="form-group">
                    <label for="image">Image:</label>
                    <input class="form-control" type="file" name="image" id="fileUpload" accept="image/*" required>
                    <input type="hidden" name="cropped_image" id="croppedImage">
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" class="form-control" id="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="price">Price <em>(If the price is fixed, otherwise leave empty)</em> :</label>
                    <input type="number" name="price" class="form-control" id="price">
                </div>
                <button type="submit" class="btn btn-primary text-white">Submit</button>
            </form>
        </div>
    </div>
@endsection
