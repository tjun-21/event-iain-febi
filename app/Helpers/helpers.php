<?php

use App\Helpers\UserHelper;

if (!function_exists('auth_user')) {
    /**
     * Get authenticated user data by parameter
     *
     * @param string|array|null $parameter Parameter(s) to get from user data
     * @param mixed $default Default value if parameter not found
     * @return mixed
     */
    function auth_user($parameter = null, $default = null)
    {
        return UserHelper::getUser($parameter, $default);
    }
}

// if (!function_exists('user_id')) {
//     /**
//      * Get authenticated user ID
//      *
//      * @return int|null
//      */
//     function user_id()
//     {
//         return UserHelper::getUserId();
//     }
// }

if (!function_exists('user_name')) {
    /**
     * Get authenticated user name
     *
     * @return string|null
     */
    function user_name()
    {
        return UserHelper::getUserName();
    }
}

if (!function_exists('user_email')) {
    /**
     * Get authenticated user email
     *
     * @return string|null
     */
    function user_email()
    {
        return UserHelper::getUserEmail();
    }
}

if (!function_exists('is_logged_in')) {
    /**
     * Check if user is authenticated
     *
     * @return bool
     */
    function is_logged_in()
    {
        return UserHelper::isLoggedIn();
    }
}

if (!function_exists('user_avatar')) {
    /**
     * Get user avatar or default image
     *
     * @param string $default Default avatar URL
     * @return string
     */
    function user_avatar($default = '/images/default-avatar.png')
    {
        return UserHelper::getUserAvatar($default);
    }
}

if (!function_exists('user_display_name')) {
    /**
     * Get user display name
     *
     * @return string
     */
    function user_display_name()
    {
        return UserHelper::getDisplayName();
    }
}

if (!function_exists('user_initials')) {
    /**
     * Get user initials
     *
     * @return string
     */
    function user_initials()
    {
        return UserHelper::getUserInitials();
    }
}

if (!function_exists('user_with_relations')) {
    /**
     * Get user data with relationships
     *
     * @param string|array $relations
     * @param string|array|null $parameter
     * @param mixed $default
     * @return mixed
     */
    function user_with_relations($relations, $parameter = null, $default = null)
    {
        return UserHelper::getUserWithRelations($relations, $parameter, $default);
    }
}

if (!function_exists('user_has')) {
    /**
     * Check if user has specific attribute value
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    function user_has($attribute, $value)
    {
        return UserHelper::hasAttribute($attribute, $value);
    }
}
