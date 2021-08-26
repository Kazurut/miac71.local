@extends('adminlte::page')

@section('title', 'Результаты теста')

@push('content_header')

@endpush

@section('content_header')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>


    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    @php
        /**
        * Нужно передать массив пользователей в js и отрисовать его в виде графика https://canvasjs.com/php-charts/multi-series-area-chart/
        */
        if(isset($graphic_name)){
            foreach ($graphic_name as $element){
                echo '<h1>' . $element->title . '</h1>'; // Название теста
            }
        }
    @endphp
    <h4>Выберите сотрудника</h4>
    <select id="userList" class="js-example-basic-single" style="width: 500px;">
        <option value="all">Все сотрудники</option>
        @php
            use App\Http\Controllers\TestingController;
            $users_list = TestingController::get_users('all');
            foreach ($users_list as $key => $value){
                if($value->id == $employee_id){
                    echo '<option value="' . $value->id . '" onclick="selectUser" selected>' . $value->name . '</option>';
                }else{
                    echo '<option value="' . $value->id . '" onclick="selectUser">' . $value->name . '</option>';
                }
            }
        @endphp
    </select>

    <input id="startDate" width="276" placeholder="Начало" value="{{ ($startDate == '1970-01-01') ? '' : $startDate }}" readonly/>
    <input id="endDate" width="276" placeholder="Конец" value="{{ ($endDate == '2970-01-01') ? '' : $endDate }}" readonly/>
    <a href="" id="forAllTime" class="btn btn-info left-margin" style="height: 45px;line-height: 31px;">За все время</a>

    <a href="" id="selectUser" class="btn btn-outline-info btn-block" style="height: 45px;line-height: 31px;margin-top: 30px">Выбрать</a>
    <br><br>
    <small class="text-muted">Вы можете выбрать необходимый временной период, выделив его на графике, либо указать его в полях выше.</small>
    @php
        $user_data = [];
        $dataPoints = array();
        if(isset($graphic_data) && $graphic_data != 'empty'){
            foreach ($graphic_data as $key => $value){
                $view_value[$key] = $value->values()->all();
            }
        }

        if(isset($view_value)){
            foreach ($view_value as $value){
                foreach ($value as $key => $el){
                    $user_data[$el->{'user_id'}][$key]['position']['x'] = strtotime($el->{'answer_date'}) * 1000;
                    $user_data[$el->{'user_id'}][$key]['position']['y'] = $el->{'result'};
                    $user_data[$el->{'user_id'}][$key]['user_id'] = $el->{'user_id'};
                }
            }
        }
        // $user_data - массив сотрудников и их ответов
        $new_date = 0;

        /*
         * Формируем json для передачи палгину
         * и отрисовки
         * */
        $view_value = [];
        if(!empty($graphic_data) && $graphic_data != 'empty'){
            foreach ($graphic_data as $key => $value){
                $view_value[$key] = $value;
            }
        }
        $date_array =  array(array( 'user_id' => '', 'position' => array()));
        //$date_array = array();

        array_multisort($user_data);

        $new_position = [];
        //echo '<pre>';
        //var_dump($date_array);
        //print_r($user_data);
        foreach ($user_data as $key => $el){
            //print_r($el);
            //echo '<br>';
            //print_r($date_array);
            //if(isset($date_array[$key]['user_id']))
            $date_array[$key]['user_id'] = $el[0]['user_id'];

            foreach ($el as $value){
                array_push($new_position, $value['position']);
            }
            $date_array[$key]['position'] = $new_position;
            $new_position = [];
            array_multisort($date_array[$key]['position']);
        }
        array_multisort($date_array);

        //print_r($date_array);

        foreach ($date_array as $key => $el){
            $user_name =  TestingController::get_users($el['user_id']);
            foreach ($user_name as $value){
                $user_name = $value->name;
            }
            $date_array[$key]['user_id'] = $user_name;
        }
    @endphp
@stop

@section('content')
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <span id="timeToRender"></span>
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
        .input-group {
            width: 300px;
            display: inline-flex;
            margin-left: 15px;
        }
        .input-daterange input{
            height: 45px;
        }
        /*}*/
        /*.input-group select{*/
        /*    height: 45px;*/
        /*}*/
    </style>
@endsection

@section('adminlte_js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/messages/messages.ru-ru.js" type="text/javascript"></script>
    <script>
        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

        $('#startDate').datepicker({
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            locale: 'ru-ru',
            format: 'yyyy-mm-dd',
            //(forAllTime == false) ? disable: true : forAllTime = false;
        });
        $('#endDate').datepicker({
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            locale: 'ru-ru',
            format: 'yyyy-mm-dd',
            minDate: function () {
                return $('#startDate').val();
            }
        });

        let $disabledResults = $('.js-example-basic-single');
        $disabledResults.select2();
        $disabledResults.on('select2:opening select2:closing', function( event ) {
            var $searchfield = $(this).parent().find('.select2-search__field');
            $searchfield.prop('disabled', true);
        });
        window.onload = function () {
            let chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                zoomEnabled: true,
                title: {
                    text: "Результат тестирования сотрутников"
                },
                subtitles: [{
                    text: 'ГУЗ ТО "ТОМИАЦ"',
                    fontSize: 18
                }],
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries
                },
                toolTip: {
                    shared: true
                },
                data: [
                    <?php foreach ($date_array as $el){   ?>
                    {
                        type: "splineArea",
                        name: "<?php echo $el['user_id']; ?>",
                        showInLegend: "true",
                        xValueType: "dateTime",
                        xValueFormatString: "DD MMMM YYYY",
                        yValueFormatString: "#,##0.##",
                        dataPoints: <?php echo json_encode($el['position']);  ?>
                    },
                    <?php } ?>
                ]
            });

            chart.render();

            function toggleDataSeries(e){
                if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                }
                else{
                    e.dataSeries.visible = true;
                }
                chart.render();
            }
        }

        $( '#forAllTime' ).on('click', function (e) {
            e.preventDefault();
            $('#startDate').val('');
            $('#endDate').val('');
        });
        $( '#selectUser' ).on('click', function (e) {
            e.preventDefault();
            let startDate = $('#startDate').val(),
                endDate = $('#endDate').val(),
                current_user_id = $('#userList option:selected').attr('value');

            if (startDate !== ''){
                if (endDate !== ''){
                    $(location).attr('href', '/admin/testing/graphic/<?=$graphic_id?>/employee=' + current_user_id + '/startDate=' + startDate + '/endDate=' + endDate);
                }else{
                    $(location).attr('href', '/admin/testing/graphic/<?=$graphic_id?>/employee=' + current_user_id + '/startDate=' + startDate);
                }
            }else if (endDate !== ''){
                $(location).attr('href', '/admin/testing/graphic/<?=$graphic_id?>/employee=' + current_user_id + '/endDate=' + endDate);
            }else{
                $(location).attr('href', '/admin/testing/graphic/<?=$graphic_id?>/employee=' + current_user_id);
            }
        });
    </script>
@endsection
