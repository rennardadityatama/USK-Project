<?php
function roleLabel($role) {
  return [
    'admin' => 'Admin',
    'user' => 'User'
  ][$role] ?? '-';
}
