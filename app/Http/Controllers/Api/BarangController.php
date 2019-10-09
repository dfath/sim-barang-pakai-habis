<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\DB;
use App\Barang;
use App\Http\Resources\BarangResource;
use App\Http\Resources\BarangResourceCollection;

class BarangController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $numberFields = [
            'kelompok_kegiatan_id',
            'kelompok_barang_id',
            'satuan_id',
        ];
        $textFields = [
            'nama',
            'nama_satuan',
            'nama_kelompok_kegiatan',
            'nama_kelompok_barang',
        ];
        $numberWhereRaws = [
            'kelompok_kegiatan_id' => 'kelompok_kegiatan_id = ?',
            'kelompok_barang_id' => 'kelompok_barang_id = ?',
            'satuan_id' => 'satuan_id = ?',
        ];
        $textFieldMaps = [
            'nama' => 'barang.nama',
            'nama_satuan' => 'satuan.nama',
            'nama_kelompok_kegiatan' => 'kelompok_kegiatan.nama',
            'nama_kelompok_barang' => 'kelompok_barang.nama',
        ];
        $numberFilter = $request->only($numberFields);
        $textFilter = $request->only($textFields);

        $query = DB::table('barang');
        $query->select('barang.*');
        // satuan
        $query->leftJoin('satuan', 'barang.satuan_id', '=', 'satuan.id');
        $query->addSelect('satuan.nama as nama_satuan');
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

        return new BarangResourceCollection($query->paginate());
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
            'kelompok_barang_id' => $request->input('kelompok_barang_id'),
            'satuan_id' => $request->input('satuan_id'),
            'nama' => $request->input('nama'),
        ];
        try {
            $query = Barang::create($input);

            return new BarangResource($query);

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
            return new BarangResource(Barang::findOrFail($id));
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
            'kelompok_barang_id' => $request->input('kelompok_barang_id'),
            'satuan_id' => $request->input('satuan_id'),
            'nama' => $request->input('nama'),
        ];
        try {
            $query = Barang::findOrFail($id);
            $query->update($input);

            return new BarangResource($query);
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
            if (Barang::destroy($id)) {
                return $this->noContent();
            }

            return $this->errorNotFound();

        } catch (Throwable $th) {
            return $this->errorBadRequest();
        }

    }
}
