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

    public function regresi()
    {
        $request = DB::table('regresi')->orderByDesc('id')->get();
        $totalX = 0;
        $totalY = 0;
        $totalX_Pangkat_Dua = 0;
        $totalX_Kali_Y = 0;
        $jumlahData = count($request);
        foreach ($request as $key => $item) {
            $item->x_pangkat_dua = $item->x * $item->x;
            $item->x_kali_y = $item->x * $item->y;

            $totalX += $item->x;
            $totalY += $item->y;
            $totalX_Pangkat_Dua += $item->x_pangkat_dua;
            $totalX_Kali_Y += $item->x_kali_y;
        }

        $data_a = new \stdClass();
        $data_a->a1 = $totalY * $totalX_Pangkat_Dua;
        $data_a->a2 = $totalX * $totalX_Kali_Y;
        $data_a->a3 = $data_a->a1 - $data_a->a2;

        $data_a->a4 = $jumlahData * $totalX_Pangkat_Dua;
        $data_a->a5 = $totalX * $totalX;
        $data_a->a6 = $data_a->a4 - $data_a->a5;

        $data_a->a_total = $data_a->a3 / $data_a->a6;

        $data_b = new \stdClass();
        $data_b->b1 = $jumlahData * $totalX_Kali_Y;
        $data_b->b2 = $totalX * $totalY;
        $data_b->b3 = $data_b->b1 - $data_b->b2;

        $data_b->b4 = $jumlahData * $totalX_Pangkat_Dua;
        $data_b->b5 = $totalX * $totalX;
        $data_b->b6 = $data_b->b4 - $data_b->b5;

        $data_b->b_total = $data_b->b3 / $data_b->b6;

        $penaksiran = new \stdClass();
        $penaksiran->x1 = mt_rand(1, 100);
        $penaksiran->x2 = mt_rand(1, 100);
        $penaksiran->x3 = mt_rand(1, 100);
        $penaksiran->x4 = mt_rand(1, 100);
        $penaksiran->x5 = mt_rand(1, 100);
        $penaksiran->x6 = mt_rand(1, 100);
        $penaksiran->x7 = mt_rand(1, 100);

        $penaksiran->y1 = $data_a->a_total + ($penaksiran->x1 * $data_b->b_total);
        $penaksiran->y2 = $data_a->a_total + ($penaksiran->x2 * $data_b->b_total);
        $penaksiran->y3 = $data_a->a_total + ($penaksiran->x3 * $data_b->b_total);
        $penaksiran->y4 = $data_a->a_total + ($penaksiran->x4 * $data_b->b_total);
        $penaksiran->y5 = $data_a->a_total + ($penaksiran->x5 * $data_b->b_total);
        $penaksiran->y6 = $data_a->a_total + ($penaksiran->x6 * $data_b->b_total);
        $penaksiran->y7 = $data_a->a_total + ($penaksiran->x7 * $data_b->b_total);

        return view(
            'regresi',
            [
                'request' => $request,
                'totalX' => $totalX,
                'totalY' => $totalY,
                'totalX_Pangkat_Dua' => $totalX_Pangkat_Dua,
                'totalX_Kali_Y' => $totalX_Kali_Y,
                'jumlahData' => $jumlahData,
                'data_a' => $data_a,
                'data_b' => $data_b,
                'penaksiran' => $penaksiran
            ]
        );
    }

    public function addRequest(Request $request)
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

    public function addRegresi(Request $request)
    {
        DB::table('regresi')->insert(
            [
                'x' => $request->x,
                'y' => $request->y,
            ]
        );
        return redirect()->back()->with('success', ['your message here !']);
    }
}
