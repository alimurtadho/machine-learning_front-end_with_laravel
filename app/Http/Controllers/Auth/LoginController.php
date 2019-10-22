<?php

namespace App\Http\Controllers\Auth;

use App\Activation;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function username()
    {
        return 'username';
    }

    public function authenticated(Request $request, $user)
    {
        if (config('settings.user.activation.enabled') && !$user->activated) {
            Activation::createTokenAndSendEmail($user);
            auth()->logout();
            return back()
                ->withInfo('You need to confirm your email address before logging in. We have sent you an email.')
                ->withAlertHeading('Confirmation Required');
        }

        return redirect()->intended($this->redirectPath());
    }

    public function activate($token)
    {
        if (!config('settings.user.activation.enabled')){
            abort(404);
        }

        if ($activation = Activation::getActivationByToken($token)) {
            if($activation->user->activated) {
                return redirect(route('login'))
                    ->withInfo('Your email has already been verified.');
            }

            $activation->activate();

            auth()->login($activation->user);

            return redirect($this->redirectPath())
                ->withSuccess('Your e-mail has been verified.')
                ->withAlertHeading('Welcome Aboard');
        }

        abort(404);
    }
}
