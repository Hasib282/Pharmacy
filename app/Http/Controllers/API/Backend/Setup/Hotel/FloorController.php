<?php

namespace App\Http\Controllers\API\Backend\Setup\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Floor;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    public function Show(Request $req){
        $data = Floor::on('mysql_second')->get();

        return response()->json([
            'status'=>true,
            'data'=>$data
        ],200);
    }

}
