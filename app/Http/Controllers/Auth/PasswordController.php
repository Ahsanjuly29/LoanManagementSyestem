<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\Password;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect user(s) after resetting password.
     *
     * @var string
     */
    protected $redirectTo = '/admin';
    
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getEmail()
    {
        $this->data['page_title']='Forgot password';
        return view('admin.auth.password')->with($this->data);
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendResetLinkEmail(Request $request)
    {
        $messages = array(
            'g-recaptcha-response.required' => 'The recaptcha field is required.'
        );
        
        $this->validate($request, [
            'email' => 'required|email',
            /*'g-recaptcha-response' => 'required|captcha'*/
        ], $messages);

        $broker = $this->getBroker();

        $response = Password::broker($broker)->sendResetLink(
            $request->only('email'), $this->resetEmailBuilder()
        );

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return $this->getSendResetLinkEmailSuccessResponse($response);

            case Password::INVALID_USER:
            default:
                return $this->getSendResetLinkEmailFailureResponse($response);
        }
    }

    public function getReset($token)
    {
        $this->data['page_title']='Reset password';
        $this->data['token']=$token;        
        return view('admin.auth.reset')->with($this->data);
    }
}
