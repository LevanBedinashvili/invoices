<?php

namespace App\Http\Controllers;

use App\Models\Warranty;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class WarrantyPdfController extends Controller
{
    /**
     * Generate and download warranty PDF.
     *
     * @param int $id
     * @return Response
     */
    public function download($id)
    {
        $get_warranty = Warranty::where('id', $id)->firstOrFail();
        $pdf = Pdf::loadView('warranties.pdf', compact('get_warranty'));
        $filename = 'warranty_' .
            ($get_warranty->first_name ?? 'user') . '_' .
            ($get_warranty->last_name ?? 'user') . '_' .
            ($get_warranty->device_name ?? 'device') . '.pdf';
        $filename = str_replace([' ', '/'], '_', $filename);
        return $pdf->download($filename);
    }

    /**
     * Preview warranty PDF as HTML in browser.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function preview($id)
    {
        $get_warranty = Warranty::where('id', $id)->firstOrFail();
        return view('warranties.pdf', compact('get_warranty'));
    }
}
