@extends('layouts.admin_app')
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Categories</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = ($categories->currentPage() - 1) * $categories->perPage() + 1;
                                @endphp
                                @foreach ($categories as  $category)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->description }}</td>
                                        <td>
                                            <a href="{{ route('agent.categories.edit', $category->id) }}" class="btn text-primary">
                                                <i class="mdi mdi-square-edit-outline mdi-24px"></i>
                                            </a>
                                            <a href="#" class="btn text-danger" onclick="event.preventDefault(); 
                                               if(confirm('Are you sure you want to delete this category?')) {
                                                   document.getElementById('delete-form-{{ $category->id }}').submit();
                                               }">
                                                <i class="mdi mdi-trash-can-outline mdi-24px"></i>
                                            </a>
                                            <form action="{{ route('agent.categories.delete', $category->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($categories->isEmpty())
                            <p>No categories available.</p>
                        @endif
                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
