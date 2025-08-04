<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Services\SmsService;
use App\Notifications\DocumentSignedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class InvoiceSignController extends Controller
{
    public function show($uuid)
    {
        $invoice = Invoice::where('uuid', $uuid)->firstOrFail();
        return view('invoice.sign', compact('invoice'));
    }

    public function sendSms(Request $request, $uuid)
    {
        $invoice = Invoice::where('uuid', $uuid)->firstOrFail();
        $phone = $invoice->getAttribute('phone_number');
        $code = rand(100000, 999999);
        session(["sms_code_$uuid" => $code]);
        $sms = new SmsService();
        $message = "დადასტურების კოდი: $code";
        $response = $sms->send($phone, $message, $invoice->getAttribute('id'));
        $status = ($response['status'] ?? '') === 'sent' ? 'SMS წარმატებით გაიგზავნა!' : 'SMS გაგზავნა ვერ მოხერხდა!';
        return back()->with('success', $status);
    }

    public function verify(Request $request, $id)
    {
        $invoice = Invoice::where('id', $id)->firstOrFail();
        $request->validate([
            'signed_name' => 'required|string|max:255',
            'signed_surname' => 'required|string|max:255',
        ]);
        $invoice->is_signed = true;
        $invoice->signed_at = now();
        $invoice->signed_ip = $request->ip();
        $invoice->signed_phone = $invoice->getAttribute('phone_number');
        $invoice->signed_name = $request->input('signed_name');
        $invoice->signed_surname = $request->input('signed_surname');
        $invoice->save();

        // Send email with PDF if email is available
        if ($invoice->personal_email) {
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('invoice.pdf', ['invoice' => $invoice]);
            
            try {
                Notification::route('mail', $invoice->personal_email)
                    ->notify(new DocumentSignedNotification($invoice, 'invoice', $pdf));
            } catch (\Exception $e) {
                // Log error but don't stop the process
                \Log::error("Failed to send invoice email: " . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'დოკუმენტი წარმატებით ხელმოწერილია!');
    }

    public function downloadPdf($id)
    {
        $invoice = Invoice::where('id', $id)->firstOrFail();
        if (!$invoice->getAttribute('is_signed')) {
            abort(403, 'PDF ხელმისაწვდომია მხოლოდ ხელმოწერის შემდეგ.');
        }
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('invoice.pdf', compact('invoice'));
        $filename = 'invoice_' .
            ($invoice->signed_name ?? $invoice->first_name ?? 'user') . '_' .
            ($invoice->signed_surname ?? $invoice->last_name ?? 'user') . '_' .
            ($invoice->invoice_number ?? 'invoice') . '.pdf';
        $filename = str_replace([' ', '/'], '_', $filename);
        return $pdf->download($filename);
    }
}
