<?php

namespace App\Http\Controllers;

use App\Models\EmployeeModel;
use App\Models\HolidayModel;
use Illuminate\Http\Request;
use App\Models\LeaveModel;
use App\Models\TimeModel;
use App\Models\LocationModel;

class DashboardController extends Controller
{
    public function GetDasboardData(Request $req, $id)
    {
        $approved = LeaveModel::where("emp_id", $id)->where('status', 'Approved')->get();
        $i = 0;
        $j = 0;
        $k = 0;
        $Approved_data = array();
        $Pending_data = array();
        $Rejected_data = array();
        foreach ($approved as $app) {
            $Approved_data[$i] = $app['start_date'];
            if ($app['end_date'] != null) {
                $Approved_data[$i] = $app['start_date'] . ' to ' . $app['end_date'];
            }
            $i++;
        }
        $pending = LeaveModel::where("status", "Pending")->where("emp_id", $id)->get();
        foreach ($pending as $pen) {
            $Pending_data[$j] = $pen['start_date'];
            if ($pen['end_date'] != null) {
                $Pending_data[$j] = $pen['start_date'] . ' to ' . $pen['end_date'];
            }
            $j++;
        }
        $Reject = LeaveModel::where("status", "Rejected")->where("emp_id", $id)->get();
        foreach ($Reject as $rej) {
            $Rejected_data[$k] = $rej['start_date'];
            if ($rej['end_date'] != null) {
                $Rejected_data[$k] = $rej['start_date'] . ' to ' . $rej['end_date'];
            }
            $k++;
        }
        $emp = EmployeeModel::first();
        $Holiday = HolidayModel::where("location", $emp['location'])->pluck('date')->toArray();
        // echo $Holiday;
        return response()->json([
            'status' => 200,
            'Message' => 'Dashboard Data By Id',
            'Approved_date' => $Approved_data,
            'pending' => $Pending_data,
            'Reject_date' => $Rejected_data,
            "Holiday" => $Holiday,
        ]);
    }
    public function AddLocation(Request $req)
    {
        $location = $req->all();
        $data = LocationModel::create($location);
        $resposne = ($data) ? ['status' => 200, 'Message' => 'Add Location Successfully'] :
            ['status' => 201, 'Message' => 'Location Not Created'];
        return response()->json($resposne, 200);
    }

    public function GetLocation()
    {
        $location = LocationModel::all();
        $resposne = ($location) ? ['status' => 200, 'Message' => 'All Location', 'data' => $location] :
            ['status' => 404, 'Message' => 'Location Not Found'];
        return response()->json($resposne, 200);
    }

    public function GetCalenderDasboard(Request $req, $id)
    {
        $leave = LeaveModel::where('emp_id', $id)->get();
        $data = array();
        foreach ($leave as $l) {
            $emp = EmployeeModel::where("id", $l['emp_id'])->first();
            $data['Leave_balance'] = $emp['emp_leave'];
            $data['Leave_Taken'] = $emp['emp_total_leave'] - $emp['emp_leave'];
            $data['Total_Leave'] = $emp['emp_total_leave'];
        }
                // Status
        $approved = LeaveModel::where("emp_id", $id)->where("status", "Approved")->pluck('status')->count();
        $Pending = LeaveModel::where("emp_id", $id)->where("status", "Pending")->pluck('status')->count();
        //Emp Holiday
        $emp = EmployeeModel::first();
        $Holiday = HolidayModel::where("location", $emp['location'])->pluck('date')->toArray();

        //Approved Status
        $approve = LeaveModel::where("emp_id", $id)->where('status', 'Approved')->get();
        $i = 0;
        $Approved_data = array();
        foreach ($approve as $app) {
            $Approved_data[$i] = $app['start_date'];
            if ($app['end_date'] != null) {
                $Approved_data[$i] = $app['start_date'] . ' to ' . $app['end_date'];
            }
            $i++;
        }

        return response()->json([
            'status' => 200,
            'Message' => 'Dashboard Calender',
            'Leaves' => $data,
            'Leave_Status' => ["Approved" => $approved, "Pending" => $Pending],
            'Holiday' => $Holiday,
            "Leave" => $Approved_data
        ], 200);
    }
    public function GetTimeSheetDasboard(Request $req,$id)
    {
        $approved = LeaveModel::where("emp_id", $id)->where('status', 'Approved')->get();
        $i = 0;
        $j = 0;
        $k = 0;
        $Approved_data = array();
        $Pending_data = array();
        $Rejected_data = array();
        foreach ($approved as $app) {
            $Approved_data[$i] = $app['start_date'];
            if ($app['end_date'] != null) {
                $Approved_data[$i] = $app['start_date'] . ' to ' . $app['end_date'];
            }
            $i++;
        }
        $pending = LeaveModel::where("status", "Pending")->where("emp_id", $id)->get();
        foreach ($pending as $pen) {
            $Pending_data[$j] = $pen['start_date'];
            if ($pen['end_date'] != null) {
                $Pending_data[$j] = $pen['start_date'] . ' to ' . $pen['end_date'];
            }
            $j++;
        }
        $Reject = LeaveModel::where("status", "Rejected")->where("emp_id", $id)->get();
        foreach ($Reject as $rej) {
            $Rejected_data[$k] = $rej['start_date'];
            if ($rej['end_date'] != null) {
                $Rejected_data[$k] = $rej['start_date'] . ' to ' . $rej['end_date'];
            }
            $k++;
        }
        // $date = TimeModel::where("emp_id",$id)->pluck('date')->toArray();
        // $projetDesc = TimeModel::where("emp_id",$id)->pluck('project_description')->toArray();
        return response()->json([
            'status' => 200,
            'Message' => 'TimeSheet Dashboard Data By Id',
            'Approved_date' => $Approved_data,
            'pending' => $Pending_data,
            'Reject_date' => $Rejected_data,
            // 'time' => [ "date" => $date,
            // "description" =>  $projetDesc
            // ]
        ]);
    }
}