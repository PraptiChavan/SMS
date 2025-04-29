<?php
if (!function_exists('checkRole')) {
    function checkRole($role)
    {
        if (Session::get('user_type') !== $role) {
            abort(403, 'Unauthorized action.');
        }
    }
}
