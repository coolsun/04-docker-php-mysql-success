
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="imagetoolbar" content="no" />
	<title>Fancybox - Fancy jQuery lightbox alternative</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
	<script type="text/javascript" src="fancybox/jquery.easing-1.3.pack.js"></script>
	<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	
	<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.js"></script>
	<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	
	<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
	<script type="text/javascript" src="web.js?m=20100203"></script>
</head>
<body>
<!-- AdPacks.com Ad Code -->
<script type="text/javascript">
(function(){
  var bsa = document.createElement('script');
     bsa.type = 'text/javascript';
     bsa.async = true;
     bsa.src = '//s3.buysellads.com/ac/bsa.js';
  (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);
})();
</script>
<!-- End AdPacks.com Ad Code -->

	<div id="page">
		<div id="header">
		    <h1><a href="/">fancybox</a></h1>
		    <ul>
				<li><a class="active" href="/home">Home</a></li>
				<li><a  href="/howto">How to use</a></li>
				<li><a  href="/api">API &amp; Options</a></li>
				<li><a  href="/blog">Tips &amp; Tricks</a></li>
				<li><a  href="/faq">FAQ</a></li>
				<li><a  href="/support">Support</a></li>
			</ul>
		</div>

	 	<div id="col_wrap">
	 		<div id="col_top"></div>
			<div id="col_left">
	            <div style="font-size:130%" class="warn">
	<p>
            Hey guys, exciting news here! We have released <b>fancyBox2</b>!
	</p>
        <p>
	    <a style="" href="http://fancyapps.com/fancybox/">Go ahead and check it out!</a>
        </p>
</div>

<h1>What is it?</h1>

<p>
	FancyBox is a tool for displaying images, html content and multi-media in a Mac-style "lightbox" that floats overtop of web page.
	<br />
	It was built using the <a href="http://jquery.com/">jQuery library</a>.
	Licensed under both <a href="http://docs.jquery.com/Licensing">MIT and GPL licenses</a>
</p>


<h1>Features</h1>

<ul class="list">
	<li>Can display images, HTML elements, SWF movies, Iframes and also Ajax requests</li>
	<li>Customizable through settings and CSS</li>
	<li>Groups related items and adds navigation.</li>
	<li>If the mouse wheel plugin is included in the page then FancyBox will respond to mouse wheel events as well</li>
	<li>Support fancy transitions by using easing plugin</li>
	<li>Adds a nice drop shadow under the zoomed item</li>
</ul>

<h1>Examples</h1>

<p>
	Different animations - 'fade', 'elastic' and 'none'<br />
	
	<a id="example1" href="http://farm5.static.flickr.com/4058/4252054277_f0fa91e026.jpg">
		<img alt="example1" src="http://farm5.static.flickr.com/4058/4252054277_f0fa91e026_m.jpg" />
	</a>
	
	<a id="example2" href="http://farm3.static.flickr.com/2489/4234944202_0fe7930011.jpg">
		<img alt="example2" src="http://farm3.static.flickr.com/2489/4234944202_0fe7930011_m.jpg" />
	</a>
	
	<a id="example3" href="http://farm3.static.flickr.com/2647/3867677191_04d8d52b1a.jpg">
		<img alt="example3" src="http://farm3.static.flickr.com/2647/3867677191_04d8d52b1a_m.jpg" />
	</a>
</p>

<p>
	Different title positions - 'outside', 'inside' and 'over'<br />

	<a id="example4" title="Lorem ipsum dolor sit amet" href="http://farm3.static.flickr.com/2680/4305925199_dee66e6c4b.jpg">
		<img alt="example4" src="http://farm3.static.flickr.com/2680/4305925199_dee66e6c4b_m.jpg" />
	</a>

	<a id="example5" title="Cras neque mi, semper at interdum id, dapibus in leo. Suspendisse nunc leo, eleifend sit amet iaculis et, cursus sed turpis." href="http://farm3.static.flickr.com/2775/4110967360_661cd9d99e.jpg">
		<img alt="example5" src="http://farm3.static.flickr.com/2775/4110967360_661cd9d99e_m.jpg" />
	</a>

	<a id="example6" title="Sed vel sapien vel sem tempus placerat eu ut tortor. Nulla facilisi. Sed adipiscing, turpis ut cursus molestie, sem eros viverra mauris, quis sollicitudin sapien enim nec est. ras pulvinar placerat diam eu consectetur." href="http://farm3.static.flickr.com/2779/4262915740_c631846165.jpg">
		<img alt="example6" src="http://farm3.static.flickr.com/2779/4262915740_c631846165_m.jpg" />
	</a>
</p>

<p>
	Image gallery <small>(ps, try using mouse scroll wheel) </small><br />

	<a rel="example_group" title="Custom title" href="http://farm3.static.flickr.com/2641/4163443812_df0b200930.jpg">
		<img alt="" src="http://farm3.static.flickr.com/2641/4163443812_df0b200930_m.jpg" />
	</a>
	
	<a rel="example_group" title="" href="http://farm3.static.flickr.com/2591/4135665747_3091966c91.jpg">
		<img alt="" src="http://farm3.static.flickr.com/2591/4135665747_3091966c91_m.jpg" />
	</a>
	
	<a rel="example_group" title="" href="http://farm3.static.flickr.com/2561/4048285842_90b7e9f8d1.jpg">
		<img alt="" src="http://farm3.static.flickr.com/2561/4048285842_90b7e9f8d1_m.jpg" />
	</a>
