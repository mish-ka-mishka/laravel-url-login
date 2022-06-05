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
    public function __construct()
    {
        $this->middleware('guest:' . $this->getAuthGuardName())->only(['authenticate']);
    }

    protected function getAuthGuardName(): ?string
    {
        return null;
    }

    protected function getAuthGuard(): StatefulGuard
    {
        return Auth::guard($this->getAuthGuardName());
    }

    protected function isNeededToRemember(Request $request, Authenticatable $user): bool
    {
        return true;
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

        $this->getAuthGuard()->login($user, $this->isNeededToRemember($request, $user));

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
