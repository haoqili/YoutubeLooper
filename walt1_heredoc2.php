<!-- From Walt's email on 10/31/09, from wikipedia

In this version:

* added pre to make the text indent as written here
* tried to add html stuff to it, like <b>
 -->

<?php
print "<pre>\n";

$name       = "HaoQi Li";
$occupation = "Student";
echo
<<<EOF

This is a heredoc section.
For more information talk to $name, your local $occupation.

<b>Thanks!</b>

EOF
;

$toprint =
<<<EOF

Hey $name! You can actually assign the heredoc section to a variable!

EOF
;
echo strtolower($toprint);
print "</pre>\n";
?>


