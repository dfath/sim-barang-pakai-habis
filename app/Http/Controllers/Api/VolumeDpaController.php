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
        $numberFields = [
            'barang_id',
            'tahun_anggaran',
            'volume_min',
            'volume_max',
            'harga_satuan_min',
            'harga_satuan_max',
            'kelompok_kegiatan_id',
            'kelompok_barang_id',
        ];
        $textFields = [
            'nama_barang',
        ];
        $numberWhereRaws = [
            'barang_id' => 'barang_id = ?',
            'tahun_anggaran' => 'tahun_anggaran = ?',
            'volume_min' => 'volume_min >= ?',
            'volume_max' => 'volume_max <= ?',
            'harga_satuan_min' => 'harga_satuan_min >= ?',
            'harga_satuan_max' => 'harga_satuan_max <= ?',
            'kelompok_kegiatan_id' => 'barang.kelompok_kegiatan_id = ?',
            'kelompok_barang_id' => 'barang.kelompok_barang_id = ?',
        ];
        $textFieldMaps = [
            'nama_barang' => 'barang.nama',
        ];
        $numberFilter = $request->only($numberFields);
        $textFilter = $request->only($textFields);

        $query = DB::table('volume_dpa');
        $query->select('volume_dpa.*');
        // barang
        $query->leftJoin('barang', 'volume_dpa.barang_id', '=', 'barang.id');
        $query->addSelect('barang.nama as nama_barang');
        // kelompok kegiatan
        $query->leftJoin('kelompok_kegiatan', 'barang.kelompok_kegiatan_id', '=', 'kelompok_kegiatan.id');
        $query->addSelect('kelompok_kegiatan.nama as nama_kelompok_kegiatan');
        // kelompok barang
        $query->leftJoin('kelompok_barang', 'barang.kelompok_barang_id', '=', 'kelompok_barang.id');
        $query->addSelect('kelompok_barang.nama as nama_kelompok_barang');

        foreach ($numberFilter as $key => $value) {
            $query->whereRaw($numberWhereRaws[$key], [$value]);
        }
        foreach ($textFilter as $key => $value) {
            $query->where($textFieldMaps[$key], 'like', "%$value%");
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
        try {
            $query = VolumeDpa::updateOrCreate([
                    'barang_id' => $request->input('barang_id'),
                    'tahun_anggaran' => $request->input('tahun_anggaran')
                ],
                [
                    'volume' => $request->input('volume'),
                    'harga_satuan' => $request->input('harga_satuan')
                ]);

            return new VolumeDpaResource($query);

        } catch (Throwable $th) {
            return $this->errorBadRequest($th->getMessage());
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
