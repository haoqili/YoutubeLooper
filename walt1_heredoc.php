<!-- From Walt's email on 10/31/09, from wikipedia -->

<?php

$name       = "HaoQi Li";
$occupation = "Student";
echo
<<<EOF

This is a heredoc section.
For more information talk to $name, your local $occupation.

Thanks!

EOF
;

$toprint =
<<<EOF

Hey $name! You can actually assign the heredoc section to a variable!

EOF
;
echo strtolower($toprint);

?>


