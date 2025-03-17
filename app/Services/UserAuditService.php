<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use UserAuditLog;

class UserAuditService
{

    /**
     * Logging the creation of a user
     *
     * @param User $user
     * @return void
     */
    public function logCreated(User $user)
    {
        $this->log($user->id, 'create', null, $this->getUserDataForLog($user));
    }
    /**
     * Creating a log entry
     *
     * @param int $userId
     * @param string $action
     * @param array|null $oldValues
     * @param array|null $newValues
     * @return void
     */
    protected function log($userId, $action, $oldValues = null, $newValues = null)
    {
        UserAuditLog::create([
            'user_id' => $userId,
            'performed_by' => Auth::id(),
            'action' => $action,
            'old_values' => $oldValues,
            'new_values' => $newValues,
        ]);
    }

    /**
     * Obtaining user data for logging
     *
     * @param User $user
     * @return array
     */
    protected function getUserDataForLog(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
    }
}
