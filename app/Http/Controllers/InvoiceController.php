<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyModel;
use App\Models\ExciteModel;
use App\Models\CountModel;
use App\Models\InvoiceModel;
use Barryvdh\DomPDF\Facade as PDF;


class InvoiceController extends Controller
{
    public function MakeInvoice(Request $req)
    {
        $excite = ExciteModel::first();
        $owner_name = $req->owner_name;
        //Number Count 
        $count = CountModel::first();
        $number = $count->number;
        $number += 0;
        $count->number = $number;
        $count->update();

        //Invoice
        $invoice = $req->input('invoice');
        $invoData = array();
        $total = 0;
        foreach($invoice as $invo){
            $total += $invo['price'];
         $invoData =[
            "price" => $invo['price'],
            "emp_id" => $invo['emp_id'],
            "total" => $total
         ];
        //  $InvoData = InvoiceModel::insert($invoData);
        }
    //    $inv = $InvoData->get();
        $company = CompanyModel::where("owner_name", $owner_name)->first();
        $data = array(); 
       $logo = $excite->company_logo;
        $data = [
            'logo' =>  $logo,
            'excite' =>  $excite->company_name,
            'form_no' =>  $number,
            'company_name' =>  $company->company_name,
            'owner_name' =>  $company->owner_name,
            'company_address' =>  $company->company_address,
            'company_detail' =>  $company->company_detail,
            // 'price' =>  $inv->price,
            // 'total' =>  $inv->total
        ];
        $pdf = \PDF::loadView('pdf', $data);

        return $pdf->download('my_pdf.pdf');
    }
    public function AddCompany(Request $req)
    {
        $comapany = $req->all();

        $data = CompanyModel::create($comapany);
        $response = ($data) ? ['status' => 200, 'Message' => 'Comapany data Added Successfully'] :
            ['status' => 201, 'Message' => 'Comapany Not Added'];
        return response()->json($response, 200);
    }

    public function GetInvoice(Request $req)
    {
        $owner_name = $req->input('owner_name');
        $data = array();
        $company = CompanyModel::where('owner_name', 'like', "%$owner_name%")->get();
        foreach ($company as $com) {
            $data['id'] = $com['id'];
            $data['company_name'] = $com['company_name'];
            $data['company_address'] = $com['company_address'];
            $data['company_detail'] = $com['company_detail'];
        }
        $response = ($data) ? ['status' => 200, 'Message' => 'Comapany BY Owner Name', 'data' => $data] :
            ['status' => 404, 'Message' => 'Comapany Data Not Found'];
        return response()->json($response, 200);
    }
}