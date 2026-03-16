<?php

/**
 * Simple in-memory "database" for demo purposes.
 *
 * Data is stored in the PHP session to behave a bit like a real
 * database-backed repository, but nothing is persisted to disk.
 */
class Database
{
    public function __construct(array $config)
    {
        // Configuration is accepted but not used; kept to resemble a real DB class.
        $this->bootstrapSession();
    }

    /**
     * Ensure the session is started and seeded with some demo users.
     */
    private function bootstrapSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['users'])) {
            $_SESSION['users'] = [
                1 => ['id' => 1, 'name' => 'Alice Example', 'email' => 'alice@example.test'],
                2 => ['id' => 2, 'name' => 'Bob Example', 'email' => 'bob@example.test'],
            ];
            $_SESSION['next_user_id'] = 3;
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getUsers(): array
    {
        return array_values($_SESSION['users'] ?? []);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getUserById(int $id): ?array
    {
        return $_SESSION['users'][$id] ?? null;
    }

    /**
     * @param array<string, string> $data
     * @return array<string, mixed> The created user
     */
    public function createUser(array $data): array
    {
        $id = (int) ($_SESSION['next_user_id'] ?? 1);
        $_SESSION['next_user_id'] = $id + 1;

        $user = [
            'id' => $id,
            'name' => trim($data['name'] ?? ''),
            'email' => trim($data['email'] ?? ''),
        ];

        $_SESSION['users'][$id] = $user;

        return $user;
    }

    /**
     * @param array<string, string> $data
     * @return array<string, mixed>|null The updated user or null if not found
     */
    public function updateUser(int $id, array $data): ?array
    {
        if (!isset($_SESSION['users'][$id])) {
            return null;
        }

        $_SESSION['users'][$id]['name'] = trim($data['name'] ?? $_SESSION['users'][$id]['name']);
        $_SESSION['users'][$id]['email'] = trim($data['email'] ?? $_SESSION['users'][$id]['email']);

        return $_SESSION['users'][$id];
    }

    public function deleteUser(int $id): void
    {
        unset($_SESSION['users'][$id]);
    }
}

