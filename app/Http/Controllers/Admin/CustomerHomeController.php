<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CustomerHomeController extends Controller
{
    //
    public function HomePage(Request $request) {
       return view('admin.homepage');
    }
}
