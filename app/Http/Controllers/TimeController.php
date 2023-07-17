<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeModel;
use App\Models\HolidayModel;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TimeController extends Controller
{
    public function AddTime(Request $req)
    {
        $today =Carbon::today()->subDays(10)->format('d/m/Y');

        $validator = Validator::make($req->all(), [
            'time.*.date' => 'required|date_format:d/m/Y|after_or_equal:' . $today,
        ]);
    //   echo date("d/m/Y");
    //   die;
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $time = $req->input('time');
        $data = array();
        $total = 0;
        foreach ($time as $t) {
            $total += $t['time'];
            $data = [
                'emp_id' => $t['emp_id'],
                'date' => $t['date'],
                'project_name' => $t['project_name'],
                'project_description' => $t['project_description'],
                'time' => $t['time'],
                'total' => $total
            ];
            // $data['total'] += $t['time'] ;

            $insert = TimeModel::insert($data);
        }

        $response = ($insert) ? ['status' => 200, 'Message' => 'Time added Successfully'] :
            ['status' => 201, 'Message' => 'Time  detail Not added'];
        return response()->json($response, 200);

    }

    public function GetTimeHistory($id, Request $req)
    {

        $timeQuery  = TimeModel::where('emp_id', $id)->whereMonth('created_at', $req->month);
        $time = $timeQuery->paginate(5);
        $m = 0;
        $y = 0;
        //Month
        $month = TimeModel::where('emp_id', $id)->whereMonth("created_at", date('m'))->pluck('time');
        $m = $month->sum();
        //Year
        $year = TimeModel::where('emp_id', $id)->whereYear("created_at", date('Y'))->pluck('time');
        $y = $year->sum();
        //Week
        $currentWeek = date('W');
        $weekData = TimeModel::whereRaw("WEEK(created_at) = ?", [$currentWeek])->get();
        $week = $weekData->sum('time');
        $response = ($time) ? ['status' => 200, 'Message' => 'Time By Employee', 'data' => $time, 'month' => $m, 'Year' => $y, 'week' => $week] :
            ['status' => 404, 'Message' => 'Data Not Found'];
        return response()->json($response, 200);
    }

    public function AddHoliday(Request $req)
    {
        $holiday = $req->all();
        $data = HolidayModel::create($holiday);
        $response = ($data) ? ['status' => 200, 'Message' => 'Add Holiday Time'] :
            ['status' => 201, 'Message' => 'New Holiday Not Added'];
        return response()->json($response, 200);
    }

    public function getHoliday(Request $req)
    {
          $holiday = HolidayModel::where('year',$req->year)->get();
          $response = ($holiday) ? ['status' => 200, 'Message' => 'All Holiday Data', "data" => $holiday] :
          ['status' => 404, 'Message' => 'Data Not Found'];
      return response()->json($response, 200);
    }

    public function GetTimeByEmp($id)
    {
       $time = TimeModel::where('emp_id',$id)->get();
       $currentWeek = date('W');
        $weekData = TimeModel::where('emp_id',$id)->whereRaw("WEEK(created_at) = ?", [$currentWeek])->get();
        $week = $weekData->sum('time');
       $response = ($time) ? ['status' => 200, 'Message' => 'Time By Employee',"Hours_of_Week" => $week ,"data" => $time] :
       ['status' => 404, 'Message' => 'Data Not Found'];
   return response()->json($response, 200);
    }

    public function updateTime(Request $req)
    {
        $upd = TimeModel::find($req->id);
        if ($upd['time'] != '') {
            // $req->time;
            $total = 0;
            $upd->update($req->all());
            $records = TimeModel::where("date", $upd['date'])->where("emp_id",$upd['emp_id'])
            ->get();
        foreach ($records as $record) {
            
            $total += $record->time;
            $record->total = $total;
            $record->save();
        }
        // $full = $total;

    }else{

        $upd->update($req->all());
    }
            
        $response = ($upd) ? ['status' => 200, 'Message' => 'Time update Successfully'] :
       ['status' => 204, 'Message' => 'Time Not Updated'];
   return response()->json($response, 200);
    }
}