<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
<header>
        <h1 style="background-color: green;padding:20px;text-align:center;color:#fff;">Reset you password</h1>
    </header>
    <section>
        <p>Hello Sir, Please, To reset your password, Click below!</p>
        <a href="http://localhost:3000/reset/password/{{$token}}"
        
        style="background-color: blue;cursor:pointer;padding:10px 20px;border:none;color:white;border-radius:5px;text-decoration:none"
        >Reset password</a>
        <p><strong>Thank you Sir.</strong></p>
    </section>
</body>
</html>