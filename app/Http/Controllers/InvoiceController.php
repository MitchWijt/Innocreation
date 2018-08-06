<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\SiteSetting;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;

use App\Http\Requests;
use Spipu\Html2Pdf\Html2Pdf;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generateMonthlyInvoiceAction(Request $request, $hash) {
        $userId = $request->input("user_id");
        $invoiceId = $request->input("invoice_id");
        $invoice = Invoice::select("*")->where("id", $invoiceId)->where("hash", $hash)->where("user_id", $userId)->first();
        $invoiceMonth = date("F Y", strtotime($invoice->created_at));
        $userName = $invoice->user->firstname;

        $vatRate = SiteSetting::select("*")->where("id", 2)->first()->description;

//        return view("/public/invoice/userMonthlyInvoice", compact("invoice", "vatRate"));
        $html2pdf = new Html2Pdf();
        $html2pdf->writeHTML(view("/public/invoice/userMonthlyInvoice", compact("invoice", "vatRate")));
        $html2pdf->output("$userName-$invoiceMonth.pdf", 'D');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
