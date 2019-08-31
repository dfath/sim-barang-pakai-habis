<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\DB;
use App\BarangMasukDetil;
use App\Http\Resources\BarangMasukDetilResource;
use App\Http\Resources\BarangMasukDetilResourceCollection;

class BarangMasukDetilController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fields = [
            'barang_masuk_id',
            'volume_dpa_id'
        ];
        $whereRaws = [
            'barang_masuk_id' => 'barang_masuk_id = ?',
            'volume_dpa_id' => 'volume_dpa_id = ?'
        ];
        $filter = $request->only($fields);

        $query = DB::table('barang_masuk_detil');
        foreach ($filter as $key => $value) {
            $query->whereRaw($whereRaws[$key], [$value]);
        }

        return new BarangMasukDetilResourceCollection($query->paginate());
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
            'barang_masuk_id' => $request->input('barang_masuk_id'),
            'volume_dpa_id' => $request->input('volume_dpa_id'),
            'volume' => $request->input('volume')
        ];
        try {
            $query = BarangMasukDetil::create($input);

            return new BarangMasukDetilResource($query);

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
            return new BarangMasukDetilResource(BarangMasukDetil::findOrFail($id));
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
            'barang_masuk_id' => $request->input('barang_masuk_id'),
            'volume_dpa_id' => $request->input('volume_dpa_id'),
            'volume' => $request->input('volume')
        ];
        try {
            $query = BarangMasukDetil::findOrFail($id);
            $query->update($input);

            return new BarangMasukDetilResource($query);
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
            if (BarangMasukDetil::destroy($id)) {
                return $this->noContent();
            }

            return $this->errorNotFound();

        } catch (Throwable $th) {
            return $this->errorBadRequest();
        }

    }
}
