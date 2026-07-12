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
    
    
    <div class="container-fluid  text-center" style="margin-top: 25px">

            
                <div class="row g-3 bg-green1">
               


                    <div class="col-xl-4 align-self-start" ><div class="p-2">
                            <b>{{$zayavka['idz']}}</b><br>
                            <img class="img-fluid img-thumbnail" src="{{$site . '/' . $evo->runSnippet('phpthumb', array('input' => 'assets/images/way-' .
 $yearApp . '/orig/' . $zayavka['idz'] . '.jpg' ?? 'assets/images/noimage.jpg' , 'options' => 'q=95, w=400')) }}" />
                            <br>

                        </div></div>
                        <div class="col-xl-6 text-left"><div class="p-2">
                               
                                <b>Маршрут: </b>{{$zayavka['route']}}<br>
                                <b>{{$zayavka['mileage']}}</b>км<br><br>
<!--                                Вывод флагов стран -->
                                @foreach($zayavka['region_country'] as $row)
                                <img src="/assets/images/flags/{{$row}}.gif" title="{{$row}}" width="60"  alt="country flag image" style="margin: 6px;">
                                @endforeach
                                <br>
                                <b>Регионы: </b>{{$zayavka['region_name'] ?? ''}}<br><br>
                                <b>Номинации: </b>{{$zayavka['nominations_rus'] ?? 'не заявлено'}}<br><br>
                                 
                                <div class="text-with-breaks"><b>Описание: </b>{{$zayavka['description']}}</div><br><br>
                                
                            </div></div>

                                <div class="col-xl text-left"><div class="p-2" >
                                        <b>Автор отчёта: <em>{{$zayavka['author'] ?? 'не указан'}}</em></b><br>
                             @if (!empty($zayavka['city']))
                             ({{$zayavka['city']}})<br>
                             @endif
                                @if (!empty($zayavka['name']) && (strcmp($zayavka['name'], $zayavka['author']) != 0))
                                        <br><b>Организатор:</b> {{$zayavka['name']}})<br>
                                @endif
                                <br>
                                    <div>
                                <img class="img-fluid img-thumbnail" src="{{$site . '/' . $evo->runSnippet('phpthumb', array('input' => $zayavka['author_photo'] ?? 'assets/images/noimage.jpg' , 'options' => 'q=95, w=200')) }}" />
                                    </div>
                                <br><b>Даты похода: </b>{{$zayavka['period']}}<br><br>
                                @if (!empty($zayavka['number']))
                                <b>Участников</b> - {{$zayavka['number'] ?? '?'}} <br><br>
                                @endif
                                @if (!empty($zayavka['command']))
                                <div class="text-with-breaks"><b>Команда: </b>{{$zayavka['command']}}</div><br><br>
                                 @endif
                                 @if (!empty($zayavka['class']))
                                <b>Класс: </b>{{$zayavka['class']}}<br><br>
                                @endif
                                 
                            </div></div>
                        </div>
                        

                        
                </div>
       
        
            @endsection