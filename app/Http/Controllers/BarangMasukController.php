<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarangMasukController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('barang-masuk.board');
    }

    /**
     * edit barang masuk
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        /** @todo cek jika $id exists & valid */
        return view('barang-masuk.edit', ['id'=>$id]);
    }

    /**
     * laporan barang masuk
     *
     * @return \Illuminate\Http\Response
     */
    public function laporan()
    {
        return view('barang-masuk.laporan');
    }
}
