@extends('adminlte::page')

@section('title', 'Тест пройден!')

@section('content_header')
    <h1>Благодарим за прохождение теста: <em><u>{{ $test_el->values()->all()[0]->title }}</u></em>!</h1>
@stop

@section('content')
    <a class="btn btn-secondary" href="/admin/testing">Назад</a>
@stop

@section('adminlte_css')
    <style>
        .btn.btn-primary{
            margin-right: 10px;
        }
        .btn.btn-primary:last-child{
            margin-right: 0;
        }
        label{
            padding-left: 10px;
        }
    </style>
@endsection

@section('adminlte_js')

@endsection
