<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('barang-keluar.board');
    }

    /**
     * laporan barang keluar
     *
     * @return \Illuminate\Http\Response
     */
    public function laporan()
    {
        return view('barang-keluar.laporan');
    }
}
