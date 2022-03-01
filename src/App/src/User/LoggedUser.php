<?php
declare(strict_types=1);

namespace App\User;

final class LoggedUser
{
    private string $id;
    private string $location;
    private array $roles;

    public function __construct(string $id, ?string $location, array $roles)
    {
        $this->id = $id;
        $this->location = $location;
        $this->roles = $roles;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function location(): ?string
    {
        return $this->location;
    }

    public function roles(): array
    {
        return $this->roles;
    }
}
