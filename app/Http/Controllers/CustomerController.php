<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('auth')->except(['index']);
        // $this->middleware('auth')->only(['index']);
    }

    /**
     * Customers Pages
     * 
     * orders
     * profile
     * payment methods
     * account settings
     */
    public function orders(User $user)
    {
        return view('customer.orders', compact('user'));
    }

    public function profile(User $user)
    {
        return view('customer.profile', compact('user'));
    }

    public function payments(User $user)
    {
        return view('customer.payments', compact('user'));
    }

    public function settings(User $user)
    {
        return view('customer.settings', compact('user'));
    }
}
