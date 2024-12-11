<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;

class CustomEloquentUserProvider extends EloquentUserProvider
{
    /**
     * Retrieve a user by their unique identifier and load relationships.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        // Use the parent method to get the user
        $user = parent::retrieveById($identifier);
        
        if ($user) {
            // Load relationships
            $user->load(['Company', 'Roles', 'permissions']);
        }
        return $user;
    }
}