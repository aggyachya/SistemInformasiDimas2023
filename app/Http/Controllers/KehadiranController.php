<?php

namespace App\Http\Controllers;
use App\Models\Mapel;
use App\Models\User;
use App\Models\PencatatanKehadiran;
use App\Models\Anggota;
use App\Models\Rabid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;


class KehadiranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    
     public function index()
    {
        $rabid = Rabid::all();
        $anggota = Anggota::all();
        $pencatatan = PencatatanKehadiran::all();
        

        return view('pages.admin.kehadiran.index', compact('rabid', 'anggota', 'pencatatan'));
    }

    public function getAnggotaByRabid($rabidId)
    {
        // Anda dapat melakukan query berdasarkan $rabidId di sini dan mengembalikan data dalam format JSON
        $anggota = Anggota::whereHas('pencatatans', function ($query) use ($rabidId) {
            $query->where('rabid_id', $rabidId)
                ->where('status', 'Hadir');
        })->get();

        return response()->json($anggota);
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
            'rabid_id' => 'required|exists:rabids,id',
            'status.*' => 'required|in:Hadir,Izin,Tidak Hadir',
        ]);

        $rabidId = $request->input('rabid_id');

        // Dapatkan entitas Rabid berdasarkan $rabidId
        $rabid = Rabid::find($rabidId);

        if (!$rabid) {
            return back()->with('error', 'Rabid tidak ditemukan');
        }

        foreach ($request->input('status') as $anggotaId => $status) {
            $anggota = Anggota::find($anggotaId);
        
            if ($anggota) {
                $attributes = [
                    'anggota_id' => $anggota->id,
                    'rabid_id' => $rabidId,
                    'status' => $status,
                    // Tambahan kolom lain yang diperlukan
                ];
        
                // Tambahkan waktu kehadiran hanya jika status adalah "Hadir"
                if ($status === 'Hadir') {
                    $attributes['waktu_kehadiran'] = now();
                    
                    // Cek jika telat
                    $waktuMulai = Carbon::parse($rabid->waktu_mulai);
                    if ($attributes['waktu_kehadiran']->greaterThan($waktuMulai)) {
                        $telatMenit = $attributes['waktu_kehadiran']->diffInMinutes($waktuMulai);
                        $attributes['keterangan'] = "Telat {$telatMenit} menit";
                    } else {
                        $attributes['keterangan'] = "Tepat Waktu";
                    }
                } else {
                    // Jika status bukan "Hadir", set waktu_kehadiran dan keterangan ke null
                    $attributes['waktu_kehadiran'] = null;
                    $attributes['keterangan'] = null;
                }
        
                // Tambahkan data kehadiran ke database
                PencatatanKehadiran::updateOrCreate(
                    [
                        'anggota_id' => $anggota->id,
                        'rabid_id' => $rabidId,
                    ],
                    $attributes
                );
            }
        }    
        // Hitung jumlah status "Hadir" berdasarkan rabid_id
        $jumlahHadir = PencatatanKehadiran::where('rabid_id', $rabidId)
        ->where('status', 'Hadir')
        ->count();

        // Perbarui nilai jumlah_anggota pada tabel Rabid
        $rabid->jumlah_anggota = $jumlahHadir;
        $rabid->save();

        return back()->with('success', 'Pencatatan kehadiran berhasil disimpan!');
    }


     // public function store(Request $request)
    // {
    //     $request->validate([
    //         'rabid_id' => 'required|exists:rabids,id',
    //         'status.*' => 'required|in:Hadir,Izin,Tidak Hadir',
    //     ]);

    //     $rabidId = $request->input('rabid_id');

    //     // Dapatkan entitas Rabid berdasarkan $rabidId
    //     $rabid = Rabid::find($rabidId);

    //     if (!$rabid) {
    //         return back()->with('error', 'Rabid tidak ditemukan');
    //     }

    //     foreach ($request->input('status') as $anggotaId => $status) {
    //         $anggota = Anggota::find($anggotaId);

    //         if ($anggota) {
    //             $attributes = [
    //                 'anggota_id' => $anggota->id,
    //                 'rabid_id' => $rabidId,
    //                 'status' => $status,
    //                 // Tambahan kolom lain yang diperlukan
    //             ];

    //             // Tambahkan waktu kehadiran jika status adalah "Hadir"
    //             if ($status === 'Hadir') {
    //                 $attributes['waktu_kehadiran'] = now();
                    
    //                 // Cek jika telat
    //                 $waktuMulai = Carbon::parse($rabid->waktu_mulai);
    //                 if ($attributes['waktu_kehadiran']->greaterThan($waktuMulai)) {
    //                     $telatMenit = $attributes['waktu_kehadiran']->diffInMinutes($waktuMulai);
    //                     $attributes['keterangan'] = "Telat {$telatMenit} menit";
    //                 } else {
    //                     $attributes['keterangan'] = null;
    //                 }
    //             } else {
    //                 $attributes['keterangan'] = null;
    //             }

    //             // Tambahkan data kehadiran ke database
    //             PencatatanKehadiran::updateOrCreate(
    //                 [
    //                     'anggota_id' => $anggota->id,
    //                     'rabid_id' => $rabidId,
    //                 ],
    //                 $attributes
    //             );
    //         }
    //     }

    //     return back()->with('success', 'Pencatatan kehadiran berhasil disimpan!');
    // }

