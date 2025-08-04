@extends('layouts.app')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6" >
                                    <div class="text-muted" >
                                        <h6 style="font-size: 10px; " class="">ინფორმაცია:</h6>
                                        <p style="font-size: 9px; color: black;" class="mb-1">გარანტიის ვადა: {{ $get_warranty->template->warranty_lenght}}</p>
                                        <p style="font-size: 9px; color: black;" class="mb-1">თარიღი: {{ $get_warranty->created_at }}</p>
                                        <p style="font-size: 9px; color: black;" class="mb-1">პირადი ნომერი: {{ $get_warranty->personal_number }}</p>

                                    </div>
                                </div>
                                <div class="col-sm-6" style="text-align: end;">
                                    <div class="text-muted" >
                                        <p style="font-size: 9px; color: black;" class="mb-1">სახელი, გვარი: {{ $get_warranty->first_name }} {{ $get_warranty->last_name }}</p>
                                        <p style="font-size: 9px; color: black;" class="mb-1">პროდუქტის დასახელება: {{ $get_warranty->device_name }}</p>
                                        <p style="font-size: 9px; color: black;" class="mb-1">პროდუქტის IMEI: {{ $get_warranty->device_imei_code }}</p>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                            <div>
                                <div style="font-size: 9px;">
                                    {!! $get_warranty->template->description !!}
                                </div>
                                <p>ხელმოწერა: ___________________</p>
                            </div>
                            <div class="d-print-none mt-4">
                                <div class="float-end">
                                    <a href="{{ route('warranty.pdf', $get_warranty->id) }}" class="btn btn-primary me-1">PDF გადმოწერა</a>
                                    <a href="javascript:window.print()" class="btn btn-success me-1">საგარანტიო</a>
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
