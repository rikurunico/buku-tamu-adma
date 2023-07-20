<?php

namespace App\Http\Controllers;

use App\DataTables\BukuTamuDataTable;
use App\Http\Requests\BukuTamuRequest;
use App\Models\BukuTamu;
use Illuminate\Http\Request;

class BukuTamuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BukuTamuDataTable $dataTable)
    {
        return $dataTable->render('dashboard.buku-tamu');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BukuTamuRequest $request)
    {
        return response()->json([
            'message' => 'Berhasil menambahkan data buku tamu.',
            'data' => BukuTamu::create($request->validated()),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(BukuTamu $bukuTamu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BukuTamu $bukuTamu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BukuTamu $bukuTamu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BukuTamu $bukuTamu)
    {
        //
    }
}
