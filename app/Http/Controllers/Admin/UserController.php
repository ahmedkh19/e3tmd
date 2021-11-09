<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;

class UserController extends Controller
{

    public function index()
    {
        return view('content.users.index');
    }

    public function ajax(Request $request)
    {
        if ($request->ajax()) {
            $users = User::orderBy('id','DESC')->get();
            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $action_btn = '<a href="'. route('users.edit', $row->id) .'" class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">' . __("data.Edit") . '</a> <a href="'. route('users.destroy', $row->id) .'" class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">' . __("data.Delete") . '</a>';
                    return $action_btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return false;
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('content.users.create',compact('roles'));
    }

    public function store(UserRequest $request)
    {
       // return $request;
        try {

            $input = $request->all();
            $input['mobile'] = $request->input('mobile');
            $input['password'] = Hash::make($input['password']);
            $input['roles_name'] = $request->input('roles');
            if (!empty($request->avatar)) {
                $input['avatar'] = uploadImage('avatars', $request->avatar);
            } else {
                $input['avatar'] = 'user.jpg';
            }
            if (!empty($request->cover)) {
                $input['cover'] = uploadImage('avatars', $request->cover);
            }
            $user = User::create($input);
            $user->assignRole($request->input('roles'));
            return redirect()->route('users.index')
                ->with('success', __('data.Created successfully'));
        } catch (\Exception $ex) {
            return redirect()->back()
                ->with('error', __('data.An error occurred, please try again'));
        }
    }


    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }


    public function edit($id)
    {
        $user = User::find($id);
        $userInformation = UserInformation::where('user_id', '=', $id)->first();
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('content.users.edit',compact('user','roles','userRole'), compact('userInformation'));
    }


    public function update(Request $request, $id)
    {
     //  return $request;
        $request->validate([
            'name' => 'required',
            'username' => 'required|string|alpha_dash|max:255|unique:users,username,' . $id . '',
            'mobile' => 'required|unique:users,mobile,'. $id.'|phone:country',
            'email' => 'required|email|unique:users,email,'. $id . '',
        ]);

        try {


            $user = User::find($id);
            //User
            $input['name'] = $request->name;
            $input['username'] = $request->username;
            $input['email'] = $request->email;
            $input['mobile'] = $request->mobile;

            if (!empty($request->password)) {
                $input['password'] = $request->password;
                $input['password'] = Hash::make($input['password']);
            }
            $input['status'] = $request->status;
            $input['roles_name'] = $request->roles;
            if (!empty($request->avatar)) {
                deleteImage("avatars",$user->avatar);
                $input['avatar'] = uploadImage('avatars', $request->avatar);
            }
            if (!empty($request->cover)) {
                 deleteImage("avatars",$user->cover);
                $input['cover'] = uploadImage('avatars', $request->cover);
            }
            //User information
            if (!empty($request->birth_date))
                $information['birth_date'] = $request->birth_date;

            if (!empty($request->gender))
                $information['gender'] = $request->gender;
            if (!empty($request->twitter))
                $information['twitter'] = $request->twitter;

            if (!empty($request->facebook))
                $information['facebook'] = $request->facebook;

            if (!empty($request->instagram))
                $information['instagram'] = $request->instagram;

            if (!empty($request->twitch))
                $information['twitch'] = $request->twitch;

            $userInformation = UserInformation::where('user_id', $id)->first();
            $user->update($input);
            if (!empty($information))
            $userInformation->update($information);

            DB::table('model_has_roles')->where('model_id', $id)->delete();
            $user->assignRole($request->input('roles'));
            return redirect()->route('users.index')
                ->with('success', 'User updated successfully');

        } catch (\Exception $ex) {
            return redirect()->back()
                ->with('error', __('data.An error occurred, please try again later'));
        }
    }


    public function destroy($id)
    {
        if ($id == 1) {
            return redirect()->route('users.index')
                    ->with('error','Unable to delete SuperAdmin');
        }

        $find = User::find($id);
        if ($find) {
            $find->delete();
            deleteImage("avatars",$find->avatar);
            deleteImage("avatars",$find->cover);
            return redirect()->route('users.index')
                ->with('success','User deleted successfully');
        } else {
            return redirect()->route('users.index')
                ->with('error','User not found');
        }
    }

}
