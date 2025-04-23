<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        // You can customize this, e.g., paginate users
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }
}
