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
                                            <input type="text" class="form-control" name="personal_number" placeholder="შეიყვანეთ მომხმარებლის პირადი ნომერი">
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
                                            <select id="inputState" name="payment_type_id" class="default-select form-control wide" required>
                                                @forelse ($get_all_payment_types as $item)
                                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                                @empty
                                                    <option disabled>გადახდის ტიპები არ მოიძებნა</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">ფილიალი</label>
                                            <select id="inputState" name="branch_id" class="default-select form-control wide" required>
                                                @forelse ($get_all_branches as $itemx)
                                                    <option value="{{ $itemx->id }}">{{ $itemx->branch_name }}</option>
                                                @empty
                                                    <option disabled>ფილიალი არ მოიძებნა</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">კომენტარი</label>
                                            <input type="text" class="form-control" name="comment">
                                        </div>
                                    </div>

                                    <h5 style="margin-top: 50px;">ინვოისის ნივთები</h5>
                                    <div id="invoice-items">
                                        <!-- JavaScript will add item input fields here dynamically -->
                                    </div>
                                    <button type="button" onclick="addNewItem()" class="btn btn-info">ნივთის დამატება</button>
                                    <br><br>
                                    <div class="mb-3 col-md-6">
                                        <button type="button" onclick="calculateTotal()" class="btn btn-warning">ფასის გამოთვლა</button>
                                        <p style="color: red; margin-top: 3px; display: none;" id="price-text"></p>
                                        <br><br>
                                    </div>
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
        function onDOMContentLoaded() {
            $('.myselectclass').each(function () {
                $(this).select2();
            });
        }
        document.addEventListener("DOMContentLoaded", onDOMContentLoaded);
    </script>

    <script>

        const items = @json(route('getItems'));
        const templateItems = @json(route('getTemplateItems'));

        let totalSum = 0;


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

            var qtyInput = document.createElement('input');
            qtyInput.type = 'number';
            qtyInput.name = 'items[' + itemIndex + '][device_qty]';
            qtyInput.placeholder = 'რაოდენობა';
            qtyInput.classList.add('form-control', 'mb-2');
            qtyInput.value = 1;
            qtyInput.min = 1;
            itemDiv.appendChild(qtyInput);

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

            var templateSelect = document.createElement('select');
            templateSelect.name = 'items[' + itemIndex + '][template_item]';
            templateSelect.id = "my-select-id";
            templateSelect.classList.add('form-control', 'mb-2');
            fetch(templateItems)
                .then(response => response.json())
                .then(data => {
                    data.forEach(template => {
                        var option = document.createElement('option');
                        option.value = template.id
                        option.text = template.title
                        templateSelect.appendChild(option);
                    });
            });
            itemDiv.appendChild(templateSelect);

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

    <script>
    function calculateTotal() {
        let totalSum = 0;

        document.querySelectorAll('.item').forEach(item => {
            const priceInput = item.querySelector('input[name^="items["][name$="][device_price]"]');
            const qtyInput = item.querySelector('input[name^="items["][name$="][device_qty]"]');
            const discountTypeSelect = item.querySelector('select[name^="items["][name$="][discount_type]"]');
            const discountPriceInput = item.querySelector('input[name^="items["][name$="][device_discounted_price]"]');
            const is_deghege = item.querySelector('input[name^="items["][name$="][is_deghege]"]');

            let price = parseFloat(priceInput.value) || 0;
            const quantity = parseInt(qtyInput.value) || 1; // Default quantity to 1 if not specified
            const discountType = discountTypeSelect.value;
            let discount = parseFloat(discountPriceInput.value) || 0;

            if (is_deghege.checked) {
                price = price / 1.18;
            }

            let totalPrice = price * quantity;

            if (discountType === 'percentage') {
                discount = (discount / 100) * totalPrice;
            } else if (discountType === 'fixed') {
                discount = discount;
            } else {
                discount = 0;
            }

            totalSum += totalPrice - discount;
        });

        // Update the total sum wherever you want to display it
        $('#price-text').text('ფასი: ' + totalSum.toFixed(2)).css('display', 'block');
        console.log(totalSum);
    }
</script>
@endsection
