<?php

namespace Tests\Unit;

use App\Repositories\BarangKeluarRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BarangKeluarRepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testVolumeBarangKeluarPerTanggal()
    {
        $barang_id = 68;
        $tanggal_mulai = "2018-12-17";
        $tanggal_selesai = date('Y-m-d');
        $service = new BarangKeluarRepository;
        $result = $service->volumeBarangKeluarPerTanggal($barang_id, $tanggal_mulai, $tanggal_selesai);

        var_dump($result);
        $this->assertTrue(property_exists($result, 'total_volume'));
    }

}
