@extends('layouts.app')
@section('content')
<div class="content-body">
    <div class="container-fluid">

        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">მონაცემების ცვლილება</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="{{ route('warranty.update', $edit_warranty_data->id) }}" method="post">
                                @method('patch')
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
                                        <input type="text" class="form-control" name="first_name" value="{{ $edit_warranty_data->first_name }}" placeholder="შეიყვანეთ მომხმარებლის სახელი" value="">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">მომხმარებლის გვარი</label>
                                        <input type="text" class="form-control" name="last_name" value="{{ $edit_warranty_data->last_name }}" placeholder="შეიყვანეთ მომხმარებლის გვარი">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">მომხმარებლის პირადი ნომერი</label>
                                        <input type="text" class="form-control" name="personal_number" value="{{ $edit_warranty_data->personal_number }}" placeholder="შეიყვანეთ მომხმარებლის პირადი ნომერი">
                                         </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">პროდუქტის IMEI კოდი</label>
                                        <input type="text" class="form-control" name="device_imei_code" value="{{ $edit_warranty_data->device_imei_code }}" placeholder="შეიყვანეთ პროდუქტის IMEI კოდი">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">პროდუქტის დასახელება</label>
                                        <input type="text" class="form-control" name="device_name" value="{{ $edit_warranty_data->device_name }}" placeholder="შეიყვანეთ პროდუქტის დასახელება">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">აირჩიეთ ფილიალი</label>
                                        <select id="inputState" name="branch_id" class="default-select form-control wide">
                                            <option value="{{ $edit_warranty_data->branch_id }}" selected>{{ $edit_warranty_data->branch->branch_name }}</option>
                                            @forelse ($get_all_branches_from_database as $branch_item)
                                            <option value="{{ $branch_item->id }}">{{ $branch_item->branch_name }}</option>
                                            @empty
                                            <option disabled>ფილიალები არ მოიძებნა</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">აირჩიეთ დიზაინი</label>
                                        <select id="inputState" name="template_id" class="default-select form-control wide">
                                            <option value="{{ $edit_warranty_data->template_id }}" selected>{{ $edit_warranty_data->template->title }}</option>
                                            @forelse ($get_template as $template_item)
                                            <option value="{{ $template_item->id }}">{{ $template_item->title }}</option>
                                            @empty
                                            <option disabled>დიზაინი არ მოიძებნა</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-info">რედაქტირება</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div
@endsection
