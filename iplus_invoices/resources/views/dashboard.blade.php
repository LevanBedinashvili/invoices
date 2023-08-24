@extends('layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">ნოთიფიკაციები</h4>
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
                                    <th>ავტორი</th>
                                    <th>მესიჯი</th>
                                    <th>სტატუსი</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($get_all_notifications as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->message }}</td>
                                        <td>{{ $item->is_seen == 1 ? "ნანახია" : "არ არის ნანახი" }}</td>
                                        <td>
                                            <form action="{{ route('notification.mark_seen', $item->id) }}" method="post">
                                                @csrf
                                                @method('put')
                                                <input type="submit" class="btn btn-primary btn-small" value="წაკითხულად მონიშვნა">
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger">
                                        ნოთიფიკაციები არ მოიძებნა
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
</div>
@endsection
