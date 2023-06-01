@extends ('templates.all')
@push('css')
    <link rel="stylesheet" href="/cart.css">
@endpush
@section('content')
<div class=scroll>
    <div class="catbutt">
    <?php
    $total = 0;
    ?>
        @foreach($tovars as $x)
        <div class="cor1">
            <div class="t2">
                <img class="donut1" src="{{$x->image}}" alt="{{$x->name}}">
            </div>
            <div class="function">
                <a href="/delete/{{$x->id}}">
                    <p>x {{$x->name}}</p>
                </a>
                @if($x->weight_id == 1)
                <p class="price">{{$price[$x->id]}}грн/{{$numbers[$x->id]}}{{$x->weight->name}}</p>
                @elseif($x->weight_id == 2)
                <p class="price">{{$price[$x->id]}}грн/{{$numbers[$x->id]}}00{{$x->weight->name}}</p>
                @endif
                <div class="butt1">
                    @if($x->weight_id == 1)
                    <p>{{$numbers[$x->id]}}</p>
                     @elseif($x->weight_id == 2)
                    <p>{{$numbers[$x->id]}}00</p>
                    @endif
                </div>
            </div>
        </div>
        <?php
        $total += $price[$x->id];?>
        @endforeach
       <p class="total">До сплати {{$total}}грн</p>
    </div>
        @if($errors->any())
        <div>
            <ul style="list-style-type: none; display: contents; color: #850000; margin-left: 10px;">
            @foreach($errors->all() as $error)
            <li style="padding: 0; margin: 0;text-align: center;">{{ $error }}</li>
            @endforeach
            </ul>
        </div>
        @endif
        <form action="/cart/submit" method="post" class="ugly">
            @csrf
            <input class="data" type="text" name="name" placeholder="Ім'я">
            <input class="data" type="text" name="phone" placeholder="Номер телефону">
            <button class="knopka" type="submit">Оформити замовлення</button>
        </form>
</div>
@endsection