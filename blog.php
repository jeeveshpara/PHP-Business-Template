<?php
$page_title = 'Insights';
$page_description = 'Articles and thoughts from the Nexa Studio team.';
require __DIR__ . '/includes/header.php';
$posts = [
    ['tag' => 'Strategy', 'title' => 'The questions to ask before you redesign your website', 'date' => 'May 18, 2026', 'class' => 'post-art-blue'],
    ['tag' => 'Design', 'title' => 'A clearer way to think about your product’s first impression', 'date' => 'April 29, 2026', 'class' => 'post-art-peach'],
    ['tag' => 'Development', 'title' => 'Five small choices that make a site feel faster', 'date' => 'April 07, 2026', 'class' => 'post-art-green'],
];
?>
<section class="page-hero compact"><div class="container narrow"><p class="eyebrow">Journal</p><h1>Ideas for building with a little more <em>intention.</em></h1></div></section>
<section class="section blog-section"><div class="container blog-grid"><?php foreach ($posts as $post): ?><article class="post-card"><div class="post-art <?= escape($post['class']) ?>"><span>NS</span></div><div class="post-content"><p class="post-meta"><?= escape($post['tag']) ?> <i>•</i> <?= escape($post['date']) ?></p><h2><?= escape($post['title']) ?></h2><a href="404.php">Read article →</a></div></article><?php endforeach; ?></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
