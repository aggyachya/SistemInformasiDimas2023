<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Jurusan;
use App\Models\PencatatanKehadiran;
use Illuminate\Http\Request;

class anggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anggota = Anggota::with('jurusan')->get();
        $jurusan = Jurusan::all();

        
        return view('pages.admin.anggota.index', compact('anggota','jurusan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'jurusan_nama' => 'required',
            'angkatan' => 'required',
            'jabatan' => 'required',
            'posisi' => 'required',
            'nickname' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'motor' => 'required',
        ]);

        // Ambil jurusan_id berdasarkan jurusan_nama
        $jurusanNama = $request->input('jurusan_nama');
        $jurusan = Jurusan::where('nama_jurusan', $jurusanNama)->first();

        // Pastikan jurusan ditemukan sebelum menyimpan data anggota
        if (!$jurusan) {
            return redirect()->back()->with('error', 'Jurusan tidak valid.');
        }

        $dataAnggota = [
            'nama_lengkap' => $request->input('nama_lengkap'),
            'jurusan_id' => $jurusan->id,
            'angkatan' => $request->input('angkatan'),
            'jabatan' => $request->input('jabatan'),
            'posisi' => $request->input('posisi'),
            'nickname' => $request->input('nickname'), // Tambahkan kolom nickname
            'jenis_kelamin' => $request->input('jenis_kelamin'), // Tambahkan kolom jenis_kelamin
            'tanggal_lahir' => $request->input('tanggal_lahir'), // Tambahkan kolom tanggal_lahir
            'motor' => $request->input('motor'), // Tambahkan kolom motor
        ];

        Anggota::create($dataAnggota);

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil disimpan!');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAnggota($id)
    {
        $anggota = Anggota::with('jurusan')->find($id);

        if (!$anggota) {
            return response()->json(['error' => 'Anggota tidak ditemukan'], 404);
        }

        return response()->json($anggota);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $anggota = Anggota::findOrFail($id);
        $jurusan = Jurusan::all();
        return view('pages.admin.anggota.edit', compact('anggota','jurusan'));
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
        $anggota = Anggota::findOrFail($id);
        $this->validate($request, [
            'nama_lengkap' => 'required',
            'jurusan_nama' => 'required',
            'angkatan' => 'required',
            'posisi' => 'required',
            'jabatan' => 'required',
            'nickname' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'motor' => 'required',

        ],[
            'nama_lengkap.required' => 'nama tidak boleh kosong',
            'jurusan_nama.required' => 'jurusan tidak boleh kosong',
            'angkatan.required' => 'angkatan tidak boleh kosong',
            'posisi.required' => 'posisi tidak boleh kosong',
            'jabatan.required' => 'jabatan tidak boleh kosong',
            'nickname.required' => 'nickname tidak boleh kosong',
            'jenis_kelamin.required' => 'jenis kelamin tidak boleh kosong',
            'tanggal_lahir.required' => 'tanggal lahir tidak boleh kosong',
            'motor.required' => 'motor tidak boleh kosong',
        ]);

        $data = $request->all();


        // Ambil jurusan_id berdasarkan jurusan_nama
        $jurusanNama = $request->input('jurusan_nama');
        $jurusan = Jurusan::where('nama_jurusan', $jurusanNama)->first();

        $anggota->update([
        'nama_lengkap' => $data['nama_lengkap'],
        'jurusan_id' => $jurusan->id, // Update jurusan_id
        'angkatan' => $data['angkatan'],
        'posisi' => $data['posisi'],
        'jabatan' => $data['jabatan'],
        'nickname' => $data['nickname'],
        'jenis_kelamin' => $data['jenis_kelamin'],
        'tanggal_lahir' => $data['tanggal_lahir'],
        'motor' => $data['motor'],
        
        ]);

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diperbaharui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);

        // foreach ($anggota->pencatatanKehadiran as $catatan) {
        //     $catatan->delete();
        // }

        // Kemudian hapus anggota
        $anggota->delete();

        return back()->with('success', 'Data anggota berhasil dihapus!');
    }


}
