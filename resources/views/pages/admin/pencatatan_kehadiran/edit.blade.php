@extends('layouts.main')
@section('title', 'Edit Pencatatan Kehadiran')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Edit Pencatatan Kehadiran</h4>
                            <a href="{{ route('pencatatan_kehadiran.index') }}" class="btn btn-primary">Kembali</a>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('pencatatan_kehadiran.update', $pencatatan_kehadiran->id) }}">
                                @csrf
                                @method('PUT')
        
                                <div class="form-group">
                                    <label for="anggota_id">Anggota</label>
                                    <select id="anggota_id" name="anggota_id" class="form-control" disabled>
                                        @foreach($anggota as $anggota)
                                            <option value="{{ $anggota->id }}" {{ $anggota->id === $pencatatan_kehadiran->anggota_id ? 'selected' : '' }}>
                                                {{ $anggota->nama_lengkap }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
        
                                <div class="form-group">
                                    <label for="rabid_id">Rabid</label>
                                    <select id="rabid_id" name="rabid_id" class="form-control" disabled>
                                        @foreach($rabid as $rabid)
                                            <option value="{{ $rabid->id }}" {{ $rabid->id === $pencatatan_kehadiran->rabid_id ? 'selected' : '' }}>
                                                {{ $rabid->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
        
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="hadir" {{ $pencatatan_kehadiran->status === 'hadir' ? 'selected' : '' }}>Hadir</option>
                                        <option value="izin" {{ $pencatatan_kehadiran->status === 'izin' ? 'selected' : '' }}>Izin</option>
                                        <option value="tidak hadir" {{ $pencatatan_kehadiran->status === 'tidak hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                                    </select>
                                </div>
        
                                <div class="form-group">
                                    <label for="waktu_kehadiran">Waktu Kehadiran</label>
                                    <input type="datetime-local" id="waktu_kehadiran" name="waktu_kehadiran" class="form-control"  disabled value="{{ \Carbon\Carbon::parse($pencatatan_kehadiran->waktu_kehadiran)->format('Y-m-d\TH:i') }}">
                                </div>
        
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea id="keterangan" name="keterangan" class="form-control" disabled>{{ $pencatatan_kehadiran->keterangan }}</textarea>
                                </div>
        
                                <div class="form-group">
                                    <label for="catatan">Catatan</label>
                                    <textarea id="catatan" name="catatan" class="form-control">{{ $pencatatan_kehadiran->catatan }}</textarea>
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
