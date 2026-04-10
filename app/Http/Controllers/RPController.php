<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RPController extends Controller
{
    public function rpPage() {
        return view('admin.rp');
    }
}
