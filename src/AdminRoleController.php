<?php

namespace Selfreliance\adminrole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Selfreliance\fixroles\Models\Role;

class AdminRoleController extends Controller
{
    public function correctAccessible($sections)
    {
        $accessible = $sections ?? [];
        if(!in_array('admin', $accessible))
        {
            $accessible[] = 'admin';
        }
        return json_encode($accessible);
    }

    public function index()
    {
        $roles = \DB::table('roles')->get();
        $menu_items = \DB::table('admin__menu')->orderBy('sort', 'asc')->get();

        return view('adminrole::home')->with( compact('roles', 'menu_items') );
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'role_name' => 'required|min:2'
        ]);

        $accessible = self::correctAccessible($request['sections']);

        $data = [
            'name' => $request->input('role_name'),
            'slug' => $request->input('role_name'),
            'accessible_pages' => $accessible
        ];

        Role::create($data);

        flash()->success('Роль успешно создана');

        return redirect()->route('AdminRolesHome');
    }
    
    public function edit($id, Request $request)
    {
        $role = Role::getRole($id);
        if($role)
        {
            if($request->isMethod('post'))
            {
                $this->validate($request, [
                    'role_name' => 'required|min:2'
                ]);

                $accessible = self::correctAccessible($request['sections']);

                $role->name = $request->input('role_name');
                $role->accessible_pages = $accessible;
                $role->save();

                flash()->success('Роль успешно обновлена');

                return redirect()->route('AdminRolesShowEdit', $id);
            }
            else if($request->isMethod('get'))
            {
                $menu_items = \DB::table('admin__menu')->orderBy('sort', 'asc')->get();
                $sections = json_decode($role->accessible_pages);
                $members = \DB::table('users')->where('role_id', $id)->get();
                $role_name = $role->name;
                $role_id = $role->id;

                return view('adminrole::edit')->with( compact(['menu_items', 'sections', 'role_name', 'role_id', 'members']) );
            }
        }
        else 
        {
            flash()->error('Роль не найдена');
            return redirect()->route('AdminRolesHome');
        }
    }

    /**
     * Destroy role
    */
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