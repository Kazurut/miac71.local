<?php

namespace App\Http\Controllers;

use App\Models\TablesModelCRUD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TablesControllerCRUD extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($table_name)
    {
        $table = DB::table($table_name)->get();
        return view('administrative.table-single', ['table_name' => $table_name, 'table' => $table]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($table_name)
    {
        return '00';$table = DB::table($table_name)->get();
        $table_column = DB::getSchemaBuilder()->getColumnListing($table_name);
        return view('administrative.table-single-add', ['table_name' => $table_name, 'table_column' => $table_column]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TablesModelCRUD  $tablesModelCRUD
     * @return \Illuminate\Http\Response
     */
    public function show(TablesModelCRUD $tablesModelCRUD)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TablesModelCRUD  $tablesModelCRUD
     * @return \Illuminate\Http\Response
     */
    public function edit(TablesModelCRUD $tablesModelCRUD)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TablesModelCRUD  $tablesModelCRUD
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TablesModelCRUD $tablesModelCRUD)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TablesModelCRUD  $tablesModelCRUD
     * @return \Illuminate\Http\Response
     */
    public function destroy(TablesModelCRUD $tablesModelCRUD)
    {
        //
    }
}
