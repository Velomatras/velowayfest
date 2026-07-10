<!-- шаблон для вывода отчётов юзера -->
@if (!empty($applications))
@foreach($applications as $row)

<div>{{$row['period']}}</div>
<div>{{$row['route']}}</div>
<div>{{$row['mileage']}}</div>
@endforeach
<br><br>
Всего отчётов - {{$total_report}}
@else 
У вас пока нет заявленных отчётов.
@endif