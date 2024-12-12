<!-- In resources/views/emails/styled_email.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password OTP</title>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        h1 {
            color: #333;
        }

        p {
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Your Forget Password OTP Is : </h1>
        <div style="text-align: center">{{ $otp }}</div>
        <p>Your OTP Is Valid For 5 Minutes</p>
    </div>
</body>

</html>
