<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
@vite('resources/css/app.css')
<body class="bg-black flex flex-col h-screen justify-center items-center flex-col">
<div class="  bg-black opacity-50 text-white text-4xl w-1/2  text-center ">
    @foreach($status as $stat)
        @if($stat->status == 'bezorgd')

        @else
            <p class="p-4">Uw bestelling is: {{$stat->status}}</p>
        @endif
    @endforeach

</div>
</body>
</html>
