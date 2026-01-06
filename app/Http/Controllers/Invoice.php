<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invoice as ModelsInvoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class Invoice extends Controller
{
  public function download($id)
    {
        $invoice = ModelsInvoice::findOrFail($id);
        $name = $invoice->invoice_id . '.pdf';
        $company = Company::first();
        $pdf = PDF::loadView('templates.invoice', compact('invoice', 'company'));

        return $pdf->download($name);
    }
    public function view($id)
    {
        $invoice = ModelsInvoice::findOrFail($id);
        $company = Company::first();
        return view('templates.invoice-view', compact('invoice', 'company'));
    }
}
