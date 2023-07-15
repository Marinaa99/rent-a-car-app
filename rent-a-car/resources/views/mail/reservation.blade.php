<!DOCTYPE html>
<html lang="{{str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Reservation Confirmation</title>

</head>

<body>
<div style="max-width: 600px; margin: 0 auto; padding: 20px;">
    <h2 style="text-align: center; color: #4CAF50;">Car Rental Confirmation</h2>
    <p>Dear Customer,</p>
    <p>We are delighted to confirm your car rental reservation.</p>

    <h3>Reservation Details:</h3>
    <ul>

        <li><strong><span style="color: #4CAF50;">Car Type:</span></strong> {{$car->brand}}</li>
        <li><strong><span style="color: #4CAF50;">Car Model:</span></strong> {{$car->model}}</li>
        <li><strong><span style="color: #4CAF50;">Daily Price:</span></strong> {{$car->daily_price}}$</li>

    </ul>

    <p>Please ensure that you bring the following documents with you when picking up the car:</p>
    <ul>
        <li>Valid driver's license</li>
        <li>Proof of identification</li>
        <li>Proof of reservation (this email)</li>
    </ul>

    <p>If you have any questions or need to modify your reservation, please contact our customer service team at Car Rental Company Phone or via email.</p>

    <p>Thank you for choosing Car Rental Company.</p>
    <br>
    <br>
    <p>Best regards,</p>
    <p>The Car Rental Company Team</p>
</div>
</body>
</html>
