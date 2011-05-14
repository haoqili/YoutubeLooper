<!--
Created 10/22/09
This is my first try on parsing the input string.  It works as planed for three cases:
1. The URL is put in (finds ID after 'v=')
2. The Embed stuff is put in (finds ID after '/v/)
3. The 11 char string is put in (assume it is the ID)

TODO:
1. Fix the display so that if an invalid string (can't find ID) is put in, the input page should still be displayed and give a warning of what was wrong.
2. Check the validity of an 11 char string?  Alphanumerics?
3. Size of image
4. Make background css stuff
5. Take out comments
-->

<?php
   // First attempt to parse
   // 1. Plan to find v=
   // 2. Parse 11 chars after
   // 3. Find v= OR /v/
   // 4. If not found, see if it is 11 digits, else return error
   
   // Test to see if we were passed a YouTube ID...
   
   //$youTubeID = $_REQUEST["ID_from_form"];
   // Instead of getting the youTubeID straight from the box, get string and parse it using the 3 steps above to find the youTubeID
   //$inputString = '';
   $inputString = $_REQUEST["ID_from_form"];
   $findVequal = "v=";
   $findVslash = "/v/"; //not implemented it
   $posVequal = strpos($inputString, $findVequal);
   print "posVequal=".$posVequal."\n";
   $posVslash = strpos($inputString, $findVslash);
   print "posVslash=".$posVslash."\n";
   $posID = 0;

   // A bug here? if ( ($posVequal && $posVslash) == false ) {
   //lol I was tired! if ( ( $posVequal != FALSE) || ( $posVslash != FALSE)) {
   if (($posVequal == false) && ($posVslash == false)){ 
      //print "$posVequal != false";     
      print "Can NOT find a V's position, neither v= nor /v/"."\n";
      if (strlen($inputString) == 11){ //assume that if the length is 11, it's the youtube ID
         $youTubeID = $inputString;
         print "you gave the youtubeID=".$youTubeID;
      }
   } else { // find the 11 chars after for youTubeID
      print "Found a V's position"."\n";
      if ($posVequal) {
         $posID = $posVequal+2;
         print "Found in pos V=, +2 posID=".$posID."\n";
      } else {//should be posVslash is it
         $posID = $posVslash+3;
         print "Found in pos /v/, +3 posID=".$posID."\n";
      }
      $youTubeID = substr($inputString, $posID, 11);
      print "youTubeID is =".$youTubeID."\n";
   }

   // Sample ID: MLsdJlfA23E
   
   // Add code here to parse the ID from a URL if you'd like to make your input handling better.
   
   //if ($youTubeID == "") {
   if ($inputString == "") {
      // No ID passed, so we'll display the form.
      print "<H1>Demo Form</H1>\n";
      print "<FORM METHOD=\"GET\">\n";    // Note: if we don't specify an ACTION URL in a form,
                                          //       the current page is the target.
      print "YouTube ID: <INPUT TYPE=\"TEXT\" NAME=\"ID_from_form\">\n";
      print "<INPUT TYPE=\"submit\" VALUE=\"Submit\">\n";
      print "</FORM>\n";
   } else {
   
      // Note the use of single quotes below. You give up the ability to do variable substitution
      // within strings (and metacharacters like \n), but you don't have to escape every double
      // quotation mark.
      
      print '<object><embed src="http://www.youtube.com/v/';
      print $youTubeID;
      print '&h1=en&fs=1&autoplay=1&loop=1" type="application/x-shockwave-flash" ';
      print 'allowscriptaccess="always" allowfullscreen="true" width="500" height="400">';
      print '</embed></object>';
      print "<br />";
      print "<p>";
      print "Don't see your video? Make sure your URL is compelete and correct!";
   }
?>
