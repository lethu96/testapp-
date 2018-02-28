<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position;
use Illuminate\Support\Facades\Response;

class PositionController extends Controller
{
    public function index()
    {
        $position=Position::all();
        return response()->json($position);
    }
}
