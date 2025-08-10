<?php

namespace App\Services;

use App\Models\AuthModel;

class AuthService
{
    private $authModel;
    private $passwordHashOptions = ['cost' => 12];

    public function __construct(\PDO $pdo)
    {
        $this->authModel = new AuthModel($pdo);
    }

    public function login(string $username, string $password): ?array
    {
        $user = $this->authModel->getUserByUsername($username);
        if ($user && password_verify($password, $user['password_hash'])) {
            return $user;
        }
        return null;
    }

    public function register(string $name, string $email, string $phone, string $password): ?array
    {
        if ($this->authModel->getUserByUsername($name)) {
            return null; // username tồn tại
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT, $this->passwordHashOptions);

        $data = [
            'name' => $name,
            'email' => $email,
            'phone_number' => $phone,
            'password_hash' => $passwordHash,
            'role' => 'user',
        ];

        if ($this->authModel->createUser($data)) {
            return $this->authModel->getUserByUsername($name);
        }
        return null;
    }

    // Giả lập gửi email reset (cần triển khai thực tế)
    public function sendPasswordResetLink(string $email): bool
{
    $user = $this->authModel->getUserByEmail($email);
    if (!$user) return false;

    $token = bin2hex(random_bytes(16)); // token 32 ký tự
    $expiresAt = date('Y-m-d H:i:s', time() + 3600); // 1 giờ hết hạn

    if (!$this->authModel->savePasswordResetToken($email, $token, $expiresAt)) {
        return false;
    }

    // TODO: Gửi email có link dạng: http://yourdomain/reset-password?token=$token
    // Bạn có thể dùng thư viện PHPMailer hoặc hàm mail() của PHP

    return true; // Giả lập thành công
}
public function validateResetToken(string $token): bool
{
    $reset = $this->authModel->getPasswordResetByToken($token);
    return $reset && strtotime($reset['expires_at']) > time();
}

public function resetPassword(string $token, string $newPassword): bool
{
    $reset = $this->authModel->getPasswordResetByToken($token);
    if (!$reset || strtotime($reset['expires_at']) < time()) {
        return false;
    }

    $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT, $this->passwordHashOptions);

    $updated = $this->authModel->updateUserPassword($reset['email'], $passwordHash);
    if ($updated) {
        $this->authModel->deletePasswordResetToken($reset['email']);
        return true;
    }
    return false;
}
}