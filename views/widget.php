<?php

function BoomRenderCreateCarousel() { 
  echo("<form action='/create/widget' method='POST' enctype=>");
  echo("<select type='multiple'>");
  echo("</select>");
  echo("</form>");
}

function BoomRenderCreateDisplayMode() { 
  echo("<form action='/create/widget' method='POST' enctype=>");
  echo("<select type='multiple'>");
  echo("</select>");
  echo("<input type='submit' value='Create Display Mode Widget' />");
  echo("</form>");
}

function BoomRenderWidgetCreate($type = "DisplayMode") { 
  switch ($type) { 
    case "DisplayMode":
      BoomRenderCreateDisplayMode(); break;
    case "Carousel":
      BoomRenderCreateCarousel(); break;
  }
}
?>