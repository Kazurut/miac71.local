@extends('adminlte::page')

@section('title', $table_name)

@section('content_header')
    <h1>Таблица: {{ $table_name }}</h1>
    @if(($table_name != '') && ($table_name != 'users') && (isset($table[0])))
        <br>
        <a class="btn btn-outline-info btn-block" href='{{ $table_name }}/create'>Добавить новую запись</a>
    @endif
@stop

@section('content')
    @php
        if(isset($table[0])){
    @endphp
        <div class="row col-name">
            <div class="col-1">ID</div>
            <div class="col-6">Preview</div>
            <div class="col-1">created_at</div>
            <div class="col-1">updated_at</div>
            <div class="col-1">Редактирование</div>
            <div class="col-1">Просмотр</div>
            <div class="col-1">Удаление</div>
        </div>
    @php
            foreach ($table as $key => $value){
                echo '<div class="row" id="'.$value->id.'">';
                foreach ($value as $element_name=>$element_value){
                    if(!isset($element_value)){
                        echo '<div class="col-1 text-danger">empty</div>';
                    }else{
                        if($element_name == 'id'){
                            echo '<div class="col-1" onclick="delete_item()">'.$element_value.'</div>';
                        }elseif($element_name == 'preview'){
                            echo '<div class="col-6" id="preview-'.$id.'" style="overflow: hidden;">'.$element_value.'</div>';
                        }else{
                            echo '<div class="col-1">'.$element_value.'</div>';
                        }
                    }
                    if($element_name == 'id')
                        $id = $element_value;
                }
                echo '<div class="col-1"><a href="'.$table_name.'/'.$id.'/edit"><i class="far fa-edit"></i></a></div>';
                echo '<div class="col-1"><a href="'.$table_name.'/'.$id.'/view"><i class="far fa-eye"></i></a></div>';
                echo '<div class="col-1" id="delete_table-'.$id.'" data-id="'.$id.'"><a href="'.$table_name.'/'.$id.'/delete"><i class="far fa-trash-alt"></i></a></div>';
                echo '</div>';
            }
        }else{
            echo '<h1>В таблице нет записей!</h1><br>
                  <h2>Начните заполнять таблицу <a class="btn btn-outline-info" href="'.$table_name.'/create">Добавить запись</a></h2>';
        }
    @endphp
    <div class="row button-navigation">
        <a class="btn btn-secondary" href="/admin/tables/">Назад</a>
    </div>

    <!-- Delete Warning Modal -->
    <div class="modal fade" id="deleteWarningModal" tabindex="-1" aria-labelledby="deleteWarningModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteWarningModalLabel">Удаление записи</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Вы действительно хотите удалить эту запись?</p>
                    <div class="container">
                        <div class="row">
                            <div class="col-12" id="delete_preview">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="delete_agree">Удалить</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>
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

@section('adminlte_js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var delete_link, delete_preview, id;

        $( 'div[id^=delete_table]' ).click(function(e) {
            e.preventDefault();
            id = $(this).attr('data-id');
            delete_preview = $( '#preview-' + id ).text();
            //console.log(delete_preview);
            //$( '#delete_preview' ).html(delete_preview);
            //$( '#deleteWarningModal' ).modal('show');
            delete_link = $(this).children().prop('href');
            Swal.fire({
                title: 'Вы уверены?',
                icon: 'warning',
                html: 'Удалить запись: ' + delete_preview + '?',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Удалить',
                cancelButtonText: 'Отмена',
                showLoaderOnConfirm: true,
                preConfirm: (login) => {
                    $.ajax({
                        url: delete_link,
                        success: function (data,status,xhr) {   // success callback function
                            $( '#deleteWarningModal' ).modal('hide');
                            $( '#' + id ).remove();
                        },
                        error: function (jqXhr, textStatus, errorMessage) { // error callback
                            console.log('error');
                        }
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Удалено!',
                        'Запись была успешно удалена.',
                        'success'
                    )
                }
            })
        });
/*
        $( '#delete_agree' ).on('click', function () {
           $.ajax({
                url: delete_link,
                success: function (data,status,xhr) {   // success callback function
                    $( '#deleteWarningModal' ).modal('hide');
                    $( '#' + id ).remove();
                },
                error: function (jqXhr, textStatus, errorMessage) { // error callback
                    console.log('error');
                }
           });
        });*/
    </script>
@stop
