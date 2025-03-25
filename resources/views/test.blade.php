<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h1 {
            color: #333333;
            font-size: 24px;
        }
        p {
            color: #555555;
            font-size: 16px;
        }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 4px;
            font-size: 16px;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Password Reset Request</h1>
        <p>Click the button below to reset your password. If you did not request a password reset, please ignore this email.</p>
        
        <a href="{{ route('expire-mail-password') }}" class="button">Reset Password</a>
        
        <p class="footer">
            If the button above does not work, copy and paste the following link into your browser: <br>
            <a href="{{ route('expire-mail-password') }}">{{ route('expire-mail-password') }}</a>
        </p>
    </div>
</body>
</html>
