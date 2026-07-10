
<!doctype html>
<html lang="en-US">
<head>

	<base href="[(site_url)]"/>
	<meta charset="UTF-8" />
<title>[(site_name)] | [*pagetitle*]</title>
	<link href="/assets/templates/veloway/css/style_white.css" rel="stylesheet" type="text/css" />
	<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<!--[if IE 6]>
	<script src="js/belatedPNG.js"></script>
	<script>
		DD_belatedPNG.fix('*');
	</script>
	<![endif]-->
	<script src="assets/templates/veloway/js/jquery-1.4.min.js" type="text/javascript"></script>
	<script src="assets/templates/veloway/js/loopedslider.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(function(){
			$('#slider').loopedSlider({
				autoStart: 6000,
				restart: 5000
			});
		});
	</script>
	


</head>
<body>
<section id="page">
	<div id="bodywrap">
		
		<section id="top">

			<nav>
				
<h1 id="sitename"><a href="#">Велопутешествия как образ жизни</a></h1>
<article class="sitenav">
	

<script type="text/javascript">
jQuery(document).ready(function($) {
var url=document.location.href;
$.each($("#sitenav a"),function(){
if(this.href==url){$(this).addClass('current');};
});
})(jQuery);

 </script>
	
	
	@php	
	$modx->getChunk('slader');	
@endphp
</article>

</nav>


			
			
		</section>
		@CHUNK Menu2
		<section id="contentwrap">
			
			
				
			<div id="contents">
				<div id="topcolumns">
					<section id="normalpage">
					
						<section id="left2">
<h2>[*longtitle*]</h2>
						<article>
						[*foto_news2*]
							[*#content*]
							
						</article>
							
							<section class="blogpreview2">
								<!-- Вывод новостей !-->
							</section>
							<div id="topcolumns">

</div>
						</section>
						

						<section id="sidebar">
							<article class="testimonials">


<blockquote>
<p>

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

				
			</di>
		</section>
	</div>
	<footer id="pagefooter">
		<div id="credits">
			<p>
			@php
			$modx->getChunk('siteInfo');	
				
			@endphp	
			</p>
		</div>
	</footer>
</section>
</body>
</html>