@extends('adminlte::page')

@section('title', 'Список таблиц')

@section('content_header')
    <h1>Список таблиц</h1>
@stop

@section('content')
    @php
        foreach ($tables_list as $tablesName){
            echo '<a class="btn btn-primary" href="/admin/tables/'.trim($tablesName).'">'.trim($tablesName).'</a>';
        }
    @endphp
@stop

<style>
    .btn.btn-primary{
        margin-right: 10px;
    }
    .btn.btn-primary:last-child{
        margin-right: 0;
    }
</style>
