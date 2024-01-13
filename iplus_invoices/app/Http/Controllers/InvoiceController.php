<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInvoiceRequest;
use App\Models\Invoice;
use App\Models\Warranty;
use App\Models\InvoiceItem;
use App\Models\Notification;
use App\Models\Payment_type;
use App\Models\Product;
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
            $is_deghege_checked = 0;
            $deviceTotalPrice = $item['device_price'];
            $discount_type = 0;

            if(isset($item['is_deghege'])) {
                $deviceTotalPrice = $deviceTotalPrice / 1.18;
                $is_deghege_checked = 1;
            }
            else {
                $deviceTotalPrice;
                $is_deghege_checked = 0;
            }

            $discountType = $item['discount_type'];
            $discountAmount = $item['device_discounted_price'];

            if ($discountType === 'fixed') {
                $discount_type = 1;
                $deviceTotalPrice = $deviceTotalPrice - $discountAmount;
            } elseif ($discountType === 'percentage') {
                $discount_type = 2;
                $deviceTotalPrice = $deviceTotalPrice - ($deviceTotalPrice * ($discountAmount / 100));
            } else {
                // No discount
                $discount_type = 0;
            }

            $name_code = $item['product_name_code'];

            $product_parts = explode(' - ', $name_code);
            $product_name = $product_parts[0];
            $product_code = $product_parts[1];
            $product_id = $product_parts[2];

            $invoiceItemData = [
                'device_name' => $product_name,
                'device_code' => $item['device_code'],
                'device_artikuli_code' => $product_code,
                'device_price' => $item['device_price'],
                'is_deghege' => $is_deghege_checked,
                'product_id' => $product_id,
                'discount_type' => $discount_type,
                'device_discounted_price' => $item['device_discounted_price'],
                'device_total_price' => $deviceTotalPrice,
            ];

            $invoice->items()->create($invoiceItemData);

            $sagarantio = new Warranty();
            $sagarantio->template_id = 0;
            $sagarantio->user_id = Auth::user()->id;
            $sagarantio->first_name = $requestData['first_name'];
            $sagarantio->last_name = $requestData['last_name'];
            $sagarantio->personal_number = $requestData['personal_number'];
            $sagarantio->branch_id = 0;
            $sagarantio->device_imei_code = $item['device_code'];
            $sagarantio->device_name = $product_name;
            $sagarantio->invoice_id = $invoice->id;
            $sagarantio->save();

        }
        $notificationMessage = 'დაამატა ინვოისი უნიკალური ნომრით - ' . $invoice->id;
        $notification = new Notification([
            'user_id' => $user->id,
            'message' => $notificationMessage,
            'is_seen' => false,
        ]);
        $notification->save();

        return redirect()->route('invoice.show', $invoice->id)->with('Success', 'ინვოისი წარმატებით დაემატა !');
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
        $get_products = Product::orderBy('id', 'asc')->get();
        return view('invoices.edit', compact('invoice', 'get_all_payment_types', 'get_products'));
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
            'items.*.device_price' => 'required|numeric|min:0',
            'items.*.product_name_code' => 'required|string|min:0',
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

            $is_deghege_checked = 0;
            $device_total_price = $itemData['device_price'];
            $discount_type = 0;

            if(isset($itemData['is_deghege'])) {
                $device_total_price = $device_total_price / 1.18;
                $is_deghege_checked = 1;
            }
            else {
                $device_total_price;
                $is_deghege_checked = 0;
            }

            $discountType = $itemData['discount_type'];
            $discountAmount = $itemData['device_discounted_price'];

            if ($discountType === 'fixed') {
                $discount_type = 1;
                $device_total_price = $device_total_price - $discountAmount;
            } elseif ($discountType === 'percentage') {
                $discount_type = 2;
                $device_total_price = $device_total_price - ($device_total_price * ($discountAmount / 100));
            } else {

                $discount_type = 0;
                $device_total_price;
            }


            $name_code = $itemData['product_name_code'];

            $product_parts = explode(' - ', $name_code);
            $product_name = $product_parts[0];
            $product_code = $product_parts[1];
            $product_id = $product_parts[2];

            if (isset($itemData['id']) && in_array($itemData['id'], $existingItemIds)) {

                $item = InvoiceItem::find($itemData['id']);
                $item->update([
                    'device_name' => $product_name,
                    'device_code' => $itemData['device_code'],
                    'device_price' => $itemData['device_price'],
                    'device_artikuli_code' => $product_code,
                    'product_id' => $product_id,
                    'device_discounted_price' => $itemData['device_discounted_price'],
                    'is_deghege' => $is_deghege_checked,
                    'discount_type' => $discount_type,
                    'device_total_price' => $device_total_price,
                ]);
                $updatedItemIds[] = $itemData['id'];
            } else {
                $newItem = new InvoiceItem([
                    'device_name' => $product_name,
                    'device_code' => $itemData['device_code'],
                    'device_price' => $itemData['device_price'],
                    'device_artikuli_code' => $product_code,
                    'product_id' => $product_id,
                    'device_discounted_price' => $itemData['device_discounted_price'],
                    'is_deghege' => $is_deghege_checked,
                    'discount_type' => $discount_type,
                    'device_total_price' => $device_total_price,
                ]);
                $invoice->items()->save($newItem);
                $updatedItemIds[] = $newItem->id;
            }
        }

        $itemsToDelete = array_diff($existingItemIds, $updatedItemIds);
        InvoiceItem::whereIn('id', $itemsToDelete)->delete();

        $notification = new Notification([
            'user_id' => auth()->user()->id,
            'message' => 'განაახლა ინვოისი უნიკალური ნომრით - '. $invoice->id,
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

        return redirect()->back()->with('Success', 'ინვოისი წარმატებით წაიშალა მონაცემთა ბაზიდან');
    }

    public function createIfExists($id)
    {
        if($id) {
            $get_all_payment_types = Payment_type::orderBy('id', 'asc')->get();
            $get_customer_info = Invoice::findOrFail($id);
            return view('invoices.create_second', compact('get_all_payment_types', 'get_customer_info'));
        }
    }

}
