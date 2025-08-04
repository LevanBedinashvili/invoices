<!DOCTYPE html>
<html lang="ka">
<head>
    <meta charset="UTF-8">
    <title>ინვოისი - ხელმოწერა</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.web-fonts.ge/fonts/archyedt-bold/css/archyedt-bold.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
            min-height: 100vh;
            font-family: "ArchyEDT-Bold", sans-serif !important;
        }
        .invoice-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .invoice-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(60, 80, 180, 0.10);
            padding: 32px 18px;
        }
        .invoice-title {
            font-size: 2rem;
            font-weight: 700;
            color: #3b3b3b;
            text-align: center;
            margin-bottom: 18px;
        }
        .invoice-details {
            font-size: 1.1rem;
            color: #555;
            background: #f3f6fd;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 16px;
            text-align: center;
        }
        .invoice-status {
            font-size: 1.1rem;
            font-weight: 500;
            color: #4f46e5;
            text-align: center;
            margin-bottom: 16px;
        }
        .invoice-success {
            text-align: center;
            color: #22c55e;
            font-size: 1.2rem;
            margin-bottom: 16px;
        }
        .invoice-pdf-btn {
            display: block;
            width: 100%;
            text-align: center;
            padding: 14px;
            border-radius: 8px;
            background: linear-gradient(90deg, #6366f1 0%, #60a5fa 100%);
            color: #fff;
            font-size: 1.15rem;
            font-weight: 600;
            text-decoration: none;
            margin-top: 10px;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.08);
            transition: background 0.2s;
        }
        .invoice-pdf-btn:hover {
            background: linear-gradient(90deg, #60a5fa 0%, #6366f1 100%);
        }
    </style>
</head>
<body>
<div class="invoice-container">
    <div class="invoice-card">
        <img src="{{ asset(path: 'template/azx_crat-75.jpg') }}" alt="" height="50" width="150">
        <div class="invoice-title">ინვოისი</div>
        <div class="invoice-details">
            <strong>ინვოისის ნომერი:</strong> {{ $invoice->invoice_number }}<br>
            <strong>თანხა:</strong> {{ $invoice->total_price }} ლარი
        </div>
        <div class="invoice-status">
            სტატუსი: {{ $invoice->is_signed ? 'ხელმოწერილია' : 'გადაგზავნილია' }}
        </div>
        @if(!$invoice->is_signed)
            <form method="POST" action="{{ route('invoice.sign.verify', $invoice->id) }}">
                @csrf
                <div class="mb-3">
                    <label for="signed_name" class="form-label">სახელი</label>
                    <input type="text" name="signed_name" id="signed_name" class="form-control form-control-lg" required placeholder="თქვენი სახელი">
                </div>
                <div class="mb-3">
                    <label for="signed_surname" class="form-label">გვარი</label>
                    <input type="text" name="signed_surname" id="signed_surname" class="form-control form-control-lg" required placeholder="თქვენი გვარი">
                </div>
                <button type="submit" class="btn btn-primary w-100 btn-lg">თანხმობა / ხელმოწერა</button>
            </form>
        @else
            <div class="invoice-success">
                დოკუმენტი წარმატებით ხელმოწერილია!
            </div>
            <a href="{{ route('invoice.downloadPdf', $invoice->id) }}" class="invoice-pdf-btn">PDF გადმოწერა</a>
        @endif
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
