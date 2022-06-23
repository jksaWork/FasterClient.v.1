<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubAreaController extends Controller
{
    public function index($id)
    {
        return view('sub_areas.index', ['area_id' => $id]);
    }
}
