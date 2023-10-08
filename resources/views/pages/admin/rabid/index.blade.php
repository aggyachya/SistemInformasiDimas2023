@extends('layouts.main')
@section('title', 'Rabid')

@section('content')
<style>
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
                        <h4>Rabid Dimas BEM FT 2023</h4>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="nav-icon fas fa-folder-plus"></i>&nbsp; Tambah Data Rabid</button>
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
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Tempat</th>
                                        <th>Tanggal</th>
                                        <th>Mulai</th>
                                        <th>Selesai</th>
                                        <th>Hadir</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rabid as $result => $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->nama }}</td>
                                        <td>{{ $data->tempat }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->tanggal)->locale('id')->isoFormat('dddd, DD MMMM YYYY') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->waktu_mulai)->format('H:i') }}</td>
                                        <td>
                                            @if ($data->waktu_selesai)
                                                {{ \Carbon\Carbon::parse($data->waktu_selesai)->format('H:i') }}
                                            @else
                                            <form method="POST" action="{{ route('rabid.set-waktu-selesai', ['id' => $data->id]) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Selesaikan</button>
                                            </form>                                            
                                            @endif
                                        </td>
                                        <td>{{ $data->jumlah_anggota }}</td>
                                        
                                        <td>
                                            <div class="d-flex">
                                                <button type="button" class="btn btn-info btn-sm detail-rabid mx-2" data-id="{{ $data->id }}" data-toggle="modal" data-target="#detailModal" onclick="showRabidDetail({{ $data->id }})">
                                                    <i class="nav-icon fas fa-info-circle"></i> &nbsp; Detail
                                                  </button>
                                                  
                                                
                                                <a href="{{ route('rabid.edit', $data->id)}}" class="btn btn-success btn-sm"><i class="nav-icon fas fa-edit"></i> &nbsp; Edit</a>
                                                
                                                <form method="POST" action="{{ route('rabid.destroy', $data->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm show_confirm" data-toggle="tooltip" title='Delete' style="margin-left: 8px"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
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
            <!-- Modal Detail -->
            <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!-- Judul Modal -->
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Rabid</h5>
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
                            <td><strong>Tanggal</strong></td>
                            <td id="tanggal"></td>
                        </tr>
                        <tr>
                            <td><strong>Tempat</strong></td>
                            <td id="tempat"></td>
                        </tr>
                        <tr>
                            <td><strong>Waktu Mulai</strong></td>
                            <td id="waktu_mulai"></td>
                        </tr>
                        <tr>
                            <td><strong>Waktu Selesai</strong></td>
                            <td id="waktu_selesai"></td>
                        </tr>
                        <tr>
                            <td><strong>Jumlah Anggota</strong></td>
                            <td id="jumlah_anggota"></td>
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
  
  

            {{-- Modal tambah anggota --}}
            <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Anggota</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('rabid.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible show fade">
                                            <div class="alert-body">
                                                <button class="close" data-dismiss="alert">
                                                    <span>&times;</span>
                                                </button>
                                                @foreach ($errors->all() as $error )
                                                {{ $error }}
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="{{ __('Nama') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="tempat">Tempat</label>
                                            <input type="text" id="tempat" name="tempat" class="form-control @error('tempat') is-invalid @enderror" placeholder="{{ __('Tempat') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="waktu_mulai">Waktu Mulai</label>
                                            <input type="datetime-local" id="waktu_mulai" name="waktu_mulai" class="form-control @error('waktu_mulai') is-invalid @enderror" placeholder="{{ __('Waktu Mulai') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="waktu_selesai">Waktu Selesai</label>
                                            <input type="datetime-local" id="waktu_selesai" name="waktu_selesai" class="form-control @error('waktu_selesai') is-invalid @enderror" placeholder="{{ __('Waktu Selesai') }}">
                                        </div>
                                                                                
                                        
                                    </div>
                                </div>
                                <div class="modal-footer br">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection


@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/id.js"></script>

<script type="text/javascript">
function capitalizeFirstLetter(text) {
    return text.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()).join(' ');
  }
  function showRabidDetail(rabidID) {
    // Lakukan permintaan AJAX ke endpoint untuk mendapatkan detail Rabid berdasarkan ID
    $.ajax({
        url: '/get-rabid/' + rabidID, // Ganti dengan URL yang sesuai
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            // Periksa apakah data Rabid ditemukan
            if (!data) {
                console.error('Rabid tidak ditemukan');
                return;
            }

            // Format waktu mulai
            var waktuMulai = new Date(data.waktu_mulai);
            var formattedWaktuMulai = ('0' + waktuMulai.getHours()).slice(-2) + ':' + ('0' + waktuMulai.getMinutes()).slice(-2);

            // Format waktu selesai (jika ada)
            var formattedWaktuSelesai = data.waktu_selesai
                ? ('0' + data.waktu_selesai.getHours()).slice(-2) + ':' + ('0' + data.waktu_selesai.getMinutes()).slice(-2)
                : 'Belum Selesai';
            
            // Konversi tanggal ke format lokal Indonesia dengan Moment.js
            var formattedTanggal = moment(data.tanggal).locale('id').format('dddd, D MMMM YYYY');


            // Isi modal dengan data Rabid yang diterima dari permintaan AJAX
            $('#nama').text(data.nama);
            $('#tanggal').text(formattedTanggal);
            $('#tempat').text(data.tempat);
            $('#waktu_mulai').text(formattedWaktuMulai);
            $('#waktu_selesai').text(formattedWaktuSelesai);
            $('#jumlah_anggota').text(data.jumlah_anggota);
            $('#catatan').text(data.catatan);

            // Tampilkan modal
            $('#detailModal').modal('show');
        },
        error: function(xhr, status, error) {
            // Handle error jika terjadi masalah dalam permintaan AJAX
            console.error(xhr.responseText);
        }
    });
}



    $(document).ready(function() {    

        $(document).on('click', '.show_confirm', function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                title: `Yakin ingin menghapus data ini?`
                , text: "Data akan terhapus secara permanen!"
                , icon: "warning"
                , buttons: true
                , dangerMode: true
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        });
    });

</script>
@endpush
