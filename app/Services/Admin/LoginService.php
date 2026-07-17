<?php

namespace App\Services\Admin;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function login(array $credentials)
    {
        $login = $credentials['email'];

        $field = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        if (! Auth::guard('admin')->attempt([
            $field     => $login,
            'password' => $credentials['password']
        ])) {

            return [
                'status' => false,
                'message' => 'Invalid username/email or password.'
            ];
        }

        $user = Auth::guard('admin')->user();

         if (! in_array($user->role->slug, [
            'super_admin',
            'admin',
            'teacher'
        ])) {

            Auth::guard('admin')->logout();
            return [
                'status' => false,
                'message' => 'You are not authorized to access admin panel.'
            ];
        }

        if ((int) $user->status !== 1) {
            Auth::guard('admin')->logout();

            return [
                'status' => false,
                'message' => 'Your account is inactive.'
            ];
        }
        return [
            'status' => true,
            'user' => $user,
            'message' => 'Login successful.'
        ];
    }
}