//     public function store(Request $request)
// {
//     $request->validate([
//         'rabid_id' => 'required|exists:rabids,id',
//         'status.*.*' => 'required|in:Hadir,Izin,Tidak Hadir',
//     ]);

//     $rabidId = $request->input('rabid_id');

//     // Dapatkan entitas Rabid berdasarkan $rabidId
//     $rabid = Rabid::find($rabidId);

//     if (!$rabid) {
//         return back()->with('error', 'Rabid tidak ditemukan');
//     }

//     foreach ($request->input('status') as $anggotaId => $statuses) {
//         $anggota = Anggota::find($anggotaId);

//         if ($anggota) {
//             foreach ($statuses as $status) {
//                 $attributes = [
//                     'anggota_id' => $anggota->id,
//                     'rabid_id' => $rabidId,
//                     'status' => $status,
//                     // Tambahan kolom lain yang diperlukan
//                 ];

//                 // Tambahkan waktu kehadiran jika status adalah "Hadir"
//                 if ($status === 'Hadir') {
//                     $attributes['waktu_kehadiran'] = now(); // Menggunakan helper now() untuk Carbon::now()
                    
//                     // Cek jika telat
//                     $waktuMulai = Carbon::parse($rabid->waktu_mulai); // Ubah waktu_mulai ke objek Carbon
//                     if ($attributes['waktu_kehadiran']->greaterThan($waktuMulai)) {
//                         $telatMenit = $attributes['waktu_kehadiran']->diffInMinutes($waktuMulai);
//                         $attributes['keterangan'] = "Telat {$telatMenit} menit";
//                     } else {
//                         $attributes['keterangan'] = null; // Tidak telat
//                     }
//                 } else {
//                     $attributes['keterangan'] = null; // Status lain tidak memiliki keterangan
//                 }

//                 // Tambahkan data kehadiran ke database
//                 PencatatanKehadiran::updateOrCreate(
//                     [
//                         'anggota_id' => $anggota->id,
//                         'rabid_id' => $rabidId,
//                         'status' => $status,
//                     ],
//                     $attributes
//                 );
//             }
//         }
//     }

//     return back()->with('success', 'Pencatatan kehadiran berhasil disimpan!');
// }



    
    



    




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Ambil data pencatatan kehadiran berdasarkan ID
        $pencatatan = PencatatanKehadiran::findOrFail($id);

        // Kemudian tampilkan halaman detail pencatatan kehadiran
        return view('pencatatan.show', compact('pencatatan'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}
