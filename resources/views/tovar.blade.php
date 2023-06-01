@extends ('templates.all')
@push('css')
    <link rel="stylesheet" href="/tovar.css">
@endpush
@section('content')
<div class="scroll">
    <div class="prod">
        <div class="colu1">
            <div class="tag1">
                <p class="name1">{{$tovar_page[0]->name}}</p>
                <div class="line1"></div>
            </div>
            <div class="tovar">
                <img class="tovar1" src="{{$tovar_page[0]->image}}" alt="donut">
            </div>
        </div>
        <div class="colu">
            <div class="butt1">
                @if($tovar_page[0]->weight_id == 1)
                <p class="weight"> 1 </p>
                @elseif($tovar_page[0]->weight_id == 2)
                <p class="weight">100</p>
                @endif
                <a href="/tovar/cart/{{$tovar_page[0]->id}}">
                <div class="kosh">
                    <svg xmlns="http://www.w3.org/2000/svg" width=53% height=53% viewBox="0 0 24 24">
                        <g fill="none" fill-rule="evenodd">
                            <path
                                d="M24 0v24H0V0h24ZM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01l-.184-.092Z" />
                            <path fill="#d6cbc1"
                                d="M10.464 3.282a2 2 0 0 1 2.964-.12l.108.12L17.468 8h2.985a1.49 1.49 0 0 1 1.484 1.655l-.092.766l-.1.74l-.082.554l-.095.595l-.108.625l-.122.648l-.136.661c-.072.333-.149.667-.232.998a21.018 21.018 0 0 1-.832 2.584l-.221.54l-.214.488l-.202.434l-.094.194l-.249.49c-.32.61-.924.97-1.563 1.022l-.16.006H6.555a1.929 1.929 0 0 1-1.71-1.008l-.232-.45l-.18-.37a20.09 20.09 0 0 1-.095-.205l-.2-.449a21.536 21.536 0 0 1-1.108-3.276a32.366 32.366 0 0 1-.156-.654l-.142-.648l-.127-.634l-.112-.613l-.1-.587l-.087-.554l-.074-.513l-.09-.683l-.066-.556a39.802 39.802 0 0 1-.017-.153a1.488 1.488 0 0 1 1.348-1.64L3.543 8h2.989l3.932-4.718Zm-.503 9.44a1 1 0 0 0-1.96.326l.013.116l.5 3l.025.114a1 1 0 0 0 1.96-.326l-.013-.116l-.5-3l-.025-.114Zm5.203-.708a1 1 0 0 0-1.125.708l-.025.114l-.5 3a1 1 0 0 0 1.947.442l.025-.114l.5-3a1 1 0 0 0-.822-1.15ZM12 4.562L9.135 8h5.73L12 4.562Z" />
                        </g>
                    </svg>
                </div>
</a>
            </div>
            <div class="sklad">
                <p class="textsklad">Склад: {{$tovar_page[0]->composition}}</p>
            </div>
        </div>

    </div>
    @if($comments!='[]')
    <div class="hot">
        @foreach($comments as $x)
        <div class="shab">
            <div class="shab_name">{{$x->user_name}}</div>
            <p class="feedshab">
                {{$x->text}}
            </p>
        </div>
        @endforeach
    </div>
    @else <p class="nocomm">На жаль, ще немає коментарів</p>
    @endif 

    <div class="comentar">
        <div class="tag1">
            <p class="name1">Відгуки</p>
            <div class="line1"></div>
        </div>
        <div class="vidhuk">
        @if($errors->any())
    <div>
        <ul style="list-style-type: none; display: contents; color: #850000; margin-left: 10px;">
          @foreach($errors->all() as $error)
            <li style="padding: 0; margin: 0;text-align: center;">{{ $error }}</li>
          @endforeach
        </ul>
    </div>
    @endif
            <form action="/tovar/{{$tovar_page[0]->id}}/submit" method="post">
                @csrf
                <div class="comname">
                    <input type="text" name="name" id="name" placeholder="Ім'я">
                </div>
                <div class="comname">
                    <input type="email" name="email" id="email" placeholder="Еmail">
                </div>
                <input class="comentar1" type="text" name="feedback" id="feedback">
                <button class="post" type="submit">Додати відгук</button>
            </form>
        </div>
    </div>
</div>
@endsection