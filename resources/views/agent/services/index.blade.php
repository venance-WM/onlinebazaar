@extends('layouts.admin_app')
@section('content')
    <div class="card">
        <div class="card-body table-responsive-sm">
            <h4 class="card-title">Services</h4>
            {{-- <a href="{{ route('services.create',['user_id' => $seller->id]) }}" class="btn btn-primary mb-3 float-end text-white">Add New Service</a> --}}
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif

            @if ($services->isEmpty())
                <div class="alert alert-warning">
                    <p>NO SERVICES YOU ADDED</p>
                </div>
            @else
            
                <table class="table table-striped table-hover">
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th width="280px">Action</th>
                    </tr>
                    @foreach ($services as $index => $service)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $service->name }}</td>
                            <td>
                                @if ($service->image)
                                    <img src="{{ asset('images/services/' . $service->image) }}" alt="{{ $service->name }}"
                                        width="50">
                                @else
                                    No images of service
                                @endif
                            </td>
                            <td>{{ $service->description }}</td>
                            <td>{{ $service->price }}</td>
                            <td>
                                <a class="btn text-primary" href="{{ route('services.edit', $service->id) }}">
                                    <i class="mdi mdi-square-edit-outline mdi-24px"></i>
                                </a>
                                <form action="{{ route('services.destroy', $service->id) }}" method="POST"
                                    style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn text-danger"><i
                                            class="mdi mdi-trash-can-outline mdi-24px"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>
@endsection
