<?php
namespace App\Http\Controllers\app\settings\users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\wingu\laratrust\Role;
use App\Models\wingu\permission_role;
use App\Models\wingu\business_modules;
use App\Models\wingu\modules;
use App\Models\wingu\roles;
use Session;
use DB;
use Wingu;
use Auth;
use Helper;
class rolesController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
      $roles = Role::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
      $count = 1;
      return view('app.settings.roles.index', compact('roles','count'));
   }


   public function create(){
      $modules = business_modules::join('modules','modules.id','=','business_modules.moduleID')
                        ->where('businessID',Auth::user()->businessID)
                        ->where('module_status',15)
                        ->select('*','modules.id as modID')
                        ->get();

      return view('app.settings.roles.create', compact('modules' ));
   }

   public function store(Request $request){

      $this->validate($request, [
         'display_name' => 'required|max:255',
         'description' => 'sometimes|max:255',
      ]);

      $role = new Role;
      $role->display_name = $request->display_name;
      $role->name = Helper::seoUrl($request->display_name);
      $role->description = $request->description;
      $role->businessID = Auth::user()->businessID;
      $role->created_by = Auth::user()->id; 
      $role->updated_by = Auth::user()->id;
      $role->save();

      $permission = count(collect($request->permissions));
      if($permission > 0){
         //upload new category
         for($i=0; $i < count($request->permissions); $i++){
            $permission = new permission_role;
            $permission->permission_id = $request->permissions[$i]; 
            $permission->role_id = $role->id; 
            $permission->businessID = Auth::user()->businessID;
            $permission->updated_by = Auth::user()->id;
            $permission->save();
         }
      }

      Session::flash('success', 'Role successfully added.');

      return redirect()->route('settings.roles.index');
   }

   public function edit($id){
      $role = Role::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $modules = business_modules::join('modules','modules.id','=','business_modules.moduleID')
                     ->where('businessID',Auth::user()->businessID)
                     ->where('module_status',15)
                     ->select('*','modules.id as modID')
                     ->get();
      $count = 1;

      return view('app.settings.roles.edit', compact('role','modules','count'));
   }

   public function update(Request $request, $id){
      $this->validate($request, [
         'display_name' => 'required|max:255',
         'description' => 'sometimes|max:255'
      ]);

      $role = Role::find($id);
      $role->name = Helper::seoUrl($request->display_name); 
      $role->display_name = $request->display_name;
      $role->description = $request->description;
      $role->updated_by = Auth::user()->id;
      $role->save();

      $permission = count(collect($request->permissions));
      if($permission > 0){
         DB::table('permission_role')->where('role_id',$id)->delete();
         //upload new category
         for($i=0; $i < count($request->permissions); $i++){
            $permission = new permission_role;
            $permission->permission_id = $request->permissions[$i]; 
            $permission->role_id = $role->id; 
            $permission->businessID = Auth::user()->businessID;
            $permission->updated_by = Auth::user()->id;
            $permission->save();
         }
      }

      Session::flash('success', 'Role successfully updated');

      return redirect()->back();
   }

   public function show($id){
      $role = Role::where('id', $id)->with('permissions')->where('businessID',Auth::user()->businessID)->first();
      return view('app.settings.roles.show')->withRole($role);
   }

   public function delete($id){
      DB::table('permission_role')->where('role_id',$id)->where('businessID',Auth::user()->businessID)->delete();

      roles::where('id',$id)->where('businessID',Auth::user()->businessID)->delete();

      Session::flash('success','Role successfully deleted');

      return redirect()->back();
   }
}
