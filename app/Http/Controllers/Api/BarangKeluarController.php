<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\DB;
use App\BarangKeluar;
use App\Http\Resources\BarangKeluarResource;
use App\Http\Resources\BarangKeluarResourceCollection;

class BarangKeluarController extends BaseController
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
            'unit_kerja_id',
            'volume',
            'tanggal'
        ];
        $whereRaws = [
            'barang_id' => 'barang_id = ?',
            'unit_kerja_id' => 'unit_kerja_id = ?',
            'volume' => 'volume = ?',
            'tanggal' => 'tanggal = ?'
        ];
        $filter = $request->only($fields);

        $query = DB::table('barang_keluar');
        foreach ($filter as $key => $value) {
            $query->whereRaw($whereRaws[$key], [$value]);
        }

        return new BarangKeluarResourceCollection($query->paginate());
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
            'unit_kerja_id' => $request->input('unit_kerja_id'),
            'volume' => $request->input('volume'),
            'tanggal' => $request->input('tanggal')
        ];
        try {
            $query = BarangKeluar::create($input);

            return new BarangKeluarResource($query);

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
            return new BarangKeluarResource(BarangKeluar::findOrFail($id));
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
            'unit_kerja_id' => $request->input('unit_kerja_id'),
            'volume' => $request->input('volume'),
            'tanggal' => $request->input('tanggal')
        ];
        try {
            $query = BarangKeluar::findOrFail($id);
            $query->update($input);

            return new BarangKeluarResource($query);
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
            if (BarangKeluar::destroy($id)) {
                return $this->noContent();
            }

            return $this->errorNotFound();

        } catch (Throwable $th) {
            return $this->errorBadRequest();
        }

    }
}
