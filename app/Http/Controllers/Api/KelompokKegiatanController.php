<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\DB;
use App\KelompokKegiatan;
use App\Http\Resources\KelompokKegiatanResource;
use App\Http\Resources\KelompokKegiatanResourceCollection;

class KelompokKegiatanController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fields = [
            'nama'
        ];
        $whereRaws = [
            'nama' => 'nama = ?'
        ];
        $filter = $request->only($fields);

        $query = DB::table('kelompok_kegiatan');
        foreach ($filter as $key => $value) {
            $query->whereRaw($whereRaws[$key], [$value]);
        }

        return new KelompokKegiatanResourceCollection($query->paginate());
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
            'nama' => $request->input('nama')
        ];
        try {
            $query = KelompokKegiatan::create($input);

            return new KelompokKegiatanResource($query);

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
            return new KelompokKegiatanResource(KelompokKegiatan::findOrFail($id));
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
            'nama' => $request->input('nama')
        ];
        try {
            $query = KelompokKegiatan::findOrFail($id);
            $query->update($input);

            return new KelompokKegiatanResource($query);
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
            if (KelompokKegiatan::destroy($id)) {
                return $this->noContent();
            }

            return $this->errorNotFound();

        } catch (Throwable $th) {
            return $this->errorBadRequest();
        }

    }
}
