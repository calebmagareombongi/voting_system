<?php
// Simulate fetching resolutions from the server
$resolutions = ['Resolution 1: Lorem ipsum dolor sit amet.', 'Resolution 2: Consectetur adipiscing elit.'];
?>

<?php foreach ($resolutions as $resolution): ?>
    <li><?= $resolution ?></li>
<?php endforeach; ?>
