<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserValidationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login()
    {
      if(session()->has('user'))
      {
        return to_route('dashboard');
      }
      return view('login');
    }

  
    public function loginAuth(Request $req)
    {
      $credentials = $req->only('email', 'password');
      
      if(Auth::attempt($credentials))
      {
        $req->session()->put('user', $req->input('email'));
        return redirect()->intended('/dashboard');
      }
      return back()
        ->withErrors([
          'invalid' => 'Invalid Credentials',
          ])
        ->withInput();
    }
    
    
    public function logout()
    {
      if(session()->has('user'))
      {
        session()->pull('user');
      }
      return redirect()->route('login.form');
    }
    
    
    public function dashboard()
    {
      $users = User::all();
      return view('dashboard', compact('users'));
    }
    
    
    public function switchAccount(Request $req)
    {
      if(Auth::user()->isAdmin())
      {
        $user = User::findOrFail($req->input('userId'));
        Auth::login($user);
        return redirect()->intended('/dashboard');
      }
      abort(403, 'UNAUTHORIZED ACTION');
    }


  public function register(Request $req)
  {
    $customErrorMessage = [
      'g-recaptcha-response' => 'Captcha is required.',
      ];
      
    $validator = Validator::make($req->all(), (new UserValidationRequest)->rules(), $customErrorMessage);
    
    if($validator->fails())
    {
      return redirect()->back()
      ->withErrors($validator)
      ->withInput();
    }
    
    User::create([
      'name' => $req->input('name'),
      'email' => $req->input('email'),
      'password' => Hash::make($req->input('password')),
      'role' => $req->input('role'),
      ]);
      
    $req->session()->flash('success', 'User added successfully');
    
    return redirect()->back();
  }
}
