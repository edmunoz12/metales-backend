<?php

namespace App\Http\Controllers\Principal;

use App\Http\Controllers\Controller;
use App\Models\Menu\Menu;
use App\Models\Submenu\Submenu;

class PrincipalController extends Controller
{
    public function index()
    {
        $menu = Menu::all();
        return response()->json($menu,200);

    }

    public function submenu()
    {
        $submenu = Submenu::all();
        return response()->json($submenu,200);
    }
}
