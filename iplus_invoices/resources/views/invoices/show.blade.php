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
                                    <img src="{{ asset('template/logo.png') }}" alt="logo" height="150" width="200" style="margin-top: 0px;">
                                </div>
                            </div>

                            <hr class="my-4">

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
                                        <p>პირადი ნომერი: {{ $invoice->personal_number }}</p>
                                    </div>

                                </div>
                                <!-- end col -->
                                <div class="col-sm-6">
                                    <div class="text-muted text-sm-end">
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
                                    <table class="table align-middle table-nowrap table-centered mb-0">
                                        <thead>
                                            <tr>
                                                <th class="fw-bold" style="width: 70px;">No.</th>
                                                <th class="fw-bold">მოწყობილობა</th>
                                                <th class="fw-bold">IMEI კოდი</th>
                                                <th class="fw-bold">ფასი</th>
                                                <th class="text-end fw-bold" style="width: 120px;">ფასდაკლებული ფასი</th>
                                            </tr>
                                        </thead><!-- end thead -->
                                        <tbody>
                                        @foreach ($invoice->items as $item)
                                            <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>
                                                <div>
                                                    <p class="text-muted mb-0">{{ $item->device_name }}</p>
                                                </div>
                                            </td>
                                            <td>{{ $item->device_code }}</td>
                                            <td>{{ $item->device_price }}</td>
                                            <td class="text-end">{{ $item->device_discounted_price }}</td>
                                        </tr>
                                        @endforeach
                                        <!-- end tr -->
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end fw-bold">
                                                ფასი ჯამში:</th>
                                            <td class="border-0 text-end">{{ $invoice->items->sum('device_total_price') }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end fw-bold">
                                                გადახდის ტიპი:</th>
                                            <td class="border-0 text-end">{{ $invoice->payment_type->title }}</td>
                                        </tr>
                                        <!-- end tr -->
                                        <!-- end tr -->
                                        </tbody><!-- end tbody -->
                                    </table><!-- end table -->
                                </div><!-- end table responsive -->
                                <div>
                                    <p>ხელმოწერა: ___________________</p>
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
