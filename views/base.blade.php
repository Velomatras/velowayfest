
<!doctype html>
<html lang="en-US">
<head>
@include('parts.logosite')
@include('style')
	<base href="[(site_url)]"/>
	<meta charset="UTF-8" />

	@include('parts.css')
	<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<!--[if IE 6]>
	<script src="js/belatedPNG.js"></script>
	<script>
		DD_belatedPNG.fix('*');
	</script>
	<![endif]-->
        
	<script src="{{$_SERVER['REQUEST_SCHEME']}}://{{$_SERVER['SERVER_NAME']}}/assets/templates/veloway/js/jquery-1.4.min.js" type="text/javascript"></script>
	<script src="{{$_SERVER['REQUEST_SCHEME']}}://{{$_SERVER['SERVER_NAME']}}/assets/templates/veloway/js/loopedslider.js" type="text/javascript"></script>
	
	<script type="text/javascript">
		$(function(){
			$('#slider').loopedSlider({
				autoStart: 6000,
				restart: 5000
			});
		});
	</script>
	<script>
        function menuClick(){
     let el = document.querySelector('#sidebar');
el.classList.toggle('open');
el.style.display = el.style.display === 'none' ? 'block' : 'none';
        }
        function toggleDivVisibility(id) {
  var el = document.getElementById(id);
  // Изучаем, как с помощью JavaScript переключать видимость элементов! 😄
  el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
function countRabbits() {
    for(let i=1; i<=3; i++) {
      alert("Кролик номер " + i);
    }
  }
    </script><!-- comment -->


</head>
<body>
<section id="page">
	<div id="bodywrap">
	@include('parts.social')
            @yield('buttonLK')
			<section id="top">

			<nav>
				
<h1 id="sitename"><a href="{{$_SERVER['REQUEST_SCHEME']}}://{{$_SERVER['SERVER_NAME']}}">Велопутешествия как образ жизни</a></h1>
<article class="sitenav">
	@include('parts.menu')
			

<script type="text/javascript">
jQuery(document).ready(function($) {
var url=document.location.href;
$.each($("#sitenav a"),function(){
if(this.href==url){$(this).addClass('current');};
});
})(jQuery);

 </script>
 	@include('parts.slader')
</article>

</nav>


			
			
		</section>
		
		<section id="contentwrap">
			
			
				
			<div id="contents">
				<div id="topcolumns">
					<section id="normalpage">
					
						<section id="left2">
                                                    <p class="fs-2"><b>
                                    @if (!empty($documentObject['longtitle']))
                                        <br>
                                        {{$documentObject['longtitle']}} 
                                    @endif
                                                        </b> </p>
                                                @yield('title')
						<article>
						@if (!empty($documentObject['content']))
							{!!$documentObject['content']!!}
						@endif	
						</article>
							
							<section class="blogpreview2">
								@yield('content')
														</section>
							<div id="topcolumns">

</div>
						</section>
						

						<section id="sidebar">
							<article class="testimonials">

<blockquote>
<p>
@yield('lk')
 </p>
</blockquote>


</article>
<section id="left3">

<article class="postpreview">


</article>
</section> 
						</section>

						<div class="clear"></div>
					</section>

					<div class="clear"></div>

				</div>

				
			</div>
		</section>
	</div>
	<footer id="pagefooter">
		<div id="credits">
			<p>
			
			</p>
		</div>
	</footer>
	</div>
</section>
    <script src="manager/media/script/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>