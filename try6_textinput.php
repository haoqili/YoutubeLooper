<!--
try6_textinput.php Created 10/29/09 HaoQi Li

In this third version I will attempt to have a text box in the Input Page.
The text put into the Inputp Page Text Box is displayed on the Video Page.
I will also take out some useless print statements.

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

      // Get input text
      print "<p>[Optional] Paste lyrics/text:<br>\n";
      print "<TEXTAREA COLS=\"50\" ROWS=\"20\" NAME=\"Lyrics_from_form\">";
      print "</TEXTAREA><br>\n";

      //"Loop it!" Button
      print "<p>\n";
      print "<INPUT TYPE=\"submit\" VALUE=\"Loop it!\">\n";
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
      print 'allowscriptaccess="always" allowfullscreen="true" width="500" height="400">';
      print "\n</embed></object>\n";
      //-----End the Looping Part---

      print "<p>\n";
      print "<pre>\n";
      print $inputLyrics;
      print "</pre>\n";

      print "<hr><p><p>Don't see anything?  Make sure your input is correct\n";
   }
?>

<!-- 

*********** TODO  List **********************

Input Page
* If no lyrics entered, replace POST with GET so its Video Page can be bookmarked
* Make sure there are at least 11 chars after v= or /v/

Video Page
* Size of video
* Add goback to Input
* Show the video URL or ID

Overall
* CSS to make things pretty

Harder stuff
* Check the validity of an 11 char string?  Alphanumerics?

*****************************************


********* Previous Versions *************

This third one is based off of:

* try4 - parsed the input string (try4_parse1.php).  It works as planed for three cases:
Finds 11 char ID after 
1. 'v=' found in URLs
2. '/v/' found in embeds
3. If neither of the above is found and if the input is 11, assume (for now) it is the ID
4. If none of the above three, don't go to Video Page, but stay on Input Page


* try5 - sorted out what pages are displayed.
There are 2 basics pages:
1. The Input Page with Input Box
2. The Video Page with the Youtube Video on loop
Cases:
- If Input Box is "", then Input Page.
- If vaild input is put in, then Video Page.- If invalid input, then Input Page with note that there was invalid input

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
