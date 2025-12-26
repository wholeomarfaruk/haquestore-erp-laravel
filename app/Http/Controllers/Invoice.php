<?php

namespace App\Http\Controllers;

use App\Models\Invoice as ModelsInvoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class Invoice extends Controller
{
  public function download($id)
    {
        $invoice = ModelsInvoice::findOrFail($id);
        $name = $invoice->invoice_id . '.pdf';

        $pdf = PDF::loadView('templates.invoice', compact('invoice'));

        return $pdf->download($name);
    }
}
