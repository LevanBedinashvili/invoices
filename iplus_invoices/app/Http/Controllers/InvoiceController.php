<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInvoiceRequest;
use App\Models\Invoice;
use App\Models\Warranty;
use App\Models\InvoiceItem;
use App\Models\Notification;
use App\Models\Branch;
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
         $user = Auth::user();

         $query = Invoice::with(['user', 'payment_type'])->orderBy('id', 'desc');

         switch ($user->role_id) {
             case 1:
                 break;
             case 2:
                 $query = $query->where('user_id', $user->id);
                 break;
             case 3:
                 $query = $query->where('branch_id', $user->branch_id);
                 break;
             default:
                 return view('invoices.index', ['get_all_invoice_from_database' => collect()]);
         }

         $get_all_invoice_from_database = $query->paginate(20);

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
        $get_all_branches = Branch::orderBy('id', 'asc')->get();
        return view('invoices.create', compact('get_all_payment_types', 'get_all_branches'));
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

        $branch_id = $request->branch_id;
        $items = $request->items;

        foreach ($items as $item) {
            $is_deghege_checked = 0;
            $item['device_qty'] = $item['device_qty'] < 1 ? 1 : $item['device_qty'];
            $deviceTotalPrice = $item['device_price'] * $item['device_qty'];
            $discount_type = 0;

            if (isset($item['is_deghege'])) {
                $deviceTotalPrice = $deviceTotalPrice / 1.18;
                $is_deghege_checked = 1;
            }

            $discountType = $item['discount_type'];
            $discountAmount = $item['device_discounted_price'];

            if ($discountType === 'fixed') {
                $discount_type = 1;
                $deviceTotalPrice = $deviceTotalPrice - $discountAmount;
            } elseif ($discountType === 'percentage') {
                $discount_type = 2;
                $deviceTotalPrice = $deviceTotalPrice - ($deviceTotalPrice * ($discountAmount / 100));
            }

            $invoiceItemData = [
                'device_name' => $item['device_name'],
                'device_code' => $item['device_code'],
                'device_artikuli_code' => $item['device_artikuli_code'],
                'device_price' => $item['device_price'],
                'device_qty' => $item['device_qty'],
                'is_deghege' => $is_deghege_checked,
                'product_id' => null,
                'discount_type' => $discount_type,
                'device_discounted_price' => $item['device_discounted_price'],
                'device_total_price' => $deviceTotalPrice,
                'template_id' => $item['template_item'],
            ];

            $invoice->items()->create($invoiceItemData);

            $sagarantio = new Warranty();
            $sagarantio->template_id = $item['template_item'];
            $sagarantio->user_id = Auth::user()->id;
            $sagarantio->first_name = $requestData['first_name'];
            $sagarantio->last_name = $requestData['last_name'];
            $sagarantio->personal_number = $requestData['personal_number'];
            $sagarantio->branch_id = $branch_id;
            $sagarantio->device_imei_code = $item['device_code'];
            $sagarantio->device_name = $item['device_name'];
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
        $get_all_branches = Branch::orderBy('id', 'asc')->get();
        return view('invoices.edit', compact('invoice', 'get_all_payment_types', 'get_products', 'get_all_branches'));
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
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'reqsometimesuired|string|max:255',
            'personal_number' => 'sometimes|string|max:255',
            'mobile_number' => 'sometimes|string|max:255',
            'date_of_birth' => 'nullable|date',
            'branch_id' => 'required',
            'payment_type_id' => 'required',
            'comment' => 'sometimes',
            'items' => 'required|array',
            'items.*.device_price' => 'required|numeric|min:0',
            'items.*.device_qty' => 'required|integer|min:1',
        ]);

        $invoice->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'personal_number' => $request->input('personal_number'),
            'mobile_number' => $request->input('mobile_number'),
            'date_of_birth' => $request->input('date_of_birth'),
            'payment_type_id' => $request->input('payment_type_id'),
            'branch_id' => $request->input('branch_id'),
            'comment' => $request->input('comment'),
        ]);

        $existingItemIds = $invoice->items->pluck('id')->toArray();
        $updatedItemIds = [];

        foreach ($request->input('items') as $itemData) {

            $is_deghege_checked = 0;
            $itemData['device_qty'] = $itemData['device_qty'] < 1 ? 1 : $itemData['device_qty'];

            $device_total_price = $itemData['device_price'] * $itemData['device_qty'];
            $discount_type = 0;

            if (isset($itemData['is_deghege'])) {
                $device_total_price = $device_total_price / 1.18;
                $is_deghege_checked = 1;
            }

            $discountType = $itemData['discount_type'];
            $discountAmount = $itemData['device_discounted_price'];

            if ($discountType === 'fixed') {
                $discount_type = 1;
                $device_total_price = $device_total_price - $discountAmount;
            } elseif ($discountType === 'percentage') {
                $discount_type = 2;
                $device_total_price = $device_total_price - ($device_total_price * ($discountAmount / 100));
            }

            if (isset($itemData['id']) && in_array($itemData['id'], $existingItemIds)) {

                $item = InvoiceItem::find($itemData['id']);
                $item->update([
                    'device_name' => $itemData['device_name'],
                    'device_code' => $itemData['device_code'],
                    'device_price' => $itemData['device_price'],
                    'device_qty' => $itemData['device_qty'],
                    'device_artikuli_code' => $itemData['device_artikuli_code'],
                    'product_id' => null,
                    'device_discounted_price' => $itemData['device_discounted_price'],
                    'is_deghege' => $is_deghege_checked,
                    'discount_type' => $discount_type,
                    'device_total_price' => $device_total_price,
                ]);
                $updatedItemIds[] = $itemData['id'];
            } else {
                $newItem = new InvoiceItem([
                    'device_name' => $itemData['device_name'],
                    'device_code' => $itemData['device_code'],
                    'device_price' => $itemData['device_price'],
                    'device_qty' => $itemData['device_qty'],
                    'device_artikuli_code' => $itemData['device_artikuli_code'],
                    'product_id' => null,
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
            $get_all_branches = Branch::orderBy('id', 'asc')->get();
            return view('invoices.create_second', compact('get_all_payment_types', 'get_customer_info', 'get_all_branches'));
        }
    }

}
