@extends('layouts.app')

@section('title', 'Buku Tamu')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Buku Tamu</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('storeBukuTamu') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="no_hp">Nomor HP</label>
                                    <input type="number" name="no_hp" id="no_hp" class="form-control" required>
                                    <small>Mulai dengan 08</small>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" name="alamat" id="alamat" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="keperluan">Keperluan</label>
                                    <textarea name="keperluan" id="keperluan" class="form-control" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('custom-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css"
        integrity="sha512-DIW4FkYTOxjCqRt7oS9BFO+nVOwDL4bzukDyDtMO7crjUZhwpyrWBFroq+IqRe6VnJkTpRAS6nhDvf0w+wHmxg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('custom-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>

    <script>
        $(document).ready(function() {
            // Tangkap form submit event
            $('form').submit(function(event) {
                event.preventDefault(); // Hindari aksi default submit form

                // Ambil URL action form
                var formAction = $(this).attr('action');

                // Ambil data form
                var formData = $(this).serialize();

                console.log(formData);

                // Kirim data menggunakan AJAX
                $.ajax({
                    type: 'POST',
                    url: formAction,
                    data: formData,
                    success: function(response) {
                        // Tampilkan iziToast success message
                        iziToast.success({
                            title: 'Sukses',
                            message: response.message,
                            position: 'topRight',
                        });

                        // Bersihkan inputan setelah berhasil kecuali csrf token
                        $('input:not([name="_token"])').val('');
                        $('textarea').val('');
                    },
                    error: function(xhr) {
                        // Tangkap pesan kesalahan dari response JSON
                        var errors = xhr.responseJSON.errors;

                        // Tampilkan iziToast error message
                        for (var error in errors) {
                            iziToast.error({
                                title: 'Error',
                                message: errors[error][0],
                                position: 'topRight',
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
