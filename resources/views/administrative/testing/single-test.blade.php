@extends('adminlte::page')

@section('title', 'List of tests')

@section('content_header')
    @php
        $new_elem = [];
        foreach ($test_el as $element){
            $new_elem = get_object_vars($element);
            $id = $element->id;
            echo '<h1>' . $element->title . '</h1>';
        }
    @endphp
@stop

@section('content')
    <form action='{{ $id }}/preResult/store' method="POST">
        @csrf
        @php
            foreach ($new_elem as $key => $value){
                $i = 1;
                if(($key != 'title') && ($key != 'id')){
                    if($value == ''){
                        echo '<div class="row"><div class="col-12 text-danger">Пустой вопрос!</div></div>';
                    }else{
                        echo '<div class="row"><div class="col-12"><p class="lead"><strong>'.$value.'</strong><p></div></div>';

                        echo '<div class="row"><div class="col-auto">';
                            echo '<input type="radio" name="' . $key . '" id="' . $key . '_answer_' . $i . '" value="1" required>';
                            echo '<label for="' . $key . '_answer_' . $i . '" class="lead"><em><small>Да</small></em></label>';
                        echo '</div><div class="col-auto">';
                            echo '<input type="radio" name="' . $key . '" id="' . $key . '_answer_' . ($i+1) . '"  value="2" required>';
                            echo '<label for="' . $key . '_answer_' . ($i+1) . '" class="lead"><em><small>Скорее да</small></em></label>';
                        echo '</div><div class="col-auto">';
                            echo '<input type="radio" name="' . $key . '" id="' . $key . '_answer_' . ($i+2) . '"  value="3" required>';
                            echo '<label for="' . $key . '_answer_' . ($i+2) . '" class="lead"><em><small>Не знаю</small></em></label>';
                        echo '</div><div class="col-auto">';
                            echo '<input type="radio" name="' . $key . '" id="' . $key . '_answer_' . ($i+3) . '"  value="4" required>';
                            echo '<label for="' . $key . '_answer_' . ($i+3) . '" class="lead"><em><small>Скорее нет</small></em></label>';
                        echo '</div><div class="col-auto">';
                            echo '<input type="radio" name="' . $key . '" id="' . $key . '_answer_' . ($i+4) . '"  value="5" required>';
                            echo '<label for="' . $key . '_answer_' . ($i+4) . '" class="lead"><em><small>Нет</small></em></label>';
                        echo '</div></div>';
                    }
                    $i++;
                }
            }
        @endphp
        <div class="row">
            <div class="col-12">
                <button type="submit" name="submit" value="save" class="btn btn-primary">Save</button>
                <a class="btn btn-secondary" href="/admin/testing">Back</a>
            </div>
        </div>
    </form>
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
