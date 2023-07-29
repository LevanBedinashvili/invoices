@extends('layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
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
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">შეცვალეთ თქვენი ანგარიშის პაროლი</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="{{ route('profile.password') }}" method="post" class="form-valide-with-icon needs-validation" novalidate>
                                @csrf
                                <div class="mb-3">
                                    <label class="text-label form-label" for="validationCustomUsername">ახალი პაროლი</label>
                                    <div class="input-group">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                        <input type="password" class="form-control" id="validationCustomUsername" name="new_password" placeholder="შეიყვანეთ ახალი პაროლი" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-label form-label" for="dz-password">Password *</label>
                                    <div class="input-group transparent-append">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                        <input type="password" class="form-control" id="dz-password" name="retry_password" placeholder="გაიმეორეთ ახალი პაროლი" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn me-2 btn-info">შეცვლა</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
