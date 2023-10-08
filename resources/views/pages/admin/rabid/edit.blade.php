@extends('layouts.main')
@section('title', 'Edit Rabid')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Edit Rabid</h4>
                            <a href="{{ route('rabid.index') }}" class="btn btn-primary">Kembali</a>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('rabid.update', $rabid->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="{{ __('Nama') }}" value="{{ old('nama', $rabid->nama) }}">
                                </div>
                                <div class="form-group">
                                    <label for="tempat">Tempat</label>
                                    <input type="text" id="tempat" name="tempat" class="form-control @error('tempat') is-invalid @enderror" placeholder="{{ __('Tempat') }}" value="{{ old('tempat', $rabid->tempat) }}">
                                </div>
                                <div class="form-group">
                                    <label for="waktu_mulai">Waktu Mulai</label>
                                    <input type="datetime-local" id="waktu_mulai" name="waktu_mulai" class="form-control @error('waktu_mulai') is-invalid @enderror" placeholder="{{ __('Waktu Mulai') }}" value="{{ old('waktu_mulai', \Carbon\Carbon::parse($rabid->waktu_mulai)->format('Y-m-d\TH:i')) }}">
                                </div>
                                <div class="form-group">
                                    <label for="waktu_selesai">Waktu Selesai</label>
                                    <input type="datetime-local" id="waktu_selesai" name="waktu_selesai" class="form-control @error('waktu_selesai') is-invalid @enderror" placeholder="{{ __('Waktu Selesai') }}" value="{{ old('waktu_selesai', $rabid->waktu_selesai ?? null) }}">
                                </div>                                
                                <div class="form-group">
                                    <label for="catatan">Catatan</label>
                                    <input type="text" id="catatan" name="catatan" class="form-control @error('catatan') is-invalid @enderror" placeholder="{{ __('Catatan') }}" value="{{ old('catatan', $rabid->catatan) }}">
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Simpan Perubahan</button>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
