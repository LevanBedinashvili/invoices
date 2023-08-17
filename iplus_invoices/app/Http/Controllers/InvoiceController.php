<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInvoiceRequest;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Notification;
use App\Models\Payment_type;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        $get_all_invoice_from_database = Invoice::orderBy('id', 'desc')->get();
        return view('invoices.index', compact('get_all_invoice_from_database'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $get_all_payment_types = Payment_type::orderBy('id', 'asc')->get();
        return view('invoices.create', compact('get_all_payment_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(CreateInvoiceRequest $request)
    {
        $user = Auth::user();

        $requestData = $request->except('items');
        $requestData['user_id'] = $user->id;

        $invoice = Invoice::create($requestData);

        $request->validate([
            'items' => 'required',
        ]);

        $items = $request->items;

        foreach ($items as $item) {
            $deviceTotalPrice = !$item['device_discounted_price'] ? $item['device_price'] : $item['device_discounted_price'];

            $invoiceItemData = [
                'device_name' => $item['device_name'],
                'device_code' => $item['device_code'],
                'device_artikuli_code' => $item['device_artikuli_code'],
                'device_price' => $item['device_price'],
                'device_discounted_price' => $item['device_discounted_price'],
                'device_total_price' => $deviceTotalPrice,
            ];

            $invoice->items()->create($invoiceItemData);
        }

        $notificationMessage = 'დაამატა ინვოისი უნიკალური ნომრით - ' . $invoice->id;
        $notification = new Notification([
            'user_id' => $user->id,
            'message' => $notificationMessage,
            'is_seen' => false,
        ]);
        $notification->save();

        return redirect()->route('invoice.index')->with('Success', 'ინვოისი წარმატებით დაემატა');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Invoice $invoice)
    {
        $invoice = Invoice::with('items')->where('id', $invoice->id)->firstOrFail();
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Invoice $invoice)
    {
        $invoice = Invoice::where('id', $invoice->id)->firstOrFail();
        $get_all_payment_types = Payment_type::orderBy('id', 'asc')->get();
        return view('invoices.edit', compact('invoice', 'get_all_payment_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'personal_number' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'items' => 'required|array',
            'items.*.device_name' => 'required|string|max:255',
            'items.*.device_price' => 'required|numeric|min:0',
            'items.*.device_artikuli_code' => 'required|string|min:0',

        ]);

        $invoice->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'personal_number' => $request->input('personal_number'),
            'mobile_number' => $request->input('mobile_number'),
            'date_of_birth' => $request->input('date_of_birth'),
        ]);

        $existingItemIds = $invoice->items->pluck('id')->toArray();
        $updatedItemIds = [];

        foreach ($request->input('items') as $itemData) {
            if(!$itemData['device_discounted_price']){
                $device_total_price = $itemData['device_price'];
            } else {
                $device_total_price = $itemData['device_discounted_price'];
            }
            if (isset($itemData['id']) && in_array($itemData['id'], $existingItemIds)) {

                // Update existing item
                $item = InvoiceItem::find($itemData['id']);
                $item->update([
                    'device_name' => $itemData['device_name'],
                    'device_code' => $itemData['device_code'],
                    'device_price' => $itemData['device_price'],
                    'device_artikuli_code' => $itemData['device_artikuli_code'],
                    'device_discounted_price' => $itemData['device_discounted_price'],
                    'device_total_price' => $device_total_price,
                ]);
                $updatedItemIds[] = $itemData['id'];
            } else {
                // Create new item
                $newItem = new InvoiceItem([
                    'device_name' => $itemData['device_name'],
                    'device_code' => $itemData['device_code'],
                    'device_artikuli_code' => $itemData['device_artikuli_code'],
                    'device_price' => $itemData['device_price'],
                    'device_discounted_price' => $itemData['device_discounted_price'],
                    'device_total_price' => $device_total_price,
                ]);
                $invoice->items()->save($newItem);
                $updatedItemIds[] = $newItem->id;
            }
        }

        // Remove items that are not present in the request
        $itemsToDelete = array_diff($existingItemIds, $updatedItemIds);
        InvoiceItem::whereIn('id', $itemsToDelete)->delete();

        $notification = new Notification([
            'user_id' => auth()->user()->id,
            'message' => 'დაამატა ინვოისი უნიკალური ნომრით - '. $invoice->id,
            'is_seen' => false,
        ]);
        $notification->save();

        return redirect()->route('invoice.show', $invoice->id)->with('Success', 'ინვოისი წარმატებით განახლდა !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);

        $invoice->delete();

        return redirect()->back()->with('Success', 'ინვოისი  წარმატებით წაიშალა მონაცემთა ბაზიდან');
    }
}
