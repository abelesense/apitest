<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    /**
     * @var UserAuditService
     */
    protected UserAuditService $auditService;

    /**
     * Constructor
     *
     * @param UserAuditService $auditService
     */
    public function __construct(UserAuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    /**
     * Get paginated users
     *
     * @param int $perPage
     * @param int $page
     * @param int $maxPerPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedUsers(int $perPage = 15, int $page = 1, int $maxPerPage = 100): LengthAwarePaginator
    {
        if ($perPage > $maxPerPage) {
            $perPage = $maxPerPage;
        }

        return User::select('id', 'name', 'email', 'role', 'created_at', 'updated_at')
            ->orderBy('id', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Create a new user
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'] ?? 'user',
        ];

        if (isset($data['password'])) {
            $userData['password'] = Hash::make($data['password']);
        }

        $user = new User();
        $user->fill($userData);
        $user->save();

        $this->auditService->logCreated($user);

        return $user;
    }

    /**
     * Get user by ID
     *
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): ?User
    {
        return User::find($id);
    }

}
