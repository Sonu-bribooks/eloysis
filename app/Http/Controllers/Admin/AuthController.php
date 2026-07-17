<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Admin\LoginService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\LoginRequest;

class AuthController extends BaseController
{
    public function __construct(
        protected LoginService $loginService
    ){}

    public function index()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $result = $this->loginService->login($request->validated());
        // dd($result);
        if (! $result['status']) {

            return $this->error(
                $result['message']
            );
        }
        $request->session()->regenerate();
        return $this->success(
           $result['message'],
            [
                'redirect' => route('admin.dashboard')
            ]

        );
    }

    public function logout()
    {
         Auth::guard('admin')->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
