<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            // ->select('created_at')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.orders', compact('orders'));
    }
}
