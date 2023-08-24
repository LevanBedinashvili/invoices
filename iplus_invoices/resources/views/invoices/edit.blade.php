@extends('layouts.app')

@section('content')
    <div class="content-body" style="margin-bottom: 100px;">
        <div class="container-fluid">
            <!-- row -->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">ინვოისის რედაქტირება</h4>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form action="{{ route('invoice.update', $invoice->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
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
                                            <input type="text" class="form-control" name="first_name" value="{{ $invoice->first_name }}" required>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">მომხმარებლის გვარი</label>
                                            <input type="text" class="form-control" name="last_name" value="{{ $invoice->last_name }}" required>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">მომხმარებლის პირადი ნომერი</label>
                                            <input type="text" class="form-control" name="personal_number" value="{{ $invoice->personal_number }}" required>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">მომხმარებლის მობილურის ნომერი</label>
                                            <input type="text" class="form-control" name="mobile_number" value="{{ $invoice->mobile_number }}" required>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">მომხმარებლის დაბადების თარიღი</label>
                                            <input type="date" class="form-control" name="date_of_birth" value="{{ $invoice->date_of_birth }}">
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">გადახდის ტიპი</label>
                                            <select id="inputState" name="payment_type_id" class="default-select form-control wide">
                                                <option value="{{ $invoice->payment_type_id }}" selected>{{ $invoice->payment_type->title }}</option>
                                                @forelse ($get_all_payment_types as $item_x)
                                                    <option value="{{ $item_x->id }}">{{ $item_x->title }}</option>
                                                @empty
                                                    <option disabled>გადახდის ტიპი არ მოიძებნა</option>
                                                @endforelse
                                            </select>
                                        </div>

                                    </div>

                                    <h5 style="margin-top: 20px;">ინვოისის ნივთები</h5>
                                    <div id="invoice-items">
                                        @foreach ($invoice->items as $item)
                                            <div class="item">
                                                <input type="checkbox" class="form-check-input" name="items[{{ $loop->index }}][is_deghege]" {{ $item->is_deghege ? 'checked' : '' }}>
                                                <label class="form-check-label">დღგ</label>
                                                <input type="text" class="form-control mb-2" name="items[{{ $loop->index }}][device_artikuli_code]" value="{{ $item->device_artikuli_code }}" placeholder="მოწყობილობის არტიკული კოდი">
                                                <input type="text" class="form-control mb-2" name="items[{{ $loop->index }}][device_name]" value="{{ $item->device_name }}" placeholder="მოწყობილობის დასახელება">
                                                <input type="number" class="form-control mb-2" name="items[{{ $loop->index }}][device_code]" value="{{ $item->device_code }}" placeholder="მოწყობილობის IMEI კოდი">
                                                <input type="number" class="form-control mb-2" name="items[{{ $loop->index }}][device_price]" value="{{ $item->device_price }}" placeholder="მოწყობილობის ფასი">
                                                <input type="number" class="form-control mb-2" name="items[{{ $loop->index }}][device_discounted_price]" value="{{ $item->device_discounted_price }}" placeholder="ფასდაკლებული ფასი">
                                                <button type="button" class="btn btn-danger mb-2" onclick="removeItem(this)">წაშლა</button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" onclick="addNewItem()" class="btn btn-info">ნივთის დამატება</button>
                                    <br><br>

                                    <button type="submit" class="btn btn-primary">ინვოისის რედაქტირება</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // JavaScript function to add new item input fields
        function addNewItem() {
            var itemIndex = document.querySelectorAll('.item').length + 1;
            var itemDiv = document.createElement('div');
            itemDiv.classList.add('item');

            var is_deghege = document.createElement('input');
            is_deghege.type = 'checkbox';
            is_deghege.name = 'items[' + itemIndex + '][is_deghege]';
            itemDiv.appendChild(is_deghege);

            var label = document.createElement('label');
            label.innerText = 'დღგ /    ';
            label.appendChild(is_deghege);
            itemDiv.appendChild(label);

            var device_artikuli_code = document.createElement('input');
            device_artikuli_code.type = 'text';
            device_artikuli_code.name = 'items[' + itemIndex + '][device_artikuli_code]';
            device_artikuli_code.placeholder = 'ნივთის არტიკული კოდი';
            device_artikuli_code.classList.add('form-control', 'mb-2');
            itemDiv.appendChild(device_artikuli_code);

            var itemNameInput = document.createElement('input');
            itemNameInput.type = 'text';
            itemNameInput.name = 'items[' + itemIndex + '][device_name]';
            itemNameInput.placeholder = 'ნივთის დასახელება';
            itemNameInput.classList.add('form-control', 'mb-2');
            itemDiv.appendChild(itemNameInput);

            var itemImeiCode = document.createElement('input');
            itemImeiCode.type = 'text';
            itemImeiCode.name = 'items[' + itemIndex + '][device_code]';
            itemImeiCode.placeholder = 'ნივთის IMEI კოდი';
            itemImeiCode.classList.add('form-control', 'mb-2');
            itemDiv.appendChild(itemImeiCode);

            var priceInput = document.createElement('input');
            priceInput.type = 'text';
            priceInput.name = 'items[' + itemIndex + '][device_price]';
            priceInput.placeholder = 'ფასი';
            priceInput.classList.add('form-control', 'mb-2');
            itemDiv.appendChild(priceInput);

            var discountPrice = document.createElement('input');
            discountPrice.type = 'text';
            discountPrice.name = 'items[' + itemIndex + '][device_discounted_price]';
            discountPrice.placeholder = 'ფასდაკლებული თანხა';
            discountPrice.classList.add('form-control', 'mb-2');
            itemDiv.appendChild(discountPrice);

            var removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.innerText = 'წაშლა';
            removeButton.classList.add('btn', 'btn-danger', 'mb-2');
            removeButton.onclick = function() {
                itemDiv.remove();
            };
            itemDiv.appendChild(removeButton);

            document.getElementById('invoice-items').appendChild(itemDiv);
        }

        function removeItem(btn) {
            btn.closest('.item').remove();
        }
    </script>


@endsection
