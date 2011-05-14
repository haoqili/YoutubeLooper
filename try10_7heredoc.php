<!--
try10_7heredoc.php Created 11/1/09 HaoQi Li

In this Seventh Version of the Youtube Looper:

* Convert print statements to HereDoc <<<EOF   blah EOF; don't forget to put EOF; on a new line without whitespaces in the front!

NOTE:
* When I started this, try8_session.php and try9_7customsize.php were NOT working.  
So need to modify this after those two work.

There are notes on the bottom
-->

<?php
   
   //####################################################
   // Parsing the input string from Input Page.
   $inputString = $_REQUEST["VideoString_from_form"];
   $findVequal = "v=";
   $findVslash = "/v/"; //not implemented it
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
   $inputVidSize = $_REQUEST["Size_from_form"];
   $dimensions = explode("x", $inputVidSize);
   $axisX = $dimensions[0];
   $axisY = $dimensions[1];

   // Get Lyrics
   $inputLyrics = $_REQUEST["Lyrics_from_form"];
  
   //######################################################
   // Header 
   print "<H1><center>Youtube Video Looper</center></H1>\n";
   
   // The Input Page
   // Displayed when inputString is nothing or invalid in 
   if ( ($inputString == "") || ($validIn == false) ) {
     
      // Get input video string textbox
print <<<HereDoc
      <FORM METHOD="POST">
      YOUTUBE Video URL/Embed/ID: <INPUT TYPE="TEXT" NAME="VideoString_from_form">\n
HereDoc;

      // Get size of video
print <<<HereDoc
      <p>Size of video:<br>
      <INPUT TYPE="RADIO" NAME="Size_from_form" VALUE="0x0">
      No Display <br>
      <INPUT TYPE="RADIO" NAME="Size_from_form" VALUE="320x265">
      320 x 265 <br>
      <INPUT TYPE="RADIO" NAME="Size_from_form" VALUE="425x344">
      425 x 344 <br>
      <INPUT TYPE="RADIO" NAME="Size_from_form" VALUE="480x385">
      480 x 385 <br>
      <INPUT TYPE="RADIO" NAME="Size_from_form" VALUE="500x400" CHECKED>
      500 x 400 <br>
      <INPUT TYPE="RADIO" NAME="Size_from_form" VALUE="640x505">
      640 x 505 <br>\n
HereDoc;

      // Get input text
print <<<HereDoc
      <p>[Optional] Paste lyrics/text:<br>
      <TEXTAREA COLS="50" ROWS="20" NAME="Lyrics_from_form"></TEXTAREA><br>\n
HereDoc;

      //"Loop it!" Button
print <<<HereDoc
      <p>
      <INPUT TYPE="SUBMIT" VALUE="Loop it!">
      </FORM>\n
HereDoc;

      //Error Message (bad input) on Input Page, stay on Input Page
      //since validIn is initialized to false, make it "true" so sthat the error message doesn't show when nothing is put in
      if ($inputString == ""){
      $validIn = true;
      }
      if ($validIn == false) {
      print "<p><hr><p>Input error detected. Please make sure your input is correct\n";
      }
   } else { 

  //######################################################
  // The Video Page
   
      //-----Start the Looping Part-------
print <<<EOF
      <object><embed src="http://www.youtube.com/v/$youTubeID&h1=en&fs=1&autoplay=1&loop=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="$axisX" height="$axisY">
      </embed></object>\n
EOF;
      //-----End the Looping Part---

      //Display youTubeID
print <<<EOF
      <p>You're watching <a href="http://www.youtube.com/watch?v=$youTubeID">http://www.youtube.com/watch?v=$youTubeID</a>, enjoy!<br>\n
EOF;
      //-----Back to Input Page Button---
print <<<EOF
      <FORM METHOD="LINK" ACTION="index.php">
      <INPUT TYPE="submit" VALUE="Back to Input Page">
      </FORM>\n
EOF;
      //-----End back to Input Page Button---

      //Input Text/Lyrics
print <<<EOF
      <p>
      <pre>$inputLyrics</pre>\n
EOF;

      //
      print "<hr><p><p>Don't see anything?  Make sure your input is correct\n";
   }
?>

<!-- 

*********** TODO  List **********************

Input Page
* If no lyrics entered, replace POST with GET so its Video Page can be bookmarked
* Make sure there are at least 11 chars after v= or /v/

Video Page advanced
* Make session so that when going back to Input Page, the inputs stay
* Add another size selection that is whatever the user puts in
* Pick out size of video if use embed and selects the size radio automatically

Overall
-DO->* Change to HereDoc
* CSS to make things pretty

Harder stuff
* Check the validity of an 11 char string?  Alphanumerics?

*****************************************


********* Previous Versions *************

This one is based off of:

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
