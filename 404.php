<?php
http_response_code(404);
$page_title = 'Page not found';
$page_description = 'The page you are looking for could not be found.';
require __DIR__ . '/includes/header.php';
?>
<section class="not-found"><div class="container not-found-layout"><div><p class="error-code">404</p><p class="eyebrow">Page not found</p><h1>Looks like this page took a different <em>path.</em></h1><p class="lead">The link may be outdated, or the page may have moved. Let’s get you back somewhere useful.</p><div class="button-row"><a class="button" href="index.php">Back home <span>→</span></a><a class="button button-ghost" href="contact.php">Contact us</a></div></div><div class="lost-map" aria-hidden="true"><span class="map-pin">×</span><i class="map-route route-one"></i><i class="map-route route-two"></i><b>YOU<br>ARE<br>HERE</b></div></div><div class="container recovery-links"><p>Or try one of these:</p><a href="about.php">About <span>→</span></a><a href="services.php">Services <span>→</span></a><a href="blog.php">Journal <span>→</span></a><a href="dashboard.php">Dashboard <span>→</span></a></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
