<?php

namespace UrlLogin\Http\Controllers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use UrlLogin\Models\UrlLoginToken;

abstract class UrlAuthController extends Controller
{
    protected const REMEMBER_AFTER_AUTHENTICATION = false;

    public function __construct()
    {
        $this->middleware('guest:' . $this->getAuthGuardName())->only(['authenticate']);
    }

    abstract protected function getAuthGuardName(): string;

    protected function getAuthGuard(): StatefulGuard
    {
        return Auth::guard($this->getAuthGuardName());
    }

    protected function redirectAfterAuthenticated(Request $request, Authenticatable $user)
    {
        return redirect()->intended();
    }

    /**
     * @throws ModelNotFoundException
     */
    public function authenticate(Request $request, string $authId, string $authToken)
    {
        $urlLoginToken = UrlLoginToken::retrieve($authId, $authToken);
        $user = $urlLoginToken->tokenable;

        $this->getAuthGuard()->login($user, self::REMEMBER_AFTER_AUTHENTICATION);

        $urlLoginToken->consume($request);

        $request->session()->regenerate();

        return $this->redirectAfterAuthenticated($request, $user);
    }

    public function logout(Request $request)
    {
        $this->getAuthGuard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }
}
