<?php

namespace App\Services;

use App\Models\ProfileModel;

class ProfileService
{
    private $profileModel;

    public function __construct(ProfileModel $profileModel)
    {
        $this->profileModel = $profileModel;
    }

    public function getUserProfile(int $userId): ?array
    {
        $user = $this->profileModel->getUserProfile($userId);
        if (!$user) {
            return null;
        }

        $address = $this->profileModel->getDefaultAddress($userId);
        return array_merge($user, [
            'address' => $address ?: [
                'address' => '',
                'ward_commune' => '',
                'district' => '',
                'province_city' => ''
            ]
        ]);
    }
    public function updateUserProfile(int $userId, array $data): bool
    {
        return $this->profileModel->updateUserProfile($userId, $data);
    }

    public function updateUserAddress(int $userId, array $data): bool
    {
        return $this->profileModel->updateUserAddress($userId, $data);
    }
}
