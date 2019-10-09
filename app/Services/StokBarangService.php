<?php

namespace App\Services;

use DB;
use App\Repositories\BarangMasukRepository;
use App\Repositories\BarangKeluarRepository;

/**
 * Stok Barang
 */
class StokBarangService
{

    private $barangMasukRepository;

    private $barangKeluarRepository;

    private $barangId;

    private $tanggal;

    private $aggregateBarangMasuk;

    private $aggregateBarangKeluar;

    public function __construct(
        BarangMasukRepository $barangMasukRepository,
        BarangKeluarRepository $barangKeluarRepository
    )
    {
        $this->barangMasukRepository = $barangMasukRepository;
        $this->barangKeluarRepository = $barangKeluarRepository;
    }

    private function volumeBarangMasuk()
    {
        $this->aggregateBarangMasuk = $this->barangMasukRepository
            ->volumeBarangMasukPerTanggal($this->barangId, '0000-00-00', $this->tanggal);
    }

    private function volumeBarangKeluar()
    {
        $this->aggregateBarangKeluar = $this->barangKeluarRepository
            ->volumeBarangKeluarPerTanggal($this->barangId, '0000-00-00', $this->tanggal);
    }

    private function aggregate()
    {
        $totalVolumeBarangKeluar = $counterBarangKeluar = intval($this->aggregateBarangKeluar->total_volume);
        $totalVolumeBarangMasuk = $totalHargaBarangMasuk = $totalHargaStok = $stok = 0;

        // hitung stok barang
        foreach ($this->aggregateBarangMasuk as $barangMasuk) {
            $totalVolumeBarangMasuk += $barangMasuk->total_volume;
            $totalHargaBarangMasuk += $barangMasuk->total_harga;

            if ($counterBarangKeluar >= $barangMasuk->total_volume) {
                $counterBarangKeluar -= $barangMasuk->total_volume;
                $totalHargaStok += $barangMasuk->total_harga;
            } elseif (($barangMasuk->total_volume - $counterBarangKeluar) >= 1 ) {
                $totalHargaStok += $barangMasuk->harga_satuan * ($barangMasuk->total_volume - $counterBarangKeluar);
                $counterBarangKeluar = 0;
            }
        }

        $stok = $totalVolumeBarangMasuk - $totalVolumeBarangKeluar;

        $result = new \stdClass;
        $result->stok = $stok;
        $result->totalHargaStok = $totalHargaStok;
        $result->totalHargaBarangMasuk = $totalHargaBarangMasuk;
        $result->totalVolumeBarangMasuk = $totalVolumeBarangMasuk;
        $result->totalVolumeBarangKeluar = $totalVolumeBarangKeluar;

        return $result;
    }

    public function hitung($barangId, $tanggal)
    {
        $this->barangId = $barangId;
        $this->tanggal = $tanggal;
        $this->stok = 0;

        $this->volumeBarangMasuk();
        $this->volumeBarangKeluar();

        return $this->aggregate();
    }

}
