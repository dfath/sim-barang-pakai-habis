<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\DB;
use App\KelompokBarang;
use App\Http\Resources\KelompokBarangResource;
use App\Http\Resources\KelompokBarangResourceCollection;

class KelompokBarangController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $textFields = [
            'nama'
        ];
        $textFieldMaps = [
            'nama' => 'kelompok_barang.nama'
        ];
        $textFilter = $request->only($textFields);

        $query = DB::table('kelompok_barang');
        $query->select('kelompok_barang.*');
        // kelompok kegiatan
        $query->leftJoin('kelompok_kegiatan', 'kelompok_barang.kelompok_kegiatan_id', '=', 'kelompok_kegiatan.id');
        $query->addSelect('kelompok_kegiatan.nama as nama_kelompok_kegiatan');

        foreach ($textFilter as $key => $value) {
            $query->where($textFieldMaps[$key], 'like', "%$value%");
        }

        return new KelompokBarangResourceCollection($query->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = [
            'kelompok_kegiatan_id' => $request->input('kelompok_kegiatan_id'),
            'nama' => $request->input('nama')
        ];
        try {
            $query = KelompokBarang::create($input);

            return new KelompokBarangResource($query);

        } catch (Throwable $th) {
            return $this->errorBadRequest();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return new KelompokBarangResource(KelompokBarang::findOrFail($id));
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
            'kelompok_kegiatan_id' => $request->input('kelompok_kegiatan_id'),
            'nama' => $request->input('nama')
        ];
        try {
            $query = KelompokBarang::findOrFail($id);
            $query->update($input);

            return new KelompokBarangResource($query);
        } catch (Throwable $th) {
            return $this->errorBadRequest();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {
            if (KelompokBarang::destroy($id)) {
                return $this->noContent();
            }

            return $this->errorNotFound();

        } catch (Throwable $th) {
            return $this->errorBadRequest();
        }

    }
}
