<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Profile;

class AdminController extends Controller
{

    public function showAdmin($id)
    {
        
        $admin = Admin::with('profile')->find($id);

        if (!$admin) {
            return response()->json(['message' => 'Administrateur non trouvé'], 404);
        }

        return response()->json(['admin' => $admin], 200);
    }


}
