<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeModel;
use App\Models\TotalLeaveModel;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function createUser(Request $req)
    {
        $emp = $req->all();
        if ($emp['user_type'] == 2) {
            $req->validate([
                "number" => 'unique:employee',
                "emergency_number" => 'unique:employee',
                "Account_number" => 'unique:employee',
                "employee_id" => 'unique:employee',
                "official_email_id" => 'unique:employee',
            ]);
            $emp['profile_photo'] = $req->profile_photo->store('profile_photo');
            //   $emp['emp_leave'] = 
        }
        $emp['password'] = Hash::make($req->password);

        $data = EmployeeModel::create($emp);
        $employee = EmployeeModel::where("id", $data['id'])->get();

        foreach ($employee as $empl) {
            $total = TotalLeaveModel::where("id", $empl['total_leave_id'])->first();
            $leave = $total['total']; // Total  Num
            $val = $leave / 12; // For Month Holiday
            $mon = 13 - date('m'); //  date for multiplication
            $mul = $val * $mon; // Total holiday by month
        }
        EmployeeModel::where("id", $data['id'])->update([
            "emp_leave" => $mul,
            "emp_total_leave" => $mul
        ]);

        if ($data) {
            $response = ['status' => 200, 'Message' => 'Data Successfully Added'];
        } else {
            $response = ['status' => 201, 'Message' => 'Data Not Registered'];
        }
        return response()->json($response, 200);
    }

    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'user_type' => 'required'
        ]);

        if ($request->user_type == 2) {

            $user = EmployeeModel::where('official_email_id', $request->email)->first();
            if ($user) {

                if (Hash::check($request->password, $user['password'])) {

                    $token = $user->createToken('auth_token')->plainTextToken;
                    return response()->json([
                        'status' => 200,
                        'Message' => 'Successfully Login',
                        'access_token' => $token,
                        'token_type' => 'Bearer',
                    ]);
                } else {
                    $response = ['status' => 202, 'Message' => 'Invalid password'];
                }
            } else {
                $response = ['status' => 204, 'Message' => 'Invalid Email'];
            }
        } elseif ($request->user_type == 1) {

            $user = EmployeeModel::where('email_id', $request->email)->first();
            if ($user) {

                if (Hash::check($request->password, $user['password'])) {

                    $token = $user->createToken('auth_token')->plainTextToken;
                    return response()->json([
                        'status' => 200,
                        'Message' => 'Successfully Login',
                        'access_token' => $token,
                        'token_type' => 'Bearer',
                    ]);
                } else {
                    $response = ['status' => 202, 'Message' => 'Invalid password'];
                }
            } else {
                $response = ['status' => 204, 'Message' => 'Invalid Email'];
            }
        }
        return response()->json($response, 200);
    }
}