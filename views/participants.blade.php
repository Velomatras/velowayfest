@extends('base')

@section('lk')
    @stack('openMenu')
    {!!$lk!!}
@endsection

@section('content')
   
    <style>
    .bg-green1 {
        background-color:#BAEEBA
    }
    .bg-green2 {
        background-color: #c3e6cb
    }
         .text-with-breaks {
    white-space: pre-line; /* сохраняет переносы, схлопывает лишние пробелы */
    white-space: pre-wrap;
    word-wrap: break-word;
}                     
    </style>
    @if ($zayavka->count() >= 1)
        {{ $zayavka->onEachSide(3)->links('pagination.participants', ['name_total' => 'участников']) }}
        @endif
    
    <div class="container-fluid  text-center" style="margin-top: 25px">

        @foreach($zayavka as $item)
    @if($loop->even) 
                <div class="row g-3 bg-green1">
                @else
                    <div class="row g-3 bg-green2">
                    @endif  


                    <div class="col-xl-4 align-self-start" ><div class="p-2">
                            <b>{{$item['idz']}}</b><br>
                            <img class="img-fluid img-thumbnail" src="{{$site . '/' . $evo->runSnippet('phpthumb', array('input' => 'assets/images/way-' .
 $yearApp . '/orig/' . $item['idz'] . '.jpg' ?? 'assets/images/noimage.jpg' , 'options' => 'q=95, w=400')) }}" />
                            <br>

                        </div></div>
                        <div class="col-xl-6 text-left"><div class="p-2">
                               
                                <b>Маршрут: </b>{{$item['route']}}<br>
                                <b>{{$item['mileage']}}</b>км<br><br>
<!--                                Вывод флагов стран -->
                                @foreach($item['region_country'] as $row)
                                <img src="/assets/images/flags/{{$row}}.gif" title="{{$row}}" width="60"  alt="country flag image" style="margin: 6px;">
                                @endforeach
                                <br>
                                <b>Регионы: </b>{{$item['region_name'] ?? ''}}<br><br>
                                <b>Номинации: </b>{{$item['nominations_rus'] ?? 'не заявлено'}}<br><br>
                                 
                                <div class="text-with-breaks"><b>Описание: </b>{{$item['description']}}</div><br><br>
                                
                            </div></div>

                                <div class="col-xl text-left"><div class="p-2" >
                                        <b>Автор отчёта: <em>{{$item['author'] ?? 'не указан'}}</em></b><br>
                             @if (!empty($item['city']))
                             ({{$item['city']}})<br>
                             @endif
                                @if (!empty($item['name']) && (strcmp($item['name'], $item['author']) != 0))
                                        <br><b>Организатор:</b> {{$item['name']}})<br>
                                @endif
                                <br>
                                    <div>
                                <img class="img-fluid img-thumbnail" src="{{$site . '/' . $evo->runSnippet('phpthumb', array('input' => $item['author_photo'] ?? 'assets/images/noimage.jpg' , 'options' => 'q=95, w=200')) }}" />
                                    </div>
                                <br><b>Даты похода: </b>{{$item['period']}}<br><br>
                                @if (!empty($item['number']))
                                <b>Участников</b> - {{$item['number'] ?? '?'}} <br><br>
                                @endif
                                @if (!empty($item['command']))
                                <div class="text-with-breaks"><b>Команда: </b>{{$item['command']}}</div><br><br>
                                 @endif
                                 @if (!empty($item['class']))
                                <b>Класс: </b>{{$item['class']}}<br><br>
                                @endif
                                 
                            </div></div>
                        </div>
                        <hr>


<!--итерация {{$loop->iteration}}  - {{$item['name']}} <br>-->
                    @endforeach
                        
                </div>
        @if ($zayavka->count() >= 1)
        {{ $zayavka->onEachSide(3)->links('pagination.participants', ['name_total' => 'участников']) }}
        @endif
        
            @endsection