<?php
namespace App\Http\Controllers;

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

        return redirect()->route("admin.dashboard");

        // if (Auth::user()->userRole->role_type == "administrator") {
        //     return redirect()->route("admin.dashboard");

        // } else if (Auth::user()->userRole->role_type == "agent") {

        //     return redirect()->route("agent.dashboard");

        // } else {

        //     return redirect()->route("member.dashboard");

        // }

    }

}
