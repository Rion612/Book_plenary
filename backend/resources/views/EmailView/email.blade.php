<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email verification</title>
    <link href="{{url('https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css')}}" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

</head>
<body>
    <header>
        <h1 style="background-color: green;padding:20px;text-align:center;color:#fff;">Api test application</h1>
    </header>
    <section>
        <p>Hello Sir, Please verify your email!</p>
        <a href="http://localhost:3000/verify/{{$token}}"
        
        style="background-color: blue;cursor:pointer;padding:10px 20px;border:none;color:white;border-radius:5px;text-decoration:none"
        >verify</a>
        <p><strong>Thank you Sir.</strong></p>
    </section>
</body>
</html>