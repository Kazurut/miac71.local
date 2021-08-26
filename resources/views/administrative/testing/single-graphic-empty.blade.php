@extends('adminlte::page')

@section('title', 'Результаты теста')

@push('content_header')

@endpush

@section('content_header')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    @php
        /**
        * Нужно передать массив пользователей в js и отрисовать его в виде графика https://canvasjs.com/php-charts/multi-series-area-chart/
        */
        $testName;
        if(isset($graphic_name)){
            foreach ($graphic_name as $element){
                echo '<h1>' . $element->title . '</h1>'; // Название теста
                $testName = $element->title;
            }
        }
    @endphp
    <h4>Выберите сотрудника</h4>
    <select id="userList" class="js-example-basic-single" style="width: 500px;">
        <option value="all">Все сотрудники</option>
        @php
            $user_name;
            use App\Http\Controllers\TestingController;
            $users_list = TestingController::get_users('all');
            foreach ($users_list as $key => $value){
                if($value->id == $employee_id){
                    echo '<option value="' . $value->id . '" onclick="selectUser" selected>' . $value->name . '</option>';
                    $user_name = $value->name;
                }else{
                    echo '<option value="' . $value->id . '" onclick="selectUser">' . $value->name . '</option>';
                }
            }
        @endphp
    </select>
    <a href="" id="selectUser" class="btn btn-info left-margin" style="height: 45px;line-height: 31px;">Выбрать</a>
@stop

@section('content')
    @php
        if($employee_id == 'all'){
            echo '<h1>Никто еще не проходил "' . $testName . '"!</h1>'; // Название теста
        }else{
            if(isset($graphic_name)){
                foreach ($graphic_name as $element){
                    echo '<h1>Сотрудник "' . $user_name . '" еще не проходил(а) "' . $testName . '"!</h1>'; // Название теста
                }
            }
        }
    @endphp
    <div class="row button-navigation" style="padding-left: 7.5px;">
        <a class="btn btn-secondary" href="/admin/testing/graphic/">Назад</a>
    </div>
@stop

@section('adminlte_css')
    <style>
        label{
            padding-left: 10px;
        }
        #timeToRender {
            position:absolute;
            top: 10px;
            font-size: 20px;
            font-weight: bold;
            background-color: #d85757;
            padding: 0 4px;
            color: #ffffff;
        }
        .select2-container--default .select2-selection--single{
            height: 45px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow{
            top: 10px !important;
        }
        .left-margin{
            margin-left: 15px;
        }
        .canvasjs-chart-canvas{
            width: 100% !important;
        }
    </style>
@endsection

@section('adminlte_js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let $disabledResults = $('.js-example-basic-single');
        $disabledResults.select2();
        $( '#selectUser' ).on('click', function (e) {
            e.preventDefault();
            var current_user_id = $( '#userList option:selected' ).attr('value');
            $(location).attr('href', '/admin/testing/graphic/<?=$graphic_id?>/employee=' + current_user_id);
        });
    </script>
@endsection
