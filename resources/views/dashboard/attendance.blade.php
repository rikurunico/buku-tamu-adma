@extends('layouts.app')

@section('title', 'Daftar Hadir')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Daftar Hadir</h1>
        </div>
        <div class="section-body">
            <div class="mb-3">
                <button class="btn btn-danger" id="resetAttendance">Reset Daftar
                    Hadir</button>
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
            // Listener for resetAttendance button click
            $('#resetAttendance').click(function(event) {
                event.preventDefault(); // Prevent default action using preventDefault()

                // Show confirmation dialog using iziToast
                iziToast.question({
                    timeout: 20000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 999,
                    title: 'Reset Daftar Hadir',
                    message: 'Apakah anda yakin ingin mereset daftar hadir?',
                    position: 'center',
                    buttons: [
                        ['<button><b>Ya</b></button>', function(instance, toast) {
                            // If user clicks 'Ya', redirect to resetAttendance route using AJAX
                            $.ajax({
                                url: "{{ route('resetAttendance') }}",
                                method: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(data) {
                                    // If successful, show success message using iziToast
                                    iziToast.success({
                                        title: 'Berhasil',
                                        message: 'Daftar hadir berhasil direset',
                                        position: 'topRight'
                                    });
                                    // Refresh data table
                                    $('#attendance-table').DataTable().ajax
                                        .reload();

                                    instance.hide({
                                        transitionOut: 'fadeOutUp'
                                    }, toast, 'button');

                                },
                                error: function(xhr, status, error) {
                                    // If failed, show error message using iziToast
                                    iziToast.error({
                                        title: 'Gagal',
                                        message: 'Daftar hadir gagal direset',
                                        position: 'topRight'
                                    });
                                }
                            });
                        }, true],
                        ['<button>Tidak</button>', function(instance, toast) {
                            // If user clicks 'Tidak', close the dialog
                            instance.hide({
                                transitionOut: 'fadeOutUp'
                            }, toast, 'button');
                        }],
                    ],
                    onClosing: function(instance, toast, closedBy) {
                        console.info('Closing | closedBy: ' + closedBy);
                    },
                    onClosed: function(instance, toast, closedBy) {
                        console.info('Closed | closedBy: ' + closedBy);
                    }
                });
            });
        });
    </script>

    {!! $dataTable->scripts() !!}
@endpush
