<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\PencatatanKehadiran;
use App\Models\Anggota;
use App\Models\Rabid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PencatatanKehadiranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pencatatan = PencatatanKehadiran::all();
        $anggota = Anggota::all();
        $rabid = Rabid::all();  

        return view('pages.admin.pencatatan_kehadiran.index', compact('pencatatan', 'anggota', 'rabid'));
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = PencatatanKehadiran::find($id);
        return view('pages.admin.pencatatan_kehadiran.index', compact('pencatatan'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pencatatan_kehadiran = PencatatanKehadiran::findOrFail($id);
        // Mengambil data anggota untuk dropdown select
        $anggota = Anggota::all();

        // Mengambil data rabid untuk dropdown select
        $rabid = Rabid::all();
        return view('pages.admin.pencatatan_kehadiran.edit', compact('pencatatan_kehadiran', 'anggota', 'rabid'));
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
        // Validasi data yang diterima dari request
        $request->validate([
            'status' => 'required', // Atur validasi sesuai kebutuhan Anda
            'catatan' => 'nullable|string', // Atur validasi sesuai kebutuhan Anda
        ]);

        // Temukan data pencatatan kehadiran berdasarkan ID
        $pencatatan_kehadiran = PencatatanKehadiran::find($id);

        if (!$pencatatan_kehadiran) {
            return back()->with('error', 'Pencatatan kehadiran tidak ditemukan.');
        }

        // Perbarui data pencatatan kehadiran dengan data baru
        $pencatatan_kehadiran->status = $request->input('status');
        $pencatatan_kehadiran->catatan = $request->input('catatan');

        $pencatatan_kehadiran->save();

        return redirect()->route('pencatatan_kehadiran.index')
            ->with('success', 'Data pencatatan kehadiran berhasil diperbarui.');
    }

    public function getPencatatanKehadiran($id)
    {
        $pencatatan_kehadiran = PencatatanKehadiran::findOrFail($id);

        // Mengambil data Anggota berdasarkan anggota_id pada Pencatatan Kehadiran
        $anggota = $pencatatan_kehadiran->anggota;

        // Mengambil data Rabid berdasarkan rabid_id pada Pencatatan Kehadiran
        $rabid = $pencatatan_kehadiran->rabid;

        return response()->json([
            'pencatatan_kehadiran' => $pencatatan_kehadiran,
            'anggota' => $anggota,
            'rabid' => $rabid,
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
         PencatatanKehadiran::find($id)->delete();
         return back()->with('success', 'Catatan kehadiran berhasil dihapus!');
    }
}
