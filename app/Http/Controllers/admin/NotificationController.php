<?php

namespace App\Http\Controllers\admin;

use App\Models\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;


class NotificationController extends Controller
{
    public function index(Request $request)
    {
        // Get the 'period' parameter from the request (default to 'today')
        $period = $request->input('period', 'today');
    
        // Determine the start date based on the period
        switch ($period) {
            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                break;
            case 'year':
                $startDate = Carbon::now()->startOfYear();
                break;
            case 'today':
            default:
                $startDate = Carbon::today();
                break;
        }
    
        // Get users created between the start date and now
        $users = User::whereBetween('created_at', [$startDate, Carbon::now()])->get();
    
        // For the cards, get user counts for today, week, month, and year
        $usersToday = User::whereDate('created_at', Carbon::today())->count();
        $usersThisWeek = User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()])->count();
        $usersThisMonth = User::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()])->count();
        $usersThisYear = User::whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()])->count();
    
        return view('admin.notifications', compact('users', 'period', 'usersToday', 'usersThisWeek', 'usersThisMonth', 'usersThisYear'));
    }
}

