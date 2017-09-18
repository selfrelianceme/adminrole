<?php

namespace Selfreliance\adminrole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Bican\Roles\Models\Role;
use DB;

class AdminRoleController extends Controller
{
    public function index()
    {
    	$users_roles = DB::table('role_user')->orderBy('id', 'desc')->paginate(10);
        return view('adminrole::home')->with(['users_roles'=>$users_roles]);
    }

    public function affixRole(Request $request)
    {
	    $created = DB::table('roles')->where('id', $request['role'])->value('name');
	    if($created)
	    {
		    $user = User::findOrFail($request['user']);
		    if(!$user->isRole($created))
		    {
		    	$user->attachRole($request->input('role'));
		    	return redirect()->route('AdminRoles')->with('status', 'Роль для пользователя прикреплена!');
		    }
			else return redirect()->route('AdminRoles')->with('status', 'Данная роль уже прикреплена к данному пользователю!');
	    }
	    else return redirect()->route('AdminRoles')->with('status', 'Данной роли не существует!');
    }

    public function createRole(Request $request)
    {
    	$this->validate($request, [
    		'name_role' => 'required|min:2',
    		'slug_role' => 'required|min:2'
    	]);


        $created = DB::table('roles')->where('name', $request['name_role'])->value('id');
        if($created) return redirect()->route('AdminRoles')->with('status', 'Данная роль уже существует!');
    	else
        {
            Role::create([
                'name' => $request->input('name_role'),
                'slug' => $request->input('slug_role'),
                'description' => '',
                'level' => 1
            ]);
            return redirect()->route('AdminRoles')->with('status', 'Роль успешно создана!');
        }
    }

    public function detachRole($id)
    {
    	$roleID = DB::table('role_user')->where('id', $id)->value('role_id');
    	if($roleID)
    	{
	    	$user_id = DB::table('role_user')->where('id', $id)->value('user_id');
	    	$user = User::findOrFail($user_id);
	    	$user->detachRole($roleID);
	    	return redirect()->route('AdminRoles')->with('status', 'Роль для пользователя удалена!');
    	}
    	else return redirect()->route('AdminRoles')->with('status', 'Данной роли не существует!');
    }

    public function showAffixRole()
   	{
   		$users = DB::table('users')->get();
   		$roles = DB::table('roles')->get();
    	return view('adminrole::affix')->with(['roles'=>$roles,'users'=>$users,'choice'=>0]);
    }

   	public function showCreateRole()
   	{
   		return view('adminrole::create');
   	}
}