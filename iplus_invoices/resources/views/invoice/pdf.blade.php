<!DOCTYPE html>
<html lang="ka">
<head>
    <meta charset="UTF-8">
    <title>ინვოისი</title>
    <style>
        @page { size: A4; margin: 20px; }
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 12px; 
            background: #fff; 
            color: #333;
        }
        .invoice-title {
            position: relative;
            margin-bottom: 24px;
        }
        .invoice-title h4 {
            font-size: 15px;
            float: right;
            margin: 0;
        }
        .logo {
            margin-bottom: 20px;
        }
        .my-100 {
            margin: 15px 0;
            border: none;
            border-top: 1px solid #ddd;
        }
        .row {
            display: flex;
            margin: 0 -15px;
        }
        .col-sm-6 {
            flex: 0 0 50%;
            padding: 0 15px;
        }
        .text-muted {
            color: #555;
        }
        .font-size-16 {
            font-size: 16px;
        }
        .font-size-15 {
            font-size: 15px;
        }
        .mb-3 {
            margin-bottom: 15px;
        }
        .mb-1 {
            margin-bottom: 5px;
        }
        .text-sm-end {
            text-align: right;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 12px;
        }
        .table th {
            background: #f8f9fa;
            font-weight: bold;
        }
        .text-end {
            text-align: right;
        }
        .fw-bold {
            font-weight: bold;
        }
        .signature-line {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px dashed #ddd;
        }
    </style>
</head>
<body>
    <div class="invoice-title">
        <h4>ინვოისი #{{ $invoice->id }}</h4>
        <div class="logo">
            <img src="{{ asset('template/azx_crat-75.jpg') }}" alt="logo" height="50">
        </div>
    </div>

    <hr class="my-100">

    <div class="row">
        <div class="col-sm-6">
            <div class="text-muted">
                <h5 class="font-size-16 ">მომხმარებლის ინფორმაცია:</h5>
                <p >სახელი: {{ $invoice->first_name }}</p>
                <p >გვარი: {{ $invoice->last_name }}</p>
                <p>პირადი ნომერი: {{ $invoice->personal_number }}</p>
            </div>

            <div class="text-muted">
                <p >დაბადების თარიღი: {{ $invoice->date_of_birth }}</p>
                <p >მობილურის ნომერი: {{ $invoice->mobile_number }}</p>
            </div>
        </div>
        
        <div class="col-sm-6">
            <div class="text-muted text-sm-end">
                @if($invoice->comment)
                <div >
                    <h5 class="font-size-15 mb-1">კომენტარი:</h5>
                    <p>{{ $invoice->comment }}</p>
                </div>
                @endif
                <div >
                    <h5 class="font-size-15 mb-1">კონსულტანტი:</h5>
                    <p>{{ $invoice->user->name }}</p>
                </div>
                <div >
                    <h5 class="font-size-15 mb-1">ინვოისის თარიღი:</h5>
                    <p>{{ $invoice->created_at }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-2">
        <h5 class="font-size-15">შეკვეთის ინფორმაცია</h5>

        <table class="table">
            <thead>
                <tr>
                    <th>მოწყობილობა</th>
                    <th>IMEI კოდი</th>
                    <th>არტიკული კოდი</th>
                    <th>ფასი | რაოდენობა | საბოლოო ფასი</th>
                    <th class="text-end">ფასდაკლება ₾/%</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $item)
                <tr>
                    <td>
                        <p class="text-muted mb-0" style="word-wrap: break-word; font-size: 10px;">
                            {{ $item->device_name }}
                        </p>
                    </td>
                    <td style="font-size: 10px;">{{ $item->device_code }}</td>
                    <td style="font-size: 10px;">{{ $item->device_artikuli_code }}</td>
                    <td style="font-size: 10px;">{{ $item->device_price }} | {{ $item->device_qty }} | {{ $item->device_total_price}}</td>
                    <td class="text-end" style="font-size: 12px;">
                        {{ $item->device_discounted_price }} 
                        @if($item->discount_type == 1) ლარი 
                        @elseif($item->discount_type == 2) პროცენტი 
                        @else არ აქვს 
                        @endif
                    </td>
                </tr>
                @endforeach

                <tr>
                    <th scope="row" colspan="4" class="text-end fw-bold">ფასი (₾):</th>
                    <td class="text-end">{{ $invoice->items->sum('device_total_price') }}</td>
                </tr>
                <tr>
                    <th scope="row" colspan="4" class="text-end fw-bold">გადახდის ტიპი:</th>
                    <td class="text-end">{{ $invoice->payment_type->title }}</td>
                </tr>
                <tr>
                    <th scope="row" colspan="4" class="text-end fw-bold">დღგ:</th>
                    <td class="text-end">
                        @if($invoice->items[0]->is_deghege == 1)
                            გარეშე
                        @else
                            ჩათვლით
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- <div class="signature-line">
            <p>მომხმარებლის ხელმოწერა: ___________________</p>
            <br>
            <p>'აიპლიუსის' წარმომადგენელი: ___________________</p>
        </div> --}}

        @if($invoice->is_signed)
        <div class="signature">
            <hr>
            <p>
                დოკუმენტი ხელმოწერილია:<br>
                ნომრით: {{ $invoice->mobile_number }}<br>
                დროით: {{ $invoice->signed_at }}<br>
                ხელმომწერი: {{ $invoice->signed_name }} {{ $invoice->signed_surname }}
            </p>
        </div>
        @endif
    </div>
</body>
</html>
