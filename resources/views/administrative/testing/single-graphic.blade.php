@extends('adminlte::page')

@section('title', 'List of tests')

@section('content_header')
    @php

        /**
        * Нужно передать массив пользователей в js и отрисовать его в виде графика https://canvasjs.com/php-charts/multi-series-area-chart/
        */
            $new_elem = [];
            foreach ($graphic_name as $element){
                $new_elem = get_object_vars($element);
                echo '<h1>' . $element->title . '</h1>'; // Название теста
            }
            unset($new_elem);

            echo '<pre>';

            $user_data = [];
            $dataPoints = array();
            foreach ($graphic_data as $key => $value){
                $view_value[$key] = $value->values()->all();
            }
            foreach ($view_value as $value){
                foreach ($value as $key => $el){
                    $user_data[$el->{'user_id'}][$key]['answer_date'] = $el->{'answer_date'};
                    $user_data[$el->{'user_id'}][$key]['result'] = $el->{'result'};
                    $user_data[$el->{'user_id'}][$key]['user_id'] = $el->{'user_id'};
                }
            }
            // $user_data - массив сотрудников и их ответов
            foreach ($user_data as $key => $value){;
                $dataPoints[$key] = array();
                    for($i = 0; $i < count($value); $i++){
                        array_push($dataPoints[$key], array("label" => $value[$i]['answer_date'], "y" => $value[$i]['result']));
                    }
                foreach ($value as $el_key => $el){
                    //echo count($value);

                }
            }
                print_r($dataPoints);
            echo '</pre>';
            /*$view_value = $graphic_data->values()->all(); // data array
            $date_array = [];
            foreach ($view_value as $key => $value){
                $date_array[$key] = $value->answer_date;
                $value_array[$key] = $value->result;
            }

            array_multisort($date_array, $value_array);

            $limit = count($date_array);
            $dataPoints = array();
            for($i = 0; $i < $limit; $i++){
                array_push($dataPoints, array("label" => $date_array[$i], "y" => $value_array[$i]));
            }*/
    @endphp
@stop

@section('content')
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <span id="timeToRender"></span>
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
        #timeToRender {
            position:absolute;
            top: 10px;
            font-size: 20px;
            font-weight: bold;
            background-color: #d85757;
            padding: 0px 4px;
            color: #ffffff;
        }
    </style>
@endsection

@section('adminlte_js')
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script>
       /* window.onload = function () {
            var data = [{
                type: "line",
                dataPoints: <?// echo json_encode($dataPoints); ?>
            }];

            console.log(data[0]['dataPoints']);
            //Better to construct options first and then pass it as a parameter
            var options = {
                zoomEnabled: true,
                animationEnabled: true,
                title: {
                    text: "Результаты теста"
                },
                axisX: {
                    title: "Дата прохождения теста"
                },
                axisY: {
                    title: "Количество баллов",
                    lineThickness: 1
                },
                data: data  // random data
            };

            var chart = new CanvasJS.Chart("chartContainer", options);
            var startTime = new Date();
            chart.render();
            var endTime = new Date();
            document.getElementById("timeToRender").innerHTML = "Time to Render: " + (endTime - startTime) + "ms";

        }*/
    </script>
@endsection
