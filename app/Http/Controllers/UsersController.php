<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        return view('users.index', ['users' => User::all()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|max:255|unique:users'
        ]);

        $user = User::create(
            array_merge(
                ['password' => bcrypt(str_random(8))],
                $request->only(['email', 'name'])
            )
        );

        flash("User '{$user->name}' added.")->important();

        return redirect('users');
    }

    public function destroy(User $user)
    {
        $user->delete();

        flash("User '{$user->name}' deleted.")->important();

        return redirect('users');
    }
}
