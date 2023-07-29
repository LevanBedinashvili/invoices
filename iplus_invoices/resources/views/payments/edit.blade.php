@extends('layouts.app')
@section('content')
<div class="content-body">
    <div class="container-fluid">

        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">რედაქტირება</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="{{ route('payment.update', $edit_payment_type->id) }}" method="post">
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
                                        <label class="form-label">გადახდის ტიპი</label>
                                        <input type="text" class="form-control" name="title" value="{{ $edit_payment_type->title }}" placeholder="შეიყვანეთ ფილიალის დასახელება">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">რედაქტირება</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div
@endsection
