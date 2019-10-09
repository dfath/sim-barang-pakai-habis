<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\DB;
use App\BarangMasuk;
use App\Repositories\BarangMasukRepository;
use App\Http\Resources\BarangMasukResource;
use App\Http\Resources\BarangMasukResourceCollection;

class BarangMasukController extends BaseController
{

    protected $barangMasukRepository;

    public function __construct(BarangMasukRepository $barangMasukRepository)
    {
        $this->barangMasukRepository = $barangMasukRepository;
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
            'perusahaan_id',
            'tahun_anggaran',
            'tanggal_perolehan_mulai',
            'tanggal_perolehan_selesai',
        ];
        $textFields = [
            'bukti_transaksi',
            'nama_perusahaan',
            'nama_kelompok_kegiatan',
            'nama_kelompok_barang',
        ];
        $numberWhereRaws = [
            'kelompok_kegiatan_id' => 'kelompok_kegiatan_id = ?',
            'kelompok_barang_id' => 'kelompok_barang_id = ?',
            'perusahaan_id' => 'perusahaan_id = ?',
            'tahun_anggaran' => 'tahun_anggaran = ?',
            'tanggal_perolehan_mulai' => 'tanggal_perolehan >= ?',
            'tanggal_perolehan_selesai' => 'tanggal_perolehan <= ?',
        ];
        $textFieldMaps = [
            'bukti_transaksi' => 'bukti_transaksi',
            'nama_perusahaan' => 'perusahaan.nama',
            'nama_kelompok_kegiatan' => 'kelompok_kegiatan.nama',
            'nama_kelompok_barang' => 'kelompok_barang.nama',
        ];
        $numberFilter = $request->only($numberFields);
        $textFilter = $request->only($textFields);

        $query = DB::table('barang_masuk');
        $query->select('barang_masuk.*');
        // perusahaan
        $query->leftJoin('perusahaan', 'barang_masuk.perusahaan_id', '=', 'perusahaan.id');
        $query->addSelect('perusahaan.nama as nama_perusahaan');
        // kelompok kegiatan
        $query->leftJoin('kelompok_kegiatan', 'barang_masuk.kelompok_kegiatan_id', '=', 'kelompok_kegiatan.id');
        $query->addSelect('kelompok_kegiatan.nama as nama_kelompok_kegiatan');
        // kelompok barang
        $query->leftJoin('kelompok_barang', 'barang_masuk.kelompok_barang_id', '=', 'kelompok_barang.id');
        $query->addSelect('kelompok_barang.nama as nama_kelompok_barang');

        foreach ($numberFilter as $key => $value) {
            $query->whereRaw($numberWhereRaws[$key], [$value]);
        }

        foreach ($textFilter as $key => $value) {
            $query->where($textFieldMaps[$key], 'like', "%$value%");
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
            'bukti_transaksi' => $request->input('bukti_transaksi')
        ];
        try {
            $query = BarangMasuk::create($input);

            return new BarangMasukResource($query);

        } catch (Throwable $th) {
            return $this->errorBadRequest($th->getMessage());
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

            $query = DB::table('barang_masuk');
            $query->select('barang_masuk.*');
            // perusahaan
            $query->leftJoin('perusahaan', 'barang_masuk.perusahaan_id', '=', 'perusahaan.id');
            $query->addSelect('perusahaan.nama as nama_perusahaan');
            // kelompok kegiatan
            $query->leftJoin('kelompok_kegiatan', 'barang_masuk.kelompok_kegiatan_id', '=', 'kelompok_kegiatan.id');
            $query->addSelect('kelompok_kegiatan.nama as nama_kelompok_kegiatan');
            // kelompok barang
            $query->leftJoin('kelompok_barang', 'barang_masuk.kelompok_barang_id', '=', 'kelompok_barang.id');
            $query->addSelect('kelompok_barang.nama as nama_kelompok_barang');
            $query->whereRaw('barang_masuk.id = ?', [$id]);

            return new BarangMasukResource($query->first());
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
            'bukti_transaksi' => $request->input('bukti_transaksi')
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

    /**
     * Laporan barang masuk.
     *
     * @return \Illuminate\Http\Response
     */
    public function laporan(Request $request)
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
        $result = array();

        foreach ($list as $key => $value) {
            $rekap = $this->barangMasukRepository->volumeDpaPerTanggal(
                $value->barang_id,
                $value->tahun_anggaran,
                $request->get('tanggal_perolehan_mulai'),
                $request->get('tanggal_perolehan_selesai')
            );
            $result[] = array(
                'no' => $key + 1,
                'barang_id' => $value->barang_id,
                'nama_barang' => $value->nama_barang,
                'tahun_anggaran' => $value->tahun_anggaran,
                'volume_dpa' => $value->volume_dpa,
                'total_harga' => $rekap->total_harga,
                'total_volume' => intval($rekap->total_volume),
            );
        }

        return array('data' => $result);
    }
}
