<?php

require_once 'Database.php';

class User
{
  private $db;

  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  public function findById($id)
  {
    $stmt = $this->db->prepare("
        SELECT 
            u.*, 
            r.name AS role_name
        FROM users u
        LEFT JOIN roles r ON u.role_id = r.id
        WHERE u.id = ?
        LIMIT 1
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }


  public function findByEmail($email)
  {
    $stmt = $this->db->prepare(
      "SELECT * FROM users WHERE email = ? 
      LIMIT 1"
    );
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function findByNik($nik)
  {
    $stmt = $this->db->prepare(
      "SELECT * FROM users WHERE nik = ? AND deleted_at IS NULL
      LIMIT 1"
    );
    $stmt->execute([$nik]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function findByPhone($phone)
  {
    $stmt = $this->db->prepare(
      "SELECT * FROM users WHERE phone = ? LIMIT 1"
    );
    $stmt->execute([$phone]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function findByEmailExceptId($email, $id)
  {
    $stmt = $this->db->prepare("
    SELECT id FROM users 
    WHERE email = ? 
      AND id != ?
      AND deleted_at IS NULL
    LIMIT 1
  ");
    $stmt->execute([$email, $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function findByNikExceptId($nik, $id)
  {
    $stmt = $this->db->prepare("
    SELECT id FROM users 
    WHERE nik = ? 
      AND id != ?
      AND deleted_at IS NULL
    LIMIT 1
  ");
    $stmt->execute([$nik, $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function updateProfile($id, $data)
  {
    if (empty($data)) {
      return false; // tidak ada yang diupdate
    }

    $fields = [];
    $params = [];

    foreach ($data as $key => $value) {
      $fields[] = "$key = :$key";
      $params[":$key"] = $value;
    }

    $params[':id'] = $id;

    $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";

    $stmt = $this->db->prepare($sql);
    return $stmt->execute($params);
  }


  /* =========================
     AUTH / LOGIN
  ========================= */

  public function login($email, $password)
  {
    $stmt = $this->db->prepare("
    SELECT 
      u.*, 
      r.name AS role_name
    FROM users u
    LEFT JOIN roles r ON u.role_id = r.id
    WHERE u.email = ?
    LIMIT 1
    ");

    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
      return false; // email tidak ditemukan
    }

    if (!password_verify($password, $user['password'])) {
      return false; // password salah
    }

    return $user; // login valid
  }

  /* =========================
     REGISTER
  ========================= */

  public function register($data)
  {
    $stmt = $this->db->prepare("
      INSERT INTO users (name, email, password, phone, address, role_id)
      VALUES (:name, :email, :password, :phone, :address, :role_id)
    ");

    return $stmt->execute([
      ':name'           => $data['name'],
      ':email'          => $data['email'],
      ':password'       => password_hash($data['password'], PASSWORD_DEFAULT),
      ':phone'          => $data['phone'],
      ':address'        => $data['address'],
      ':role_id'        => 2,
    ]);
  }

  /* =========================
     RESET PASSWORD
  ========================= */

  public function saveResetToken($email, $token, $expiry)
  {
    $stmt = $this->db->prepare("
      UPDATE users 
      SET reset_token = ?, reset_expiry = ? 
      WHERE email = ?
    ");
    return $stmt->execute([$token, $expiry, $email]);
  }

  public function findByToken($token)
  {
    $stmt = $this->db->prepare("
      SELECT * FROM users
      WHERE reset_token = ?
        AND reset_expiry >= NOW()
    ");
    $stmt->execute([$token]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function updatePassword($id, $password)
  {
    $stmt = $this->db->prepare("
      UPDATE users 
      SET password = ?, reset_token = NULL, reset_expiry = NULL 
      WHERE id = ?
    ");
    return $stmt->execute([
      password_hash($password, PASSWORD_DEFAULT),
      $id
    ]);
  }

  public function getUsersByRole($roleId)
  {
    $stmt = $this->db->prepare("
        SELECT *
        FROM users
        WHERE role_id = :role
        ORDER BY id DESC
    ");
    $stmt->execute([
      ':role' => $roleId
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
