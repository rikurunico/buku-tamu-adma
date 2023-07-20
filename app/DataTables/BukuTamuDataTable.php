<?php

namespace App\DataTables;

use App\Models\BukuTamu;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BukuTamuDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                $buttons = '
            <a href="javascript:void(0)" class="dropdown-item btn-edit" data-url="' . route('buku-tamu.show', $row) . '" data-id="' . $row->id  . '"><i class="fas fa-edit"></i> Edit</a>
            <a href="javascript:void(0)" class="dropdown-item btn-delete" data-url="' . route('buku-tamu.destroy', $row) . '" data-id="' . $row->id  . '"><i class="fas fa-trash"></i> Delete</a>
        ';

                return '
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cogs"></i> Actions
                </button>
                <div class="dropdown-menu">
                    ' . $buttons . '
                </div>
            </div>
        ';
            })
            ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->translatedFormat('l, d F Y');
            })
            ->addIndexColumn()
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(BukuTamu $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('bukutamu-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" .
                "<'row'<'col-sm-12'rt>>" .
                "<'row'<'col-sm-12 col-md-5'il><'col-sm-12 col-md-7'p>>")
            ->language([
                'sProcessing' => 'Sedang memproses...',
                'sLengthMenu' => 'Tampilkan _MENU_ Data',
                'sZeroRecords' => 'Tidak ditemukan data yang sesuai',
                'sInfo' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ Data',
                'sInfoEmpty' => 'Menampilkan 0 sampai 0 dari 0 Data',
                'sInfoFiltered' => '(disaring dari _MAX_ Data keseluruhan)',
                'sInfoPostFix' => '',
                'sSearch' => 'Cari:',
                'sUrl' => '',
                'oPaginate' => [
                    'sFirst' => 'Pertama',
                    'sPrevious' => 'Sebelumnya',
                    'sNext' => 'Selanjutnya',
                    'sLast' => 'Terakhir'
                ],
                'oAria' => [
                    'sSortAscending' => ': aktifkan untuk mengurutkan kolom secara naik',
                    'sSortDescending' => ': aktifkan untuk mengurutkan kolom secara turun'
                ]
            ])
            ->selectStyleSingle()
            ->buttons([
                // Button::make('excel'),
                Button::make('csv')->text('Export CSV'),
                Button::make('print')->text('Print')->pageSize('A4'),
                // Button::make('reset'),
                // Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->width(10)->searchable(false)->orderable(false),
            Column::make('nama'),
            Column::make('no_hp'),
            Column::make('alamat'),
            Column::make('keperluan'),
            Column::make('created_at')->title('Tanggal Masuk'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'BukuTamu_' . date('YmdHis');
    }
}
