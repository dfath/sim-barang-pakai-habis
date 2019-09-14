<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelompokKegiatanController extends Controller
{
    public function index()
    {
        return view('kelompok-kegiatan.board');
    }
}
