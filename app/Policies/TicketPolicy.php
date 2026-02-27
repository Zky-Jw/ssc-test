<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ticket;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        // Role 102 dan 106 bisa melihat semua tiket
        return in_array($user->role, [102, 106]);
    }

    public function viewOwn(User $user)
    {
        // Role 101 hanya bisa melihat tiket yang dibuatnya
        return $user->role == 101;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function viewAssigned(User $user)
    {
        // Role 103 dan 104 hanya bisa melihat tiket yang ditujukan ke unit mereka
        return in_array($user->role, [103, 104]);
    }

    public function viewAll(User $user)
    {
        // Role 105 hanya bisa melihat semua tiket tanpa action
        return $user->role == 105;
    }


    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ticket $ticket): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ticket $ticket): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ticket $ticket): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ticket $ticket): bool
    {
        //
    }
}
