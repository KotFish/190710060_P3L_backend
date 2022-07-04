<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Promo::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => ['required', 'string', 'unique:promo'],
            'persentase' => ['filled', 'integer', 'between:0,100'],
            'aktif' => ['filled', 'boolean']
        ]);

        $model = Promo::create($data);

        return response()->json([
            'message' => 'Data id ' . $model->id . ' berhasil ditambah.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Promo::find($id);

        if ($data === null) {
            return response()->json([
                'message' => 'Data id ' . $id . ' tidak ditemukan.'
            ], 404);
        }

        return $data;
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
        $oldData = Promo::find($id);

        if ($oldData === null) {
            return response()->json([
                'message' => 'Data id ' . $id . ' tidak ditemukan.'
            ], 404);
        }

        $newData = $request->validate([
            'id' => ['filled', 'string', Rule::unique('promo')->ignore($id)],
            'persentase' => ['filled', 'integer', 'between:0,100'],
            'aktif' => ['filled', 'boolean']
        ]);

        if (empty($newData)) {
            return response()->json([
                'message' => 'Data baru tidak ditemukan.'
            ], 422);
        }

        Promo::where('id', $id)->update($newData);

        return response()->json([
            'message' => 'Data id ' . $id . ' berhasil diubah.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Promo::find($id);

        if ($data === null) {
            return response()->json([
                'message' => 'Data id ' . $id . ' tidak ditemukan.'
            ], 404);
        }

        Promo::destroy($id);
        
        return response()->json([
            'message' => 'Data id ' . $id . ' berhasil dihapus.'
        ]);
    }
}
