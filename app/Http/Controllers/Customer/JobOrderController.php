<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobOrderController extends Controller
{
    /**
     * Display a listing of job orders for customer.
     */
    public function index()
    {
        return view('customer.joborders.index');
    }
}
