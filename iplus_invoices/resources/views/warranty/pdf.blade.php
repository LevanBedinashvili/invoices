<h2>საგარანტიო დოკუმენტი</h2>
<p>მომხმარებელი: {{ $warranty->first_name }} {{ $warranty->last_name }}</p>
<p>IMEI: {{ $warranty->device_imei_code }}</p>
<p>მოწყობილობა: {{ $warranty->device_name }}</p>
@if($warranty->is_signed)
    <hr>
    <p>
        დოკუმენტი ხელმოწერილია:<br>
        ნომრით: {{ $warranty->signed_phone }}<br>
        დროით: {{ $warranty->signed_at }}<br>
        IP: {{ $warranty->signed_ip }}<br>
        ხელმომწერი: {{ $warranty->signed_name }} {{ $warranty->signed_surname }}
    </p>
@endif
