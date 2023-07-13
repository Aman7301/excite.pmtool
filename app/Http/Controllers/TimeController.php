<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeModel;
use App\Models\HolidayModel;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TimeController extends Controller
{
    public function AddTime(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'time.*.date' => 'required|date|after_or_equal:' . Carbon::today()->subDays(10)->format('d/m/Y'),
        ]);

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

    public function GetTime($id, Request $req)
    {

        $time = TimeModel::where('emp_id', $id)->whereMonth('created_at', $req->month)->get();
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
}