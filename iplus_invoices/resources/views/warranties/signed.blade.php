@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">საგარანტიო ხელმოწერილია</div>
        <div class="card-body">
            <h5>მადლობა! დოკუმენტი წარმატებით ხელმოწერილია.</h5>
            <p>დრო: {{ $warranty->signed_at }}</p>
            <p>IP: {{ $warranty->signed_ip }}</p>
            <p>მობილური: {{ $warranty->signed_phone }}</p>
            <a href="{{ route('warranty.pdf', $warranty->id) }}" class="btn btn-primary">PDF გადმოწერა</a>
        </div>
    </div>
</div>
@endsection
