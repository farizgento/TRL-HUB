<?php

namespace App\Http\Controllers;

use App\Models\ToolCategory;
use App\Models\ToolLocation;
use App\Models\User;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::with('role')->orderBy('name')->get();

        return view('admin.users', ['users' => $users]);
    }

    public function masters()
    {
        return view('admin.masters', [
            'categories' => ToolCategory::orderBy('category_name')->get(),
            'locations' => ToolLocation::orderBy('location_name')->get(),
        ]);
    }
}
