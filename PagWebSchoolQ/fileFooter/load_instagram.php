<?php
// Elenco statico dei profili Instagram
$profiles = [
  ['username' => '@schoolq_official', 'url' => 'https://instagram.com/schoolq_official'],
  ['username' => '@team_schoolq', 'url' => 'https://instagram.com/team_schoolq'],
];

foreach ($profiles as $profile) {
  echo '<p><a href="' . $profile['url'] . '" target="_blank" style="color: #0A3D62;">' . $profile['username'] . '</a></p>';
}
?>
