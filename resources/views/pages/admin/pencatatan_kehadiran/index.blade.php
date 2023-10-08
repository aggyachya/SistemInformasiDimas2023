@extends('layouts.main')
@section('title', 'Pencatatan Rabid')

@section('content')
<style>
    /* Mengurangi jarak antar baris dalam tabel */
    .rabid-info table tbody tr {
        line-height: 1;
    }

    /* Mengubah warna latar belakang menjadi biru muda */
    .rabid-info {
        background-color: #F0F0F0; /* Ganti dengan warna biru muda yang Anda inginkan */
    }

    .card-header.d-flex.justify-content-between {
    display: flex;
    align-items: center; /* Untuk mengatur vertikal tengah */
    }

    .card-header h4, .card-header select {
        flex: 1; /* Agar keduanya mendapatkan lebar yang sama */
        margin-right: 10px; /* Spasi antara elemen */
    }

    /* Mengurangi jarak atas dan bawah pada modal header */
    .modal-header {
      padding-top: 20px; /* Sesuaikan padding atas sesuai kebutuhan */
      padding-bottom: 10px; /* Sesuaikan padding bawah sesuai kebutuhan */
      margin-bottom: 0; /* Menghilangkan margin bawah */
      margin-left: 5;
    }
  
    /* Mengurangi jarak atas dan bawah pada modal body */
    .modal-body {
      padding-top: 10px; /* Sesuaikan padding atas sesuai kebutuhan */
      padding-bottom: 10px; /* Sesuaikan padding bawah sesuai kebutuhan */
      margin-bottom: 0; /* Menghilangkan margin bawah */
    }
  
    /* Mengurangi jarak atas dan bawah pada modal footer */
    .modal-footer {
      padding-top: 10px; /* Sesuaikan padding atas sesuai kebutuhan */
      padding-bottom: 10px; /* Sesuaikan padding bawah sesuai kebutuhan */
      margin-top: 0; /* Menghilangkan margin atas */
    }
</style>



