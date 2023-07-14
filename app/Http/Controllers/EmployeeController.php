<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeModel;
use App\Models\AcademyModel;
use App\Models\ProfessionalModel;
use App\Models\DocumentModel;
use App\Models\ProjectModel;
use App\Models\TimeModel;

class EmployeeController extends Controller
{
    public function UpdateEmployee(Request $req)
    {
        $upd = EmployeeModel::find($req->id);
        $upd->update($req->all());
        $response = ($upd) ? ['status' => 200, 'Mesaage' => 'Employee Successfully updated'] :
            ['status' => 204, 'Message' => 'Employee Not Updated'];
        return response()->json($response, 200);
    }

    public function CreateAcademy(Request $req)
    {
        $academy = $req->input('emp');
        $data = array();
        foreach ($academy as $acad) {
            $data = [
                'emp_id' => $acad['emp_id'],
                'degree_name' => $acad['degree_name'],
                'college' => $acad['college'],
                'stream' => $acad['stream'],
                'graduation_year' => $acad['graduation_year'],
                'CGPA' => $acad['CGPA']
            ];
            $insert = AcademyModel::insert($data);
        }
        $response = ($insert) ? ['status' => 200, 'Mesaage' => 'Employee Academy detail created Successfully'] :
            ['status' => 201, 'Message' => 'Employee Academy detail Not created'];
        return response()->json($response, 200);
    }

    public function deleteAcademy($id)
    {
        $del = AcademyModel::where('id', $id)->delete();
        $response = ($del) ? ['status' => 200, 'Mesaage' => 'Employee Academy detail deleted Successfully'] :
            ['status' => 202041, 'Message' => 'Employee Academy detail Not deleted'];
        return response()->json($response, 200);
    }

    public function updateAcademy(Request $req)
    {
        $upd = AcademyModel::find($req->id);
        $upd->update($req->all());
        $response = ($upd) ? ['status' => 200, 'Mesaage' => 'Employee Academy updated Successfully'] :
            ['status' => 204, 'Message' => 'Employee Academy Not Updated'];
        return response()->json($response, 200);
    }

    public function Createprofessional(Request $req)
    {
        $academy = $req->input('emp');
        $data = array();
        foreach ($academy as $acad) {
            $data = [
                'emp_id' => $acad['emp_id'],
                'company' => $acad['company'],
                'designation' => $acad['designation'],
                'start_date' => $acad['start_date'],
                'end_date' => $acad['end_date']
            ];
            $insert = ProfessionalModel::insert($data);
        }
        $response = ($insert) ? ['status' => 200, 'Mesaage' => 'Employee professional detail created Successfully'] :
            ['status' => 201, 'Message' => 'Employee professional  detail Not created'];
        return response()->json($response, 200);
    }

    public function deleteprofessional($id)
    {
        $del = ProfessionalModel::where('id', $id)->delete();
        $response = ($del) ? ['status' => 200, 'Mesaage' => 'Employee professional detail deleted Successfully'] :
            ['status' => 204, 'Message' => 'Employee professional detail Not deleted'];
        return response()->json($response, 200);
    }

    public function updateprofessional(Request $req)
    {
        $upd = ProfessionalModel::find($req->id);
        $upd->update($req->all());
        $response = ($upd) ? ['status' => 200, 'Mesaage' => 'Employee professional updated Successfully'] :
            ['status' => 204, 'Message' => 'Employee professional Not Updated'];
        return response()->json($response, 200);
    }

    public function CreateDocument(Request $req)
    {
        $doc = $req->all();
        $doc['file'] = $req->file->store('Adhar_Card');

        $data = DocumentModel::create($doc);
        if ($data) {
            $response = ['status' => 200, 'Message' => 'Employee Document Successfully Added'];
        } else {
            $response = ['status' => 201, 'Message' => 'Employee Document Not Registered'];
        }
        return response()->json($response, 200);
    }

