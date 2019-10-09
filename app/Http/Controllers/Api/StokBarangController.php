<?php

namespace App\Http\Controllers\Api;

use App\Services\StokBarangService;
use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\StokBarangResource;
use App\Http\Resources\StokBarangResourceCollection;

class StokBarangController extends BaseController
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
            'kelompok_kegiatan_id' => 'barang.kelompok_kegiatan_id = ?',
            'kelompok_barang_id' => 'barang.kelompok_barang_id = ?',
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

        /** @todo hitung stok barang */
        $query->addSelect(DB::raw('100 as stok'));

        foreach ($numberFilter as $key => $value) {
            $query->whereRaw($numberWhereRaws[$key], [$value]);
        }

        foreach ($textFilter as $key => $value) {
            $query->where($textFieldMaps[$key], 'like', "%$value%");
        }

        $tanggal = ($request->has('tanggal')) ? $request->input('tanggal') : date('Y-m-d');
        $service = $this->stokBarangService;

        $pages = $query->paginate();
        $pages->getCollection()->transform(function ($value) use($service, $tanggal) {
            $value->stok = $service->hitung($value->id, $tanggal)->stok;
            return $value;
        });

        return new StokBarangResourceCollection($pages);
    }

}
