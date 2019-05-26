<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction\Transaction;
use DB;
class ReportController extends Controller
{
    public function getReportMonthly(){
        return Transaction::select(DB::raw('sum(sub_total) as total, MONTH(created_at) as month,status'))->groupBy(DB::raw('MONTH(created_at),STATUS'))
        ->whereRaw('YEAR(created_at) = YEAR(NOW())')
        ->get();
    }
}
