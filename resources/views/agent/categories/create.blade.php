@extends('layouts.admin_app')
@section('content')

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Register Category Here</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('agent.categories.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="categoryName">Category Name:</label>
                            <input type="text" class="form-control" id="categoryName" name="category-name" placeholder="Enter category name" required>
                        </div>
                        <div class="form-group">
                            <label for="categoryDescription">Category Description:</label>
                            <textarea class="form-control" id="categoryDescription" name="category-description" rows="3" placeholder="Enter category description"></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection