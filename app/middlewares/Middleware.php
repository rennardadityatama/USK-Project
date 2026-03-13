<?php

require_once BASE_PATH . '/app/models/UserModels.php';

class Middleware
{
  public static function check()
  {
    if (empty($_SESSION['user'])) {
      header('Location: ' . BASE_URL . 'index.php?c=auth&m=login');
      exit;
    }
  }

  public static function role(array $roles)
  {
    self::check();

    if (!in_array((int)$_SESSION['user']['role'], $roles, true)) {
      http_response_code(403);
      echo "Akses ditolak";
      var_dump($_SESSION['user']['role'], $roles);
      exit;
    }
  }

  public static function getUrlByRole($role)
  {
    switch ($role) {
      case 1:
        return BASE_URL . 'index.php?c=admin&m=dashboard';
      case 2:
        return BASE_URL . 'index.php?c=user&m=dashboard';
      default:
        return BASE_URL . 'index.php?c=auth&m=login';
    }
  }
  public static function getCurrentRole(): ?int
  {
    return $_SESSION['user']['role'] ?? null;
  }

  public static function isRole(int $role): bool
  {
    return isset($_SESSION['user']['role']) && (int)$_SESSION['user']['role'] === $role;
  }
}
