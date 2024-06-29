<?php

namespace App\Enums;

enum UserRole: int
{
    case Admin = 1;
    case Customer = 2;

    /**
     * Get the label for the role.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            UserRole::Admin => 'Admin',
            UserRole::Customer => 'Customer',
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
            self::Admin->value => self::Admin->label(),
            self::Customer->value => self::Customer->label(),
        ];
    }

    /**
     * Get an instance of UserRole from a value.
     *
     * @param int $value
     * @return self
     */
    public static function fromValue(int $value): self
    {
        return match ($value) {
            self::Admin->value => self::Admin,
            self::Customer->value => self::Customer,
            default => throw new \InvalidArgumentException("Invalid UserRole value: $value"),
        };
    }
}
