@extends('layouts.app')
@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="invoice-title">
                                <h4 class="float-end font-size-15">ინვოისი #{{ $invoice->id }} </h4>
                                <div class="mb-4">
                                    <img src="{{ asset('template/azx_crat-75.jpg') }}" alt="logo" height="50" width="200" style="margin-top: 0px;">
                                </div>
                            </div>

                            <hr class="my-100">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="text-muted">
                                        <h5 class="font-size-16 mb-3">მომხმარებლის ინფორმაცია:</h5>
                                        <p class="mb-1">სახელი: {{ $invoice->first_name }}</p>
                                        <p class="mb-1">გვარი: {{ $invoice->last_name }}</p>
                                        <p>პირადი ნომერი: {{ $invoice->personal_number }}</p>
                                    </div>

                                    <div class="text-muted">
                                        <p class="mb-1">დაბადების თარიღი: {{ $invoice->date_of_birth }}</p>
                                        <p class="mb-1">მობილურის ნომერი: {{ $invoice->mobile_number }}</p>
                                    </div>

                                </div>
                                <!-- end col -->
                                <div class="col-sm-6">
                                    <div class="text-muted text-sm-end">
                                        @if($invoice->comment != null)
                                        <div class="mt-4">
                                            <h5 class="font-size-15 mb-1">კომენტარი:</h5>
                                            <p>{{ $invoice->comment }}</p>
                                        </div>
                                        @endif
                                        <div class="mt-4">
                                            <h5 class="font-size-15 mb-1">კონსულტანტი:</h5>
                                            <p>{{ $invoice->user->name }}</p>
                                        </div>
                                        <div class="mt-4">
                                            <h5 class="font-size-15 mb-1">ინვოისის თარიღი:</h5>
                                            <p>{{ $invoice->created_at }}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->

                            <div class="py-2">
                                <h5 class="font-size-15">შეკვეთის ინფორმაცია</h5>

                                <div class="table-responsive">
                                    <table class="table align-middle table-centered mb-0">
                                        <thead>
                                            <tr>
                                                <th class="fw-bold">მოწყობილობა</th>
                                                <th class="fw-bold">IMEI კოდი </th>
                                                <th class="fw-bold">არტიკული კოდი</th>
                                                <th class="fw-bold">ფასი | საბოლოო ფასი </th>
                                                <th class="text-end fw-bold" style="width: 120px;">ფასდაკლება ₾/%</th>
                                            </tr>
                                        </thead><!-- end thead -->
                                        <tbody>
                                        @foreach ($invoice->items as $item)
                                            <tr>
                                            <td>
                                                <div>
                                                    <p class="text-muted mb-0" style="word-wrap: break-word; font-size: 10px;">
                                                        {{ $item->device_name }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td style="font-size: 10px;">{{ $item->device_code }}</td>
                                            <td style="font-size: 10px;">{{ $item->device_artikuli_code }}</td>
                                            <td style="font-size: 10px;">{{ $item->device_price }} | {{ $item->device_total_price}} </td>

                                            <td class="text-end" style="font-size: 12px;">{{ $item->device_discounted_price }} @if($item->discount_type == 1) ლარი @elseif($item->discount_type == 2) პროცენტი @else არ აქვს @endif</td>
                                        </tr>
                                        @endforeach
                                        <!-- end tr -->
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end fw-bold">
                                                ფასი (₾):</th>
                                            <td class="border-0 text-end">{{ $invoice->items->sum('device_total_price') }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end fw-bold">
                                                გადახდის ტიპი:</th>
                                            <td class="border-0 text-end">{{ $invoice->payment_type->title }}</td>
                                        </tr>
                                        <tr>
                                            @if($invoice->items[0]->is_deghege == 1)
                                            <th scope="row" colspan="4" class="border-0 text-end fw-bold">
                                                დღგ:
                                            </th>
                                            <td class="border-0 text-end">გარეშე</td>
                                            @else
                                            <th scope="row" colspan="4" class="border-0 text-end fw-bold">
                                                დღგ:
                                            </th>
                                            <td class="border-0 text-end">ჩათვლით</td>
                                            @endif
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div>
                                    <p>მომხმარებლის ხელმოწერა: ___________________</p>
                                </div>
                                <br>
                                <div>
                                    <p>'აიპლიუსის' წარმომადგენელი: ___________________</p>
                                </div>
                                <div class="d-print-none mt-4">
                                    <div class="float-end">
                                        <a href="javascript:window.print()" class="btn btn-success me-1">ინვოისი</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->
            </div><!-- end row -->


        </div>
        <!-- container-fluid -->
    </div>
@endsection
