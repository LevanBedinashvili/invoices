@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">საგარანტიო დოკუმენტი</div>
        <div class="card-body">
            <h5>სახელი, გვარი: {{ $warranty->first_name }} {{ $warranty->last_name }}</h5>
            <p>პროდუქტი: {{ $warranty->device_name }}</p>
            <p>IMEI: {{ $warranty->device_imei_code }}</p>
            <p>გარანტიის ვადა: {{ $warranty->template->warranty_lenght }}</p>
            <p>აღწერა:</p>
            <div style="background:#f7f7f7; padding:8px; border-radius:6px;">{!! $warranty->template->description !!}</div>
            <hr>
            <a href="{{ route('warranty.pdf', $warranty->id) }}" class="btn btn-primary">PDF გადმოწერა</a>
            @if(!$warranty->is_signed)
                <form method="POST" action="{{ route('warranty.sign.sendSms', $warranty->uuid) }}" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-warning">SMS ვერიფიკაციის გაგზავნა</button>
                </form>
                <form method="POST" action="{{ route('warranty.sign.verify', $warranty->uuid) }}" class="mt-3">
                    @csrf
                    <input type="text" name="code" placeholder="შეიყვანეთ SMS კოდი" class="form-control mb-2" required>
                    <button type="submit" class="btn btn-success">ხელმოწერა</button>
                </form>
            @else
                <div class="alert alert-success mt-3">დოკუმენტი უკვე ხელმოწერილია!</div>
            @endif

            @if(session('success'))
                <div class="alert alert-info mt-2">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger mt-2">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
