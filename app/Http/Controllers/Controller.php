<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use App\Models\UserRelationship;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        $userId = auth()->id();
        $users = UserRelationship::with(['mainUser', 'subUser'])
            ->where('main_user_id', $userId)
            ->get();

        return Inertia::render('User/Index', [
            'users' => $users
        ]);
    }
    public function create()
    {
        return view('users.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,name',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:admin,secretario,gerente,operario',
        ]);

        $user = User::create([
            'name' => $request->username,
            'email' => $request->username . '@example.com', // Generando un email ficticio basado en el ID
            'password' => bcrypt($request->password),
            'rol' => $request->role,
        ]);

        UserRelationship::create([
            'main_user_id' => auth()->id(),
            'sub_user_id' => $user->id,
        ]);

        return redirect()->back()->with('message', 'Usuario creado correctamente');
    }
    public function edit()
    {
        return view('users.edit');
    }
    public function update()
    {
        return view('users.update');
    }
    public function destroy()
    {
        return view('users.destroy');
    }
}
