@extends('layouts.app')

@section('content')
    <div class="content-body" style="margin-bottom: 100px;">
        <div class="container-fluid">

            <!-- row -->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">ახალი ინვოისი</h4>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form action="{{ route('invoice.store') }}" method="post">
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
                                            <input type="text" class="form-control" name="first_name" placeholder="შეიყვანეთ მომხმარებლის სახელი" value="{{ $get_customer_info->first_name }}">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">მომხმარებლის გვარი</label>
                                            <input type="text" class="form-control" name="last_name" placeholder="შეიყვანეთ მომხმარებლის გვარი" value="{{ $get_customer_info->last_name }}">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">მომხმარებლის პირადი ნომერი</label>
                                            <input type="number" class="form-control" name="personal_number" placeholder="შეიყვანეთ მომხმარებლის პირადი ნომერი" value="{{ $get_customer_info->personal_number }}">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">მომხმარებლის მობილურის ნომერი</label>
                                            <input type="number" class="form-control" name="mobile_number" placeholder="შეიყვანეთ მომხმარებლის ტელეფონის ნომერი" value="{{ $get_customer_info->mobile_number }}">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">მომხმარებლის დაბადების თარიღი</label>
                                            <input type="date" class="form-control" name="date_of_birth" value="{{ $get_customer_info->date_of_birth }}">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">გადახდის ტიპი</label>
                                            <select id="inputState" name="payment_type_id" class="default-select form-control wide">
                                            <option value="{{ $get_customer_info->payment_type_id }}" selected>{{ $get_customer_info->payment_type->title }}</option>
                                                @forelse ($get_all_payment_types as $item_x)
                                                    <option value="{{ $item_x->id }}">{{ $item_x->title }}</option>
                                                @empty
                                                    <option disabled>გადახდის ტიპი არ მოიძებნა</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <h5 style="margin-top: 50px;">ინვოისის ნივთები</h5>
                                    <div id="invoice-items">
                                        <!-- JavaScript will add item input fields here dynamically -->
                                    </div>
                                    <button type="button" onclick="addNewItem()" class="btn btn-info">ნივთის დამატება</button>
                                    <br><br>

                                    <button type="submit" class="btn btn-primary">ინვოისის დამატება</button>
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
            label.innerText = 'დელეგატი /    '; // Replace 'Label Text' with the actual label text
            label.appendChild(is_deghege); // Append the checkbox as a child of the label
            itemDiv.appendChild(label); // Append the label (with the checkbox) to the container

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

            var discountTypeSelect = document.createElement('select');
            discountTypeSelect.name = 'items[' + itemIndex + '][discount_type]';
            discountTypeSelect.classList.add('form-control', 'mb-2');
            discountTypeSelect.innerHTML = `
                <option value="none">No Discount</option>
                <option value="fixed">ფიქსირებული თანხა</option>
                <option value="percentage">პროცენტი</option>
            `;
            itemDiv.appendChild(discountTypeSelect);

            var discountPrice = document.createElement('input');
            discountPrice.type = 'text';
            discountPrice.name = 'items[' + itemIndex + '][device_discounted_price]';
            discountPrice.placeholder = 'ფასდაკლება';
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
    </script>
@endsection
