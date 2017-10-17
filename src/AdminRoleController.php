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
        $menu_items = \DB::table('admin__menu')->orderBy('sort', 'asc')->get();
        return view('adminrole::home')->with(['roles' => $roles, 'menu_items' => $menu_items]);
    }

    public static function checkExistRole($role)
    {
        $check = \DB::table('roles')->where('id', $role)->orWhere('name', $role)->orWhere('slug', $role)->first();
        if($check) return $check->id;
        else if(!$check) return 0;
        return -1;
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'role_name' => 'required|min:2'
        ]);
        if(!$this->checkExistRole($request['role_name'])){
            $accessible = $request['sections'];
            if(!in_array('admin', $accessible)) $accessible[] = 'admin';
            $accessible = json_encode($accessible);
            Role::create([
                'name' => $request['role_name'],
                'slug' => $request['role_name'],
                'accessible_pages' => $accessible
            ]);
            return redirect()->route('AdminRolesHome')->with('status', 'Роль успешно создана!');
        }else return redirect()->route('AdminRolesHome')->with('status', 'Данная роль уже существует!');
    }

    public function edit($name, Request $request)
    {
        if($this->checkExistRole($name)){
            if($request->isMethod('post')){
                $this->validate($request, [
                    'role_name' => 'required|min:2'
                ]);
                $accessible = (!is_null($request['sections'])) ? $request['sections'] : [];
                if(!in_array('admin', $accessible)) $accessible[] = 'admin';
                $accessible = json_encode($accessible);
                \DB::table('roles')->where('name', $name)->update([
                    'name' => $request['role_name'], 
                    'accessible_pages' => $accessible
                ]);
                return redirect()->route('AdminRolesShowEdit', $request['role_name'])->with('status', 'Роль успешно обновлена!');
            }else if($request->isMethod('get')){
                $menu_items = \DB::table('admin__menu')->orderBy('sort', 'asc')->get();
                $role = \DB::table('roles')->where('name', $name)->first();
                $sections = json_decode($role->accessible_pages);
                $members = \DB::table('role_user')->where('role_id', $role->id)->get();
                return view('adminrole::edit')->with([
                    'menu_items' => $menu_items,
                    'sections' => $sections,
                    'role_name' => $name, 
                    'members' => $members
                ]);
            }
        }else return redirect()->route('AdminRolesHome');
    }

    public function destroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        $role = $this->checkExistRole($request->input('id'));
        if($role){
            $users = User::all();
            foreach($users as $user) $user->detachRole($role);

            $role = \DB::table('roles')->where('id', $role);
            $role->delete();

            return redirect()->route('AdminRolesHome')->with('status', 'Роль удалена!');
        }else return redirect()->route('AdminRolesHome');
    }
}