    public function updateDocument(Request $req)
    {
        $upd = DocumentModel::find($req->id);
        $upd->update($req->all());
        $response = ($upd) ? ['status' => 200, 'Mesaage' => 'Employee document updated Successfully'] :
            ['status' => 204, 'Message' => 'Employee document Not Updated'];
        return response()->json($response, 200);
    }

    public function deleteDocument($id)
    {
        $del = DocumentModel::where('id', $id)->delete();
        $response = ($del) ? ['status' => 200, 'Mesaage' => 'Employee document detail deleted Successfully'] :
            ['status' => 204, 'Message' => 'Employee document detail Not deleted'];
        return response()->json($response, 200);
    }

    public function CreateProject(Request $req)
    {
        $academy = $req->input('emp');
        $data = array();
        foreach ($academy as $acad) {
            $data = [
                'emp_id' => $acad['emp_id'],
                'project_name' => $acad['project_name'],
                'role' => $acad['role'],
                'project_code' => $acad['project_code'],
                'start_date' => $acad['start_date'],
                'end_date' => $acad['end_date']
            ];
            $insert = ProjectModel::insert($data);
        }
        $response = ($insert) ? ['status' => 200, 'Mesaage' => 'Employee project detail added Successfully'] :
            ['status' => 201, 'Message' => 'Employee project  detail Not added'];
        return response()->json($response, 200);
    }

    public function updateProject(Request $req)
    {
        $upd = ProjectModel::find($req->id);
        $upd->update($req->all());
        $response = ($upd) ? ['status' => 200, 'Mesaage' => 'Employee project updated Successfully'] :
            ['status' => 204, 'Message' => 'Employee project Not Updated'];
        return response()->json($response, 200);
    }

    public function deleteProject($id)
    {
        $del = ProjectModel::where('id', $id)->delete();
        $response = ($del) ? ['status' => 200, 'Mesaage' => 'Employee project detail deleted Successfully'] :
            ['status' => 204, 'Message' => 'Employee project detail Not deleted'];
        return response()->json($response, 200);
    }

    public function GetEmployee(Request $req, $id)
    {
        $employee = EmployeeModel::where('id', $id)->get();
        $data = array();
        $i = 0;
        foreach ($employee as $emp) {
            $data[$i] = $emp;
            $academy = AcademyModel::where('emp_id', $emp['id'])->get();
            $data[$i]['Academy'] = $academy;
            $professional = ProfessionalModel::where('emp_id', $emp['id'])->get();
            $data[$i]['professional'] = $professional;
            $document = DocumentModel::where('emp_id', $emp['id'])->get();
            $data[$i]['document'] = $document;
            $project = ProjectModel::where('emp_id', $emp['id'])->get();
            $data[$i]['project'] = $project;
            $i++;
        }
        $response = ($data) ? ['status' => 200, 'Message' => 'Employee Detail By Id', 'data' => $data] :
            ['status' => 404, 'Message' => 'Data Not Found'];
        return response()->json($response, 200);
    }

    public function AllEmp(Request $req)
    {
        $name = $req->input('name');
        // $users = User::where('name', 'like', "%$name%")->get();
        $employee = EmployeeModel::where("user_type", 2)->where('first_name', 'like', "%$name%")->get();

        $data = array();
        $i = 0;
        foreach ($employee as $emp) {
            $data[$i]['id'] = $emp['id'];
            $data[$i]['name'] = trim($emp['first_name']) . ' ' . trim($emp['last_name']);
            $data[$i]['role'] = $emp['skillset'];
            $project = ProjectModel::where("emp_id", $emp['id'])->get();
            if ($project->count() > 0) {
                $projectName = $project->pluck('project_name')->toArray();
                $data[$i]['project'] = $projectName;
            }
            $data[$i]['email'] = $emp['official_email_id'];
            $i++;
        }
        $response = ($data) ? ['status' => 200, 'Message' => 'All Employees', 'data' => $data] :
            ['status' => 404, 'Message' => 'Data Not Found'];
        return response()->json($response, 200);
    }
}