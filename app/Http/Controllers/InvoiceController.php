<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyModel;
use App\Models\ExciteModel;
use App\Models\CountModel;
use App\Models\InvoiceModel;
use App\Models\InvoicePriceModel;
use Barryvdh\DomPDF\Facade as PDF;


class InvoiceController extends Controller
{
    public function MakeInvoice(Request $req)
    {
        $excite = ExciteModel::first();
        $company_id = $req->company_id;

        //Number Count 
        $count = CountModel::first();
        $number = $count->number;
        $number += 1;
        $count->number = $number;
        $count->update();

        //InvoicePrice create

        $invoice = $req->input('invoice');
        $invoData = array();
        $subtotal = 0;
        foreach ($invoice as $invo) {
            $subtotal += $invo['price'] * $invo['quantity'];
            $total = $invo['price'] * $invo['quantity'];
            $invoData = [
                "quantity" => $invo['quantity'],
                "description" => $invo['description'],
                "price" => $invo['price'],
                "emp_id" => $invo['emp_id'],
                "form_no" => $number,
                "total" => $total,
                "sub_total" => $subtotal
            ];
            $InvoData = InvoicePriceModel::create($invoData);
        }
        //Take InvoicePrice data who created now
        $inv = InvoicePriceModel::where("form_no", $InvoData['form_no'])->get();
        $a = 0;
        foreach ($inv as $i) {
            $invoice_id[$a++] = $i['id'];
        }
        //Invoice create
        $invoice = $req->all();
        $invoice['invoice_price_id'] = implode(',', $invoice_id);
        $invoice_save = InvoiceModel::create($invoice);
        $company = CompanyModel::where("id", $company_id)->first();
        $data = array();
        $logo = $excite->company_logo;
        //data for response
        $data = [
            'logo' => $logo,
            'excite' => $excite->company_name,
            'form_no' => $number,
            'date' => $invoice_save->date,
            'company_name' => $company->company_name,
            'owner_name' => $company->owner_name,
            'company_address' => $company->company_address,
            'company_detail' => $company->company_detail,
            'invoice' => $inv
        ];
        $response = ($data) ? ['status' => 200, 'Message' => "Invoice Price data", "data" => $data] :
            ['status' => 404, "Message" => "Data Not Found"];

        return response()->json($response, 200);
    }
    public function AddCompany(Request $req)
    {
        $comapany = $req->all();

        $data = CompanyModel::create($comapany);
        $response = ($data) ? ['status' => 200, 'Message' => 'Comapany data Added Successfully'] :
            ['status' => 201, 'Message' => 'Comapany Not Added'];
        return response()->json($response, 200);
    }

    public function GetInvoice(Request $req, $id)
    {
        $company = CompanyModel::where("id", $id)->first();
        $response = ($company) ? ['status' => 200, 'Message' => 'Comapany by Id', 'data' => $company] :
            ['status' => 404, 'Message' => 'Comapany Data Not Found'];
        return response()->json($response, 200);
    }
}