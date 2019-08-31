<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\DB;
use App\Perusahaan;
use App\Http\Resources\PerusahaanResource;
use App\Http\Resources\PerusahaanResourceCollection;

class PerusahaanController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fields = [
            'nama',
            'alamat',
            'pimpinan'
        ];
        $whereRaws = [
            'nama' => 'nama = ?',
            'alamat' => 'alamat = ?',
            'pimpinan' => 'pimpinan = ?'
        ];
        $filter = $request->only($fields);

        $query = DB::table('perusahaan');
        foreach ($filter as $key => $value) {
            $query->whereRaw($whereRaws[$key], [$value]);
        }

        return new PerusahaanResourceCollection($query->paginate());
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
            'nama' => $request->input('nama'),
            'alamat' => $request->input('alamat'),
            'pimpinan' => $request->input('pimpinan')
        ];
        try {
            $query = Perusahaan::create($input);

            return new PerusahaanResource($query);

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
            return new PerusahaanResource(Perusahaan::findOrFail($id));
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
            'nama' => $request->input('nama'),
            'alamat' => $request->input('alamat'),
            'pimpinan' => $request->input('pimpinan')
        ];
        try {
            $query = Perusahaan::findOrFail($id);
            $query->update($input);

            return new PerusahaanResource($query);
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
            if (Perusahaan::destroy($id)) {
                return $this->noContent();
            }

            return $this->errorNotFound();

        } catch (Throwable $th) {
            return $this->errorBadRequest();
        }

    }
}
