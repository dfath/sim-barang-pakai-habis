<?php

namespace App\Http\Controllers\Api;

use App\Services\StokBarangService;
use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\DB;
use App\BarangKeluar;
use App\Http\Resources\BarangKeluarResource;
use App\Http\Resources\BarangKeluarResourceCollection;

class BarangKeluarController extends BaseController
{
    private $stokBarangService;

    public function __construct(
        StokBarangService $stokBarangService
    )
    {
        $this->stokBarangService = $stokBarangService;
    }

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

        // cek stok barang
        $stok = $this->stokBarangService->hitung($input['barang_id'], $input['tanggal'])->stok;
        if ($stok < $input['volume']) {
            return $this->errorBadRequest('Stok barang tidak mencukupi!');
        }

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

    /**
     * Laporan barang keluar.
     *
     * @return \Illuminate\Http\Response
     */
    public function laporan(Request $request)
    {
        $numberFields = [
            'unit_kerja_id',
            'tanggal_mulai',
            'tanggal_selesai',
            'kelompok_kegiatan_id',
            'kelompok_barang_id'
        ];

        $numberWhereRaws = [
            'unit_kerja_id' => 'unit_kerja_id = ?',
            'tanggal_mulai' => 'tanggal >= ?',
            'tanggal_selesai' => 'tanggal <= ?',
            'kelompok_kegiatan_id' => 'kelompok_kegiatan_id = ?',
            'kelompok_barang_id' => 'kelompok_barang_id = ?',
        ];

        $numberFilter = $request->only($numberFields);

        if (!$request->has(['tanggal_mulai', 'tanggal_selesai'])) {
            return $this->errorBadRequest('Paramater interval tanggal tidak ada!');
        }

        $query = DB::table('barang_keluar');
        $query->select('barang_keluar.barang_id');
        $query->addSelect(DB::raw('COALESCE( SUM(volume), 0) as total_volume'));
        // barang
        $query->leftJoin('barang', 'barang_keluar.barang_id', '=', 'barang.id');
        $query->addSelect('barang.nama as nama_barang');

        foreach ($numberFilter as $key => $value) {
            $query->whereRaw($numberWhereRaws[$key], [$value]);
        }

        $query->groupBy('barang_id', 'nama_barang');

        $list = $query->get();
        $result = array();

        foreach ($list as $key => $value) {
            $stokMulai = $this->stokBarangService->hitung($value->barang_id, $request->get('tanggal_mulai'));

            $stokSelesai = $this->stokBarangService->hitung($value->barang_id, $request->get('tanggal_selesai'));

            $result[] = array(
                'no' => $key + 1,
                'barang_id' => $value->barang_id,
                'nama_barang' => $value->nama_barang,
                'sisa' => $stokSelesai->stok,
                'total_harga' => $stokSelesai->totalHargaBarangKeluar - $stokMulai->totalHargaBarangKeluar,
                'total_volume' => intval($value->total_volume)
            );
        }

        return array('data' => $result);
    }
}
