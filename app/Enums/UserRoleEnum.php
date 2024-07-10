<?php

namespace App\Enums;

enum UserRoleEnum: int
{
    case ADMIN = 1;
    case CUSTOMER = 2;

    /**
     * Get the label for the role.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            UserRoleEnum::ADMIN => 'Admin',
            UserRoleEnum::CUSTOMER => 'Customer',
        };
    }

    /**
     * Get an array of all roles with their values and labels.
     *
     * @return string[]
     */
    public static function toArray(): array
    {
        return [
            self::ADMIN->value => self::ADMIN->label(),
            self::CUSTOMER->value => self::CUSTOMER->label(),
        ];
    }

    /**
     * Get an instance of UserRoleEnum from a value.
     *
     * @param int $value
     * @return self
     */
    public static function fromValue(int $value): self
    {
        return match ($value) {
            self::ADMIN->value => self::ADMIN,
            self::CUSTOMER->value => self::CUSTOMER,
            default => throw new \InvalidArgumentException("Invalid UserRoleEnum value: $value"),
        };
    }
}
