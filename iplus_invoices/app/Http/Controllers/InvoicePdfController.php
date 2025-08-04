<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use PDF;

class InvoicePdfController extends Controller
{
    public function download($id)
    {
        $invoice = Invoice::with(['items', 'payment_type', 'branch'])->findOrFail($id);
        $pdf = PDF::loadView('invoice.pdf', ['invoice' => $invoice]);
        
        $filename = 'invoice_' . 
            ($invoice->signed_name ?? $invoice->first_name ?? 'user') . '_' .
            ($invoice->signed_surname ?? $invoice->last_name ?? 'user') . '_' .
            ($invoice->invoice_number ?? date('Y-m-d')) . '.pdf';

        $filename = str_replace([' ', '/'], '_', $filename);
        return $pdf->download($filename);
    }
}
