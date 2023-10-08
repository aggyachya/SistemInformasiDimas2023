@extends('layouts.main')

@section('title', 'Edit Anggota')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
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
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Edit Anggota: {{ $anggota->nickname }}</h4>
                        <a href="{{ route('anggota.index') }}" class="btn btn-primary">Kembali</a>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('anggota.update', $anggota->id) }}">
                            @csrf
                            @method('PUT')
                    
                            <div class="form-group">
                                <label for="nama_lengkap">Nama Lengkap</label>
                                <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" value="{{ $anggota->nama_lengkap }}">
                            </div>
                    
                            <div class="form-group">
                                <label for="nickname">Nickname</label>
                                <input type="text" id="nickname" name="nickname" class="form-control" value="{{ $anggota->nickname }}">
                            </div>
                    
                            <div class="form-group">
                                <label for="jurusan_nama">Jurusan</label>
                                <select id="jurusan_nama" name="jurusan_nama" class="form-control">
                                    <option value="">Pilih Jurusan</option>
                                    @foreach ($jurusan as $jurusanOption)
                                        <option value="{{ $jurusanOption->nama_jurusan }}" 
                                            {{ $anggota->jurusan->nama_jurusan == $jurusanOption->nama_jurusan ? 'selected' : '' }}>
                                            {{ $jurusanOption->nama_jurusan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                    
                            <div class="form-group">
                                <label for="angkatan">Angkatan</label>
                                <select id="angkatan" name="angkatan" class="form-control">
                                    <option value="">Pilih Angkatan</option>
                                    <option value="2020" {{ $anggota->angkatan == '2020' ? 'selected' : '' }}>2020</option>
                                    <option value="2021" {{ $anggota->angkatan == '2021' ? 'selected' : '' }}>2021</option>
                                    <option value="2022" {{ $anggota->angkatan == '2022' ? 'selected' : '' }}>2022</option>
                                </select>
                            </div>
                    
                            <div class="form-group">
                                <label for="jabatan">Jabatan</label>
                                <select id="jabatan" name="jabatan" class="form-control">
                                    <option value="">Pilih Jabatan</option>
                                    <option value="Korbid" {{ $anggota->jabatan == 'Korbid' ? 'selected' : '' }}>Koordinator Bidang</option>
                                    <option value="Kabid" {{ $anggota->jabatan == 'Kabid' ? 'selected' : '' }}>Kepala Bidang</option>
                                    <option value="Wakabid" {{ $anggota->jabatan == 'Wakabid' ? 'selected' : '' }}>Wakil Kepala Bidang</option>
                                    <option value="Supervisi PMO" {{ $anggota->jabatan == 'Supervisi PMO' ? 'selected' : '' }}>Supervisi PMO</option>
                                    <option value="Sekretaris" {{ $anggota->jabatan == 'Sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                                    <option value="Bendahara" {{ $anggota->jabatan == 'Bendahara' ? 'selected' : '' }}>Bendahara</option>
                                    <option value="Kadiv" {{ $anggota->jabatan == 'Kadiv' ? 'selected' : '' }}>Kepala Divisi</option>
                                    <option value="Staf Ahli" {{ $anggota->jabatan == 'Staf Ahli' ? 'selected' : '' }}>Staf Ahli</option>
                                    <option value="Staf Muda" {{ $anggota->jabatan == 'Staf Muda' ? 'selected' : '' }}>Staf Muda</option>
                                </select>
                            </div>
                    
                            <div class="form-group">
                                <label for="posisi">Posisi</label>
                                <select id="posisi" name="posisi" class="form-control">
                                    <option value="">Pilih Posisi</option>
                                    <option value="Fungsio" {{ $anggota->posisi == 'Fungsio' ? 'selected' : '' }}>Fungsio</option>
                                    <option value="Desbin" {{ $anggota->posisi == 'Desbin' ? 'selected' : '' }}>Desbin</option>
                                    <option value="RBT" {{ $anggota->posisi == 'RBT' ? 'selected' : '' }}>RBT</option>
                                    <option value="TPL" {{ $anggota->posisi == 'TPL' ? 'selected' : '' }}>TPL</option>
                                    <option value="Ankas" {{ $anggota->posisi == 'Ankas' ? 'selected' : '' }}>Ankas</option>
                                    <option value="Fordimas" {{ $anggota->posisi == 'Fordimas' ? 'selected' : '' }}>Fordimas</option>
                                </select>
                            </div>
                    
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="laki-laki" {{ $anggota->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="perempuan" {{ $anggota->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                    
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" value="{{ $anggota->tanggal_lahir }}">
                            </div>
                    
                            <div class="form-group">
                                <label for="motor">Motor</label>
                                <select id="motor" name="motor" class="form-control">
                                    <option value="">Pilih Motor</option>
                                    <option value="yes" {{ $anggota->motor == 'yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="no" {{ $anggota->motor == 'no' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                    
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<script>
    // JavaScript untuk mengatur nilai yang dipilih pada dropdown
    document.addEventListener("DOMContentLoaded", function() {
        var jurusanDropdown = document.getElementById("jurusan_nama");
        var namaJurusanSebelumnya = "{{ $anggota->jurusan->nama_jurusan ?? '' }}"; // Ganti dengan nilai nama jurusan sebelumnya dari model Anggota

        // Set nilai yang dipilih sesuai dengan nama_jurusan_sebelumnya
        if (namaJurusanSebelumnya !== "") {
            for (var i = 0; i < jurusanDropdown.options.length; i++) {
                if (jurusanDropdown.options[i].value === namaJurusanSebelumnya) {
                    jurusanDropdown.options[i].selected = true;
                    break;
                }
            }
        }
    });
</script>
