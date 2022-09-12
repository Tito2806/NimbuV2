<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = array(
            'count_user' => DB::table('users')->count(),
            'menu'      => 'admin.menu.v_menu_admin',
            'content' => 'admin.content.view_dashboard'
        );
        return view('admin.layouts.v_template',$data);
    }
}
