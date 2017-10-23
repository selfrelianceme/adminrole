<?php

namespace Selfreliance\adminrole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Selfreliance\fixroles\Models\Role;

class AdminRoleController extends Controller
{
    /**
     * Index
     * @return view home with roles and menu_items
    */
    public function index()
    {
        $roles = \DB::table('roles')->get();
        $menu_items = \DB::table('admin__menu')->orderBy('sort', 'asc')->get();
        return view('adminrole::home')->with(['roles' => $roles, 'menu_items' => $menu_items]);
    }

    /**
     * Static checkExistRole($role)
     * @return 1 if role created, 0 - not created, -1 - not have roles
    */
    public static function checkExistRole($role)
    {
        $check = \DB::table('roles')->where('id', $role)->orWhere('name', $role)->orWhere('slug', $role)->first();
        if($check) return $check->id;
        else if(!$check) return 0;
        return -1;
    }

    /**
     * Create role
     * @param request $request
     * @return mixed
    */
    public function create(Request $request)
    {
        $this->validate($request, [
            'role_name' => 'required|min:2'
        ]);

        if(!$this->checkExistRole($request['role_name']))
        {
            $accessible = ($request['sections']) ? $request['sections'] : [];
            if(!in_array('admin', $accessible)) $accessible[] = 'admin';

            $accessible = json_encode($accessible);
            Role::create([
                'name' => $request['role_name'],
                'slug' => $request['role_name'],
                'accessible_pages' => $accessible
            ]);

            return redirect()->route('AdminRolesHome')->with('status', 'Роль успешно создана!');
        }
        else return redirect()->route('AdminRolesHome')->with('status', 'Данная роль уже существует!');
    }

    /**
     * Edit role
     * @param int id
     * @param request $request
    */
    public function edit($id, Request $request)
    {
        if($this->checkExistRole($id))
        {
            if($request->isMethod('post'))
            {
                $this->validate($request, [
                    'role_name' => 'required|min:2'
                ]);

                $accessible = (!is_null($request['sections'])) ? $request['sections'] : [];
                if(!in_array('admin', $accessible)) $accessible[] = 'admin';

                $accessible = json_encode($accessible);
                $role = Role::findOrFail($id);
                $role->name = $request->input('role_name');
                $role->accessible_pages = $accessible;
                $role->save();

                return redirect()->route('AdminRolesShowEdit', $id)->with('status', 'Роль успешно обновлена!');
            }
            else if($request->isMethod('get'))
            {
                $menu_items = \DB::table('admin__menu')->orderBy('sort', 'asc')->get();
                $role = \DB::table('roles')->where('id', $id)->first();
                $sections = json_decode($role->accessible_pages);
                $members = \DB::table('users')->where('role_id', $id)->get();

                return view('adminrole::edit')->with([
                    'menu_items' => $menu_items,
                    'sections' => $sections,
                    'role_name' => $role->name,
                    'role_id' => $id,
                    'members' => $members
                ]);
            }
        }
        else return redirect()->route('AdminRolesHome');
    }

    /**
     * Destroy role
     * @param int $id
     * @return mixed
    */
    public function destroy($id)
    {
        if($this->checkExistRole($id))
        {
            $users = User::all();
            foreach($users as $user)
            {
                if($user->role_id == $id) $user->detachRole($id);
            }

            $role = \DB::table('roles')->where('id', $id);
            $role->delete();

            return redirect()->route('AdminRolesHome')->with('status', 'Роль удалена!');
        }
        else return redirect()->route('AdminRolesHome');
    }
}