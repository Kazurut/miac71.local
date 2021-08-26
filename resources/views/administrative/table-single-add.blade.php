@extends('adminlte::page')

@section('title', $table_name)

@section('content_header')
    <h1>Таблица: {{ $table_name }}</h1>
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

    <form action='create/store' method="POST">
        @csrf
        <table border="1">
            <tr>
                @php
                    $last_col = '';
                    $date = date('m.d.Y');
                    $datetime = date('m.d.Y h:m:s');
                        foreach ($table_column as $key=>$value){
                            if($value == 'id'){
                                echo '<input type="text" placeholder="'.$value.'" disabled>';
                            }else{
                                if(($value == 'created_at') || ($value == 'updated_at')){
                                    $last_col = $last_col . '<input type="text" placeholder="'.$value.'(mm.dd.yyyy)" name="'.$value.'" value="'.$date.'" readonly>';
                                }else{
                                    if($table_info[$key] == 'date'){
                                        echo '<input type="text" placeholder="'.$value.'(mm.dd.yyyy)" name="'.$value.'" required>';
                                    }elseif($table_column[$key] == 'failed_at'){
                                        echo '<input type="text" placeholder="'.$value.'(mm.dd.yyyy h:m:s)" value="'.$datetime.'" name="'.$value.'" readonly>';
                                    }else{
                                        echo '<input type="text" placeholder="'.$value.'" name="'.$value.'" required>';
                                    }
                                }
                            }
                        }
                        echo $last_col;
                @endphp
            </tr>
        </table>
        <br>

        <button type="submit" name="submit" value="create" class="btn btn-primary">Добавить</button>
        <a class="btn btn-secondary" href="/admin/tables/{{$table_name}}">Назад</a>
    </form>
@stop

<style>
    .btn.btn-primary{
        margin-right: 10px;
    }
    .btn.btn-primary:last-child{
        margin-right: 0;
    }
</style>
