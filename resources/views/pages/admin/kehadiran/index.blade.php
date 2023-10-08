@extends('layouts.main')

@section('title', 'Kehadiran Rabid')


<style>
    /* Gaya CSS Anda di sini */
    /* Tambahkan gaya untuk tombol checkbox */
    .custom-checkbox-btn {
        display: none;
    }

    .custom-checkbox-label {
        display: inline-block;
        padding: 5px 20px;
        background-color: #e0e0e0;
        border: 1px solid #ccc;
        cursor: pointer;
    }

    /* Tambahkan gaya untuk label yang dicentang */
    .custom-checkbox-label.checked {
        background-color: yellow; /* Ganti warna latar belakang menjadi kuning */
        color: #000; /* Ganti warna teks agar terlihat jelas */
    }
</style>


@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Kehadiran Rabid</h4>
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
                        <form action="{{ route('kehadiran.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="rabid_id">Pilih Rabid ke:</label>
                                <select id="rabid_id" name="rabid_id" class="form-control">
                                    <option value="">Pilih Rabid</option>
                                    @foreach ($rabid as $rabidOption)
                                        <option value="{{ $rabidOption->id }}">{{ $rabidOption->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div id="pencatatan-table" style="display: none;">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Anggota</th>
                                            <th>Posisi</th>
                                            <th>Jabatan</th>
                                            <th>Kehadiran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($anggota as $key => $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->nickname }}</td>
                                            <td>{{ $data->jabatan }}</td>
                                            <td>{{ $data->posisi }}</td>
                                            <td>
                                                <div class="btn-group" data-toggle="buttons">
                                                    <label class="btn btn-outline-primary">
                                                        <input type="radio" name="status[{{ $data->id }}]" value="Hadir" class="custom-radio-btn"> Hadir
                                                    </label>
                                                    <label class="btn btn-outline-primary">
                                                        <input type="radio" name="status[{{ $data->id }}]" value="Izin" class="custom-radio-btn"> Izin
                                                    </label>
                                                    <label class="btn btn-outline-primary">
                                                        <input type="radio" name="status[{{ $data->id }}]" value="Tidak Hadir" class="custom-radio-btn"> Tidak Hadir
                                                    </label>
                                                </div>
                                                
                                            </td>
                                            
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        
                            <button type="submit" class="btn btn-primary" id="submit-button">Simpan</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>

document.addEventListener("DOMContentLoaded", function () {
    const rabidSelect = document.querySelector("#rabid_id");
    const pencatatanTable = document.querySelector("#pencatatan-table");
    const checkboxes = document.querySelectorAll(".custom-checkbox-btn");
    const pilihButton = document.querySelector("#pilih-button");

    // Fungsi untuk menampilkan/menyembunyikan tabel berdasarkan pilihan Rabid
    rabidSelect.addEventListener("change", function () {
        selectedRabidId = this.value; // Update selectedRabidId dengan nilai yang dipilih
        if (selectedRabidId !== "") {
            pencatatanTable.style.display = "block";
            // Lakukan permintaan AJAX untuk mendapatkan data anggota berdasarkan selectedRabidId
            fetch(`/get-anggota/${selectedRabidId}`)
                .then(response => response.json())
                .then(data => {
                    // Render data anggota ke dalam elemen HTML dengan ID anggota-list
                    anggotaList.innerHTML = data;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            
        } else {
            pencatatanTable.style.display = "none";
        
        }
    });

});

// document.addEventListener("DOMContentLoaded", function () {
//     const rabidSelect = document.querySelector("#rabid_id");
//     const pencatatanTable = document.querySelector("#pencatatan-table");
//     const checkboxes = document.querySelectorAll(".custom-checkbox-btn");
//     const pilihButton = document.querySelector("#pilih-button");

//     // Fungsi untuk menampilkan/menyembunyikan tabel berdasarkan pilihan Rabid
//     rabidSelect.addEventListener("change", function () {
//         selectedRabidId = this.value; // Update selectedRabidId dengan nilai yang dipilih
//         if (selectedRabidId !== "") {
//             pencatatanTable.style.display = "block";
            
//         } else {
//             pencatatanTable.style.display = "none";
        
//         }
//     });

// });

</script>

@endsection