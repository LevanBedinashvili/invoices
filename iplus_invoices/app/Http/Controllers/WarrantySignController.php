<?php
namespace App\Http\Controllers;

use App\Models\Warranty;
use App\Services\SmsService;
use App\Notifications\DocumentSignedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;


class WarrantySignController extends Controller
{
    public function show($uuid)
    {
        $warranty = Warranty::where('uuid', $uuid)->firstOrFail();
        return view('warranty.sign', compact('warranty'));
    }

    public function sendSms(Request $request, $uuid)
    {
        $warranty = Warranty::where('uuid', $uuid)->firstOrFail();
        $phone = $warranty->getAttribute('phone_number');
        $code = rand(100000, 999999);
        session(["sms_code_$uuid" => $code]);
        $sms = new SmsService();
        $message = "დადასტურების კოდი: $code";
        $response = $sms->send($phone, $message, $warranty->getAttribute('id'));
        $status = ($response['status'] ?? '') === 'sent' ? 'SMS წარმატებით გაიგზავნა!' : 'SMS გაგზავნა ვერ მოხერხდა!';
        return back()->with('success', $status);
    }

    public function verify(Request $request, $id)
    {
        $warranty = Warranty::where('id', $id)->firstOrFail();
        $request->validate([
            'signed_name' => 'required|string|max:255',
            'signed_surname' => 'required|string|max:255',
        ]);
        $warranty->is_signed = true;
        $warranty->signed_at = now();
        $warranty->signed_ip = $request->ip();
        $warranty->signed_phone = $warranty->getAttribute('phone_number');
        $warranty->signed_name = $request->input('signed_name');
        $warranty->signed_surname = $request->input('signed_surname');
        $warranty->save();

        // Send email with PDF if email is available
        if ($warranty->personal_email) {
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('warranties.pdf', ['get_warranty' => $warranty]);
            try {
                Notification::route('mail', $warranty->personal_email)
                    ->notify(new DocumentSignedNotification($warranty, 'warranty', $pdf));
            } catch (\Exception $e) {
                // Log error but don't stop the process
                \Log::error("Failed to send warranty email: " . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'დოკუმენტი წარმატებით ხელმოწერილია!');
    }

    public function downloadPdf($uuid)
    {
        $warranty = Warranty::where('uuid', $uuid)->firstOrFail();
        if (!$warranty->getAttribute('is_signed')) {
            abort(403, 'PDF ხელმისაწვდომია მხოლოდ ხელმოწერის შემდეგ.');
        }
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('warranties.pdf', ['get_warranty' => $warranty]);
        $filename = 'warranty_' .
            ($warranty->signed_name ?? $warranty->first_name ?? 'user') . '_' .
            ($warranty->signed_surname ?? $warranty->last_name ?? 'user') . '_' .
            ($warranty->device_name ?? 'device') . '.pdf';
        $filename = str_replace([' ', '/'], '_', $filename);
        return $pdf->download($filename);
    }
}
