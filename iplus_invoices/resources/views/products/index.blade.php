@extends('layouts.app')
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">პროდუქტები</h4>
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
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="display table" >
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>სახელი</th>
                                        <th>კოდი</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($get_all_products as $product_item)
                                        <tr>
                                            <td>{{ $product_item->id }}</td>
                                            <td>{{ $product_item->name }}</td>
                                            <td>{{ $product_item->code }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('product.edit', $product_item->id) }}"
                                                       class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                            class="fas fa-pencil-alt"></i>რედაქტირება</a>

{{--                                                    <form action="{{ route('branch.destroy', $branch_item->id) }}" method="post">--}}
{{--                                                        @method('delete')--}}
{{--                                                        @csrf--}}
{{--                                                        <button class="btn btn-danger shadow btn-xs sharp"><i--}}
{{--                                                                class="fa fa-trash"></i>წაშლა</button>--}}
{{--                                                    </form>--}}
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <div class="alert alert-danger">
                                            პროდუქტები არ მოიძებნა
                                        </div>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- container-fluid -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">პროდუქტის დამატება</h4>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form action="{{ route('product.store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label class="form-label">პროდუქტის დასახელება</label>
                                            <input type="text" class="form-control" name="name" placeholder="შეიყვანეთ პროდუქტის დასახელება">
                                        </div>

                                        <div class="mb-3 col-md-12">
                                            <label class="form-label">პროდუქტის კოდი</label>
                                            <input type="text" class="form-control" name="code" placeholder="შეიყვანეთ პროდუქტის კოდი">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">პროდუქტის დამატება</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
