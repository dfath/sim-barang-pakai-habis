<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelompokBarangController extends Controller
{
    public function index()
    {
        return view('kelompok-barang.board');
    }
}
