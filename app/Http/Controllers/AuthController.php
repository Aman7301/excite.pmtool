<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeModel;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function createUser(Request $req)
    {
        $emp = $req->all();
        if ($emp['user_type'] == 2) {
            $emp['profile_photo'] = $req->profile_photo->store('profile_photo');
        }
        $emp['password'] = Hash::make($req->password);
        $data = EmployeeModel::create($emp);
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