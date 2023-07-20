@extends('layouts.app')

@section('title', 'Data Buku Tamu')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Manage Data Buku Tamu</h1>
        </div>
        <div class="section-body">
            <div class="table-responsive">
                {!! $dataTable->table([
                    'class' => 'table table-hover',
                ]) !!}
            </div>
        </div>
    </section>

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
                    <form id="form-add-data">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama">
                        </div>
                        <div class="form-group">
                            <label for="no_hp">Nomor HP</label>
                            <input type="number" class="form-control" id="no_hp" name="no_hp">
                            <small class="text-muted">Mulai dengan 08</small>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat">
                        </div>
                        <div class="form-group">
                            <label for="keperluan">Keperluan</label>
                            <textarea name="keperluan" id="keperluan" class="form-control" cols="30" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary saveButton">Save Changes</button>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    <script>
        $(document).ready(function() {
            const formAddData = $('#form-add-data');
            const editForm = $('#editForm');
            const editModal = $('#editModal');
            const saveButton = $('.saveButton');
            const bukutamuTable = $('#bukutamu-table');

            // Edit button click event
            $(document).on('click', '.btn-edit', function() {
                const url = $(this).data('url');
                const id = $(this).data('id');

                console.log(url);
                console.log(id);

                editForm.attr('action', url).attr('method', 'POST');
                $('.modal-title').html('Edit Peserta');
                saveButton.attr('id', 'editData').html('Edit');
                formAddData.append('<input type="hidden" id="id" name="_id">');

                // Fetch data using AJAX and populate the form fields
                $.get(url, function(data) {
                    if (data.success) {
                        $('#id').val(data.data.id);
                        $('#nama').val(data.data.nama);
                        $('#no_hp').val(data.data.no_hp);
                        $('#alamat').val(data.data.alamat);
                        $('#keperluan').val(data.data.keperluan);
                        editModal.modal('show');
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: 'Failed to retrieve data.',
                            position: 'topRight',
                        });
                    }
                });
            });

            // Update Using editData Listener
            $(document).on('click', '#editData', function(e) {
                e.preventDefault();
                formAddData.append('<input type="hidden" name="_method" value="PUT">');
                const formEditData = new FormData(formAddData[0]);
                const id = $('#id').val();
                const url = '{{ route('buku-tamu.update', ':id') }}';

                // Replace ':id' with the actual ID value
                const apiUrl = url.replace(':id', id);

                $.ajax({
                    url: apiUrl,
                    type: 'POST',
                    data: formEditData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.message === 'Validation errors') {
                            $.each(response.data, function(key, value) {
                                iziToast.error(value);
                            });
                        } else {
                            if (response.success) {
                                editModal.modal('hide');
                                formAddData[0].reset();
                                editForm.remove('input[name=_method]');
                                editForm.attr('action', '').attr('method', '');
                                saveButton.removeAttr('id');

                                bukutamuTable.DataTable().ajax.reload();
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
                        // Handle errors
                        handleAjaxErrors(xhr);
                    }
                });
            });

            // Delete button click event
            $(document).on('click', '.btn-delete', function() {
                const url = $(this).data('url');
                const id = $(this).data('id');

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
                            bukutamuTable.DataTable().ajax.reload();
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

            // Function to handle Ajax errors
            function handleAjaxErrors(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    const message = xhr.responseJSON.message;
                    let errorList = '<ul>';
                    for (const key in errors) {
                        errorList += '<li>' + errors[key][0] + '</li>';
                    }
                    errorList += '</ul>';
                    iziToast.error({
                        title: 'Error',
                        message: message + '<br>' + errorList,
                        position: 'topRight',
                    });
                } else if (xhr.status === 500) {
                    const message = xhr.responseJSON.message;
                    iziToast.error({
                        title: 'Error',
                        message: message,
                        position: 'topRight',
                    });
                }
            }
        });
    </script>

    {{ $dataTable->scripts() }}
@endpush
