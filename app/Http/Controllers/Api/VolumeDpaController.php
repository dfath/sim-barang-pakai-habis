<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\DB;
use App\VolumeDpa;
use App\Http\Resources\VolumeDpaResource;
use App\Http\Resources\VolumeDpaResourceCollection;

class VolumeDpaController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fields = [
            'barang_id',
            'tahun_anggaran',
            'volume_min',
            'volume_max',
            'harga_satuan_min',
            'harga_satuan_max'
        ];
        $whereRaws = [
            'barang_id' => 'barang_id = ?',
            'tahun_anggaran' => 'tahun_anggaran = ?',
            'volume_min' => 'volume_min >= ?',
            'volume_max' => 'volume_max <= ?',
            'harga_satuan_min' => 'harga_satuan_min >= ?',
            'harga_satuan_max' => 'harga_satuan_max <= ?'
        ];
        $filter = $request->only($fields);

        $query = DB::table('volume_dpa');
        foreach ($filter as $key => $value) {
            $query->whereRaw($whereRaws[$key], [$value]);
        }

        return new VolumeDpaResourceCollection($query->paginate());
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
            'barang_id' => $request->input('barang_id'),
            'tahun_anggaran' => $request->input('tahun_anggaran'),
            'volume' => $request->input('volume'),
            'harga_satuan' => $request->input('harga_satuan')
        ];
        try {
            $query = VolumeDpa::create($input);

            return new VolumeDpaResource($query);

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
            return new VolumeDpaResource(VolumeDpa::findOrFail($id));
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
            'barang_id' => $request->input('barang_id'),
            'tahun_anggaran' => $request->input('tahun_anggaran'),
            'volume' => $request->input('volume'),
            'harga_satuan' => $request->input('harga_satuan')
        ];
        try {
            $query = VolumeDpa::findOrFail($id);
            $query->update($input);

            return new VolumeDpaResource($query);
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
            if (VolumeDpa::destroy($id)) {
                return $this->noContent();
            }

            return $this->errorNotFound();

        } catch (Throwable $th) {
            return $this->errorBadRequest();
        }

    }
}
