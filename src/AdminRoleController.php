<?php

namespace Selfreliance\adminrole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Selifreliance\fixroles\Models\Role;
use DB;

class AdminRoleController extends Controller
{
    public function index()
    {
        $roles = DB::table('roles')->get();
        return view('adminrole::home')->with(['roles' => $roles]);
    }

    public function create(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|min:2',
    		'slug' => 'required|min:2',
            'description' => 'min:2'
    	]);
        $created = DB::table('roles')->where('name', $request['name'])->value('id');
        if($created) return redirect()->route('AdminRolesHome')->with('status', 'Данная роль уже существует!');
        else{
            Role::create([
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'description' => $request->input('description')
            ]);
            return redirect()->route('AdminRolesControl')->with('status', 'Роль успешно создана!');
        }
    }

    public function delete($id)
    {
        $created = DB::table('roles')->where('id', $id);
        if($created)
        {
            $users = User::all();
            foreach($users as $user) $user->detachRole($id);
            $created->delete();
            return redirect()->route('AdminRolesControl')->with('status', 'Роль удалена!');
        }
        else return redirect()->route('AdminRolesControl');
    }
}