 @include('parts.logosite')
 @include('parts.social')

<!DOCTYPE html>
<html lang="en">
<link href="assets/templates/veloway/css/style_white.css" rel="stylesheet" type="text/css" />
@php
global $modx;
$id_doc = $modx->documentIdentifier; 
$document = \DocumentManager::get($id_doc);
print_r($document->toArray());
echo $modx->documentObject['template'];
@endphp
   <head>
     </head>
	 <body>
	 {{$data['anykey']}}
	 {{$document['content']}}
	 {{$raund}}
	 {{$document['pagetitle']}}
	 @foreach ($document['tv'] as $key => $elem)
	 <br>TV параметр - 
	 @foreach ($elem as $key2 => $elem2)
	 {{$elem[$key2]}}
	 
	 @endforeach
	 @endforeach
	 {{ $anykey }}
	 </body>
</html>
	

