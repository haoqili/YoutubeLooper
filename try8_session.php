<!--
try8_session.php Created 10/31/09 HaoQi Li
See the cleaned up version in try8b_session.php

This is where I spent a lot of time debugging and figuring out session.  I learned:
* How session works
* $_name is a piece of string, it has to be connected to other strings with ., can't just put in if in double quotes

In this Fifth Version of the Youtube Looper:

* Make the URL of video on Video Page go to another tab, target="_blank"
* Make a session so that when clicked on "goback," previous inputs and selections are still there

There are notes on the bottom
-->

<?php
   session_start();
   print "\ndebugging: session variable input_string is " . $_SESSION["input_string"]."<br>\n";
   //print isset($_SESSION["input_string"]))."\n";
   
   if (isset($_SESSION["input_string"])){
       print "IS IN SESSION!<br>\n";
       // print $_SESSIOn["input_string"];
       print "<br><br>";
   

        $possibleInValue = "VALUE=\"".$_SESSION["input_string"]."\"";
       print $possibleInValue;
       print "\n<br>--------<br>\n";
    
   }else{
       print "NOT in session<br>\n";
       $possibleInValue = "";
   }
   //####################################################
   // Parsing the input string from Input Page.
   //if(isset($_SESSION["input_string"])){
   //    $inputString = $_SESSION["input_string"];
   //}else{
       //session_start();
//   if (! isset($_SESSION["input_string"])){  
       $inputString = $_REQUEST["VideoString_from_form"];
       $_SESSION["input_string"] = $inputString;
//   }
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
  //    $possibleInValue="";
  //    if(isset($_SESSION["input_string"])){
 //       $possibleInValue = "VALUE=\"".$_SESSION["input_string"]."\"";
        //$possibleInValue = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
   //   }
      print "<FORM METHOD=\"POST\">\n";    
      print "YouTube video URL/embed/ID: <INPUT TYPE=\"TEXT\" NAME=\"VideoString_from_form\"". $possibleInValue.">\n";
      print "\n<br>Debugging: Possible In Value:<br>\n";
      print $possibleInValue;
      print "\n<br>End debugging.<br>\n";
      
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

      print "<INPUT TYPE=\"RADIO\" NAME=\"Size_from_form\" VALuUE=\"640x505\">\n";
      print "640 x 505 <br>\n";

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
      print "\n<br> Debugging: we have inputSting == empty, so set validIn to Ture<br>\n";
      $validIn = true;
      }
 
      print "\n<br> Debugging: validIn is:<br>\n";
      print $validIn;
      print "\n<br> -------- <br>\n";     
 
      if ($validIn == false) {
      print "<p><hr><p>Input error detected. Please make sure your input is correct\n";
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

      //Display youTubeID
      print "<p>You're watching <a href=\"http://www.youtube.com/watch?v=";
      print $youTubeID;
      print "\" target=\"_blank\">http://www.youtube.com/watch?v=";
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
