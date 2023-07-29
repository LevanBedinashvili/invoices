@extends('layouts.app')
@section('content')
<div class="content-body">
    <div class="container-fluid">

        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">ადმინისტრატორის დამატება</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="{{ route('warranty.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    @if (session('Error'))
                                    <div class="alert alert-danger">
                                        {{ session('Error') }}
                                    </div>
                                    @endif
                                    @if (session('Success'))
                                    <div class="alert alert-success">
                                        {{ session('Success') }}
                                    </div>
                                    @endif
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">მომხმარებლის სახელი</label>
                                        <input type="text" class="form-control" name="first_name" placeholder="შეიყვანეთ მომხმარებლის სახელი">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">მომხმარებლის გვარი</label>
                                        <input type="text" class="form-control" name="last_name" placeholder="შეიყვანეთ მომხმარებლის გვარი">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">მომხმარებლის პირადი ნომერი</label>
                                        <input type="number" class="form-control" name="personal_number" placeholder="შეიყვანეთ მომხმარებლის პირადი ნომერი">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">პროდუქტის IMEI კოდი</label>
                                        <input type="number" class="form-control" name="device_imei_code" placeholder="შეიყვანეთ პროდუქტის IMEI კოდი">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">აირჩიეთ ფილიალი</label>
                                        <select id="inputState" name="branch_id" class="default-select form-control wide">
                                            @forelse ($get_all_branches_from_database as $branch_item)
                                            <option value="{{ $branch_item->id }}">{{ $branch_item->branch_name }}</option>
                                            @empty
                                            <option disabled>ფილიალები არ მოიძებნა</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-warning">საგარანტიოს დამატება</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div
@endsection
