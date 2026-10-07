<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_login();
$user = $_SESSION['user'];
$page_title = 'Dashboard';
$page_description = 'Your Nexa Studio dashboard.';
require __DIR__ . '/includes/header.php';
?>
<section class="member-section"><div class="container"><div class="member-heading"><div><p class="eyebrow">Member area</p><h1>Good morning, <?= escape(explode(' ', $user['name'])[0]) ?>.</h1><p>Here is a quick view of your account and project activity.</p></div><a class="button button-small" href="contact.php">New enquiry <span>→</span></a></div><div class="dashboard-grid"><article class="status-card highlight-card"><span class="status-label">Current project</span><h2>Website discovery</h2><p>Your initial workshop is ready to schedule.</p><div class="progress-label"><span>Progress</span><strong>20%</strong></div><div class="progress"><i></i></div><a href="contact.php">View project brief →</a></article><article class="status-card"><span class="status-label">Next step</span><h2>Book your workshop</h2><p>Choose a time for our 60-minute alignment call.</p><a href="contact.php">Find a time →</a></article><article class="status-card"><span class="status-label">Account</span><h2>Keep details current</h2><p><?= escape($user['email']) ?></p><a href="profile.php">Edit profile →</a></article></div><div class="activity"><div class="section-heading"><div><p class="eyebrow">Activity</p><h2>Recent updates</h2></div></div><div class="activity-list"><div><span class="activity-dot"></span><p><strong>Account created</strong><small>Your Nexa Studio member account is active.</small></p><time>Today</time></div><div><span class="activity-dot pale"></span><p><strong>Welcome to your dashboard</strong><small>Use this space to follow project progress.</small></p><time>Today</time></div></div></div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
