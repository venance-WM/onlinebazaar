@extends('layouts.admin_app')
@section('content')
<div class="container">
    <h1 class="text-center">Online Bazaar Documentation <small>SAMPLE</small></h1>
    
    <div id="overview">
        <h2>Overview</h2>
        <p>This document provides a summary of the Online Bazaar functionalities.</p>
    </div>

    <div id="features">
        <h2>Features</h2>
        <ul>
            <li>User registration and login with email verification</li>
            <li>Product browsing, searching, and cart management</li>
            <li>Order placement and order management</li>
            <li>Admin dashboard for product and order management</li>
        </ul>
    </div>

    <div id="usage">
        <h2>Usage</h2>
        <p><strong>User Actions:</strong> Register, login, browse products, add to cart, place orders.</p>
        <p><strong>Admin Actions:</strong> Manage products, view and update orders.</p>
    </div>

    <div id="api-endpoints">
        <h2>API Endpoints</h2>
        <p><strong>Authentication:</strong> POST /api/register, POST /api/login</p>
        <p><strong>Products:</strong> GET /api/products, GET /api/products/{id}, POST /api/products, PUT /api/products/{id}, DELETE /api/products/{id}</p>
        <p><strong>Orders:</strong> GET /api/orders, GET /api/orders/{id}, POST /api/orders, PUT /api/orders/{id}, DELETE /api/orders/{id}</p>
    </div>

    <div id="faq">
        <h2>FAQ</h2>
        <p><strong>Reset Password:</strong> Click "Forgot Password" on the login page.</p>
        <p><strong>Contact Support:</strong> Email support@yourdomain.com</p>
    </div>

    <div id="license">
        <h2>License</h2>
        <p>Licensed under the MIT License. See the <a href="LICENSE">LICENSE</a> file for details.</p>
    </div>
</div>
@endsection