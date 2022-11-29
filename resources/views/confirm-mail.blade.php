<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap');

        * {
            font-family: 'Tajawal', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background: #f5f5f5;
            border-top: 5px solid #7da38d;
        }

        img {
            max-width: 200px;
            display: block;
            margin: 40px auto;
        }

        .container {
            line-height: 3em;
            background: white;
            padding: 45px;
            margin: 0 auto;
            text-align: center
        }

        h1 {
            color: #333333;
            font-size: 25px;
            text-align: center;
        }

        p {
            text-align: center;

        }

        a {
            padding: 10px;
            background: #7da38d;
            border-radius: 3px;
            border: none;
            color: white;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <img src="https://cfundsa.com/assets/logo.544c8757.png">
    <div class="container">
        <h1>التحقق من البريد الالكتروني في منصة التمويل الجماعي</h1>
        <p>من فضلك قم بالدخول علي الرابط التالي من اجل التحقق من بريدك الالكتروني</p>
        <a href="http://cfundsa.com/verify-email/{{ $token }}" target="_blank">تأكيد البريد الالكتروني</a>
    </div>
</body>

</html>
