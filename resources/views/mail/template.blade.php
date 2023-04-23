<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8"><!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <style>
        .main {
            background-color: #e9ecef;
            padding: 32px 0;
        }
        .containter {
            font-size: 16px;
            font-family: Arial, Helvetica, sans-serif;
            width: 740px;
            margin: 0 auto;
            background-color: #fff;
            padding: 32px;
        }
        .text-otp {
            font-size: 18px;
            background-color: blanchedalmond;
        }
        .footer {
            margin-top: 16px;
        }
        .footer-sign {
            margin-top: 8px;
            font-weight: bold;
            text-align: right;
            margin-bottom: 52px;
        }
    </style>

</head>
<body>
    <main>
        <div class="main">
            @yield('contentEmail')
        </div>
    </main>
</body>
</html>
