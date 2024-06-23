<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
class RoleController extends Controller
{
/**
* Display a listing of the resource.
*
*/


// function __construct()
// {

// $this->middleware('permission:عرض صلاحية', ['only' => ['index']]);
// $this->middleware('permission:اضافة صلاحية', ['only' => ['create','store']]);
// $this->middleware('permission:تعديل صلاحية', ['only' => ['edit','update']]);
// $this->middleware('permission:حذف صلاحية', ['only' => ['destroy']]);

// }




/**
* Display a listing of the resource.
*
*/
public function index(Request $request)
{
$roles = Role::orderBy('id','DESC')->paginate(5);
return view('roles.index',compact('roles'))
->with('i', ($request->input('page', 1) - 1) * 5);
}
/**
* Show the form for creating a new resource.
*
*/
public function create()
{
$permission = Permission::get();
return view('roles.create',compact('permission'));
}
/**
* Store a newly created resource in storage.
*

*/
public function store(Request $request)
{
$this->validate($request, [
'name' => 'required|unique:roles,name',
'permission' => 'required',
]);
$roles = Role::create(['name' => $request->input('name')]);
$roles->syncPermissions($request->input('permission'));
return redirect('/roles.index')

->with('success','Role created successfully');
}
/**
* Display the specified resource.
*
*
*/
public function show_roles()
{
$roles = Role::all();
$roolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
->get();
return view('roles.show_roles',array('roles'=>$roles,'roolePermissions'=>$roolePermissions));

}
/**
* Show the form for editing the specified resource.
*
*
*/
public function edit_roles()
{
$role = Role::all();
$permission = Permission::get();
$rolePermissions = DB::table("role_has_permissions");

return view('roles.edit_roles',array('role'=>$role,'permission'=>$permission,'rolePermissions'=>$rolePermissions));
}
/**
* Update the specified resource in storage.
*

*/
public function update(Request $request, $id)
{
$this->validate($request, [
'name' => 'required',
'permission' => 'required',
]);
$roles = Role::find($id);
$roles->name = $request->input('name');
$roles->save();
$roles->syncPermissions($request->input('permission'));
return redirect()->route('roles.index')
->with('success','Role updated successfully');
}
/**
* Remove the specified resource from storage.
*
*
*/
public function destroy($id)
{
DB::table("roles")->where('id',$id)->delete();
return redirect()->route('roles.index')
->with('success','Role deleted successfully');
}
}
