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
                                                <label class="form-check-label">დიპლომატიური</label>
                                                <select id="my-select-id2" class="default-select form-control wide myselectclass" name="items[{{ $loop->index }}][product_name_code]">
                                                    <option value="{{ $item->product->name }} - {{ $item->product->code }} - {{ $item->product->id }}" selected>{{ $item->product->name }} - {{ $item->product->code }} - {{ $item->product->id }}</option>
                                                    @forelse ($get_products as $product_item)
                                                    <option value="{{ $product_item->name }} - {{ $product_item->code }} - {{ $product_item->id }}">{{ $product_item->name }} - {{ $product_item->code }} - {{ $product_item->id }}</option>
                                                    @empty
                                                    <option disabled>პროდუქტები არ მოიძებნა</option>
                                                    @endforelse
                                                </select>
                                                <input style="margin-top: 10px;" type="number" class="form-control mb-2" name="items[{{ $loop->index }}][device_code]" value="{{ $item->device_code }}" placeholder="მოწყობილობის IMEI კოდი">
                                                <input type="number" class="form-control mb-2" name="items[{{ $loop->index }}][device_price]" value="{{ $item->device_price }}" placeholder="მოწყობილობის ფასი">
                                                <select class="form-control mb-2" name="items[{{ $loop->index }}][discount_type]">
                                                    <option value="none">No Discount</option>
                                                    <option value="fixed" {{ $item->discount_type === 1 ? 'selected' : '' }}>ფიქსირებული თანხა</option>
                                                    <option value="percentage" {{ $item->discount_type === 2 ? 'selected' : '' }}>პროცენტი</option>
                                                </select>
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
        function onDOMContentLoaded() {
            $('.myselectclass').each(function () {
                $(this).select2();
            });
        }
        document.addEventListener("DOMContentLoaded", onDOMContentLoaded);
    </script>

    <script>

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
            label.innerText = 'დიპლომატიური /    ';
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
                        option.value = product.name+' - '+product.code+' - '+product.id;
                        option.text = product.name+' - '+product.code+' - '+product.id;
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

        function removeItem(btn) {
            btn.closest('.item').remove();
        }
    </script>
@endsection
