<?php

// First matching pattern wins. Patterns are regular expressions.
// flags defaults to i. A pattern may also be written as /vitamin c/i.
return array(
    array('pattern' => 'vitamin c|ascorbic', 'emoji' => '🍊'),
    array('pattern' => '\\bprotein\\b', 'emoji' => '🥩'),
    array('pattern' => '\\biron\\b', 'emoji' => '⚙️'),
    array('pattern' => 'comedy', 'emoji' => '😄'),
);
