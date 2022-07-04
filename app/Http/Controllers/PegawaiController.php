<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Pegawai::all();
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
            'jabatan' => ['required', Rule::in(['Manager', 'Administrator', 'Customer Service'])],
            'email' => ['required', 'email:filter', 'unique:pegawai', 'unique:pengemudi', 'unique:pelanggan'],
            'password' => ['required', 'string'],
        ]);

        $data['password'] = Hash::make($data['password']);

        $model = Pegawai::create($data);

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
        $data = Pegawai::find($id);

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
        $oldData = Pegawai::find($id);

        if ($oldData === null) {
            return response()->json([
                'message' => 'Data id ' . $id . ' tidak ditemukan.'
            ], 404);
        }

        $newData = $request->validate([
            'tanggal_lahir' => ['filled', 'date_format:Y-m-d'],
            'jenis_kelamin' => ['filled', Rule::in(['Laki-laki', 'Perempuan'])],
            'jabatan' => ['filled', Rule::in(['Manager', 'Administrator', 'Customer Service'])],
            'email' => ['filled', 'email:filter', Rule::unique('pegawai')->ignore($id), 'unique:pengemudi', 'unique:pelanggan'],
            'password' => ['filled', 'string'],
        ]);

        if (empty($newData)) {
            return response()->json([
                'message' => 'Data baru tidak ditemukan.'
            ], 422);
        }

        if (isset($newData['password'])) {
            $newData['password'] = Hash::make($newData['password']);
        }

        Pegawai::where('id', $id)->update($newData);

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
        $data = Pegawai::find($id);

        if ($data === null) {
            return response()->json([
                'message' => 'Data id ' . $id . ' tidak ditemukan.'
            ], 404);
        }

        Pegawai::destroy($id);
        
        return response()->json([
            'message' => 'Data id ' . $id . ' berhasil dihapus.'
        ]);
    }
}