</p>

<p>
    Various examples
</p>

<ul>
	<li><a id="various1" href="#inline1" title="Lorem ipsum dolor sit amet">Inline - auto detect width / height</a></li>
	<li><a id="various2" href="#inline2">Inline - modal window</a></li>
	<li><a id="various3" href="/data/login.php">Ajax - passing custom data</a></li>
	<li><a id="various5" href="/data/iframe.html">Iframe (75% width and height)</a></li>
	<li><a id="various6" href="http://www.adobe.com/jp/events/cs3_web_edition_tour/swfs/perform.swf">Swf</a></li>
	<li><a id="various7" href="http://farm5.static.flickr.com/4039/4309726477_c0416f6955.jpg">Example of callbacks</a></li>
	<li><a id="various8" href="/data/non_existing_image.jpg">Non existing image</a></li>
	<li><a id="various9" href="/data/non_existing_url.php">Non existing url</a></li>
	
	<li><a class="various iframe" href="http://maps.google.com/?output=embed&f=q&source=s_q&hl=en&geocode=&q=London+Eye,+County+Hall,+Westminster+Bridge+Road,+London,+United+Kingdom&hl=lv&ll=51.504155,-0.117749&spn=0.00571,0.016512&sll=56.879635,24.603189&sspn=10.280244,33.815918&vpsrc=6&hq=London+Eye&radius=15000&t=h&z=17">Google maps (iframe)</a></li>
	<li><a class="various iframe" href="http://www.youtube.com/embed/L9szn1QQfas?autoplay=1">Youtube (iframe)</a></li>
</ul>

<p>
    Examples of manual call
</p>

<ul>
	<li><a id="manual1" href="javascript:;" title="">Image</a></li>
	<li><a id="manual2" href="javascript:;" title="">Image gallery</a></li>
</ul>

<p class="note">
    <small>Photo Credit: <a href="http://www.flickr.com/people/kharied/">Katie Harris</a></small>
</p>

<div id="inline1">
	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis mi eu elit tempor facilisis id et neque. Nulla sit amet sem sapien. Vestibulum imperdiet porta ante ac ornare. Nulla et lorem eu nibh adipiscing ultricies nec at lacus. Cras laoreet ultricies sem, at blandit mi eleifend aliquam. Nunc enim ipsum, vehicula non pretium varius, cursus ac tortor. Vivamus fringilla congue laoreet. Quisque ultrices sodales orci, quis rhoncus justo auctor in. Phasellus dui eros, bibendum eu feugiat ornare, faucibus eu mi. Nunc aliquet tempus sem, id aliquam diam varius ac. Maecenas nisl nunc, molestie vitae eleifend vel, iaculis sed magna. Aenean tempus lacus vitae orci posuere porttitor eget non felis. Donec lectus elit, aliquam nec eleifend sit amet, vestibulum sed nunc.
</div>

<div id="inline2">
	<p>
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. &nbsp;&nbsp; <a href="javascript:;" onclick="$.fancybox.close();">Close</a>
	</p>
</div>

			</div>

			<div id="col_right">
				<div id="col_sep">
<p>
	<b><a href="http://fancyapps.com/fancybox/">Download fancyBox2 from http://fancyapps.com</a></b>
</p>
<p><br /></p>

					<!-- <a href="http://fancybox.googlecode.com/files/jquery.fancybox-1.3.4.zip"><img alt="Download" src="/img/download.gif" /></a> -->

					<p><b>Past Release</b><br /><a href="http://fancybox.googlecode.com/files/jquery.fancybox-1.3.4.zip">Version</b> 1.3.4 (2010/11/11)</a></p>
					
					<p><a href="/changelog/">Changelog</a></p>

					<form id="donate_form" action="https://www.paypal.com/cgi-bin/webscr" method="post">
						<p>
							<input type="hidden" name="cmd" value="_donations" />
							<input type="hidden" name="business" value="janis.skarnelis@gmail.com" />
							<input type="hidden" name="item_name" value="FancyBox" />
							<input type="hidden" name="amount" value="10.00" />
							<input type="hidden" name="no_shipping" value="0" />
							<input type="hidden" name="no_note" value="1" />
							<input type="hidden" name="currency_code" value="EUR" />
							<input type="hidden" name="tax" value="0" />
							<input type="hidden" name="lc" value="LV" />
							<input type="hidden" name="bn" value="PP-DonationsBF" />

						
										</p>
						<p>
							<b><a id="donate" href="javascript:;" style="font-size:120%">Donate</a></b>
						</p>
					</form>
			
			   </div>

			   <div id="adblock">

					<h2>Our Sponsors</h2>
<!-- AdPacks.com Zone Code -->
<div id="bsap_1255513" class="bsarocks bsap_439877dd0926c71f4ca8c574860a4ef8"></div>
<a href="http://adpacks.com" id="bsap_aplink">via Ad Packs</a>
<!-- End AdPacks.com Zone Code -->

					

	            </div>
			</div>

			<div class="clear"></div>
		</div>

		<div id="col_bottom"></div>

		<div id="footer">
		    <p>Contact: info <span>[at]</span>  fancybox <span>[dot]</span> net &nbsp;&nbsp; /please, don`t send emails for help, use <a href="http://groups.google.com/group/fancybox">support forum</a> instead</p>
	        <p>� 2008 - 2013 / fancybox.net</p>
		</div>
	</div>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-4230547-1");
pageTracker._initData();
pageTracker._trackPageview();
</script>
</body>
</html>
