<?php

namespace App\Policies;

use App\Enums\UserRoleEnum;
use App\Models\{Brand, User};

class BrandPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user['role_id'] == UserRoleEnum::ADMIN;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Brand $brand
     * @return bool
     */
    public function view(User $user, Brand $brand): bool
    {
        return $user['role_id'] == UserRoleEnum::ADMIN;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user['role_id'] == UserRoleEnum::ADMIN;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Brand $brand
     * @return bool
     */
    public function update(User $user, Brand $brand): bool
    {
        return $user['role_id'] == UserRoleEnum::ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Brand $brand
     * @return bool
     */
    public function delete(User $user, Brand $brand): bool
    {
        return $user['role_id'] == UserRoleEnum::ADMIN;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Brand $brand
     * @return bool
     */
    public function restore(User $user, Brand $brand): bool
    {
        return $user['role_id'] == UserRoleEnum::ADMIN;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Brand $brand
     * @return bool
     */
    public function forceDelete(User $user, Brand $brand): bool
    {
        return $user['role_id'] == UserRoleEnum::ADMIN;
    }
}
