<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveModel;
use App\Models\LeaveTypeModel;

class LeaveController extends Controller
{
    public function AddLeave(Request $req)
    {
        $leave  = $req->all();
        $data = LeaveModel::create($leave);
        $response = ($data) ? ['status' => 200, 'Message' => 'Leave Add Successfully'] :
        ['status' => 201, 'Message' => 'Leave Not  Add '];
        return response()->json($response, 200);
    }

    public function GetLeaveType(Request $req)
    {
        if($req->end_date){
        $type = LeaveTypeModel::where("leave_status",2)->get();
        }else{
            $type = LeaveTypeModel::where("leave_status",1)->get();
        }
        return response()->json($type, 200);
    }

    public function GetLeaveByEmp($id)
    {
        $leave = LeaveModel::where('emp_id',$id)->get();
        $response = ($leave) ? ['status' => 200, 'Message' => 'Leave By Emp', 'data' => $leave] :
        ['status' => 404, 'Message' => 'Leave Not Found By this Id'];
        return response()->json($response, 200);
    }

    public function deleteLeave($id)
    {
        $leave = LeaveModel::where('id',$id)->delete();
        $response = ($leave) ? ['status' => 200, 'Message' => 'Employee Leave deleted'] :
        ['status' => 204, 'Message' => 'Leave Not Deleted'];
        return response()->json($response, 200);
    }
}
 