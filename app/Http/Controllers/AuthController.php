<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function register(Request $request)
     {
         // Validasi input
         $request->validate([
             'username' => 'required|string|max:16|unique:users,username',
             'email' => 'required|string|email|max:255|unique:users,email',
             'password' => 'required|string|min:4|confirmed',
         ], [
             'username.unique' => 'Username has already been used',
             'email.unique' => 'The email has already been registered!',
             'password.confirmed' => 'Password confirmation does not match!',
         ]);
     
         // Simpan user ke database
         $user = User::create([
             'username' => $request->username,
             'email' => $request->email,
             'password' => bcrypt($request->password),
         ]);
     
         Auth::login($user);

         return redirect()->route('user.home');
     }
     

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);
    
        $login_type = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    
        // Coba autentikasi berdasarkan tipe login
        if (Auth::attempt([$login_type => $request->login, 'password' => $request->password])) {
            return redirect()->route('user.home');
        }
    
        return redirect()->back()->withErrors(['login' => 'Email/Username or password is incorrect!']);
    }
    

    public function logout()
    {
        Auth::logout();
        return redirect()->route('user.login');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
