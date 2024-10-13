<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceOrder;
use Illuminate\Support\Facades\Auth;

class ServiceOrderController extends Controller
{
    public function service()
    {
        $services = Service::all();
        return view('customers.service', compact('services'));
    }
    

    public function store(Service $service)
    {
        $sellerId = $service->seller_id; // Assuming seller_id is in the Service model
    
        $order = ServiceOrder::create([
            'service_id' => $service->id,
            'customer_id' => Auth::id(),
            'seller_id' => $sellerId,
        ]);
    
        // Redirect to the service order details page
        return redirect()->route('service-orders.show', $order->id)->with('success', 'Service ordered successfully.');
    }

    public function service_orders(ServiceOrder $serviceOrder)
    {
        // Ensure the authenticated user is the owner of the service order
        // if ($serviceOrder->user_id !== Auth::id()) {
        //     abort(403);
        // }

        return view('customers.orders.service_order_details', compact('serviceOrder'));
    }

    public function destroy(ServiceOrder $serviceOrder)
    {
        // Ensure the authenticated user is the owner of the service order
        if ($serviceOrder->user_id !== Auth::id()) {
            abort(403);
        }

        $serviceOrder->delete();

        return redirect()->route('service.index')->with('success', 'Service order canceled successfully.');
    }
}