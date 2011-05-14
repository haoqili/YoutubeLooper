<?php
   // Demo of PHP 
   
   // Test to see if we were passed a YouTube ID...
   
   $youTubeID = $_REQUEST["ID_from_form"];
   
   // Sample ID: MLsdJlfA23E
   
   // Add code here to parse the ID from a URL if you'd like to make your input handling better.
   
   if ($youTubeID == "") {
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
   }
?>
