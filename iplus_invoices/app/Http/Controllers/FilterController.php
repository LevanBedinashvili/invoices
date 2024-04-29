<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warranty;
use App\Models\Invoice;



class FilterController extends Controller
{
    public function invoice_search(Request $request)
    {
        $query = Invoice::with(['user', 'payment_type'])->orderBy('id', 'desc');

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }
        if ($request->filled('personal_number')) {
            $query->where('personal_number', $request->personal_number);
        }
        if ($request->filled('first_name')) {
            $query->where('first_name', $request->first_name);
        }
        if ($request->filled('last_name')) {
            $query->where('last_name', $request->last_name);
        }

        $get_all_invoice_from_database = $query->paginate(200);

        return view('invoices.index', compact('get_all_invoice_from_database'));
    }

    public function warranty_search(Request $request)
    {
        $query = Warranty::with(['user', 'branch'])->orderBy('id', 'desc');

        if ($request->filled('device_imei_code')) {
            $query->where('device_imei_code', $request->device_imei_code);
        }
        if ($request->filled('personal_number')) {
            $query->where('personal_number', $request->personal_number);
        }
        if ($request->filled('first_name')) {
            $query->where('first_name', $request->first_name);
        }
        if ($request->filled('last_name')) {
            $query->where('last_name', $request->last_name);
        }

        $get_all_warranty_from_database = $query->paginate(200);

        return view('warranties.index', compact('get_all_warranty_from_database'));
    }
}
