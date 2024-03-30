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
                                            <input type="text" class="form-control" name="personal_number" value="{{ $invoice->personal_number }}" >
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">მომხმარებლის მობილურის ნომერი</label>
                                            <input type="text" class="form-control" name="mobile_number" value="{{ $invoice->mobile_number }}" >
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

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">ფილიალი</label>
                                            <select id="inputState" name="branch_id" class="default-select form-control wide">
                                                <option value="{{ $invoice->branch_id }}" selected>{{ $invoice->branch->branch_name }}</option>
                                                @forelse ($get_all_branches as $item_xx)
                                                    <option value="{{ $item_xx->id }}">{{ $item_xx->branch_name }}</option>
                                                @empty
                                                    <option disabled>ფილიალი არ მოიძებნა</option>
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">კომენტარი</label>
                                            <input type="text" class="form-control" name="comment" value="{{ $invoice->comment }}" >
                                        </div>

                                    </div>

                                    <h5 style="margin-top: 20px;">ინვოისის ნივთები</h5>
                                    <div id="invoice-items">
                                        @foreach ($invoice->items as $item)
                                            <div class="item">
                                                <input type="checkbox" class="form-check-input" name="items[{{ $loop->index }}][is_deghege]" {{ $item->is_deghege ? 'checked' : '' }}>
                                                <label class="form-check-label">დიპლომატიური</label>
                                                <input style="margin-top: 10px;" type="text" class="form-control mb-2" name="items[{{ $loop->index }}][device_name]" value="{{ $item->device_name }}" placeholder="მოწყობილობის დასახელება">
                                                <input style="margin-top: 10px;" type="text" class="form-control mb-2" name="items[{{ $loop->index }}][device_artikuli_code]" value="{{ $item->device_artikuli_code }}" placeholder="მოწყობილობის არტიკული კოდი">
                                                <input style="margin-top: 10px;" type="text" class="form-control mb-2" name="items[{{ $loop->index }}][device_code]" value="{{ $item->device_code }}" placeholder="მოწყობილობის IMEI კოდი">
                                                <input type="text" class="form-control mb-2" name="items[{{ $loop->index }}][device_price]" value="{{ $item->device_price }}" placeholder="მოწყობილობის ფასი">
                                                <select class="form-control mb-2" name="items[{{ $loop->index }}][discount_type]">
                                                    <option value="none">No Discount</option>
                                                    <option value="fixed" {{ $item->discount_type === 1 ? 'selected' : '' }}>ფიქსირებული თანხა</option>
                                                    <option value="percentage" {{ $item->discount_type === 2 ? 'selected' : '' }}>პროცენტი</option>
                                                </select>
                                                <input type="text" class="form-control mb-2" name="items[{{ $loop->index }}][device_discounted_price]" value="{{ $item->device_discounted_price }}" placeholder="ფასდაკლებული ფასი">
                                                <button type="button" class="btn btn-danger mb-2" onclick="removeItem(this)">წაშლა</button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" onclick="addNewItem()" class="btn btn-info">ნივთის დამატება</button>
                                    <br><br>
                                    <div class="mb-3 col-md-6">
                                        <button type="button" onclick="calculateTotal()" class="btn btn-warning">ფასის გამოთვლა</button>
                                        <p style="color: red; margin-top: 3px; display: none;" id="price-text"></p>
                                        <br><br>
                                    </div>
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

            var itemTitle = document.createElement('input');
            itemTitle.type = 'text';
            itemTitle.name = 'items[' + itemIndex + '][device_name]';
            itemTitle.placeholder = 'ნივთის დასახელება';
            itemTitle.classList.add('form-control', 'mb-2');
            itemTitle.style.marginTop = '10px';
            itemDiv.appendChild(itemTitle);


            var itemArtikuliCode = document.createElement('input');
            itemArtikuliCode.type = 'text';
            itemArtikuliCode.name = 'items[' + itemIndex + '][device_artikuli_code]';
            itemArtikuliCode.placeholder = 'ნივთის არტიკული კოდი';
            itemArtikuliCode.classList.add('form-control', 'mb-2');
            itemArtikuliCode.style.marginTop = '10px';
            itemDiv.appendChild(itemArtikuliCode);

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

<script>
    function calculateTotal() {
        let totalSum = 0;

        document.querySelectorAll('.item').forEach(item => {
            const priceInput = item.querySelector('input[name^="items["][name$="][device_price]"]');
            const discountTypeSelect = item.querySelector('select[name^="items["][name$="][discount_type]"]');
            const discountPriceInput = item.querySelector('input[name^="items["][name$="][device_discounted_price]"]');
            const is_deghege = item.querySelector('input[name^="items["][name$="][is_deghege]"]');

            let price = parseFloat(priceInput.value) || 0;
            const discountType = discountTypeSelect.value;
            let discount = parseFloat(discountPriceInput.value) || 0;

            if (is_deghege.checked) {
                price = price / 1.18;
            }

            if (discountType === 'percentage') {
                discount = (discount / 100) * price;
            }

            totalSum += price - discount;
        });

        // Update the total sum wherever you want to display it
        $('#price-text').text('ფასი: ' + totalSum.toFixed(2)).css('display', 'block');
        console.log(totalSum);
    }
</script>
@endsection
