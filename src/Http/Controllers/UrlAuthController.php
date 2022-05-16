<?php

namespace UrlLogin\Http\Controllers;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use UrlLogin\Contracts\AuthenticatableViaUrl;

abstract class UrlAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:' . $this->getAuthGuardName())->only(['authenticate']);
    }

    abstract protected function getAuthGuardName(): string;

    protected function getAuthGuard(): StatefulGuard
    {
        return Auth::guard($this->getAuthGuardName());
    }

    protected function redirectAfterAuthenticated(Request $request)
    {
    }

    /**
     * @throws ValidationException
     */
    public function authenticate(Request $request, string $authId, string $authToken)
    {
        if (! $this->getAuthGuard()->attempt([
            config('url-login.model_parameters.auth_id') => $authId,
            config('url-login.model_parameters.auth_token_hash') => $authToken,
        ], true)) {
            throw ValidationException::withMessages([
                'form' => [__('auth.failed')],
            ]);
        }

        $request->session()->regenerate();

        /** @var AuthenticatableViaUrl $user */
        $user = $this->getAuthGuard()->user();

        $user->invalidateUrlAuthToken();

        $this->redirectAfterAuthenticated($request);
    }

    public function logout(Request $request)
    {
        $this->getAuthGuard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }
}
