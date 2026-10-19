<?php

// First matching pattern wins. Put the narrower word before the broader one.
// pattern is a regular expression. flags defaults to i.
// Set one of: emoji, font, svg, src.
// font is a class from a library loaded by icon-fonts.php.
return array(
    array('pattern' => 'vitamin c|ascorbic', 'emoji' => '🍊'),
    array('pattern' => '\\bprotein\\b', 'emoji' => '🥩'),
    array('pattern' => 'calcium|potassium', 'emoji' => '🥛'),
    array('pattern' => '\\bfiber\\b', 'emoji' => '🌾'),
    array('pattern' => '\\biron\\b', 'font' => 'fas fa-weight-hanging'),
    array('pattern' => 'omega', 'font' => 'fas fa-fish'),
    array('pattern' => 'daily intake', 'emoji' => '📅'),

    array(
        'pattern' => 'zelda',
        'svg' => "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path fill='currentColor' d='M12 2.2 14.6 8H9.4L12 2.2zM6.2 21.5 8.8 15.2H3.6L6.2 21.5zM17.8 21.5 20.4 15.2h-5.2L17.8 21.5z'/></svg>",
    ),
    array('pattern' => 'videogames|nintendo', 'font' => 'fas fa-gamepad'),
    array('pattern' => 'comedy', 'font' => 'fas fa-laugh'),
    array('pattern' => '\\bmusic\\b', 'font' => 'fas fa-music'),
    array('pattern' => '\\bnews\\b', 'src' => 'assets/icons/news.svg'),
    array('pattern' => '\\btravel\\b', 'emoji' => '✈️'),
    array('pattern' => '\\bsleep\\b', 'emoji' => '😴'),
);
