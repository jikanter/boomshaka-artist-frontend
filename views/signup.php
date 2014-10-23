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
	
      <h1>Artist Websites by BOOMSHAKA<sup>(beta invite)</sup></h1>
      <h2>Show your work to the world</h2>
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
            <label for="domain">Desired Domain </label>
            <input name="domain" id="domain" type="text" placeholder="(e.g. jordanartist.com)"/>
          </section>
          <p>
            <input id="submit" value="Continue" type="submit" />
          </p>
        </form>
      </body>
    </html>
BOOMSHAKA;
}
function BoomRenderSignupRequestSubmitted($flash = '') { 
  echo <<<BOOMSHAKA
    <html>
  <body>
  <h2 style='color: green'>${flash}</h2>
  <iframe width="420" height="315" src="//www.youtube.com/embed/mOLxlzrxCv0" frameborder="0"  allowfullscreen></iframe>
  </body>
  </html>
BOOMSHAKA;
}
?>


