<?php

namespace App\Services;

use App\Models\AuthModel;

class AuthService
{
    private $authModel;
    private $passwordHashOptions = [
        'cost' => 12,
    ];

    public function __construct(AuthModel $authModel)
    {
        $this->authModel = $authModel;
    }

    public function login(string $email, string $password): ?array
    {
        $user = $this->authModel->getUserByEmail($email);
        if ($user && password_verify($password, $user['password_hash'])) {
            return $user;
        }
        return null;
    }

    public function register(string $name, string $email, string $phone, string $password, ?string $gender = null, ?string $birthDate = null): ?array
    {
        if ($this->authModel->getUserByEmail($email)) {
            return null;
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT, $this->passwordHashOptions);

        $data = [
            'name' => $name,
            'email' => $email,
            'phone_number' => $phone,
            'password_hash' => $passwordHash,
            'gender' => $gender,
            'birth_date' => $birthDate,
        ];

        if ($this->authModel->createUser($data)) {
            return $this->authModel->getUserByEmail($email);
        }
        return null;
    }
}
