@extends('layouts.app')

@section('title', 'Undian')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Undi Sekarang!</h1>
        </div>
        <div class="container">
            <div class="col-lg-6 mx-auto">
                <div class="text-center">
                    <p id="lucky-number"
                        class="text-center bg-primary text-white font-weight-bold text-2xl px-4 py-2 rounded-md">0000000</p>

                    <button id="draw-button" class="btn btn-danger mt-4 mb-4 py-2 px-4">
                        Mulai Acak
                    </button>
                </div>
                <div class="card border-warning mt-6 mx-auto">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Informasi Pemenang</h5>
                        <p class="card-text"><strong>Nomor:</strong></p>
                        <p id="nomor_hadirin" class="card-text">{____________}</p>
                        <p class="card-text"><strong>Nama:</strong></p>
                        <p id="nama_hadirin" class="card-text">{____________}</p>
                        <p class="card-text"><strong>No HP:</strong></p>
                        <p id="nomor_hp_hadirin" class="card-text">{____________}</p>
                        <p class="card-text"><strong>Delegasi:</strong></p>
                        <p id="delegasi_kafilah" class="card-text">{____________}</p>
                        <p class="card-text"><strong>Alamat:</strong></p>
                        <p id="alamat_hadirin" class="card-text">{____________}</p>
                        <div class="peserta">
                            <p class="card-text"><strong>Status Peserta</strong></p>
                            <select id="is_peserta" disabled class="form-control">
                                <option value="" selected>Belum melakukan undian</option>
                                <option value="no">Tidak</option>
                                <option value="yes">Ya</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="form-group mt-4">
                    <label for="notes">Notes:</label>
                    <input type="text" class="form-control" id="notes" placeholder="Masukkan notes">
                </div>

                <div class="form-group mt-2" id="status-group">
                    <label for="status">Status:</label>
                    <select id="status" class="form-control">
                        <option value="sudah_menerima">Sudah Menerima</option>
                        <option value="belum_menerima" selected>Belum Menerima</option>
                    </select>
                </div>

                <div class="text-center mt-2" id="save-button-group" style="display: none;">
                    <button id="save-button" class="btn btn-warning mb-4 py-2 px-4">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('custom-css')
    <style>
        .text-2xl {
            font-size: 24px;
        }

        .peserta {
            display: none;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css"
        integrity="sha512-DIW4FkYTOxjCqRt7oS9BFO+nVOwDL4bzukDyDtMO7crjUZhwpyrWBFroq+IqRe6VnJkTpRAS6nhDvf0w+wHmxg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('custom-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <script>
        $(document).ready(function() {

            $('body').addClass('sidebar-mini');

            var isDrawingStarted = false; // Menyimpan status apakah pengacakan sudah dimulai
            var createdId;


            $('#draw-button').click(function() {
                $.ajax({
                    url: '{{ route('getRandomWinner') }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var $luckyNumber = $('#lucky-number');
                        var counter = 0; // Counter untuk menghitung waktu pengacakan angka
                        var interval = setInterval(function() {
                            // Fungsi yang akan dijalankan setiap 100 milidetik (0.1 detik)
                            var randomNumber = Math.floor(Math.random() *
                                10000); // Mengacak angka antara 0 hingga 999
                            $luckyNumber.text(
                                randomNumber
                            ); // Mengupdate teks dengan angka yang diacak
                            counter++; // Meningkatkan nilai counter

                            if (counter >= 50) {
                                // Setelah 10 detik (100 * 0.1 detik = 10 detik)
                                clearInterval(
                                    interval); // Menghentikan interval pengacakan
                                $luckyNumber.text(response.data
                                    .nomor_hadirin); // Menampilkan angka pemenang
                                $('#nomor_hadirin').text(response.data.nomor_hadirin);
                                $('#nama_hadirin').text(response.data.nama_hadirin);
                                $('#alamat_hadirin').text(response.data.alamat_hadirin);
                                $('#delegasi_kafilah').text(response.data
                                    .delegasi_kafilah);
                                $('#nomor_hp_hadirin').text(response.data
                                    .no_hp_hadirin);
                                $('#is_peserta').val(response.data.is_peserta);
                                isDrawingStarted =
                                    true; // Set isDrawingStarted menjadi true setelah memulai pengacakan
                                $('#status-group').show(); // Tampilkan grup status
                                $('#save-button-group')
                                    .show(); // Tampilkan grup tombol simpan

                                $.ajax({
                                    url: '{{ route('pemenang.store') }}',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        nomor_pemenang: response.data
                                            .nomor_hadirin,
                                        nama_pemenang: response.data
                                            .nama_hadirin,
                                        alamat_pemenang: response.data
                                            .alamat_hadirin,
                                        delegasi: response.data
                                            .delegasi_kafilah,
                                        no_hp_pemenang: response.data
                                            .no_hp_hadirin,
                                        is_peserta: response.data.is_peserta,
                                        notes: $('#notes').val(),
                                        status: $('#status').val()
                                    },
                                    success: function(response) {
                                        // Set global variable to id created
                                        createdId = response.data.id;

                                        iziToast.success({
                                            title: 'Success',
                                            message: response
                                                .message,
                                            position: 'topRight',
                                        })
                                    },
                                });
                            }
                        }, 100); // Interval pengacakan setiap 100 milidetik (0.1 detik)
                    },
                    error: function(xhr, status, error) {
                        iziToast.error({
                            title: 'Error',
                            message: xhr.responseJSON.message,
                            position: 'topRight'
                        });
                    }
                });
            });



            $('#save-button').click(function() {
                if (!isDrawingStarted) {
                    return; // Jika pengacakan belum dimulai, hentikan fungsi simpan
                }

                var nomorHadirin = $('#nomor_hadirin').text();
                var namaHadirin = $('#nama_hadirin').text();
                var alamatHadirin = $('#alamat_hadirin').text();
                var delegasiKafilah = $('#delegasi_kafilah').text();
                var nomorHpHadirin = $('#nomor_hp_hadirin').text();
                var is_peserta = $('#is_peserta').val();
                var notes = $('#notes').val();
                var status = $('#status').val();
                $.ajax({
                    url: '{{ route('pemenang.update', '') }}' + '/' + createdId,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT',
                        nomor_pemenang: nomorHadirin,
                        nama_pemenang: namaHadirin,
                        alamat_pemenang: alamatHadirin,
                        no_hp_pemenang: nomorHpHadirin,
                        delegasi: delegasiKafilah,
                        is_peserta: is_peserta,
                        notes: notes,
                        status: status,
                    },
                    success: function(response) {
                        iziToast.success({
                            title: 'Success',
                            message: response.message,
                            position: 'topRight',
                        });

                        //reset all value to default
                        $('#lucky-number').text('0000000');
                        $('#nomor_hadirin').text('{____________}');
                        $('#nama_hadirin').text('{____________}');
                        $('#alamat_hadirin').text('{____________}');
                        $('#delegasi_kafilah').text('{____________}');
                        $('#nomor_hp_hadirin').text('{____________}');
                        $('#is_peserta').val('');
                        $('#notes').val('');
                        $('#status').val('belum_menerima');

                        isDrawingStarted =
                            false; // Set isDrawingStarted menjadi false setelah pengacakan selesai
                        createdId = null;
                    },
                    error: function(xhr) {
                        // Menampilkan error jika ada kesalahan
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var message = xhr.responseJSON.message;
                            var errorList = '<ul>';

                            for (var key in errors) {
                                errorList += '<li>' + errors[key][0] + '</li>';
                            }

                            errorList += '</ul>';

                            // Menampilkan pesan error validasi
                            iziToast.error({
                                title: 'Error',
                                message: message + '<br>' + errorList,
                                position: 'topRight',
                            });
                        } else if (xhr.status === 500) {
                            // Menampilkan pesan error server
                            var message = xhr.responseJSON.message;

                            iziToast.error({
                                title: 'Error',
                                message: message,
                                position: 'topRight',
                            });
                        } else {
                            // Menampilkan pesan error lainnya
                            iziToast.error({
                                title: 'Error',
                                message: 'An error occurred. Please try again later.',
                                position: 'topRight',
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
