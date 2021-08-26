@extends('adminlte::page')

@section('title', $table_name)

@section('content_header')
    <h1>Table name: {{ $table_name }}</h1>
    <h2>Element id: {{ $id }}</h2>
@stop

@section('content')
    <div class="row col-name">
        <div class="col-2">ID</div>
        <div class="col-10">Value</div>
    </div>
    @php
        $last_col = '';
        foreach ($table as $key => $value){
            foreach ($value as $element_name => $element_value){
                if(!isset($element_value)){
                    echo '<div class="row">
                            <div class="col-2">'.$element_name.':</div>
                            <div class="col-10 text-danger">empty</div>
                          </div>';
                }else{
                    if(($element_name == 'created_at') || ($element_name == 'updated_at') || ($element_name == 'failed_at')){
                        $last_col = $last_col . '<div class="row">
                                                   <div class="col-2">'.$element_name.':</div>
                                                   <div class="col-10">'.$element_value.'</div>
                                                 </div>';
                    }elseif($element_name == 'id'){
                        echo '<div class="row">
                                <div class="col-2">'.$element_name.':</div>
                                <div class="col-10">'.$element_value.'</div>
                              </div>';
                    }else{
                        echo '<div class="row">
                                <div class="col-2">'.$element_name.':</div>
                                <div class="col-10"><textarea readonly>'.$element_value.'</textarea></div>
                              </div>';
                    }
                }
            }
        }
        echo $last_col;
    @endphp
    <div class="row button-navigation">
        <a class="btn btn-secondary" href="/admin/tables/{{ $table_name }}">Назад</a>
    </div>
@stop

<style>
    [class*="col-"] {
        /*padding: 7.5px;*/
        background-color: rgba(86, 61, 124, .15);
        border: 1px solid rgba(86, 61, 124, .2);
    }
    .row{
        margin: 0 !important;
    }
    textarea {
        width: 100%;
        background: transparent;
        border: none;
    }
</style>