<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Pencatatan Kehadiran Rabid</h4>
                        <select id="rabidFilter" class="form-control">
                            <option value="">Pilih Rabid ke:</option>
                            @foreach ($rabid as $r)
                                <option value="{{ $r->id }}">{{ $r->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                {{ $message }}
                            </div>
                        </div>
                        @endif


                        <div class="rabid-info card">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td><strong>Nama</strong></td>
                                        <td><strong>Tempat</strong></td>
                                        <td><strong>Tanggal</strong></td>
                                        <td><strong>Waktu Mulai</strong></td>
                                        <td><strong>Waktu Selesai</strong></td>
                                    </tr>
                                    <tr>
                                        <td><span id="rabidNama"</span></td>
                                        <td><span id="rabidTempat"></span></td>
                                        <td><span id="rabidTanggalMulai"></span></td>
                                        <td><span id="rabidWaktuMulai"></span></td>
                                        <td><span id="rabidWaktuSelesai"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>                                              

                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Rabid</th>
                                        <th>Status</th>
                                        <th>Waktu Hadir</th>
                                        <th>Keterangan</th>
                                        {{-- <th>Catatan</th> --}}
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pencatatan as $result => $data)
                                    <tr data-rabid="{{ $data->rabid_id }}"> <!-- Tambahkan atribut data-rabid -->
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->anggota->nickname }}</td>
                                        <td>{{ $data->rabid->nama }}</td>
                                        <td>{{ $data->status }}</td>
                                        <td>
                                            @if ($data->waktu_kehadiran)
                                                {{ \Carbon\Carbon::parse($data->waktu_kehadiran)->format('H:i') }}
                                            @else
                                                
                                            @endif
                                        </td>
                                        <td>{{ ucwords(strtolower($data->keterangan)) }}</td>
                                        {{-- <td>{{ $data->catatan }}</td> --}}
                                        <td>
                                            <div class="d-flex">
                                                <button type="button" class="btn btn-info btn-sm detail-Pencatatan mx-2" data-id="{{ $data->id }}" data-toggle="modal" data-target="#detailModal" onclick="showPencatatanKehadiranDetail({{ $data->id }})">
                                                    <i class="nav-icon fas fa-info-circle"></i> &nbsp; Detail
                                                  </button>                                                <a href="{{ route('pencatatan_kehadiran.edit', $data->id)}}" class="btn btn-success btn-sm"><i class="nav-icon fas fa-edit"></i> &nbsp; Edit</a>
                                                <form method="POST" action="{{ route('pencatatan_kehadiran.destroy', $data->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm show_confirm mx-1" data-toggle="tooltip" title='Delete' style="margin-left: 8px"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Detail -->
        <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Judul Modal -->
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pencatatan Kehadiran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>

                <!-- Konten Modal -->
                <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td><strong>Nama</strong></td>
                        <td id="nama"></td>
                    </tr>
                    <tr>
                        <td><strong>Rabid</strong></td>
                        <td id="rabid"></td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td id="status"></td>
                    </tr>
                    <tr>
                        <td><strong>Waktu Kehadiran</strong></td>
                        <td id="waktu_kehadiran"></td>
                    </tr>
                    <tr>
                        <td><strong>Keterangan</strong></td>
                        <td id="keterangan"></td>
                    </tr>
                    <tr>
                        <td><strong>Catatan</strong></td>
                        <td id="catatan"></td>
                    </tr>
                    </tbody>
                </table>
                </div>
        
                <!-- Tombol-tombol Modal -->
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
<script type="text/javascript">
    function capitalizeFirstLetter(text) {
        return text.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()).join(' ');
    }

    function sentenceCase(text) {
    if (!text) return ''; // Jika teks kosong, kembalikan string kosong
    return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
}
    
    function showPencatatanKehadiranDetail(id) {
        $.ajax({
            url: '/get-pencatatan-kehadiran/' + id, // Ganti dengan URL yang sesuai
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                // Kapitalisasi huruf pertama pada semua atribut kecuali waktu_kehadiran
            $('#nama').text(capitalizeFirstLetter(data.anggota.nama_lengkap));
            $('#rabid').text(capitalizeFirstLetter(data.rabid.nama));
            $('#status').text(capitalizeFirstLetter(data.pencatatan_kehadiran.status));
            
            // Mengubah format waktu_kehadiran menjadi HH:MM
            var waktuKehadiran = new Date(data.pencatatan_kehadiran.waktu_kehadiran);
            var formattedWaktuKehadiran = ('0' + waktuKehadiran.getHours()).slice(-2) + ':' + ('0' + waktuKehadiran.getMinutes()).slice(-2);
            $('#waktu_kehadiran').text(formattedWaktuKehadiran);

            $('#keterangan').text(capitalizeFirstLetter(data.pencatatan_kehadiran.keterangan));
            $('#catatan').text(capitalizeFirstLetter(data.pencatatan_kehadiran.catatan));

            $('#detailModal').modal('show'); // Menampilkan modal

            var catatanText = sentenceCase(data.pencatatan_kehadiran.catatan);
            $('#catatan').text(catatanText);
            $('#detailModal').modal('show'); // Menampilkan modal
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }
    $('#rabidFilter').change(function() {
    var selectedRabidId = $(this).val();
    var selectedRabid = @json($rabid->keyBy('id')); // Pastikan variabel JavaScript ini memiliki data Rabid yang sesuai

    // Tampilkan atau sembunyikan informasi Rabid berdasarkan pilihan dropdown
    if (selectedRabidId && selectedRabid[selectedRabidId]) {
        var rabidInfo = selectedRabid[selectedRabidId];
        $('#rabidNama').text(rabidInfo.nama);
        $('#rabidTempat').text(rabidInfo.tempat);
        $('#rabidTanggalMulai').text(formatDate(rabidInfo.tanggal));
        $('#rabidWaktuMulai').text(formatTime(rabidInfo.waktu_mulai));
        $('#rabidWaktuSelesai').text(formatTime(rabidInfo.waktu_selesai));

        

        // Perbarui tabel dengan data yang sesuai dengan rabid_id yang dipilih
        var selectedRabidId = $(this).val();
        $('#table-2 tbody tr').hide(); // Sembunyikan semua baris dalam tabel terlebih dahulu
        $('#table-2 tbody tr[data-rabid="' + selectedRabidId + '"]').show(); // Tampilkan baris dengan rabid_id yang sesuai
        $('.rabid-info').show();
    } else {
        // Jika tidak ada Rabid yang dipilih atau data Rabid tidak ditemukan
        $('#rabidNama, #rabidTempat, #rabidTanggalMulai, #rabidWaktuMulai, #rabidWaktuSelesai').text('');
        $('.rabid-info').hide();
    }
});

    function formatTime(datetimeString) {
        if (datetimeString) {
            var datetime = new Date(datetimeString);
            var hours = datetime.getHours().toString().padStart(2, '0');
            var minutes = datetime.getMinutes().toString().padStart(2, '0');
            return hours + ':' + minutes;
        } else {
            return ''; // Mengembalikan string kosong jika datetimeString kosong
        }
    }

    function formatDate(datetimeString) {
    if (datetimeString) {
        var options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
        var datetime = new Date(datetimeString);
        return datetime.toLocaleDateString('id-ID', options);
    } else {
        return ''; // Mengembalikan string kosong jika datetimeString kosong
    }
    }


    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
                title: `Yakin ingin menghapus data ini?`
                , text: "Data akan terhapus secara permanen!"
                , icon: "warning"
                , buttons: true
                , dangerMode: true
            , })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
    });

</script>
@endpush
