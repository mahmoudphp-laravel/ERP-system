<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\fuse;
use App\Models\User;

use Spatie\Permission\Models\Role;
use DB;
use Hash;
class UserController extends Controller
{
/**
* Display a listing of the resource.
*
*/
public function index(Request $request)
{

$data = User::all();
return view('users.show_users',compact('data'))
->with('i', ($request->input('page', 1) - 1) * 5);
}



public function create()
{
    $roles = Role::pluck('name','name')->all();

return view('users.Add_user',compact('roles'));

}
// public function creatte()
// {
//     $roles = Role::pluck('name','name')->all();

// return view('roles.index',compact('roles'));

// }
/**
* Store a newly created resource in storage.
*
*
*/
public function store(Request $request)
{
    $this->validate($request, [
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|same:confirm-password',
        'roles_name' => 'required'
        ]);

        $input = $request->all();


        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->roles_name);
        return redirect('/users.show_users')
        ->with('success','تم اضافة المستخدم بنجاح');


}

/**
* Display the specified resource.
*

*/
public function show($id)
{
$user =User::find($id);
return view('users.show',compact('user'));
}
/**
* Show the form for editing the specified resource.
*

*/
public function edit($id)
{
$user =User::find($id);
$roles = Role::pluck('name','name')->all();
$userRole = $user->roles->pluck('name','name')->all();
return view('users.edit',compact('user','roles','userRole'));
}
/**
* Update the specified resource in storage.
*

*/

/**
* Remove the specified resource from storage.
*

*/
public function destroy(Request $request)
{
User::find($request->user_id)->delete();
return redirect('/users.show_users')
->with('success','تم حذف المستخدم بنجاح');
}
}
