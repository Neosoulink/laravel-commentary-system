<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(String $title) {
        return view('comments', [
            'title' => $title,
            'currentUser' => auth()->user()
        ]);
    }

     public function get(request $request) {
        $request->validate([
            'ref_page' => 'required'
        ]);

        return redirect()->route('page.index', $request->ref_page);
    }
}
