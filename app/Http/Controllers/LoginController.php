<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use function Webmozart\Assert\Tests\StaticAnalysis\null;

class LoginController extends Controller
{
    public function zaloguj(Request $request){
        $login=$request->login;
        $password=$request->password;
        $user=User::where('login', $login)->first();
        if(!empty($user)) {
            if ($user->password == $password) {
                session()->put('login', $login);
                return redirect('/dysk');
            } else {
                return redirect('/')->with('al', 2);
            }
        }else{
            return redirect('/')->with('al', 2);
        }

    }
    public function rejestruj(Request $request){
        $login=$request->login;
        $password=$request->password;
        $user=User::where('login', $login)->first();
        if(empty($user)) {
            User::create([
                'login' => $login,
                'password' => $password,
            ]);
            return redirect("/")->with('al', 1);
        }
        else{
            return redirect("/")->with('al', 3);
        }
    }
    public function logout(Request $req){
        $req->session()->pull('login');
        return redirect('/')->with('success','Zostałeś wylogowany!');
    }
}
