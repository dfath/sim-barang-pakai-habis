<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\DB;
use App\BarangMasuk;
use App\Http\Resources\BarangMasukResource;
use App\Http\Resources\BarangMasukResourceCollection;

class BarangMasukController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fields = [
            'kelompok_kegiatan_id',
            'kelompok_barang_id',
            'perusahaan_id',
            'tahun_anggaran',
            'tanggal_perolehan_mulai',
            'tanggal_perolehan_selesai',
            'bukti_tansaksi'
        ];
        $whereRaws = [
            'kelompok_kegiatan_id' => 'kelompok_kegiatan_id = ?',
            'kelompok_barang_id' => 'kelompok_kegiatan_id = ?',
            'perusahaan_id' => 'perusahaan_id = ?',
            'tahun_anggaran' => 'tahun_anggaran = ?',
            'tanggal_perolehan_mulai' => 'tanggal_perolehan >= ?',
            'tanggal_perolehan_selesai' => 'tanggal_perolehan <= ?',
            'bukti_tansaksi' => 'bukti_tansaksi = ?'
        ];
        $filter = $request->only($fields);

        $query = DB::table('barang_masuk');
        foreach ($filter as $key => $value) {
            $query->whereRaw($whereRaws[$key], [$value]);
        }

        return new BarangMasukResourceCollection($query->paginate());
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
            'perusahaan_id' => $request->input('perusahaan_id'),
            'tahun_anggaran' => $request->input('tahun_anggaran'),
            'tanggal_perolehan' => $request->input('tanggal_perolehan'),
            'jenis_bukti' => $request->input('jenis_bukti'),
            'bukti_tansaksi' => $request->input('bukti_tansaksi')
        ];
        try {
            $query = BarangMasuk::create($input);

            return new BarangMasukResource($query);

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
            return new BarangMasukResource(BarangMasuk::findOrFail($id));
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
            'perusahaan_id' => $request->input('perusahaan_id'),
            'tahun_anggaran' => $request->input('tahun_anggaran'),
            'tanggal_perolehan' => $request->input('tanggal_perolehan'),
            'jenis_bukti' => $request->input('jenis_bukti'),
            'bukti_tansaksi' => $request->input('bukti_tansaksi')
        ];
        try {
            $query = BarangMasuk::findOrFail($id);
            $query->update($input);

            return new BarangMasukResource($query);
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
            if (BarangMasuk::destroy($id)) {
                return $this->noContent();
            }

            return $this->errorNotFound();

        } catch (Throwable $th) {
            return $this->errorBadRequest();
        }

    }
}
