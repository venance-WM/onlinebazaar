@extends('layouts.admin_app')

@section('content')
{{-- <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="d-flex justify-content-between flex-wrap">
        <div class="d-flex align-items-end flex-wrap">
          <div class="me-md-3 me-xl-5">
            <h2>Welcome back,</h2>
            <p class="mb-md-0">Analysis of system</p>
          </div>
          <div class="d-flex">
            <i class="mdi mdi-view-dashboard text-muted hover-cursor"></i>
            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;</p>
            <p class="text-primary mb-0 hover-cursor">Analysis</p>
          </div>
        </div>
        <div class="d-flex justify-content-between align-items-end flex-wrap">
          <button type="button" class="btn btn-light bg-white btn-icon me-3 d-none d-md-block ">
            null
          </button> 
          <button class="btn btn-primary mt-2 mt-xl-0">system errors report</button>
        </div>
      </div>
    </div>
  </div> --}}
  <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header text-center"><b>System Users</b></div>
                <div class="card-body">
                  <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
                    <h5 class="card-title text-center text-white" style="display: inline-block; width: 100px; height: 100px; line-height: 100px; border-radius: 50%; background-color: #cac561; margin:0 auto;">
                      {{ $userCount }}
                  </h5>
                  </div>
                
                    <p class="card-text text-center ">
                      <i><b>Total number of Customers, sellers, & agents.</b></i>
                    </p>
                    <div class="d-flex justify-content-between flex-wrap">
                        <a href="{{ route('admin.customers.list') }}" class="btn btn-light ms-1 mb-2">View Customers</a>
                        <a href="{{ route('admin.sellers.list') }}" class="btn btn-light ms-1 mb-2">View Sellers</a>
                        <a href="{{ route('admin.agents.manage') }}" class="btn btn-light ms-1 mb-2">View Agents</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection