<html>
<head>
<link rel="stylesheet" href="css/style.css" type="text/css" title="default" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

<script type="text/javascript">
  function feedback() {
    alert("Please send feedback and comments to HQ AT MIT DOT EDU. Thank you!\nThis site has been a web programming learning tool, I appreciate your help and support!");
  }


  $(document).ready(function(){
      $("#vidbox").focus();
  });

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-21853982-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();


</script>
</head>
<body>
<!--Created 2009-2011 HaoQi Li haoqili at mit
-->

<?php
   session_start();
   #print "\ndebugging: session variable input_string is " . $_SESSION["input_string"]."<br>\n";

   if (isset($_SESSION["input_string"])){
       #print "IS IN SESSION!<br>\n";
       #print "<br><br>";

       $possibleInValue = "VALUE=\"".$_SESSION["input_string"]."\"";
       #print $possibleInValue;
       #print "\n<br>--------<br>\n";
    
       $possibleLyrics = urldecode($_SESSION["input_lyrics"]);
       
       /// START::: GET SIZE

   }else{
       #print "NOT in session<br>\n";
       $possibleInValue = "";
      
       $possibleLyrics = "";
      
       $possibleSize0 = "";
       $possibleSize1 = "";
       $possibleSize2 = "";
       $possibleSize3 = "";
       $possibleSize4 = " CHECKED";
       $possibleSize5 = "";
   }
   //####################################################
   // Parsing the input string from Input Page.
   $inputString = htmlentities($_REQUEST["myvideo"]);
   $_SESSION["input_string"] = $inputString;
   $findVequal = "v=";
   $findVslash = "/v/"; 
   $posVequal = strpos($inputString, $findVequal);
   $posVslash = strpos($inputString, $findVslash);
   $posID = 0;
   $validIn = false;

   if (($posVequal == false) && ($posVslash == false)){ 
      if (strlen($inputString) == 11){ //assume that if the length is 11, it's the youtube ID
         $youTubeID = $inputString;
         $validIn = true; 
     }
   } else { // find the 11 chars after for youTubeID
      if ($posVequal) {
         $posID = $posVequal+2;
      } else { // ($posVslash)
         $posID = $posVslash+3;
      }
      $youTubeID = substr($inputString, $posID, 11);
      $validIn = true;
   }

   // Size of Video
   $inputVidSize = $_REQUEST["mysize"];
   $_SESSION["input_size"] = $inputVidSize;
   $dimensions = explode("x", $inputVidSize);
   $axisX = $dimensions[0];
   $axisY = $dimensions[1];

   // Get Lyrics
   $inputLyrics = htmlentities($_REQUEST["mylyrics"]); //htmlentities to prevent xss
   $_SESSION["input_lyrics"] = urlencode($inputLyrics);

   //######################################################
   // Header 
   print "<H1>Youtube Video Looper</H1>\n";
   
   // comments
   print "<div id=\"feedback\" onclick=\"feedback()\">Feed back</div>";

   // The Input Page
   // Displayed when inputString is nothing or invalid in 
   if ( ($inputString == "") || ($validIn == false) ) {
      print "<div id=\"mainleft\">";
     
      // Get input video string textbox
      print "<FORM METHOD=\"GET\">\n";    
      print "Video URL or ID: <INPUT id=\"vidbox\" TYPE=\"TEXT\" NAME=\"myvideo\"". $possibleInValue.">\n";
      
      // Get size of video
      print "<p>Size of video:<br>\n";
      print "<label><INPUT TYPE=\"RADIO\" NAME=\"mysize\" VALUE=\"0x0\"".$possibleSize0.">\n";
      print "No Display <br></label>\n";
      
      print "<label><INPUT TYPE=\"RADIO\" NAME=\"mysize\" VALUE=\"320x265\"".$possibleSize1.">\n";
      print "320 x 265 <br></label>\n";

      print "<label><INPUT TYPE=\"RADIO\" NAME=\"mysize\" VALUE=\"425x344\"".$possibleSize2.">\n";
      print "425 x 344 <br></label>\n";

      print "<label><INPUT TYPE=\"RADIO\" NAME=\"mysize\" VALUE=\"480x385\"".$possibleSize3.">\n";
      print "480 x 385 <br></label>\n";

      print "<label><INPUT TYPE=\"RADIO\" NAME=\"mysize\" VALUE=\"500x400\"".$possibleSize4.">\n";
      print "500 x 400 <br></label>\n";

      print "<label><INPUT TYPE=\"RADIO\" NAME=\"mysize\" VALUE=\"640x505\"".$possibleSize5.">\n";
      print "640 x 505 <br></label>\n";

      // Get input text
      print "<p>Paste lyrics/text if you want to learn a song <br />... or write a love note:<br>\n";
      print "<TEXTAREA id=\"lyricsbox\" NAME=\"mylyrics\">";
      print $possibleLyrics;
      print "</TEXTAREA><br>\n";
      print "</div><!-- main left-->";

      //"Loop it!" Button
      print "<p>\n";
      print "<INPUT id=\"loopbutton\" TYPE=\"SUBMIT\" VALUE=\"Loop it!\">\n";
      print "</FORM>\n";

      //Error Message (bad input) on Input Page, stay on Input Page
      //since validIn is initialized to false, make it "true" so sthat the error message doesn't show when nothing is put in
      if ($inputString == ""){
      $validIn = true;
      }
      if ($validIn == false) {
      print "<script>alert(\"Input error detected. It's not a valid Youtube url.\");</script>";
      }
      //------ End Error Message stuff ------------
   
   } else { 

  //######################################################
  // The Video Page
   
      //-----Start the Looping Part-------
      print '<object><embed src="http://www.youtube.com/v/';
      print $youTubeID;
      print '&h1=en&fs=1&autoplay=1&loop=1" type="application/x-shockwave-flash" ';
      print 'allowscriptaccess="always" allowfullscreen="true" ';
      print 'width="';
      print $axisX;
      print '" height="';
      print $axisY;
      print '">';
      print "\n</embed></object>\n";
      //-----End the Looping Part---

      // ----- You're watching ------
      print "<p>You're watching <a href=\"http://www.youtube.com/watch?v=";
      print $youTubeID;
      print "\" target=\"_blank\">http://www.youtube.com/watch?v=";
      print $youTubeID;
      print "</a>, enjoy!<br>\n";

      // ----- Youtube looper Permanent link ------
      print "<p><p><a href=\"
http://youtubelooper.com/?myvideo=http://www.youtube.com/watch?v="
      .$youTubeID
      ."&mysize=".$_SESSION["input_size"]
      ."&mylyrics=".$_SESSION["input_lyrics"]
      ."\" target=\"_blank\">"
      ."Permanent link (if no lyrics)</a>:";

      print "<textarea id=\"copyurlbox\" onclick=\"this.focus(); this.select();\">http://youtubelooper.com/?myvideo=http://www.youtube.com/watch?v="
      .$youTubeID
      ."&mysize=".$_SESSION["input_size"]
      ."&mylyrics=".$_SESSION["input_lyrics"]
      ."</textarea>";

      // ----- Scripts MIT Permanent link ------
      print "<p><p><a href=\"
http://haoqili.scripts.mit.edu/Songs/index.php?myvideo=http://www.youtube.com/watch?v="
      .$youTubeID
      ."&mysize=".$_SESSION["input_size"]
      ."&mylyrics=".$_SESSION["input_lyrics"]
      ."\" target=\"_blank\">"
      ."Permanent link (if have lyrics)</a>:";

      print "<textarea id=\"copyurlbox\" onclick=\"this.focus(); this.select();\">http://haoqili.scripts.mit.edu/Songs/index.php?myvideo=http://www.youtube.com/watch?v="
      .$youTubeID
      ."&mysize=".$_SESSION["input_size"]
      ."&mylyrics=".$_SESSION["input_lyrics"]
      ."</textarea>";


      // ------End permanent link ----

      //-----Back to Input Page Button---
      print "<FORM METHOD=\"LINK\" ACTION=\"index.php\">\n";
      print "<INPUT TYPE=\"submit\" VALUE=\"Back to Input Page\">\n";
      print "</FORM>\n";
      //-----End back to Input Page Button---

      //Input Text/Lyrics
      print "<p><hr />\n";
      print "<pre>\n";
      print $inputLyrics;
      print "</pre>\n";
   }
