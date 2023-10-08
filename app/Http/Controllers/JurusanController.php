<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Anggota;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jurusan = Jurusan::all();

        // Loop melalui setiap jurusan untuk menghitung jumlah anggota
        foreach ($jurusan as $jurusan) {
            $jumlahAnggota = Anggota::where('jurusan_id', $jurusan->id)->count();
            $jurusan->jumlah = $jumlahAnggota;
            $jurusan->save();
        }

        $jurusans = Jurusan::orderByDesc('jumlah')->get();

        return view('pages.admin.jurusan.index', compact('jurusans'));
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
        $this->validate($request, [
            'nama_jurusan' => 'required|unique:jurusans',
        ], [
            'nama_jurusan.unique' => 'Nama Jurusan sudah ada',
        ]);

        Jurusan::create([
            'id' => $request->jurusan_id,
            'nama_jurusan' => $request->nama_jurusan,
        ]);

        return back()->with('success', 'Data jurusan berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return view('pages.admin.jurusan.edit', compact('jurusan'));
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
        $this->validate($request, [
            'nama_jurusan' => 'unique:jurusans',
        ], [
            'nama_jurusan.unique' => 'Nama Jurusan sudah ada',
        ]);

        $data = $request->all();

        $jurusan = Jurusan::findOrFail($id);
        $jurusan->update($data);

        return redirect()->route('jurusan.index')->with('success', 'Data jurusan berhasil diperbaharui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();

        return back()->with('success', 'Data jurusan berhasil dihapus!');
    }
}
