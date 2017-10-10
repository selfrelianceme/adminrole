<?php

namespace Selfreliance\adminrole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Selfreliance\fixroles\Models\Role;
use Selfreliance\Adminamazing\AdminController;

class AdminRoleController extends Controller
{
    public function index()
    {
        $roles = \DB::table('roles')->get();
        return view('adminrole::home')->with(['roles' => $roles]);
    }

    public static function checkExistRole($name)
    {
        $check = \DB::table('roles')->where('name', $name)->first();
        if($check) return 1;
        else if(!$check) return 0;
        return -1;
    }

    public function edit($name, Request $request)
    {
        if($this->checkExistRole($name)){
            if($request->isMethod('post')){
                $this->validate($request, [
                    'role_name' => 'required|min:2'
                ]);
                \DB::table('roles')->where('name', $name)->update(['name' => $request['role_name']]);
                return redirect()->route('AdminRolesHome');
            }else if($request->isMethod('get')){
                $menu = \DB::table('admin__menu')->orderBy('sort', 'asc')->get();
                $role = \DB::table('roles')->where('name', $name)->first();
                $members = \DB::table('role_user')->where('role_id', $role->id)->get();
                $result = AdminController::makeMenu($menu, json_decode($role->accessible_pages), 2);
                return view('adminrole::edit')->with(['tree' => $result, 'role_name' => $name, 'members' => $members]);
            }
        }else return redirect()->route('AdminRolesHome');
    }

    public function delete($name)
    {
        if($this->checkExistRole($name)){
            $users = User::all();
            foreach($users as $user) $user->detachRole($name);

            $role = \DB::table('roles')->where('name', $name);
            $role->delete();

            return redirect()->route('AdminRolesHome')->with('status', 'Роль удалена!');
        }else return redirect()->route('AdminRolesHome');
    }
}