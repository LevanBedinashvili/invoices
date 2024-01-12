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
                                            <label class="form-label">მომხმარებლის მობილურის ნომერი</label>
                                            <input type="number" class="form-control" name="mobile_number" placeholder="შეიყვანეთ მომხმარებლის ტელეფონის ნომერი">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">მომხმარებლის დაბადების თარიღი</label>
                                            <input type="date" class="form-control" name="date_of_birth">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">გადახდის ტიპი</label>
                                            <select id="inputState" name="payment_type_id" class="default-select form-control wide">
                                                @forelse ($get_all_payment_types as $item)
                                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                                @empty
                                                    <option disabled>გადახდის ტიპები არ მოიძებნა</option>
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

        const items = @json(route('getItems'));

        function addNewItem() {
            var itemIndex = document.querySelectorAll('.item').length + 1;
            var itemDiv = document.createElement('div');
            itemDiv.classList.add('item');

            var is_deghege = document.createElement('input');
            is_deghege.type = 'checkbox';
            is_deghege.name = 'items[' + itemIndex + '][is_deghege]';
            itemDiv.appendChild(is_deghege);


            var label = document.createElement('label');
            label.innerText = 'დელეგატი /    ';
            label.appendChild(is_deghege);
            itemDiv.appendChild(label);

            var productSelect = document.createElement('select');
            productSelect.name = 'items[' + itemIndex + '][product_name_code]';
            productSelect.id = "my-select-id";
            productSelect.classList.add('form-control', 'mb-2');

            fetch(items)
                .then(response => response.json())
                .then(data => {
                    data.forEach(product => {
                        var option = document.createElement('option');
                        option.value = product.name+' - '+product.code;;
                        option.text = product.name+' - '+product.code;
                        productSelect.appendChild(option);
                    });
                 window.jQuery('#my-select-id').select2();
            });
            itemDiv.appendChild(productSelect);

            var itemImeiCode = document.createElement('input');
            itemImeiCode.type = 'text';
            itemImeiCode.name = 'items[' + itemIndex + '][device_code]';
            itemImeiCode.placeholder = 'ნივთის IMEI კოდი';
            itemImeiCode.classList.add('form-control', 'mb-2');
            itemImeiCode.style.marginTop = '10px';
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
