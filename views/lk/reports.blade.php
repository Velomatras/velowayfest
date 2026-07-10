<!-- шаблон для вывода отчётов юзера -->
<style>
    .container_report{
        display: grid;
        grid-template-columns: 200px 4fr 1fr;
        background-color: yellow;
        gap: 10px;
    }
</style>
<div class="container_report">
    @foreach($reports as $row)
        @if(!empty($row['pic'])) 
            <div><a href="{{$site}}{{$row['pic'] }}">
                    <img width="150px" src="{{$site}}{{$row['pic'] }}"/></a></div>
                @php
$file_path_orig = $site . '/assets/images/way-' . $row['year'] . '/orig/' . $row['idz'] . '.jpg';
$file_path_thumb = $site . '/assets/images/way-' . $row['year'] . '/thumb/' . $row['idz'] . '.jpg' ;
@endphp
            @elseif((is_readable($file_path_orig) == true) && (is_readable($file_path_thumb) == true))
                <div>Есть фото<br><a href="{{$site}}/assets/images/way-{{$row['year'] }}/orig/{{$row['idz'] }}.jpg">
                        <img src="{{$site}}/assets/images/way-{{$row['year'] }}/thumb/{{$row['idz'] }}.jpg"/></a></div>
                @else
                    <div>нет фото<br>
                        <a href="{{$site}}/assets/images/way-{{$row['year'] }}/orig/{{$row['idz']  }}.jpg">
                            <img src="{{$site}}/assets/images/way-{{$row['year'] }}/thumb/{{$row['idz']  }}.jpg"/></a></div>
                    @endif

                    <div>
                        Маршрут: <a href="{{$row['link'] }}">{{$row['route'] }}</a><br><br>
                        Период: {{$row['period'] }}<br><br>
                        дней в пути: {{$row['duration'] }}<br>
                        км: {{$row['mileage'] }}<br><br>
                        Описание: {{$row['description'] }}<br><br></div>
                    <div>
                        Организатор: {{$row['name'] }}<br><br>

                        @if (!empty($row['author']) && ($row['author'] != $row['name']))
                            Автор отчёта: {{$row['author'] }}
                        @endif
                    </div>
                @endforeach
            </div>

            <br><br>
            Всего отчётов - {{$total_report}}
