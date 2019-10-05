<?php

namespace App\Http\Controllers;

use Throwable;
use App\Instansi;
use Illuminate\Http\Request;

class InstansiController extends Controller
{
    public function index(Request $request)
    {
        $instansi = Instansi::first();

        $message = array();

        if ($request->isMethod('post')) {

            $input = [
                'nama_aplikasi' => $request->input('nama_aplikasi'),
                'nama_instansi' => $request->input('nama_instansi'),
                'alamat_instansi' => $request->input('alamat_instansi'),
                'kepala_opd' => $request->input('kepala_opd'),
                'pengelola' => $request->input('pengelola')
            ];

            try {
                $instansi->update($input);

                $message['content'] = 'Sukses update data instansi';
                $message['color'] = 'is-success';
            } catch (Throwable $th) {
                $message['content'] = $th->getMessage();
                $message['color'] = 'is-danger';
            }

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                if ($file->isValid() && $file->getClientOriginalExtension() === "png") {
                    $file->move(public_path('img'), $file->storeAs('logo', 'logo.png'));
                } else {
                    $message['content'] = 'File Harus berformat png';
                    $message['color'] = 'is-danger';
                }
            }

        }

        return view('instansi.board', ['instansi' => $instansi, 'message' => $message]);
    }
}
