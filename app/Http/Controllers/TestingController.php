<?php

namespace App\Http\Controllers;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function get_all_test_list()
    {
        $table = DB::table('testing_question')->select('id', 'title')->get();
        return view('administrative.testing.test-list', ['test_name' => $table]);
    }

    public function single_test($test_id)
    {
        $user_id = Auth::user()->id;
        $today_test_count = DB::table('testing_answers')->select()->where('user_id', $user_id)->where('answer_date', date('Y-m-d'))->count();

        if ($today_test_count == 0) {
            $table = DB::table('testing_question')->select()->where('id', $test_id)->get();
            return view('administrative.testing.single-test', ['test_el' => $table]);
        }else {
            $table = DB::table('testing_question')->select('title')->where('id', $test_id)->get();
            return view('administrative.testing.single-test-success', ['test_el' => $table]);
        }
    }

    public function single_test_success($test_id)
    {
        $table = DB::table('testing_question')->select()->where('id', $test_id)->get();
        return view('administrative.testing.single-test-success', ['test_el' => $table]);
    }

    public function single_test_store(Request $request, $test_id)
    {
        $data = $request->all();
        $query = [];
        $date = date('Y-m-d');
        $user_id = Auth::user()->id;

        unset($data['submit']);
        unset($data['_token']);

        $sum = 0;
        foreach ($data as $item) {
            $sum += $item;
        }
        $query['user_id'] = $user_id;
        $query['answer_date'] = $date;
        $query['result'] = $sum;

        DB::table('testing_answers')->insertGetId($query);
        return redirect()->route('current_test', ['test_id' => $test_id]);
    }

    public function get_all_test_list_graphic()
    {
        $table = DB::table('testing_question')->select('id', 'title')->get();
        return view('administrative.testing.graphic-list', ['test_name' => $table]);
    }

    public function single_graphic($graphic_id)
    {
        $user_id = Auth::user()->id;
        $graphic_data = [];

        $available_user_id = DB::table('testing_answers')->select('user_id')->groupBy('user_id')->get(); // Пользователи, которые прошли хотя бы один тест
        $table = DB::table('testing_question')->select('id', 'title')->where('id', $graphic_id)->get();

        foreach ($available_user_id as $value){
            //$value->user_id - Пользователи, прошедшие тест
            // Получаем результаты теста для каждого пользователя
            $stack = DB::table('testing_answers')->select()->where('user_id', $value->user_id)->get();
            array_push($graphic_data, $stack);
        }
        //echo '<pre>';
        //print_r($graphic_data);

        return view('administrative.testing.single-graphic', ['graphic_data' => $graphic_data, 'graphic_name' => $table]);
    }
}
