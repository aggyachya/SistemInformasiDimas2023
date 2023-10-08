<?php

namespace App\Http\Controllers;
use App\Models\Rabid;
use Illuminate\Http\Request;

class RabidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rabid = Rabid::all();

        return view('pages.admin.rabid.index', compact('rabid'));
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
        // Ambil tanggal dari input waktu_mulai dengan format 'Y-m-d\TH:i'
        $tanggalMulai = date('Y-m-d\TH:i', strtotime($request->input('waktu_mulai')));

        // Masukkan tanggal ke dalam request
        $request->merge(['tanggal' => $tanggalMulai]);

        $request->validate([
            'nama' => 'required',
            'tempat' => 'required',
            'tanggal' => 'required|date_format:Y-m-d\TH:i',
            'waktu_mulai' => 'required|date_format:Y-m-d\TH:i',
            'waktu_selesai' => 'nullable|date_format:Y-m-d\TH:i|after:waktu_mulai',
        ], [
            'tanggal.required' => 'Tanggal harus diisi.',
            'waktu_mulai.required' => 'Waktu Mulai harus diisi.',
            'waktu_selesai.required' => 'Waktu Selesai harus diisi.',
            'tanggal.date_format' => 'Format Tanggal tidak valid.',
            'waktu_mulai.date_format' => 'Format Waktu Mulai tidak valid.',
            'waktu_selesai.date_format' => 'Format Waktu Selesai tidak valid.',
            'waktu_selesai.after' => 'Waktu Selesai harus setelah Waktu Mulai.',
        ]);

        Rabid::create($request->all());

        return back()->with('success', 'Data Rabid berhasil diperbarui!');
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
        $rabid = Rabid::findOrFail($id);

        return view('pages.admin.rabid.edit', compact('rabid'));
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
        $data = $request->all();
        $rabid = Rabid::findOrFail($id);

        // Ambil tanggal dari waktu_mulai
        $tanggalMulai = \Carbon\Carbon::parse($rabid->waktu_mulai)->format('Y-m-d');

        // Gabungkan tanggal dari waktu_mulai dengan waktu saat ini
        $tanggal = $tanggalMulai . ' ' . \Carbon\Carbon::now()->format('H:i:s');

        // Setel tanggal dalam $data
        $data['tanggal'] = $tanggal;

        // Update data Rabid
        $rabid->update($data);

        return redirect()->route('rabid.index')->with('success', 'Data Rabid berhasil diperbarui!');
    }

    public function getRabid($id)
    {
        
        // Cari Rabid berdasarkan ID
        $rabid = Rabid::find($id);

        // Periksa apakah Rabid ditemukan
        if (!$rabid) {
            return response()->json(['error' => 'Rabid tidak ditemukan'], 404);
        }

        // Kembalikan data Rabid dalam format JSON
        return response()->json($rabid);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rabid = Rabid::findOrFail($id);
        // Hapus catatan kehadiran terlebih dahulu
        // foreach ($rabid->pencatatanKehadiran as $catatan) {
        //     $catatan->delete();
        // }
        $rabid->delete();
        return back()->with('success', 'Data Rabid berhasil dihapus!');
    }

    public function setWaktuSelesai($id)
    {
        $rabid = Rabid::find($id);

        if (!$rabid) {
            return response()->json(['success' => false, 'message' => 'Rabid tidak ditemukan'], 404);
        }

        // Perbarui waktu_selesai menjadi waktu sekarang
        $rabid->waktu_selesai = now();
        $rabid->save();

        return redirect()->route('rabid.index')->with('success', 'Rabid telah berhasilkan diselesaikan');
    }

    
    
}
