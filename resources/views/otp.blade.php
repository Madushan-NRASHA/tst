<!DOCTYPE html>
<html>
<head>
    <title>Your OTP Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 500px;
            margin: 50px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #333;
            font-size: 24px;
        }
        p {
            color: #555;
            font-size: 16px;
            line-height: 1.6;
        }
        .otp {
            font-size: 22px;
            font-weight: bold;
            color: #ff5722;
            background: #f8d7da;
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
            margin: 10px 0;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #007bff; /* Bootstrap blue */
            margin-top: 10px;
        }
        .footer {
            font-size: 14px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>OTP Verification</h1>
        <p>Your One-Time Password (OTP) is:</p>
        <p class="otp">{{ $otp }}</p>
        <p>This OTP is valid for <strong>10 minutes</strong>.</p>
        <p>If you did not request this, please ignore this email.</p>
        <div class="footer">
            <p>Regards,</p>
            <p class="company-name">Keen Rabbits Pvt Ltd</p>
        </div>
    </div>
</body>
</html>
