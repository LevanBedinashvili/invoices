@extends('layouts.app')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        @if(Auth::user()->role_id == 1)
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">საგარანტიოს მოძებნა</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="{{ route('filter.warranty_search') }}" method="get">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">პროდუქტის იმეი კოდი</label>
                                        <input type="text" class="form-control" name="device_imei_code" placeholder="ინვოისის ნომერი">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">მომხმარებლის პირადი ნომერი</label>
                                        <input type="text" class="form-control" name="personal_number" placeholder="მომხმარებლის პირადი ნომერი">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">მომხმარებლის სახელი</label>
                                        <input type="text" class="form-control" name="first_name" placeholder="მომხმარებლის სახელი">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">მომხმარებლის გვარი</label>
                                        <input type="text" class="form-control" name="last_name" placeholder="მომხმარებლის გვარი">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-info">მოძებნა</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif


    </div>
    <!-- container-fluid -->
</div>


    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">საგარანტიოს სია</h4>

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
                                <table id="examplec" class="display table" style="min-width: 845px">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ავტორი</th>
                                        <th>სახელი, გვარი</th>
                                        <th>პირადი ნომერი</th>
                                        <th>პროდუქტის IMEI კოდი</th>
                                        <th>ფილიალი</th>
                                        <th>თარიღი</th>
                                        <th>სტატუსი</th>
                                        <th>ამობეჭდვა</th>
                                        <th>რედაქტირება</th>
                                        <th>SMS გაგზავნა</th>
{{--                                        <th>წაშლა</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($get_all_warranty_from_database as $warranty_item)
                                        <tr>
                                            <td>{{ $warranty_item->id }}</td>
                                            <td>{{ $warranty_item->user->name }}</td>
                                            <td>{{ $warranty_item->first_name }} {{ $warranty_item->last_name }}</td>
                                            <td>{{ $warranty_item->personal_number }}</td>
                                            <td>{{ $warranty_item->device_imei_code }}</td>
                                            <td>{{ $warranty_item->branch->branch_name }}</td>
                                            <td>{{ $warranty_item->created_at }}</td>
                                            <td>
                                                @if($warranty_item->is_signed)
                                                    <span style="color: #22c55e; font-weight: 600;">ხელმოწერილია</span>
                                                @else
                                                    <span style="color: #ef4444; font-weight: 600;">გაგზავნილი</span>
                                                @endif
                                            </td>
                                            <td><a href="{{ route('warranty.show', $warranty_item->id) }}" class="btn btn-info">საგარანტიო</a></td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('warranty.edit', $warranty_item->id) }}"
                                                       class="btn btn-primary shadow btn-xs sharp me-1">რედაქტირება</a>
                                                </div>
                                            </td>
                                            <td>
                                                <form method="POST" action="{{ route('warranty.sendSignSms', $warranty_item->id) }}" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning btn-xs">SMS გაგზავნა</button>
                                                </form>
                                            </td>
{{--                                            <td>--}}
{{--                                                <div class="d-flex">--}}
{{--                                                    <form action="{{ route('warranty.destroy', $warranty_item->id) }}" method="post">--}}
{{--                                                        @method('delete')--}}
{{--                                                        @csrf--}}
{{--                                                        <button class="btn btn-danger shadow btn-xs sharp"><i--}}
{{--                                                            class="fa fa-trash"></i>წაშლა</button>--}}
{{--                                                    </form>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
                                        </tr>
                                    @empty
                                        <div class="alert alert-danger">
                                            მონაცემთა ბაზაში არ მოიძებნა ინფორმაცია
                                        </div>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $get_all_warranty_from_database->links() }}

                        </div>
                    </div>
                </div>
            </div>
            <button type="button" id="export_button" class="btn btn-dark" style="margin-top: 10px;">ექსელში გატანა</button>

        </div>
        <!-- container-fluid -->
    </div>

    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script>
    function html_table_to_excel(type)
        {
            var data = document.getElementById('examplec');

            var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});

            const dateObject = new Date();

            let date = dateObject.toUTCString();

            XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });

            XLSX.writeFile(file, 'warranties.' + type);
        }

        const export_button = document.getElementById('export_button');

        export_button.addEventListener('click', () =>  {
            html_table_to_excel('xlsx');
        });
</script>
@endsection
