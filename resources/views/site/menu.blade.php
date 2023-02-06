<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>StonksPizza</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex flex-row text-white">
<div class="w-full flex flex-row  justify-between absolute">

    <h1 class="text-4xl">&nbsp;StonksPizza</h1>
    <div class=" text-center">
        @if (Auth::check())
            <p>Hello, {{ Auth::user()->name }}</p>
        @else
            <a class="text-2xl" href="{{ route('login') }}">login/</a>
            <a class="text-2xl" href="{{ route('register') }}">register</a>&nbsp;
        @endif
    </div>
</div>
    <div class="flex h-screen w-3/4 justify-center items-center flex-row flex-wrap bg-gray-500 justify-around  ">
       @foreach($pizza as $pizzas)
           <form method="post" action="{{route('menu.store')}}" class="w-1/4 bg-red-500 border-black flex flex-col text-white text-2xl h-1/2 justify-around">
               @csrf
               <img src="{{URL::asset($pizzas->image)}}">
               <div>
               <div>
               <p> &nbsp;{{$pizzas->naam}}</p>
               <p>&nbsp;prijs: €{{$pizzas->prijs}}</p>
               </div>
                   <br>
               <div class="flex w-full items-center justify-around ">
                   <input type="hidden" id="user_id" name="user_id" value="{{Auth::id()}}" />
                   <input type="hidden" id="pizza_id" name="pizza_id" value="{{$pizzas->id}}" />
                   <input id="stuks" name="stuks" placeholder="stuks" class="number w-1/6 flex items-center text-center text-black" >
               <button type="submit" class="bg-blue-600 w-3/4" >toevoegen</button>
               </div>
               </div>
           </form>
        @endforeach
    </div>
    <div class="w-1/4 flex flex-col items-center bg-red-500 h-screen ">
        <br>
        <br>
        <br>
    <p class="text-xl">winkelwagen</p>
        <div>
            @foreach($winkelwagen as $item)

                <form class="flex" action="{{route('menu.destroy',['winkelwagen' => $item->id])}}" method="post">
                    @method('DELETE')
                    @csrf
                    <p >{{ $item->pizza->naam }} | aantal {{ $item->stuks }}x</p>&nbsp;

                    <button type="submit" class="text-red-900 ">verwijder</button>
                </form>
                <br>
            @endforeach
                <?php $totaalprijs = 0; ?>
                @foreach($winkelwagen as $pizza)
                        <?php
                        $tot =  $pizza->pizza->prijs * $pizza->stuks;
                        $totaalprijs += intval($tot); ?>
                @endforeach
                <?php
                $totprijs = "€".strval($totaalprijs).",00"
                ?>
                <p>{{ $totprijs }}</p>
            <button type= ></button>
        </div>
        <form class="w-full flex justify-center" action="{{route('bestel.create')}}" method="post">
            @csrf
            <input type="hidden" id="user_id" name="user_id" value="{{Auth::id()}}" />
            <input type="hidden" id="totaal" name="totaal" value="{{$totaalprijs}}" />
            <button class="text-white bold bg-blue-500 rounded-3xl w-1/2 h-10 opacity-100">Bestel</button></form>
    </div>
    </div>




</body>
</html>
