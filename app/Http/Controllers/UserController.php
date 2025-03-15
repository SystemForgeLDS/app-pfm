<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Constants\UserRoles;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() 
    {
        $users = User::paginate(5);

        return view('user.index', ['users' => $users, 'roles' => UserRoles::class]);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(UserRequest $request)
    {
        $user = new CreateNewUser;
        $user = $user->create($request->all());
        
        $user->save();

        return redirect(route('users.index'))->with('msg', 'Usuário "' . $user->name . '" criado com sucesso');
    }

    public function edit($id) 
    {

        $user = User::findOrFail($id);

        return view('user.edit', ['user' => $user, 'roles' => UserRoles::class]);
    }

    public function update(UserRequest $request) 
    {
        $user = User::findOrFail($request->id);
        $data = $request->all();

        $user->update($data);

        return redirect(route('users.index'))->with('msg', 'Usuário "' . $user->name . '" atualizado.');
    }

    public function show($id) 
    {
        $user = User::findOrFail($id);

        return view('user.show', ['user' => $user, 'roles' => UserRoles::class]);
    }

    public function destroy($id) {

        $user = User::findOrFail($id);

        $user->delete();

        return redirect(route('users.index'))->with('msg', 'Usuário "' . $user->name . '" excluído.');
    }

}
