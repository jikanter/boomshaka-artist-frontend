<?php
function BoomRenderSignup() { 
echo <<<BOOMSHAKA
    <!DOCTYPE HTML>
    <html>
      <head>
        <link rel="stylesheet" href="styles/style.css" type="text/css" />
      </head>
      <body>
      <h1>Sign up for BOOMSHAKA Beta</h1>
      <h2>Get your artist website:</h2>
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
            <input name="domain" id="domain" type="text" /> (e.g. jordankanterartist.com)
          </section>
          <input id="submit" value="Get a Site" type="submit" />
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


