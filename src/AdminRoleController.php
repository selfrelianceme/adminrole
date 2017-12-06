<?php

namespace Selfreliance\adminrole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Selfreliance\fixroles\Models\Role;
use Selfreliance\adminmenu\Models\AdminMenu;

class AdminRoleController extends Controller
{
    protected function correctAccessible($sections)
    {
        $accessible = $sections ?? [];
        $path = config('adminamazing.path');
        if(!in_array($path, $accessible))
        {
            $accessible[] = $path;
        }
        return json_encode($accessible);
    }

    public function index()
    {
        $roles = Role::orderBy('name', 'asc')->get();
        $menuItems = AdminMenu::orderBy('sort', 'asc')->get();

        return view('adminrole::home', compact('roles', 'menuItems'));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'role_name' => 'required|min:2'
        ]);

        $data = [
            'name' => $request->input('role_name'),
            'slug' => $request->input('role_name'),
            'accessible_pages' => self::correctAccessible($request['sections'])
        ];

        $role = Role::getRole($request->input('role_name'));
        if(!$role)
        {
            Role::create($data);
            flash()->success('Роль успешно создана');
        }
        else
        {
            flash()->error('Роль уже существует');
        }

        return redirect()->route('AdminRolesHome');
    }

    public function update($id, Request $request)
    {
        $role = Role::getRole($id);
        if($role)
        {
            $this->validate($request, [
                'role_name' => 'required|min:2'
            ]);

            $data = [
                'name' => $request->input('role_name'),
                'accessible_pages' => self::correctAccessible($request['sections'])
            ];

            $role->update($data);

            flash()->success('Роль успешно обновлена');
            return redirect()->route('AdminRolesEdit', $id);
        }
        else
        {
            flash()->error('Роль не найдена');
            return redirect()->route('AdminRolesHome');
        }
    }
    
    public function edit($id, Request $request)
    {
        $role = Role::getRole($id);
        if($role)
        {
            $menuItems = AdminMenu::orderBy('sort', 'asc')->get();
            $sections = json_decode($role->accessible_pages);
            $members =  User::where('role_id', $id)->get();

            $roleName = $role->name;
            $roleID = $role->id;

            return view('adminrole::edit', compact('menuItems', 'sections', 'roleName', 'roleID', 'members'));
        }
        else 
        {
            flash()->error('Роль не найдена');
            return redirect()->route('AdminRolesHome');
        }
    }

    public function destroy($id)
    {
        $role = Role::getRole($id);
        if($role)
        {
            $users = User::all();

            foreach($users as $user)
            {
                if($user->role_id == $id) $user->detachRole($id);
            }

            $role->delete();

            flash()->success('Роль успешно удалена');
        }
        else
        {
            flash()->error('Роль не найдена');
        }
        
        return redirect()->route('AdminRolesHome');
    }
}