<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $menu = Menu::when($search, function ($query, $search) {
            return $query->where('nama_menu', 'like', $search . '%');
        })->paginate(10);

        return view('menu.index', compact('menu', 'search'));
    }
}
