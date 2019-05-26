<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction\Response;
use Auth;
class ResponseController extends Controller
{
    public function postResponse(Request $request){
        $response = Response::where('review_id',$request->review_id)->first();
        if(empty($response))$response = new Response;
        $response->review_id = $request->review_id;
        $response->admin_id = Auth::guard('admin')->id();
        $response->content = $request->response;
        $response->save();
    }
}
