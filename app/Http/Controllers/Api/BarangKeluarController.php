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
        $numberFields = [
            'barang_id',
            'unit_kerja_id',
            'volume',
            'tanggal'
        ];
        $textFields = [
            'nama_unit_kerja',
            'nama_barang',
        ];
        $numberWhereRaws = [
            'barang_id' => 'barang_id = ?',
            'unit_kerja_id' => 'unit_kerja_id = ?',
            'volume' => 'volume = ?',
            'tanggal' => 'tanggal = ?'
        ];
        $textFieldMaps = [
            'nama_unit_kerja' => 'unit_kerja.nama',
            'nama_barang' => 'barang.nama',
        ];

        $numberFilter = $request->only($numberFields);
        $textFilter = $request->only($textFields);

        $query = DB::table('barang_keluar');
        $query->select('barang_keluar.*');
        // unit kerja
        $query->leftJoin('unit_kerja', 'barang_keluar.unit_kerja_id', '=', 'unit_kerja.id');
        $query->addSelect('unit_kerja.nama as nama_unit_kerja');
        // barang
        $query->leftJoin('barang', 'barang_keluar.barang_id', '=', 'barang.id');
        $query->addSelect('barang.nama as nama_barang');
        // kelompok kegiatan
        $query->leftJoin('kelompok_kegiatan', 'barang.kelompok_kegiatan_id', '=', 'kelompok_kegiatan.id');
        $query->addSelect('kelompok_kegiatan.id as kelompok_kegiatan_id');
        $query->addSelect('kelompok_kegiatan.nama as nama_kelompok_kegiatan');
        // kelompok barang
        $query->leftJoin('kelompok_barang', 'barang.kelompok_barang_id', '=', 'kelompok_barang.id');
        $query->addSelect('kelompok_barang.id as kelompok_barang_id');
        $query->addSelect('kelompok_barang.nama as nama_kelompok_barang');

        foreach ($numberFilter as $key => $value) {
            $query->whereRaw($numberWhereRaws[$key], [$value]);
        }

        foreach ($textFilter as $key => $value) {
            $query->where($textFieldMaps[$key], 'like', "%$value%");
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
