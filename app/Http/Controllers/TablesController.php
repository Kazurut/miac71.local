<?php

namespace App\Http\Controllers;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TablesController extends Controller
{
    /**
     * Проверяем разрешено ли пользователю просматривать и редактировать таблицу
     * в зависимости от его уровня доступа
     * входные данные - название таблицы ($table_name)
     */
    public function allowedTables($table_name)
    {
        $userAccessLevel = Auth::user()->access_level; // Уровень доступа пользователя

        // Пользователи с 1 уровенем доступа могут просматривать и редактировать любые таблицы, кроме системных
        // Получаем список таблиц доступных пользователю
        $allowedTables = DB::table('access_level_table')->select($userAccessLevel)->where('id', '1')->value($userAccessLevel);
        $allowedTables = explode(',', $allowedTables);

        // Если текущая таблица есть в списке, то разрешаем доступ, иначе выводим ошибку доступа
        foreach ($allowedTables as $value){
            if(trim($value) == $table_name)
                return 1;
        }

        return 0; // возвращаем ошибку доступа
    }

    public function allowedTablesList(){
        $userAccessLevel = Auth::user()->access_level; // Уровень доступа пользователя

        // Пользователи с 1 уровенем доступа могут просматривать и редактировать любые таблицы, кроме системных
        // Получаем список таблиц доступных пользователю
        $allowedTables = DB::table('access_level_table')->select($userAccessLevel)->where('id', '1')->value($userAccessLevel);
        $allowedTables = explode(',', $allowedTables);

        return $allowedTables;
    }

    public function table_list()
    {
        //$userAccessLevel = Auth::user()->access_level; // Уровень доступа пользователя
        //$this->allowedTablesList();

        return view('admin.tables-list', ['tables_list' => $this->allowedTablesList()]);
    }

    public function single_table($table_name)
    {
        if($this->allowedTables($table_name)){
            $table = DB::table($table_name)->select('id', 'preview', 'created_at', 'updated_at')->get();
            return view('administrative.table-single', ['table_name' => $table_name, 'table' => $table]);
        }else {
            return view('administrative.table-single-error', ['table_name' => $table_name]);
        }
    }

    public function  single_table_create($table_name)
    {
        $table_info = [];
        $table = DB::table($table_name)->get();
        $table_column = DB::getSchemaBuilder()->getColumnListing($table_name);
        foreach ($table_column as $key=>$value){
            $table_info[$key] = DB::getSchemaBuilder()->getColumnType($table_name, $table_column[$key]);
        }
        return view('administrative.table-single-add', ['table_name' => $table_name, 'table_column' => $table_column, 'table_info' => $table_info]);
    }

    public  function single_table_store(Request $request, $table_name){
        $data = $request->all();
        $query = $data;
        unset($query['_token']);

        if(isset($data['submit']) && $query['submit'] == 'update'){
            if(isset($query['updated_at']) || $query['updated_at'] == '')
                $query['updated_at'] = date('m.d.Y');
            if(isset($query['id'])) {
                $id = $query['id'];
                unset($query['id']);
            }
            unset($query['submit']);

            $id = DB::table($table_name)->where('id', $id)->update($query);
        }elseif(isset($query['submit']) && $query['submit'] == 'create'){
            if(isset($query['created_at']))
                $query['created_at'] = date('m.d.Y');
            if(isset($query['updated_at']))
                $query['updated_at'] = date('m.d.Y');
            unset($query['submit']);
            $id = DB::table($table_name)->insertGetId($query);
        }

        return redirect('/admin/tables/'.$table_name.'/');
        //return $query;
    }

    public function single_table_edit($table_name, $id)
    {
        $table = DB::table($table_name)->where('id', $id)->get();
        $table_column = DB::getSchemaBuilder()->getColumnListing($table_name);
        return view('administrative.table-single-edit', ['table_name' => $table_name, 'id' => $id, 'table' => $table]);
    }

    public function single_table_view($table_name, $id)
    {
        $table = DB::table($table_name)->where('id', $id)->get();
        $table_column = DB::getSchemaBuilder()->getColumnListing($table_name);
        return view('administrative.table-single-view', ['table_name' => $table_name, 'id' => $id, 'table' => $table]);
    }

    public function single_table_delete($table_name, $id)
    {
        DB::table($table_name)->where('id', $id)->delete();
        return redirect('/admin/tables/'.$table_name.'/');
    }
}
