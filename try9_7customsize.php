<!--
try9_7customsize.php Created 11/1/09 HaoQi Li

In this Sixth Version of the youtube Looper:

* Add custom input size boxes

NOTE: When I started on this, try8_session.php was NOT working.
Must modify this after try8_session.php works.

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
      print "<FORM METHOD=\"POST\">\n";    
      print "YouTube video URL/embed/ID: <INPUT TYPE=\"TEXT\" NAME=\"VideoString_from_form\">\n";
      
      // Get size of video
      print "<p>Size of video:<br>\n";
      print "<INPUT TYPE=\"RADIO\" NAME=\"Size_from_form\" VALUE=\"0x0\">\n";
      print "No Display <br>\n";
      
      print "<INPUT TYPE=\"RADIO\" NAME=\"Size_from_form\" VALUE=\"320x265\">\n";
      print "320 x 265 <br>\n";

      print "<INPUT TYPE=\"RADIO\" NAME=\"Size_from_form\" VALUE=\"425x344\">\n";
      print "425 x 344 <br>\n";

      print "<INPUT TYPE=\"RADIO\" NAME=\"Size_from_form\" VALUE=\"480x385\">\n";
      print "480 x 385 <br>\n";

      print "<INPUT TYPE=\"RADIO\" NAME=\"Size_from_form\" VALUE=\"500x400\" CHECKED>\n";
      print "500 x 400 <br>\n";

      print "<INPUT TYPE=\"RADIO\" NAME=\"Size_from_form\" VALUE=\"640x505\">\n";
      print "640 x 505 <br>\n";
      
      //Customize Sizes
      print "<INPUT TYPE=\"RADIO\" NAME=\"Size_from_form\">\n";
      print "Width: <INPUT TYPE=\"TEXT\" NAME=\"Width_from_form\" SIZE=\"5\">&nbsp;&nbsp;&nbsp;\n";
      print "Height: <INPUT TYPE=\"TEXT\" NAME=\"Height_from_form\" SIZE=\"5\"><br> \n";


      // Get input text
      print "<p>[Optional] Paste lyrics/text:<br>\n";
      print "<TEXTAREA COLS=\"50\" ROWS=\"20\" NAME=\"Lyrics_from_form\">";
      print "</TEXTAREA><br>\n";

      //"Loop it!" Button
      print "<p>\n";
      print "<INPUT TYPE=\"SUBMIT\" VALUE=\"Loop it!\">\n";
      print "</FORM>\n";

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

      //Display youTubeID
      print "<p>You're watching <a href=\"http://www.youtube.com/watch?v=";
      print $youTubeID;
      print "\">http://www.youtube.com/watch?v=";
      print $youTubeID;
      print "</a>, enjoy!<br>\n";

      //-----Back to Input Page Button---
      print "<FORM METHOD=\"LINK\" ACTION=\"index.php\">\n";
      print "<INPUT TYPE=\"submit\" VALUE=\"Back to Input Page\">\n";
      print "</FORM>\n";
      //-----End back to Input Page Button---

      //Input Text/Lyrics
      print "<p>\n";
      print "<pre>\n";
      print $inputLyrics;
      print "</pre>\n";

      //
      print "<hr><p><p>Don't see anything?  Make sure your input is correct\n";
   }
?>

<!-- 

*********** TODO  List **********************

Input Page
* If no lyrics entered, replace POST with GET so its Video Page can be bookmarked
* Make sure there are at least 11 chars after v= or /v/

Video Page
-Do->* Size of video
-Do->* Add goback to Input
-Do->* Show the video URL or ID

Video Page advanced
* Make session so that when going back to Input Page, the inputs stay
* Add another size selection that is whatever the user puts in
* Pick out size of video if use embed and selects the size radio automatically

Overall
* Change to HereDoc
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
