<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserHelper
{
    /**
     * Get authenticated user data by parameter
     *
     * @param string|array $parameter Parameter(s) to get from user data
     * @param mixed $default Default value if parameter not found
     * @return mixed
     */
    public static function getUser($parameter = null, $default = null)
    {
        $user = Auth::user();

        if (!$user) {
            return $default;
        }

        // If no parameter specified, return entire user object
        if ($parameter === null) {
            return $user;
        }

        // If parameter is an array, return multiple values
        if (is_array($parameter)) {
            $result = [];
            foreach ($parameter as $param) {
                $result[$param] = $user->{$param} ?? $default;
            }
            return $result;
        }

        // If parameter is a string, return single value
        return $user->{$parameter} ?? $default;
    }

    /**
     * Get authenticated user ID
     *
     * @return int|null
     */
    public static function getUserId()
    {
        return Auth::id();
    }

    /**
     * Get authenticated user name
     *
     * @return string|null
     */
    public static function getUserName()
    {
        return self::getUser('name');
    }

    /**
     * Get authenticated user email
     *
     * @return string|null
     */
    public static function getUserEmail()
    {
        return self::getUser('email');
    }

    /**
     * Check if user is authenticated
     *
     * @return bool
     */
    public static function isLoggedIn()
    {
        return Auth::check();
    }

    /**
     * Check if user has specific attribute value
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public static function hasAttribute($attribute, $value)
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $user->{$attribute} === $value;
    }

    /**
     * Get user data with relationships
     *
     * @param string|array $relations
     * @param string|array $parameter
     * @param mixed $default
     * @return mixed
     */
    public static function getUserWithRelations($relations, $parameter = null, $default = null)
    {
        if (!Auth::check()) {
            return $default;
        }

        $user = User::with($relations)->find(Auth::id());

        if (!$user) {
            return $default;
        }

        // If no parameter specified, return entire user object with relations
        if ($parameter === null) {
            return $user;
        }

        // If parameter is an array, return multiple values
        if (is_array($parameter)) {
            $result = [];
            foreach ($parameter as $param) {
                // Support nested attributes like 'profile.phone'
                $result[$param] = data_get($user, $param, $default);
            }
            return $result;
        }

        // If parameter is a string, return single value
        // Support nested attributes like 'profile.phone'
        return data_get($user, $parameter, $default);
    }

    /**
     * Get user avatar or default image
     *
     * @param string $default Default avatar URL
     * @return string
     */
    public static function getUserAvatar($default = '/images/default-avatar.png')
    {
        $avatar = self::getUser('avatar');
        return $avatar ?: $default;
    }

    /**
     * Get user display name (name or email if name is empty)
     *
     * @return string
     */
    public static function getDisplayName()
    {
        $name = self::getUser('name');
        $email = self::getUser('email');

        return $name ?: ($email ? explode('@', $email)[0] : 'Unknown User');
    }

    /**
     * Get user initials for avatar placeholder
     *
     * @return string
     */
    public static function getUserInitials()
    {
        $name = self::getUser('name');

        if (!$name) {
            return 'U';
        }

        $words = explode(' ', trim($name));
        $initials = '';

        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
            if (strlen($initials) >= 2) break;
        }

        return $initials ?: 'U';
    }
}
