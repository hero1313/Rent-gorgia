<?php

namespace App\Http\Controllers;

use App\Models\Banner_record;
use App\Models\Branch;
use App\Models\Outdoor_banner_record;


use App\Models\Enrollment;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function partyIndex(Request $request)
    {
        $payments = Enrollment::where('index', 3);

        if($request->filter_years){
            $payments = $payments->where('years',$request->filter_years);
        }
        if($request->filter_month){
            $payments = $payments->where('month',$request->filter_month);
        }
        if($request->filter_status){
            $payments = $payments->where('status',$request->filter_status);
        }
        if($request->filter_tenant){
            $payments = $payments->where('tenant', 'LIKE', "%$request->filter_tenant%");
        }
        $payments = $payments->orderBy('created_at', 'DESC')->get();
        $total = $payments->sum('transfer');

        // dd($search);

        return view('main.components.party-report', compact(['payments','total']));
    }

    public function ownIndex(Request $request)
    {
        $payments = Enrollment::where('index', 1);

        if($request->filter_years){
            $payments = $payments->where('years',$request->filter_years);
        }
        if($request->filter_month){
            $payments = $payments->where('month',$request->filter_month);
        }
        if($request->filter_status){
            $payments = $payments->where('status',$request->filter_status);
        }
        if($request->filter_tenant){
            $payments = $payments->where('tenant', 'LIKE', "%$request->filter_tenant%");
        }
        $payments = $payments->orderBy('created_at', 'DESC')->get();
        $total = $payments->sum('transfer');

        return view('main.components.own-report', compact(['payments','total']));
    }

    public function outdoorIndex(Request $request)
    {
        $payments = Enrollment::where('index', 2);

        if($request->filter_years){
            $payments = $payments->where('years',$request->filter_years);
        }
        if($request->filter_month){
            $payments = $payments->where('month',$request->filter_month);
        }
        if($request->filter_tenant){
            $payments = $payments->where('tenant', 'LIKE', "%$request->filter_tenant%");
        }
        $payments = $payments->orderBy('created_at', 'DESC')->get();
        $total = $payments->sum('transfer');

        return view('main.components.outdoor-report', compact(['payments','total']));
    }
}
