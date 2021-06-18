@extends('adminlte::page')

@section('title', $table_name)

@section('content_header')
    <h1 class="text-danger">У вас нет прав на просмотр и редактирование таблицы: {{ $table_name }}</h1>
@stop

@section('content')
    <a class="btn btn-secondary" href="/admin/tables/">Назад</a>
@stop

<style>
    .btn.btn-primary{
        margin-right: 10px;
    }
    .btn.btn-primary:last-child{
        margin-right: 0;
    }
    button.action{
        background: transparent;
        border: none;
    }
    [class*="col-"] {
        /*padding: 7.5px;*/
        background-color: rgba(86, 61, 124, .15);
        border: 1px solid rgba(86, 61, 124, .2);
    }
    .col-auto, .col{
        border: none;
        background: transparent;
    }
    [class*=i]{
        line-height: inherit;
    }
    .row{
        margin: 0 !important;
    }
    .col-1 a i.far {
        width: 100%;
    }
</style>
