<?php

namespace App\Http\Controllers;

use App\Models\Autoincrement;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Pelanggan::all();
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
            'tanggal_lahir' => ['required', 'date_format:Y-m-d', 'before_or_equal:17 years ago'],
            'jenis_kelamin' => ['filled', Rule::in(['Laki-laki', 'Perempuan'])],
            'email' => ['required', 'email:filter', 'unique:pegawai', 'unique:pengemudi', 'unique:pelanggan'],
            'password' => ['sometimes', 'string'],
        ]);

        if (empty($data['password'])) {
            $data['password'] = $data['tanggal_lahir'];
        }

        $data['password'] = Hash::make($data['password']);

        $aiModel = Autoincrement::find('pelanggan');

        $data['id'] = 'CUS' . date('ymd') . '-' . $aiModel->value;

        $model = Pelanggan::create($data);

        $aiModel->value = $aiModel->value + 1;

        $aiModel->save();

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
        $data = Pelanggan::find($id);

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
        $oldData = Pelanggan::find($id);

        if ($oldData === null) {
            return response()->json([
                'message' => 'Data id ' . $id . ' tidak ditemukan.'
            ], 404);
        }

        $newData = $request->validate([
            'tanggal_lahir' => ['filled', 'date_format:Y-m-d', 'before_or_equal:17 years ago'],
            'jenis_kelamin' => ['filled', Rule::in(['Laki-laki', 'Perempuan'])],
            'email' => ['filled', 'email:filter', 'unique:pegawai', 'unique:pengemudi', Rule::unique('pelanggan')->ignore($id)],
            'password' => ['filled', 'string'],
        ]);

        if (empty($newData)) {
            return response()->json([
                'message' => 'Data baru tidak ditemukan.'
            ], 422);
        }

        unset($newData['id']);
        
        if (isset($newData['password'])) {
            $newData['password'] = Hash::make($newData['password']);
        }
        
        Pelanggan::where('id', $id)->update($newData);

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
        $data = Pelanggan::find($id);

        if ($data === null) {
            return response()->json([
                'message' => 'Data id ' . $id . ' tidak ditemukan.'
            ], 404);
        }

        Pelanggan::destroy($id);
        
        return response()->json([
            'message' => 'Data id ' . $id . ' berhasil dihapus.'
        ]);
    }
}
