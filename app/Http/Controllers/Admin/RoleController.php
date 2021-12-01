<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Hash;
use App\Models\User;
use DataTables;
class RoleController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $roles = Role::orderBy('id','DESC')->paginate(5);
        return view('content.roles.index',compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }


    public function ajax(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::orderBy('id', 'DESC');
            return Datatables::of($roles)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $action_btn = '<a href="' . route('roles.edit', $row->id) . '" class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">' . __("data.Edit") . '</a> <a href="' . route('roles.destroy', $row->id) . '" class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">' . __("data.Delete") . '</a>';
                    return $action_btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return false;
    }

    public function create()
    {
        $permission = Permission::get();
        return view('content.roles.create',compact('permission'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name'
        ]);
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
        return redirect()->route('roles.index')
            ->with('success', __('data.Created successfully'));
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        return view('content.roles.edit',compact('role','permission','rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'permission' => 'required',
            ]);
            $role = Role::find($id);
            $role->name = $request->input('name');
            $role->update();
            $role->syncPermissions($request->input('permission'));
            return redirect()->back()
                ->with('success',__('data.Updated successfully'));

        } catch (\Exception $ex) {
            return redirect()->back()
                ->with('error',__('data.An error occurred, please try again later'));

        }
    }

    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
            ->with('success','Role deleted successfully');
    }

}
