@extends('layouts.main')
@section('title', 'Anggota')

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
                        <h4>Anggota Dimas BEM FT 2023</h4>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="nav-icon fas fa-folder-plus"></i>&nbsp; Tambah Data Anggota</button>
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
                                        <th>Nama Lengkap</th>
                                        <th>Jurusan</th>
                                        <th>Angkatan</th>
                                        <th>Posisi</th>
                                        <th>Jabatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($anggota as $result => $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->nama_lengkap }}</td>
                                        <td>
                                            @if ($data->jurusan)
                                                {{ $data->jurusan->nama_jurusan }}
                                            @else
                                                
                                            @endif
                                        </td>                                                                                
                                        <td>{{ $data->angkatan }}</td>
                                        <td>{{ $data->posisi }}</td>
                                        <td>{{ $data->jabatan }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <button type="button" class="btn btn-info btn-sm detail-anggota mx-2" data-id="{{ $data->id }}" data-toggle="modal" data-target="#detailModal" onclick="showAnggotaDetail({{ $data->id }})">
                                                    <i class="nav-icon fas fa-info-circle"></i> &nbsp; Detail
                                                  </button>
                                                  
                                                
                                                <a href="{{ route('anggota.edit', $data->id)}}" class="btn btn-success btn-sm"><i class="nav-icon fas fa-edit"></i> &nbsp; Edit</a>
                                                
                                                <form method="POST" action="{{ route('anggota.destroy', $data->id) }}">
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
                    <h5 class="modal-title" id="exampleModalLabel">Detail Anggota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
  
                    <!-- Konten Modal -->
                    <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td><strong>Nama Lengkap</strong></td>
                            <td id="namaLengkap"></td>
                        </tr>
                        <tr>
                            <td><strong>Nickname</strong></td>
                            <td id="nickname"></td>
                        </tr>
                        <tr>
                            <td><strong>Jurusan</strong></td>
                            <td id="jurusan"></td>
                        </tr>
                        <tr>
                            <td><strong>Angkatan</strong></td>
                            <td id="angkatan"></td>
                        </tr>
                        <tr>
                            <td><strong>Posisi</strong></td>
                            <td id="posisi"></td>
                        </tr>
                        <tr>
                            <td><strong>Jabatan</strong></td>
                            <td id="jabatan"></td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Kelamin</strong></td>
                            <td id="jenisKelamin"></td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Lahir</strong></td>
                            <td id="tanggalLahir"></td>
                        </tr>
                        <tr>
                            <td><strong>Motor</strong></td>
                            <td id="motor"></td>
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
                            <form action="{{ route('anggota.store') }}" method="POST">
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
                                            <label for="nama_lengkap">Nama anggota</label>
                                            <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" placeholder="{{ __('Nama anggota') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="nickname">Nickname</label>
                                            <input type="text" id="nickname" name="nickname" class="form-control @error('nickname') is-invalid @enderror" placeholder="{{ __('Nickname') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="jurusan_nama">Jurusan</label>
                                            <select id="jurusan_nama" name="jurusan_nama" class="form-control @error('jurusan_nama') is-invalid @enderror">
                                                <option value="">Pilih Jurusan</option>
                                                @foreach ($jurusan as $jurusanOption)
                                                    <option value="{{ $jurusanOption->nama_jurusan }}">{{ $jurusanOption->nama_jurusan }}</option>
                                                @endforeach
                                            </select>
                                        </div>                                                                               
                                        <div class="form-group">
                                            <label for="angkatan">Angkatan</label>
                                            <select id="angkatan" name="angkatan" class="form-control @error('angkatan') is-invalid @enderror">
                                                <option value="">Pilih Angkatan</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                            </select>
                                        </div>                                        
                                        <div class="form-group">
                                            <label for="jabatan">Jabatan</label>
                                            <select id="jabatan" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror">
                                                <option value="">Pilih Jabatan</option>
                                                <option value="Korbid">Koordinator Bidang</option>
                                                <option value="Kabid">Kepala Bidang</option>
                                                <option value="Wakabid">Wakil Kepala Bidang</option>
                                                <option value="Supervisi PMO">Supervisi PMO</option>
                                                <option value="Sekretaris">Sekretaris</option>
                                                <option value="Bendahara">Bendahara</option>
                                                <option value="Kadiv">Kepala Divisi</option>
                                                <option value="Staf Ahli">Staf Ahli</option>
                                                <option value="Staf Muda">Staf Muda</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="posisi">Posisi</label>
                                            <select id="posisi" name="posisi" class="form-control @error('posisi') is-invalid @enderror">
                                                <option value="">Pilih Posisi</option>
                                                <option value="Fungsio">FUNGSIO</option>
                                                <option value="Desbin">DESBIN</option>
                                                <option value="RBT">RBT</option>
                                                <option value="TPL">TPL</option>
                                                <option value="Ankas">ANKAS</option>
                                                <option value="Fordimas">FORDIMAS</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <select id="jenis_kelamin" name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="laki-laki">Laki-laki</option>
                                                <option value="perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tanggal_lahir">Tanggal Lahir</label>
                                            <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror">
                                        </div>
                                        <div class="form-group">
                                            <label for="motor">Motor</label>
                                            <select id="motor" name="motor" class="form-control @error('motor') is-invalid @enderror">
                                                <option value="">Pilih Motor</option>
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
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
  function showAnggotaDetail(anggotaId) {
    $.ajax({
      url: '/get-anggota/' + anggotaId,
      method: 'GET',
      dataType: 'json',
      success: function(data) {
        // Mengonversi data sesuai dengan aturan huruf kapital pada awal kalimat
        var namaLengkap = capitalizeFirstLetter(data.nama_lengkap);
        var nickname = capitalizeFirstLetter(data.nickname);
        var jurusan = data.jurusan ? capitalizeFirstLetter(data.jurusan.nama_jurusan) : '-';
        var angkatan = capitalizeFirstLetter(data.angkatan);
        var posisi = capitalizeFirstLetter(data.posisi);
        var jabatan = capitalizeFirstLetter(data.jabatan);
        var jenisKelamin = capitalizeFirstLetter(data.jenis_kelamin);
        
        // Format tanggal lahir ke dalam "DD Month YYYY" dengan bahasa Indonesia
        var formattedTanggalLahir = moment(data.tanggal_lahir).locale('id').format('D MMMM YYYY');

        // Mengonversi data motor sesuai dengan aturan huruf kapital pada awal kalimat
        var motor = capitalizeFirstLetter(data.motor);

        $('#namaLengkap').text(namaLengkap);
        $('#nickname').text(nickname);
        $('#jurusan').text(jurusan);
        $('#angkatan').text(angkatan);
        $('#posisi').text(posisi);
        $('#jabatan').text(jabatan);
        $('#jenisKelamin').text(jenisKelamin);
        $('#tanggalLahir').text(formattedTanggalLahir);
        $('#motor').text(motor);

        // Tampilkan modal
        $('#detailModal').modal('show');
      },
      error: function() {
        console.log('Gagal mengambil data anggota.');
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
