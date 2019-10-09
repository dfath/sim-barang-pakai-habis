<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Repositories\BarangMasukRepository;
use App\KelompokKegiatan;
use App\KelompokBarang;
use App\UnitKerja;
use App\Services\StokBarangService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    private $stokBarangService;

    public function __construct(
        StokBarangService $stokBarangService
    )
    {
        $this->stokBarangService = $stokBarangService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('barang-keluar.board');
    }

    /**
     * laporan barang keluar
     *
     * @return \Illuminate\Http\Response
     */
    public function laporan()
    {
        return view('barang-keluar.laporan');
    }

    /**
     * Laporan barang keluar.
     *
     * @return \Illuminate\Http\Response
     */
    public function laporanExcel(Request $request)
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

        // generate file excel
        $spreadsheet = new Spreadsheet();
        $index = 1;

        if ($request->has('kelompok_kegiatan_id')) {
            $label = KelompokKegiatan::find($request->get('kelompok_kegiatan_id'));
            $spreadsheet
                ->setActiveSheetIndex(0)
                ->setCellValue('A' . $index, 'Kelompok Kegiatan')
                ->setCellValue('B' . $index, $label->nama);
            $index++;
        }

        if ($request->has('kelompok_barang_id')) {
            $label = KelompokBarang::find($request->get('kelompok_barang_id'));
            $spreadsheet
                ->setActiveSheetIndex(0)
                ->setCellValue('A' . $index, 'Kelompok Barang')
                ->setCellValue('B' . $index, $label->nama);
            $index++;
        }

        if ($request->has('unit_kerja_id')) {
            $label = UnitKerja::find($request->get('unit_kerja_id'));
            $spreadsheet
                ->setActiveSheetIndex(0)
                ->setCellValue('A' . $index, 'Unit Kerja')
                ->setCellValue('B' . $index, $label->nama);
            $index++;
        }

        if ($request->has('tanggal_mulai')) {
            $spreadsheet
                ->setActiveSheetIndex(0)
                ->setCellValue('A' . $index, 'Tanggal Mulai')
                ->setCellValue('B' . $index, $request->get('tanggal_mulai'));
            $index++;
        }

        if ($request->has('tanggal_selesai')) {
            $spreadsheet
                ->setActiveSheetIndex(0)
                ->setCellValue('A' . $index, 'Tanggal Selesai')
                ->setCellValue('B' . $index, $request->get('tanggal_selesai'));
            $index++;
        }

        $index++;

        $spreadsheet
            ->setActiveSheetIndex(0)
            ->setCellValue('A' . $index, 'Nama Barang')
            ->setCellValue('B' . $index, 'Sisa')
            ->setCellValue('C' . $index, 'Jumlah Barang Keluar')
            ->setCellValue('D' . $index, 'Nilai (Jumlah barang * harga satuan)');


        foreach ($list as $key => $value) {
            $stokMulai = $this->stokBarangService->hitung($value->barang_id, $request->get('tanggal_mulai'));

            $stokSelesai = $this->stokBarangService->hitung($value->barang_id, $request->get('tanggal_selesai'));

            $i = $key + $index;

            $spreadsheet
                ->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $value->nama_barang)
                ->setCellValue('B' . $i, $stokSelesai->stok)
                ->setCellValue('C' . $i, intval($value->total_volume))
                ->setCellValue('D' . $i, $stokSelesai->totalHargaBarangKeluar - $stokMulai->totalHargaBarangKeluar);
        }

        $filename = "laporan-barang-keluar-" . date('YmdHis') . ".xls";

        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        // serving to IE 9
        header('Cache-Control: max-age=1');
        // serving to IE over SSL
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
        exit;
    }
}
