@extends('layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">ადმინების სია</h4>

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
                            <table id="example" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>სახელი</th>
                                        <th>ელ.ფოსტა</th>
                                        <th>ადმინ როლი</th>
                                        <th>ფილიალი</th>
                                        <th>რედაქტირება</th>
{{--                                        <th>წაშლა</th>--}}
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse ($get_all_users_from_database as $user_item)
                                    <tr>
                                        <td>{{ $user_item->id }}</td>
                                        <td>{{ $user_item->name }}</td>
                                        <td>{{ $user_item->email }}</td>
                                        <td>{{ $user_item->role->role_name }}</td>
                                        <td>{{ $user_item->branch->branch_name }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('users.edit', $user_item->id) }}"
                                                   class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                        class="fas fa-pencil-alt"></i>რედაქტირება</a>
                                            </div>
                                        </td>
{{--                                        <td>--}}
{{--                                            <div class="d-flex">--}}
{{--                                                 <form action="{{ route('users.destroy', $user_item->id) }}" method="post">--}}
{{--                                                    @method('delete')--}}
{{--                                                    @csrf--}}
{{--                                                    <button class="btn btn-danger shadow btn-xs sharp"><i--}}
{{--                                                        class="fa fa-trash"></i>წაშლა</button>--}}
{{--                                                </form>--}}
{{--                                            </div>--}}
{{--                                        </td>--}}
                                    </tr>
                                @empty
                                    <div class="alert alert-danger">
                                        ადმინისტრატორები არ მოიძებნა
                                    </div>
                                @endforelse
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>სახელი</th>
                                    <th>ელ.ფოსტა</th>
                                    <th>ადმინ როლი</th>
                                    <th>რედაქტირება</th>
{{--                                    <th>წაშლა</th>--}}
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container-fluid -->
</div>
@endsection
