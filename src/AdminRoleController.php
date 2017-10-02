<?php

namespace Selfreliance\adminrole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Selfreliance\fixroles\Models\Role;

class AdminRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('CheckAccess');
    }
    
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

    public function create(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|min:2',
    	]);

        $privilegions = collect([]);
        foreach($request->input() as $key => $privilegion){
            if(strpos($key, 'privilegion_') !== false){
                $key = str_replace('privilegion_', '/admin', $key);
                $privilegions->push($key);
            } 
        }

        if($this->checkExistRole($request['name'])) return redirect()->route('AdminRolesHome')->with('status', 'Данная роль уже существует!');
        else{
            Role::create([
                'name' => $request->input('name'),
                'slug' => $request->input('name')
            ]);
            $this->attach(1, $request['name'], $privilegions);
            return redirect()->route('AdminRolesHome')->with('status', 'Роль успешно создана!');
        }
    }

    public function edit($name)
    {
        if($this->checkExistRole($name))
        {
            $privilegion = json_decode(
                \DB::table('admin__sections')->where('name', $name)->value('privilegion')
            );
            return view('adminrole::edit')->with(['name' => $name, 'privilegions' => $privilegion]);
        }else redirect()->route('AdminRolesHome');       
    }

    public function update(Request $request)
    {
        if($this->checkExistRole($request['name'])){
            $this->validate($request, [
                'name' => 'required|min:2'
            ]);

            $privilegions = collect([]);
            foreach($request->input() as $key => $privilegion){
                if(strpos($key, 'privilegion_') !== false){
                    $key = str_replace('privilegion_', '', $key);
                    $privilegions->push($key);
                }
            }
            $this->attach(2, $request['name'], $privilegions);
            return redirect()->route('AdminRolesHome')->with('status', 'Роль отредактирована!');
        }else redirect()->route('AdminRolesHome');
    }

    public function attach($type, $name, $privilegions)
    {
        if($type == 1){
            return \DB::table('admin__sections')->insert(
                    ['name' => strtolower($name), 'privilegion' => $privilegions]
            );
        }else if($type == 2){
            if($this->checkExistRole($name)){
                if(!count($privilegions)) $privilegions = collect([""]);
                return \DB::table('admin__sections')->where('name', strtolower($name))->update(
                    ['privilegion' => $privilegions]
                );
            }
        }
    }

    public function delete($name)
    {
        if($this->checkExistRole($name)){
            $users = User::all();
            foreach($users as $user) $user->detachRole($name);

            $role = \DB::table('roles')->where('name', $name);
            $sections = \DB::table('admin__sections')->where('name', strtolower($name));

            $role->delete();
            $sections->delete();
            return redirect()->route('AdminRolesHome')->with('status', 'Роль удалена!');
        }else return redirect()->route('AdminRolesHome');
    }
}