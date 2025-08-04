<!DOCTYPE html>
<html lang="ka">
<head>
    <meta charset="UTF-8">
    <title>საგარანტიო დოკუმენტი</title>
    <style>
        @page { size: A4; margin: 0; }
        html, body { width: 100%; height: 100%; margin: 0; padding: 0; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; background: #fff; }
        .pdf-container {
            width: 99%;
            max-width: 800px;
            margin: 2px auto;
            background: #fff;
            border-radius: 6px;
            padding: 10px 12px;
            box-sizing: border-box;
            page-break-inside: avoid;
        }
        h2 { text-align: center; font-size: 13px; margin-bottom: 10px; }
        .section { margin-bottom: 5px; }
        .label { font-weight: bold; color: #222; }
        .signature { margin-top: 12px; }
        .desc-box {
            font-size: 9px;
            line-height: 1.05;
            background: #f7f7f7;
            border-radius: 4px;
            padding: 5px 7px;
            margin-top: 2px;
        }
    </style>
</head>
<body>
    <div class="pdf-container">
        <h2>საგარანტიო დოკუმენტი</h2>
        <div class="section">
            <span class="label">გარანტიის ვადა:</span> {{ $get_warranty->template->warranty_lenght }}<br>
            <span class="label">თარიღი:</span> {{ $get_warranty->created_at }}<br>
            <span class="label">პირადი ნომერი:</span> {{ $get_warranty->personal_number }}<br>
        </div>
        <div class="section">
            <span class="label">სახელი, გვარი:</span> {{ $get_warranty->first_name }} {{ $get_warranty->last_name }}<br>
            <span class="label">პროდუქტის დასახელება:</span> {{ $get_warranty->device_name }}<br>
            <span class="label">პროდუქტის IMEI:</span> {{ $get_warranty->device_imei_code }}<br>
        </div>
        <div class="section">
            <span class="label">აღწერა:</span>
            <div class="desc-box">
                {!! $get_warranty->template->description !!}
            </div>
        </div>
        <div class="signature">
            @if($get_warranty->is_signed)
                <hr>
                <p>
                    დოკუმენტი ხელმოწერილია:<br>
                    ნომრით: {{ $get_warranty->signed_phone }}<br>
                    დროით: {{ $get_warranty->signed_at }}<br>
                    {{-- IP: {{ $get_warranty->signed_ip }}<br> --}}
                    ხელმომწერი: {{ $get_warranty->signed_name }} {{ $get_warranty->signed_surname }}
                </p>
            @endif
        </div>
    </div>
</body>
</html>
