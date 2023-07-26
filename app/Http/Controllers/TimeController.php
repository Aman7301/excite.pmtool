<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeSheetModel;
use App\Models\HolidayModel;
use App\Models\ProjectModel;
use App\Models\TaskModel;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TimeController extends Controller
{
    public function AddTime(Request $req)
    {
        $today = Carbon::today()->subDays(10)->format('d/m/Y');

        $validator = Validator::make($req->all(), [
            'time.*.date' => 'required|date_format:d/m/Y|after_or_equal:' . $today,
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
                'project_id' => $t['project_id'],
                'project_name' => $t['project_name'],
                'task_id' => $t['task_id'],
                'task' => $t['task'],
                'task_description' => $t['task_description'],
                'time' => $t['time'],
                'total' => $total
            ];
            // $data['total'] += $t['time'] ;

            $insert = TimeSheetModel::insert($data);
        }

        $response = ($insert) ? ['status' => 200, 'Message' => 'Time added Successfully'] :
            ['status' => 201, 'Message' => 'Time  detail Not added'];
        return response()->json($response, 200);

    }

    public function GetTimeHistory($id, Request $req)
    {

        $timeQuery = TimeSheetModel::where('emp_id', $id)->whereMonth('created_at', $req->month)->whereYear('created_at', $req->year);
        $time = $timeQuery->paginate(5);
        $m = 0;
        $y = 0;
        //Month
        $month = TimeSheetModel::where('emp_id', $id)->whereYear("created_at", $req->year)->whereMonth("created_at",  $req->month)->pluck('time');
        $m = $month->sum();
        //Year
        $year = TimeSheetModel::where('emp_id', $id)->whereYear("created_at", $req->year)->pluck('time');
        $Y = $year->sum();
        //Week
        $currentWeek = date('W');
        $weekData = TimeSheetModel::whereYear("created_at", $req->year)->whereMonth("created_at",  $req->month)->where('emp_id', $id)->whereRaw("WEEK(created_at) = ?", [$currentWeek])->pluck('time');
        $week = $weekData->sum();

        //Extra Support
        $i = 0;
        $data = 0;
        $years = TimeSheetModel::where('emp_id', $id)->whereYear("created_at",$req->year)->where("total", ">", 8)->get();
        // return $years;
        foreach ($years as $y) {
            $total[$i] = $y['total'] - 8;
            $data += $total[$i];
            $i++;
        }
       
        $response = ($time) ? [
            'status' => 200,
            'Message' => 'Time By Employee',
            'Year' => $Y,
            'month' => $m,
            'week' => $week,
            'Support_per_year' => $data,
            'data' => $time
        ] :
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
        $Pune = HolidayModel::where(['year' => $req->year, 'location_id' => 1])->get();
        $USA = HolidayModel::where(['year' => $req->year, 'location_id' => 2])->get();

        $response = ($Pune) ? ['status' => 200, 'Message' => 'All Holiday Data', "data" => [
            "Pune" => $Pune,
            "USA" => $USA
        ]   ] :
            ['status' => 404, 'Message' => 'Data Not Found'];
        return response()->json($response, 200);
    }

    public function GetTimeByEmp($id)
    {
        $time = TimeSheetModel::where('emp_id', $id)->get();
        $currentWeek = date('W');
        $weekData = TimeSheetModel::where('emp_id', $id)->whereRaw("WEEK(created_at) = ?", [$currentWeek])->get();
        $week = $weekData->sum('time');
        $response = ($time) ? ['status' => 200, 'Message' => 'Time By Employee', "Hours_of_Week" => $week, "data" => $time] :
            ['status' => 404, 'Message' => 'Data Not Found'];
        return response()->json($response, 200);
    }

    public function updateTime(Request $req)
    {
        $upd = TimeSheetModel::find($req->id);
        if ($upd['time'] != '') {
            // $req->time;
            $total = 0;
            $upd->update($req->all());
            $records = TimeSheetModel::where("date", $upd['date'])->where("emp_id", $upd['emp_id'])
                ->get();
            foreach ($records as $record) {

                $total += $record->time;
                $record->total = $total;
                $record->save();
            }
            // $full = $total;

        } else {

            $upd->update($req->all());
        }

        $response = ($upd) ? ['status' => 200, 'Message' => 'Time update Successfully'] :
            ['status' => 204, 'Message' => 'Time Not Updated'];
        return response()->json($response, 200);
    }

    public function AddProject(Request $req)
    {
        $project = $req->all();
        $add = ProjectModel::create($project);
        $response = ($add) ? ['status' => 200, 'Message' => 'Project Add Successfully'] :
            ['status' => 201, 'Message' => 'Project Not Added'];
        return response()->json($response, 200);
    }

    public function GetProject()
    {
        $project = ProjectModel::all();
        $response = ($project) ? ['status' => 200, 'Message' => 'All Project', 'project' => $project] :
            ['status' => 404, 'Message' => 'Data NOt Found'];
        return response()->json($response, 200);
    }

    public function UpdateProject(Request $req)
    {
        $project = ProjectModel::find($req->id);
        $upd = $project->update($req->all());
        $response = ($upd) ? ['status' => 200, 'Message' => 'Project Update Successfully'] :
            ['status' => 204, 'Message' => 'Project Not Updated'];
        return response()->json($response, 200);
    }

    public function DeleteProject($id)
    {
        $del = ProjectModel::where("id", $id)->delete();
        $response = ($del) ? ['status' => 200, 'Message' => 'Project deleted Successfully'] :
            ['status' => 204, 'Message' => 'Project Not deleted'];
        return response()->json($response, 200);
    }

    public function AddTask(Request $req)
    {
        $Task = $req->all();
        $add = TaskModel::create($Task);
        $response = ($add) ? ['status' => 200, 'Message' => 'Task Add Successfully'] :
            ['status' => 201, 'Message' => 'Task Not Added'];
        return response()->json($response, 200);
    }

    public function GetTask()
    {
        $Task = TaskModel::all();
        $response = ($Task) ? ['status' => 200, 'Message' => 'All Task', 'Task' => $Task] :
            ['status' => 404, 'Message' => 'Data NOt Found'];
        return response()->json($response, 200);
    }

    public function UpdateTask(Request $req)
    {
        $Task = TaskModel::find($req->id);
        $upd = $Task->update($req->all());
        $response = ($upd) ? ['status' => 200, 'Message' => 'Task Update Successfully'] :
            ['status' => 204, 'Message' => 'Task Not Updated'];
        return response()->json($response, 200);
    }

    public function DeleteTask($id)
    {
        $del = TaskModel::where("id", $id)->delete();
        $response = ($del) ? ['status' => 200, 'Message' => 'Task deleted Successfully'] :
            ['status' => 204, 'Message' => 'Task Not deleted'];
        return response()->json($response, 200);
    }
}