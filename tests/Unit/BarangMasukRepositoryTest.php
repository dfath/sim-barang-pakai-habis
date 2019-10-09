<?php

namespace Tests\Unit;

use App\Repositories\BarangMasukRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BarangMasukRepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testVolumeDpaPerTanggal()
    {
        $barang_id = 78;
        $tahun_anggaran = 2019;
        $tanggal_mulai = "2018-12-17";
        $tanggal_selesai = "2019-06-18";
        $service = new BarangMasukRepository;
        $result = $service->volumeDpaPerTanggal($barang_id, $tahun_anggaran, $tanggal_mulai, $tanggal_selesai);

        $this->assertTrue(property_exists($result, 'total_volume'));
        $this->assertTrue(property_exists($result, 'total_harga'));
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testVolumeBarangMasukPerTanggal()
    {
        $barang_id = 68;
        $tanggal_mulai = "2017-12-17";
        $tanggal_selesai = date('Y-m-d');
        $service = new BarangMasukRepository;
        $result = $service->volumeBarangMasukPerTanggal($barang_id, $tanggal_mulai, $tanggal_selesai);

        $this->assertTrue(count($result) > 0);
    }
}
