@extends('layouts.app')

@section('title', 'Peserta')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Manage Data Peserta</h1>
        </div>
        <div class="section-body">
            <div class="mb-3">
                <button class="btn btn-primary" id="addButton" data-toggle="modal" data-target="#editModal">Add</button>

                <a href="{{ route('pesertaExport') }}" class="btn btn-success">Export</a>

                <button class="btn btn-primary" id="excelImport" data-toggle="modal" data-target="#importExcel"><i
                        class="fas fa-file-import me-2"></i> Import Excel</button>
            </div>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive text-nowrap">
                {!! $dataTable->table([
                    'class' => 'table table-hover table-fixed',
                ]) !!}
            </div>
        </div>


    </section>

    <!-- Modal Import -->
    <div class="modal fade" id="importExcel" data-bs-keyboard="false" tabindex="-1" aria-labelledby="importExcelLabel"
        data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importExcelLabel">Import Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('pesertaImport') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Import Menggunakan File Excel</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="file" name="file" required
                                        accept=".xlsx, .xls">
                                    <label class="custom-file-label" for="file">Pilih File</label>
                                </div>
                            </div>
                            <a href="{{ route('pesertaExportTemplate') }}" class="btn btn-success mt-3">Download
                                Template</a>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Tambah Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true"
        data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <form id="editForm" action="" method="POST"> --}}
                    <form id="form-add-data">
                        @csrf
                        <!-- Form fields for 'nomor', 'nama', 'alamat', 'delegasi_kafilah', 'nomor_hp' -->
                        <div class="form-group">
                            <label for="nomor">Nomor</label>
                            <input type="text" class="form-control" id="nomor" name="nomor">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat">
                        </div>
                        <div class="form-group">
                            <label for="delegasi_kafilah">Delegasi Kafilah</label>
                            <input type="text" class="form-control" id="delegasi_kafilah" name="delegasi_kafilah">
                        </div>
                        <div class="form-group">
                            <label for="nomor_hp">Nomor HP</label>
                            <input type="number" class="form-control" id="nomor_hp" name="nomor_hp">
                        </div>
                        <button type="submit" class="btn btn-primary saveButton" id="">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css"
        integrity="sha512-DIW4FkYTOxjCqRt7oS9BFO+nVOwDL4bzukDyDtMO7crjUZhwpyrWBFroq+IqRe6VnJkTpRAS6nhDvf0w+wHmxg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('custom-js')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <script>
        document.getElementById('file').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            $('.custom-file-label').html(fileName);
        });
    </script>

    <script>
        $(document).ready(function() {

            // Add button click event
            $('#addButton').click(function() {
                // Reset the form
                $('#form-add-data')[0].reset();
                $('#form-add-data').trigger('reset');
                $('.modal-title').html('Tambahkan Peserta');

                // Show the modal
                $('#editModal').modal('show');

                // Set form action URL
                $('.saveButton').attr('id', 'addData').html('Tambah Data');
            });

            //CREATE DATA
            $(document).on('click', '#addData', function(e) {
                e.preventDefault();
                $('#form-add-data').append('<input type="hidden" name="_method" value="POST">');
                var formTambahData = new FormData($('#form-add-data')[0]);
                $.ajax({
                    url: '{{ route('peserta.store') }}',
                    type: 'POST',
                    data: formTambahData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.message == 'Validation errors') {
                            $.each(response.data, function(key, value) {
                                iziToast.error(value);
                            });
                        } else {
                            if (response.success) {
                                $('#editModal').modal('hide');
                                $('#form-add-data')[0].reset();
                                $('#form-add-data').trigger('reset');
                                $('#editForm').remove('input[name=_method]');
                                $('#editForm').attr('action', '');
                                $('#editForm').attr('method', '');
                                //reset id addData
                                $('#addData').attr('id', '');

                                $('#peserta-table').DataTable().ajax.reload();
                                iziToast.success({
                                    title: 'Success',
                                    message: response.message,
                                    position: 'topRight',
                                });
                            } else {
                                iziToast.error({
                                    title: 'Error',
                                    message: response.message,
                                    position: 'topRight',
                                });
                            }
                        }
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
                        }
                    }
                });
            });

            // Edit button click event
            $(document).on('click', '.btn-edit', function() {
                var url = $(this).data('url');
                var id = $(this).data('id');

                // Set form action URL
                $('#editForm').attr('action', url);
                $('#editForm').attr('method', 'POST');
                $('.modal-title').html('Edit Peserta');
                $('.saveButton').attr('id', 'editData').html('Edit');
                $('#form-add-data').append('<input type="hidden" id="id" name="_id">');
                // Fetch data using AJAX and populate the form fields
                $.get(url, function(data) {

                    if (data.success) {
                        // Jika permintaan berhasil, isi nilai pada form dan tampilkan modal

                        $('#id').val(data.data.id);
                        $('#nomor').val(data.data.nomor);
                        $('#nama').val(data.data.nama);
                        $('#alamat').val(data.data.alamat);
                        $('#delegasi_kafilah').val(data.data.delegasi_kafilah);
                        $('#nomor_hp').val(data.data.nomor_hp);
                        $('#form-add-data').append(
                            '<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">'
                        );
                        // Show the modal
                        $('#editModal').modal('show');
                    } else {
                        // Jika permintaan tidak berhasil, tampilkan toast error
                        iziToast.error({
                            title: 'Error',
                            message: 'Failed to retrieve data.',
                            position: 'topRight',
                        });
                    }
                });
            });

            //Update Using editData Listener
            $(document).on('click', '#editData', function(e) {
                e.preventDefault();
                $('#form-add-data').append('<input type="hidden" name="_method" value="PUT">');
                let formEditData = new FormData($('#form-add-data')[0]);
                let id = $('#id').val();
                let url = '{{ route('peserta.update', ':id') }}';

                // Mengganti ':id' dengan nilai ID yang diambil dari input field
                url = url.replace(':id', id);


                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formEditData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.message == 'Validation errors') {
                            $.each(response.data, function(key, value) {
                                iziToast.error(value);
                            });
                        } else {
                            if (response.success) {
                                $('#editModal').modal('hide');
                                $('#form-add-data')[0].reset();
                                $('#form-add-data').trigger('reset');
                                $('#editForm').remove('input[name=_method]');
                                $('#editForm').attr('action', '');
                                $('#editForm').attr('method', '');
                                //reset id editData
                                $('#editData').attr('id', '');

                                $('#peserta-table').DataTable().ajax.reload();
                                iziToast.success({
                                    title: 'Success',
                                    message: response.message,
                                    position: 'topRight',
                                });
                            } else {
                                iziToast.error({
                                    title: 'Error',
                                    message: response.message,
                                    position: 'topRight',
                                });
                            }
                        }
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
                        }
                    }
                });
            });

            // Delete button click event
            $(document).on('click', '.btn-delete', function() {
                var url = $(this).data('url');
                var id = $(this).data('id');

                // Show confirmation alert
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Check if the delete was successful
                        if (response.success) {
                            // Show success toast
                            iziToast.success({
                                title: 'Success',
                                message: response.message,
                                position: 'topRight',
                            });

                            // Refresh the data table
                            window.LaravelDataTables['peserta-table'].ajax.reload();
                        } else {
                            // Show error toast
                            iziToast.error({
                                title: 'Error',
                                message: response.message,
                                position: 'topRight',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Show error toast
                        iziToast.error({
                            title: 'Error',
                            message: 'Failed to delete data.',
                            position: 'topRight',
                        });
                    }
                });
            });
        });
    </script>

    {{ $dataTable->scripts() }}
@endpush
