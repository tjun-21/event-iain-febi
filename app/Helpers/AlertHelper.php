<?php

if (!function_exists('alert_success')) {
    /**
     * Flash success message
     */
    function alert_success($message)
    {
        return session()->flash('success', $message);
    }
}

if (!function_exists('alert_error')) {
    /**
     * Flash error message
     */
    function alert_error($message)
    {
        return session()->flash('error', $message);
    }
}

if (!function_exists('alert_info')) {
    /**
     * Flash info message
     */
    function alert_info($message)
    {
        return session()->flash('info', $message);
    }
}

if (!function_exists('alert_warning')) {
    /**
     * Flash warning message
     */
    function alert_warning($message)
    {
        return session()->flash('warning', $message);
    }
}

if (!function_exists('redirect_with_success')) {
    /**
     * Redirect with success message
     */
    function redirect_with_success($route, $message, $parameters = [])
    {
        return redirect()->route($route, $parameters)->with('success', $message);
    }
}

if (!function_exists('redirect_with_error')) {
    /**
     * Redirect with error message
     */
    function redirect_with_error($route, $message, $parameters = [])
    {
        return redirect()->route($route, $parameters)->with('error', $message);
    }
}

if (!function_exists('back_with_error')) {
    /**
     * Redirect back with error and input
     */
    function back_with_error($message)
    {
        return redirect()->back()->withInput()->with('error', $message);
    }
}

if (!function_exists('back_with_success')) {
    /**
     * Redirect back with success message
     */
    function back_with_success($message)
    {
        return redirect()->back()->with('success', $message);
    }
}
