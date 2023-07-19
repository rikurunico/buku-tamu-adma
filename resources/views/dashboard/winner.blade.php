@extends('layouts.app')

@section('title', 'Daftar Hadir')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Daftar Pemenang</h1>
        </div>
        <div class="section-body">
            <div class="table-responsive">
                {!! $dataTable->table([
                    'class' => 'table table-hover table-fixed',
                ]) !!}
            </div>
        </div>
    </section>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
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
                            <input type="hidden" class="form-control" name="id" id="id">

                            <label for="notes">Catatan</label>
                            <textarea class="form-control" name="notes" id="notes" rows="3"></textarea>

                            <label for="status">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="sudah_menerima">Sudah Menerima</option>
                                <option value="belum_menerima">Belum Menerima</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block saveButton">Save Changes</button>
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
        $(document).ready(function() {
            $('#editModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var url = "{{ route('pemenang.edit', ':id') }}";
                url = url.replace(':id', id);

                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(response) {
                        var data = response.data;
                        $('#notes').val(data.notes);
                        $('#status').val(data.status);
                    },
                    error: function(response) {
                        iziToast.error({
                            title: 'Error',
                            message: 'Data gagal diambil',
                            position: 'topRight'
                        });
                    }
                });

                var modal = $(this);
                modal.find('.modal-title').text('Edit Status Pemenang');
                modal.find('.modal-body #id').val(id);
            });


            $('#form-add-data').on('submit', function(e) {
                e.preventDefault();
                var id = $('#id').val();
                var status = $('#status').val();
                var notes = $('#notes').val();
                $.ajax({
                    type: "PUT",
                    url: "{{ route('pemenang.update', '') }}/" + id,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "status": status,
                        "notes": notes
                    },
                    success: function(response) {
                        $('#editModal').modal('hide');
                        $('#winner-table').DataTable().ajax.reload();
                        iziToast.success({
                            title: 'Success',
                            message: 'Status berhasil diubah',
                            position: 'topRight'
                        });
                    },
                    error: function(response) {
                        iziToast.error({
                            title: 'Error',
                            message: 'Status gagal diubah',
                            position: 'topRight'
                        });
                    }
                });
            });
        });
    </script>

    {!! $dataTable->scripts() !!}
@endpush
