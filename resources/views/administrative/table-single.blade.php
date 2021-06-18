@extends('adminlte::page')

@section('title', $table_name)

@section('content_header')
    <h1>Table name: {{ $table_name }}</h1>
    @if(($table_name != '') && ($table_name != 'users'))
        <br>
        <a class="btn btn-outline-info btn-block" href='{{ $table_name }}/create'>Add new</a>
    @endif
@stop

@section('content')
    <div class="row col-name">
        <div class="col-1">ID</div>
        <div class="col-6">Preview</div>
        <div class="col-1">created_at</div>
        <div class="col-1">updated_at</div>
        <div class="col-1">Edit</div>
        <div class="col-1">View more</div>
        <div class="col-1">Delete</div>
    </div>
    @php
        foreach ($table as $key => $value){
            echo '<div class="row">';
            foreach ($value as $element_name=>$element_value){
                if(!isset($element_value)){
                    echo '<div class="col-1 text-danger">empty</div>';
                }else{
                    if($element_name == 'id'){
                        echo '<div class="col-1">'.$element_value.'</div>';
                    }elseif($element_name == 'preview'){
                        echo '<div class="col-6" style="overflow: hidden;">'.$element_value.'</div>';
                    }else{
                        echo '<div class="col-1">'.$element_value.'</div>';
                    }
                }
                if($element_name == 'id')
                    $id = $element_value;
            }
            echo '<div class="col-1"><a href="'.$table_name.'/'.$id.'/edit"><i class="far fa-edit"></i></a></div>';
            echo '<div class="col-1"><a href="'.$table_name.'/'.$id.'/view"><i class="far fa-eye"></i></a></div>';
            echo '<div class="col-1"><a href="'.$table_name.'/'.$id.'/delete"><i class="far fa-trash-alt"></i></a></div>';
            echo '</div>';
        }
        echo '<br>';
    @endphp
    <a class="btn btn-secondary" href="/admin/tables/">Back</a>
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
