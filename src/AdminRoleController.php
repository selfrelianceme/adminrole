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
    */
    public function index()
    {
        $roles = \DB::table('roles')->get();
        $menu_items = \DB::table('admin__menu')->orderBy('sort', 'asc')->get();
        return view('adminrole::home')->with(['roles' => $roles, 'menu_items' => $menu_items]);
    }

    /**
     * Check exist role
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

            $data = [
                'name' => $request->input('role_name'),
                'accessible_pages' => $accessible
            ];

            Role::create($data);

            flash()->success( trans('translate-roles::role.createdRole') );
        }
        else 
        {
            flash()->error( trans('translate-roles::role.existsRole') );
        }

        return redirect()->route('AdminRolesHome');
    }

    /**
     * Edit role
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

                flash()->success( trans('translate-roles::role.updatedRole') );

                return redirect()->route('AdminRolesShowEdit', $id);
            }
            else if($request->isMethod('get'))
            {
                $menu_items = \DB::table('admin__menu')->orderBy('sort', 'asc')->get();
                $role = \DB::table('roles')->where('id', $id)->first();
                $sections = json_decode($role->accessible_pages);
                $members = \DB::table('users')->where('role_id', $id)->get();
                $role_name = $role->name;
                $role_id = $role->id;

                return view('adminrole::edit')->with( compact(['menu_items', 'sections', 'role_name', 'role_id', 'members']) );
            }
        }
        else 
        {
            flash()->error( trans('translate-roles::role.notFound') );
            return redirect()->route('AdminRolesHome');
        }
    }

    /**
     * Destroy role
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

            flash()->success( trans('translate-roles::role.deletedRole') );
        }
        else
        {
            flash()->error( trans('translate-roles::role.notFound') );
        }
        
        return redirect()->route('AdminRolesHome');
    }
}