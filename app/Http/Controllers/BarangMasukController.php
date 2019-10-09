<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Repositories\BarangMasukRepository;
use App\KelompokKegiatan;
use App\KelompokBarang;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    protected $barangMasukRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BarangMasukRepository $barangMasukRepository)
    {
        $this->middleware('auth');
        $this->barangMasukRepository = $barangMasukRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('barang-masuk.board');
    }

    /**
     * edit barang masuk
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        /** @todo cek jika $id exists & valid */
        return view('barang-masuk.edit', ['id'=>$id]);
    }

    /**
     * laporan barang masuk
     *
     * @return \Illuminate\Http\Response
     */
    public function laporan()
    {
        return view('barang-masuk.laporan');
    }

    /**
     * Laporan barang masuk.
     *
     * @return \Illuminate\Http\Response
     */
    public function laporanExcel(Request $request)
    {
        $numberFields = [
            'kelompok_kegiatan_id',
            'kelompok_barang_id',
            'tahun_anggaran',
            'tanggal_perolehan_mulai',
            'tanggal_perolehan_selesai',
        ];
        $numberWhereRaws = [
            'kelompok_kegiatan_id' => 'kelompok_kegiatan_id = ?',
            'kelompok_barang_id' => 'kelompok_barang_id = ?',
            'tahun_anggaran' => 'tahun_anggaran = ?',
            'tanggal_perolehan_mulai' => 'tanggal_perolehan >= ?',
            'tanggal_perolehan_selesai' => 'tanggal_perolehan <= ?',
        ];

        $numberFilter = $request->only($numberFields);

        if (!$request->has(['tanggal_perolehan_mulai', 'tanggal_perolehan_selesai'])) {
            return $this->errorBadRequest('Paramater interval tanggal tidak ada!');
        }

        $query = DB::table('barang_masuk_detil_view');
        $query->select('barang_id', 'nama_barang', 'tahun_anggaran', 'volume_dpa');

        foreach ($numberFilter as $key => $value) {
            $query->whereRaw($numberWhereRaws[$key], [$value]);
        }

        $query->groupBy('barang_id', 'nama_barang', 'tahun_anggaran', 'volume_dpa');

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

        if ($request->has('tahun_anggaran')) {
            $spreadsheet
                ->setActiveSheetIndex(0)
                ->setCellValue('A' . $index, 'Tahun Anggaran')
                ->setCellValue('B' . $index, $request->get('tahun_anggaran'));
            $index++;
        }

        if ($request->has('tanggal_perolehan_mulai')) {
            $spreadsheet
                ->setActiveSheetIndex(0)
                ->setCellValue('A' . $index, 'Tanggal Mulai')
                ->setCellValue('B' . $index, $request->get('tanggal_perolehan_mulai'));
            $index++;
        }

        if ($request->has('tanggal_perolehan_selesai')) {
            $spreadsheet
                ->setActiveSheetIndex(0)
                ->setCellValue('A' . $index, 'Tanggal Selesai')
                ->setCellValue('B' . $index, $request->get('tanggal_perolehan_selesai'));
            $index++;
        }

        $index++;

        $spreadsheet
            ->setActiveSheetIndex(0)
            ->setCellValue('A' . $index, 'Nama Barang')
            ->setCellValue('B' . $index, 'Tahun Anggaran')
            ->setCellValue('C' . $index, 'Volume DPA')
            ->setCellValue('D' . $index, 'Jumlah Barang Masuk')
            ->setCellValue('E' . $index, 'Nilai (Jumlah barang * harga satuan)');

        foreach ($list as $key => $value) {
            $rekap = $this->barangMasukRepository->volumeDpaPerTanggal(
                $value->barang_id,
                $value->tahun_anggaran,
                $request->get('tanggal_perolehan_mulai'),
                $request->get('tanggal_perolehan_selesai')
            );

            $i = $key + $index;

            $spreadsheet
                ->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $value->nama_barang)
                ->setCellValue('B' . $i, $value->tahun_anggaran)
                ->setCellValue('C' . $i, $value->volume_dpa)
                ->setCellValue('D' . $i, $rekap->total_harga)
                ->setCellValue('E' . $i, intval($rekap->total_volume));
        }

        $filename = "laporan-barang-masuk-" . date('YmdHis') . ".xls";

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
