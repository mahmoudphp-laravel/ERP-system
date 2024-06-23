<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\fuse;

class fuseController extends Controller
{
/**
* Display a listing of the resource.
*
*/
public function index()
{
$data =fuse::all();
return view('vatora.empty',compact('data'));
}


}
