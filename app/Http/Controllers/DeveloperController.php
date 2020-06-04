<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeveloperController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            return response()->json();
        }

        $code = '101e0014413aed2114daddb6368b3d83';
        $list = DB::table('developer')
            ->where('code', $code)
            ->orderByDesc('id')
            ->paginate(5);

        return view('developer.index',[
            'list' => $list,
        ]);
    }


}
