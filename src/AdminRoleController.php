<?php

namespace Selfreliance\adminrole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use DB;

class AdminRoleController extends Controller
{
    public function index($type)
    {
        if($type == 'roles') $what_to_transfer = DB::table('role_user')->orderBy('id', 'desc')->paginate(10);
        else if($type == 'permissions') $what_to_transfer = DB::table('permission_user')->orderBy('id', 'desc')->paginate(10);
        else return redirect()->route('AdminRoles', 'roles');
        return view('adminrole::home')->with(['type'=>$type,'what_to_transfer'=>$what_to_transfer]);
    }

    public function affix($type, Request $request)
    {
        $created = DB::table($type)->where('id', $request['id'])->value('name');
        if($type == 'roles')
        {
            if($created)
            {
                $user = User::findOrFail($request['user']);
                if(!$user->isRole($request['id']))
                {
                    $user->attachRole($request->input('id'));
                    return redirect()->route('AdminRoles', $type)->with('status', 'Роль для пользователя прикреплена!');
                }
                else return redirect()->route('AdminRoles', $type)->with('status', 'Данная роль уже прикреплена к данному пользователю!');
            }
            else return redirect()->route('AdminRoles', $type)->with('status', 'Данной роли не существует!');
        }else if($type == 'permissions'){
            if($created)
            {
                $user = User::findOrFail($request['user']);
                if(!$user->isRole($request['id']))
                {
                    $user->attachPermission($request->input('id'));
                    return redirect()->route('AdminRoles', $type)->with('status', 'Права для пользователя приклеплены!');
                }
                else return redirect()->route('AdminRoles', $type)->with('status', 'Данные права уже приклеплены к данному пользователю!');
            }
            else return redirect()->route('AdminRoles', $type)->with('status', 'Данных прав не существует!');
        }
        else return redirect()->route('AdminRoles', 'roles');
    }

    public function create($type, Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|min:2',
    		'slug' => 'required|min:2',
            'description' => 'min:2'
    	]);
        $created = DB::table($type)->where('name', $request['name'])->value('id');
        if($type == 'roles')
        {
            if($created) return redirect()->route('AdminRoles', $type)->with('status', 'Данная роль уже существует!');
            else{
                Role::create([
                    'name' => $request->input('name'),
                    'slug' => $request->input('slug'),
                    'description' => $request->input('description'),
                    'level' => 1
                ]);
                return redirect()->route('AdminRoles', $type)->with('status', 'Роль успешно создана!');
            }
        }else if($type == 'permissions'){
            if($created) return redirect()->route('AdminRoles', $type)->with('status', 'Данные права уже существует!');
            else{
                Permission::create([
                    'name' => $request->input('name'),
                    'slug' => $request->input('slug'),
                    'description' => $request->input('description')
                ]);
            }
        }
        else return redirect()->route('AdminRoles', 'roles');
    }

    public function detach($type,$id)
    {
    	if($type == 'roles') 
        {
            $roleID = DB::table('role_user')->where('id', $id)->value('role_id');
            if($roleID)
            {
                $user_id = DB::table('role_user')->where('id', $id)->value('user_id');
                $user = User::findOrFail($user_id);
                $user->detachRole($roleID);
                return redirect()->route('AdminRoles', $type)->with('status', 'Роль для пользователя удалена!');
            }
            else return redirect()->route('AdminRoles', $type)->with('status', 'Данной роли не существует!');
        }
        else if($type == 'permissions'){
            $permissionID = DB::table('permission_user')->where('id', $id)->value('permission_id');
            if($permissionID)
            {
                $user_id = DB::table('permission_user')->where('id', $id)->value('user_id');
                $user = User::findOrFail($user_id);
                $user->detachRole($permissionID);
                return redirect()->route('AdminRoles', $type)->with('status', 'Права для пользователя удалены!');
            }
            else return redirect()->route('AdminRoles', $type)->with('status', 'Данных прав не существует!');
        }
        else return redirect()->route('AdminRoles', 'roles');
    }

    public function showAffix($type)
   	{
        if($type != 'roles' && $type != 'permissions') return redirect()->route('AdminRoles', $type);
   		$users = DB::table('users')->get();
        $what_to_attach = DB::table($type)->get();
    	return view('adminrole::affix')->with(['what_to_attach'=>$what_to_attach,'users'=>$users,'type'=>$type]);
    }

   	public function showCreate($type)
   	{
        if($type != 'roles' && $type != 'permissions') return redirect()->route('AdminRoles', $type);
   		return view('adminrole::create')->with(['type'=>$type]);
   	}
}