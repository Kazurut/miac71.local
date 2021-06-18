@extends('adminlte::page')

@section('title', 'List of tests')

@section('content_header')
    <h1>List of tests</h1>
@stop

@section('content')
    @php
        foreach ($test_name as $value){
            echo '<a class="btn btn-primary" href="/admin/testing/'.$value->id.'">'.$value->title.'</a>';
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
