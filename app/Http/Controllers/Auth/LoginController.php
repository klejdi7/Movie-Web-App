<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\Models\User;
use Spatie\Permission\Traits\HasRoles;
use Redirect;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to convenienuse Illuminate\Http\Request;
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function __construct()
    {

        $this->middleware('guest')->except('logout');

    }
		/*
		LOGOUT User
		*/
        public function logout(Request $request) {
            Auth::logout();
            return redirect('/');
        }

		/*
		Login User
		*/
        public function login(Request $request)
        {
            $validator = Validator::make($request->all(), [               
                'email' => 'required',
                'psw' => 'required|string'
            ]);
        
            if ($validator->fails()) {    
                return response()->json(["errors" => "Both fields required!"], 406);
            }
                
            $user = User::where('email', $request->input('email'))->first();
           
            if($user) {
                
                $credentials = [
                    "email" => $request->get('email'),
                    "password" => $request->get('psw'),
                ];
                
                $auth = Auth::attempt($credentials);
          
                if($auth) {

                    Auth::login($user);

                    return redirect()->route('home')->withSession(['user' => $user]);

                    } else {
    
                    return response()->json([ 'errors' => 'Email or password is invalid' ], 401);

                    } 
                } else {
    
                    return response()->json(['errors' => 'User Does not exist' ], 401);
                }
            }
        }