<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function index()
    {
        $request = DB::table('request')->orderByDesc('days_to')->paginate(10);
        $group = DB::table('request')->select(DB::raw('count(*) as count, qty'))->groupBy('qty')->get();
        $totalFreq = 0;
        foreach ($group as $value) {
            $totalFreq += $value->count;
        }
        return view(
            'app',
            [
                'request' => $request,
                'group' => $group,
                'totalFreq' => $totalFreq
            ]
        );
    }

    public function add(Request $request)
    {
        $lastDay = DB::table('request')->latest('days_to')->first();
        DB::table('request')->insert(
            [
                'days_to' => $lastDay->days_to + 1,
                'qty' => $request->qty,
            ]
        );
        return redirect()->back()->with('success', ['your message here !']);
    }
}
