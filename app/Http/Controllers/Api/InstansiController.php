<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\DB;
use App\Instansi;
use App\Http\Resources\InstansiResource;
use App\Http\Resources\InstansiResourceCollection;

class InstansiController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return new InstansiResource(Instansi::findOrFail($id));
        } catch (Throwable $th) {
            return $this->errorNotFound();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = [
            'nama_aplikasi' => $request->input('nama_aplikasi'),
            'nama_instansi' => $request->input('nama_instansi'),
            'alamat_instansi' => $request->input('alamat_instansi'),
            'kepala_opd' => $request->input('kepala_opd'),
            'pengelola' => $request->input('pengelola')
        ];
        try {
            $query = Instansi::findOrFail($id);
            $query->update($input);

            return new InstansiResource($query);
        } catch (Throwable $th) {
            return $this->errorBadRequest();
        }

    }
}
