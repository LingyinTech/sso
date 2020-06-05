<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeveloperController extends Controller
{
    public function index(Request $request)
    {
        $code = $request->session()->get('code');

        $list = DB::table('developer')
            ->where('code', $code)
            ->orderByDesc('id')
            ->simplePaginate(20);

        if ($request->ajax()) {
            return response()->json([
                'list' => $list
            ]);
        }

        return view('developer.index', [
            'list' => $list,
        ]);
    }

    public function store(Request $request)
    {
        exit(0);
        $result = DB::table('developer')->insert([
            'code' => $request->session()->get('code'),
            'api_token' => uniqid(),
            'white_list' => $request->get('white_list', ''),
        ]);

        return response()->json([
            'code' => $result ? 0 : 1,
            'msg' => $result ? 'success' : 'fail',
        ]);
    }

    public function update(Request $request, $id)
    {
        $check = DB::table('developer')->where([
            'id' => $id,
            'code' => $request->session()->get('code'),
        ])->exists();

        if (!$check) {
            return response()->json([
                'code' => 1,
                'msg' => '记录不存在',
            ]);
        }

        $result = DB::table('developer')
            ->where([
                'id' => $id,
                'code' => $request->session()->get('code'),
            ])
            ->update([
                'white_list' => $request->get('white_list'),
            ]);

        return response()->json([
            'code' => $result ? 0 : 1,
            'msg' => $result ? 'success' : 'fail',
        ]);

    }
}
