<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveModel;
use App\Models\LeaveTypeModel;
use App\Models\EmployeeModel;
use App\Events\NewYearStarted;
use DateTime;

class LeaveController extends Controller
{
    public function AddLeave(Request $req)
    {
        $leave = $req->all();
        $data = LeaveModel::create($leave);
        $response = ($data) ? ['status' => 200, 'Message' => 'Leave Add Successfully'] :
            ['status' => 201, 'Message' => 'Leave Not  Add '];
        return response()->json($response, 200);
    }

    public function GetLeaveType(Request $req)
    {
        if ($req->end_date) {
            $type = LeaveTypeModel::where("leave_status", 2)->get();
        } else {
            $type = LeaveTypeModel::where("leave_status", 1)->get();
        }
        return response()->json($type, 200);
    }

    public function GetLeaveByEmp($id)
    {
        $leave = LeaveModel::where('emp_id', $id)->get();
        $data = array();
        $i = 0;
        foreach($leave as $l){
            $data[$i] = $l;
            $emp = EmployeeModel::where("id",$l['emp_id'])->first();
            $data[$i]['Total_Leave']  =  $emp['emp_total_leave'];
            $data[$i]['Leave_balance']  =  $emp['emp_leave'];
            $data[$i]['Leave_Taken']  =  $emp['emp_total_leave'] - $emp['emp_leave'];
            $i++;
        }
        $response = ($leave) ? ['status' => 200, 'Message' => 'Leave By Emp', 'data' => $leave] :
            ['status' => 404, 'Message' => 'Leave Not Found By this Id'];
        return response()->json($response, 200);
    }

    public function deleteLeave($id)
    {
        $leave = LeaveModel::where('id', $id)->delete();
        $response = ($leave) ? ['status' => 200, 'Message' => 'Employee Leave deleted'] :
            ['status' => 204, 'Message' => 'Leave Not Deleted'];
        return response()->json($response, 200);
    }

    public function updateLeave(Request $req)
    {
        $upd = LeaveModel::find($req->id);
        $data = $upd->update($req->all());
        if ($upd->status == "Approved") {
            if ($upd['end_date'] == '') {
                $employee = EmployeeModel::where("id", $upd->emp_id)->first();
                if ($employee) {
                    $employee->update([
                        'emp_leave' => $employee->emp_leave - 1
                    ]);
                }
            } else {
                $employee = EmployeeModel::where("id", $upd->emp_id)->first();
                $start_date = DateTime::createFromFormat('d/m/Y', $upd['start_date']);
                $end_date = DateTime::createFromFormat('d/m/Y', $upd['end_date']);

                $interval = $end_date->diff($start_date);
                $sub = $interval->days;
               $employee->update([
                'emp_leave' => $employee->emp_leave - $sub
               ]);
            }
        }
        $response = ($data) ? ['status' => 200, 'Mesaage' => 'Leave updated Successfully'] :
            ['status' => 204, 'Message' => 'Leave Not Updated'];
        return response()->json($response, 200);
    }

}