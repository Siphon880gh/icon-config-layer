<?php
require __DIR__ . '/src/IconMatcher.php';

$icons = IconMatcher::load(__DIR__ . '/config/sample-rules.php');
$labels = array(
    'Vitamin C',
    'Protein',
    'Calcium',
    'Fiber (total)',
    'Iron',
    'Omega-3',
    'Daily intake',
    'Zelda OoT',
    'Opinion/Videogames',
    'Comedy',
    'Mood/Music',
    'News',
    'Travel',
    'Sleep',
);

function h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Icon config</title>
    <?php include __DIR__ . '/icon-fonts.php'; ?>
    <link rel="stylesheet" href="assets/demo.css">
</head>
<body>
    <main>
        <h1>Word match</h1>
        <p>Each line is a label. The icon is the first rule in <code>config/sample-rules.php</code> whose pattern fits.</p>
        <ul>
            <?php foreach ($labels as $label): ?>
                <?php $rule = $icons->match($label); ?>
                <li>
                    <?php echo $icons->html($label); ?>
                    <span class="label"><?php echo h($label); ?></span>
                    <?php if ($rule): ?>
                        <code><?php echo h($rule['pattern']); ?></code>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </main>
</body>
</html>
