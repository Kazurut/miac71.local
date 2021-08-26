@extends('adminlte::page')

@section('title', $table_name)

@section('content_header')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <h1>Table name: {{ $table_name }}</h1>
    <h2>Element id: {{ $id }}</h2>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row col-name">
        <div class="col-2">ID</div>
        <div class="col-10">Value</div>
    </div>

    <form action='edit/store' method="POST">
        @csrf
            @php
                $last_col = '';
                foreach ($table as $key=>$value){
                    foreach ($value as $element_name=>$element_value){
                        if($element_name == 'id'){
                            echo '<div class="row">
                                    <div class="col-2">'.$element_name.':</div>
                                    <div class="col-10 disable"><input type="text" placeholder="id" value="'.$element_value.'" disabled></div>
                                  </div>';
                        }else{
                            if(($element_name == 'created_at') || ($element_name == 'updated_at') || ($element_name == 'failed_at')){
                                if($element_value == ''){
                                    $last_col = $last_col .
                                    '<div class="row">
                                        <div class="col-2">'.$element_name.':</div>
                                        <div class="col-10 text-danger">empty</div>
                                     </div>';
                                }else{
                                    $last_col = $last_col .
                                    '<div class="row">
                                        <div class="col-2">'.$element_name.':</div>
                                        <div class="col-10 disable"><input type="text" placeholder="'.$element_value.'(mm.dd.yyyy)" value="'.$element_value.'" name="'.$element_name.'" readonly></div>
                                     </div>';
                                }
                            }else{
                                echo '<div class="row">
                                        <div class="col-2">'.$element_name.':</div>
                                        <div class="col-10">
                                          <input class="current_input" type="text" placeholder="'.$element_name.'" name="'.$element_name.'" id="'.$element_name.'" value="'.$element_value.'" required>
                                          <i class="fas fa-pencil-alt"></i>
                                        </div>
                                      </div>';
                            }
                        }
                    }
                }
                echo $last_col;
            @endphp
        <input type="hidden" name="id" value="{{ $id }}">
        <div class="row button-navigation">
            <button type="submit" name="submit" value="update" class="btn btn-primary">Обновить</button>
            <a class="btn btn-secondary" href="/admin/tables/{{$table_name}}">Назад</a>
        </div>
    </form>
@stop

<style>
    [class*="col-"], .col {
        /*padding: 7.5px;*/
        background-color: rgba(86, 61, 124, .15);
        border: 1px solid rgba(86, 61, 124, .2);
    }
    .disable{
        opacity: 0.8;
        margin-bottom: 0;
    }
    .row{
        margin: 0 !important;
    }
    input{
        border: none;
        background: transparent;
        width: inherit;
        padding: 0;
    }
    .fas {
        position: absolute;
        right: 10px;
        line-height: inherit !important;
    }
    .col-10 input{
        padding-right: 26px;
    }
    textarea {
        width: 100%;
        background: transparent;
        padding-right: 26px;
        border: none;
    }
</style>

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('input.current_input').focusin(function () {
            if(this.id != ''){
                let input = [
                    this.type, //type
                    this.placeholder, //placeholder
                    this.name, //name
                    this.id, //id
                    this.value //value
                ];

                new_input_elem = "<textarea class='current_input' placeholder='" + input[1] + "' name='" + input[2] + "' id='" + input[3] + "' required>" + input[4] + "</textarea>";
                old_elem = this;
                $(this).replaceWith(new_input_elem);
                $('textarea#' + this.id).focus();
                let elemLen = input[4].length;
            //    $('textarea#' + this.id).selectionStart = elemLen;
            }
        })
    </script>
@stop