?>
</body>
</html>
<!-- 

*********** TODO  List **********************

Input Page
* If no lyrics entered, replace POST with GET so its Video Page can be bookmarked
* Make sure there are at least 11 chars after v= or /v/

Video Page advanced
-Do->* Make session so that when going back to Input Page, the inputs stay
* Add another size selection that is whatever the user puts in
* Pick out size of video if use embed and selects the size radio automatically

Overall
* Change to HereDoc
* CSS to make things pretty

Harder stuff
* Check the validity of an 11 char string?  Alphanumerics?

*****************************************


********* Previous Versions *************

This third one is based off of:

* try4_parse1.php - parsed the input string.  It works as planed for three cases:
Finds 11 char ID after 
1. 'v=' found in URLs
2. '/v/' found in embeds
3. If neither of the above is found and if the input is 11, assume (for now) it is the ID
4. If none of the above three, don't go to Video Page, but stay on Input Page


* try5_fixPageOrder.php - sorted out what pages are displayed.
There are 2 basics pages:
1. The Input Page with Input Box
2. The Video Page with the Youtube Video on loop
Cases:
- If Input Box is "", then Input Page.
- If vaild input is put in, then Video Page.- If invalid input, then Input Page with note that there was invalid input

* try6_textinput.php - added a textarea for putting in lyrics

* try7_editvidpg.php - I did:
1. Add go back to Input Page Button on Video Page, no session saved though
2. Show the video URL on the Video Page
3. Made size of video selectable

****************************************


***** N.B. *******
For the Input Page:
* FORM METHOD=\"GET\" or POST
    - Doesn't have an ACTION URL because the current page is the target.
    - With POST, the resulting Video Page URL would be shorter, but can't be bookmarked.  $_REQUEST[] can get stuff from both GET and POST

For the Video Page
* Print with single quotes ' '
    - Disadvantage: cannot do variable substitution with strngs and metacharacters like \n
    - Advantage: don't have to escape " 
-->
