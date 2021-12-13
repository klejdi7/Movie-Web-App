<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use DB;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @author Klejdi Arapi
     *
     * 
     */

    public function index()
    {
        if(Auth::check()){

        $user = [
            'id' => Auth::user()->id,
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'username' => Auth::user()->username,
            'role' => Auth::user()->role,
        ];

        return response()->json($user);

        } else {
            return response()->json([ 'user_msg' => 'User not logged in', 'logged_in' => false ], 406);

        }
    }

    /**
     * 
     * 
     * 
     * 
     */

    public function show($id)
    {

        $user = User::where('id', $id)->select('name' , 'username', 'created_at')->get();

        return $user->toArray();
    }

    /** 
     * 
     * 
     * 
     * 
    */

}
