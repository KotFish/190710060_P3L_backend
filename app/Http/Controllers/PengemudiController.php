<?php

namespace App\Http\Controllers;

use App\Models\Pengemudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PengemudiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Pengemudi::all();
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
            'tanggal_lahir' => ['filled', 'date_format:Y-m-d'],
            'jenis_kelamin' => ['filled', Rule::in(['Laki-laki', 'Perempuan'])],
            'bahasa' => ['filled', 'array', Rule::in(['Indonesia', 'Inggris'])],
            'tersedia' => ['filled', 'boolean'],
            'email' => ['required', 'email:filter', 'unique:pegawai', 'unique:pengemudi', 'unique:pelanggan'],
            'password' => ['required', 'string'],
        ]);

        if (isset($data['bahasa'])) {
            $data['bahasa'] = implode(",", $data['bahasa']);
        }

        $data['password'] = Hash::make($data['password']);

        $model = Pengemudi::create($data);

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
        $data = Pengemudi::find($id);

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
        $oldData = Pengemudi::find($id);

        if ($oldData === null) {
            return response()->json([
                'message' => 'Data id ' . $id . ' tidak ditemukan.'
            ], 404);
        }

        $newData = $request->validate([
            'tanggal_lahir' => ['filled', 'date_format:Y-m-d'],
            'jenis_kelamin' => ['filled', Rule::in(['Laki-laki', 'Perempuan'])],
            'bahasa' => ['filled', 'array', Rule::in(['Indonesia', 'Inggris'])],
            'tersedia' => ['filled', 'boolean'],
            'email' => ['filled', 'email:filter', 'unique:pegawai', Rule::unique('pengemudi')->ignore($id), 'unique:pelanggan'],
            'password' => ['filled', 'string'],
        ]);

        if (empty($newData)) {
            return response()->json([
                'message' => 'Data baru tidak ditemukan.'
            ], 422);
        }

        if (isset($newData['bahasa'])) {
            $newData['bahasa'] = implode(',', $newData['bahasa']);
        }

        if (isset($newData['password'])) {
            $newData['password'] = Hash::make($newData['password']);
        }

        Pengemudi::where('id', $id)->update($newData);

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
        $data = Pengemudi::find($id);

        if ($data === null) {
            return response()->json([
                'message' => 'Data id ' . $id . ' tidak ditemukan.'
            ], 404);
        }

        Pengemudi::destroy($id);
        
        return response()->json([
            'message' => 'Data id ' . $id . ' berhasil dihapus.'
        ]);
    }
}
