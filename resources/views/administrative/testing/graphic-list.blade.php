@extends('adminlte::page')

@section('title', 'Список тестов')

@section('content_header')
    <h1>Список тестов</h1>
@stop

@section('content')
    @php
        foreach ($test_name as $value){
            echo '<a class="btn btn-primary" href="/admin/testing/graphic/'.$value->id.'/employee=all">'.$value->title.'</a>';
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
