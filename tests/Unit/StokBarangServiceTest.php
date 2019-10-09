<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use App\Services\StokBarangService;
use App\Repositories\BarangMasukRepository;
use App\Repositories\BarangKeluarRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StokBarangServiceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHitungStokBarangItem()
    {
        $barang_id = 68;
        $tanggal= date('Y-m-d');
        $barangMasuk = new BarangMasukRepository;
        $barangKeluar = new BarangKeluarRepository;
        $service = new StokBarangService($barangMasuk, $barangKeluar);
        $result = $service->hitung($barang_id, $tanggal);

        $this->assertTrue(count($result) > 0);
    }

    public function testHitungStokBarangList()
    {
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

        $query->addSelect(DB::raw('100 as stok'));

        // $query->whereRaw('barang.kelompok_kegiatan_id = ?', [1]);

        $pages = $query->paginate(500);

        $barangMasuk = new BarangMasukRepository;
        $barangKeluar = new BarangKeluarRepository;
        $service = new StokBarangService($barangMasuk, $barangKeluar);

        $tanggal = date('Y-m-d');
        $pages->getCollection()->transform(function ($value) use($service, $tanggal) {
            $value->stok = $service->hitung($value->id, $tanggal)->stok;
            return $value;
        });

        $this->assertTrue(count($pages) > 0);
    }

}
