<?php
function BoomRenderSignup() { 
echo <<<BOOMSHAKA
    <!DOCTYPE html>
    <html>
      <head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="styles/style.css" type="text/css" />
		<title>Artist Websites by BOOMSHAKA (beta invite)</title>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-55726311-1', 'auto');
	  ga('send', 'pageview');
	
	</script>
	</head>
	<body>
      <h1 class="service-request">Artist Websites by BOOMSHAKA<sup>(beta invite)</sup></h1>
      <h2 class="service-request">Show your work to the world</h2>
        <form method="POST" action="{$_SERVER['REQUEST_URI']}" enctype="application/x-www-form-urlencoded">
          <section>
            <label for="firstname">First Name</label>
            <input name="firstname" id="firstname" type="text" />
          </section>
          <section>
            <label for="lastname">Last Name</label>
            <input name="lastname" id="lastname" type="text" />
          </section>
          <section>
          
            <label for="email">Email</label>
            <input name="email" id="email" type="text" />
          </section>
          <section>
            <label for="imlookingfor">I'm looking for</label>
            <select name="imlookingfor">
 		<option></option>
		<option>a brand new artist website</option>
                <option>updates to my existing website</option>
		<option>a place to sell my work online</option>
            </select>
          </section>
          <p>
            <input onclick="ga('send', 'event', 'Acquisition', 'signup', 'Boomshaka Signup', 1);" id="submit" value="Signup" type="submit" />
          </p>
        </form>
	<p>Questions? Email Jordan Kanter and Dan Schreck at <a href='&#109;ai&#108;to&#58;bo&#111;m%73&#104;aka%64&#101;s&#105;gn%40gm&#37;61i&#108;%2Ec&#111;m'>&#98;o&#111;&#109;&#115;h&#97;kade&#115;&#105;gn&#64;&#103;ma&#105;l&#46;com</a></p>
      </body>
    </html>
BOOMSHAKA;
}
function BoomRenderSignupRequestSubmitted($flash = '') { 
  echo <<<BOOMSHAKA
  <!DOCTYPE HTML>
  <html>
  <head>
	    <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="styles/style.css" type="text/css" />
	    <title>Artist Websites by BOOMSHAKA (beta invite)</title>
  </head>
  <body>
  <h2 style='color: green'>${flash}</h2>
  <section class="thank-you">
    <iframe width="420" height="315" src="//www.youtube.com/embed/mOLxlzrxCv0" frameborder="0"  allowfullscreen></iframe>
  </section>
  </body>
  </html>
BOOMSHAKA;
}
?>


