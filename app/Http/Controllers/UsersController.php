<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 

    public function index(Request $request)
    {
        $data = [
            'count_user' => User::latest()->count(),
            'menu'       => 'admin.menu.v_menu_admin',
            'content'    => 'admin.content.view_user',
            'title'    => 'Table User'
        ];

        if ($request->ajax()) {
            $q_user = User::select('*')->orderByDesc('created_at');
            return Datatables::of($q_user)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = '<div data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2 edit editUser"><i class=" fi-rr-edit"></i></div>';
                        $btn = $btn.' <div data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2 deleteUser"><i class="fi-rr-trash"></i></div>';
 
                         return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.layouts.v_template',$data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if($request->image){
            $name = time().'.' . explode('/', explode(':', substr($request->image, 0, strpos
            ($request->image, ';')))[1])[1];

           \Image::make($request->image)->save(public_path('images/usuario/').$name);
           $request->merge(['image' => $name]);

        }
        User::updateOrCreate(['id' => $request->user_id],
                [
                 'name' => $request->name,
                 'email' => $request->email,
                 'image' => $request->image,
                 'rol' => $request->rol,
                 'password' => Hash::make($request->password),
                ]);        

        return response()->json(['success'=>'Usuario Guardado!']);
    }

    public function show($id)
    {
        //
    }

    public function edit(Request $request, $id)
    {
        $User = User::find($id);

        $currentPhoto = $User->photo;

        if ($request->image != $currentPhoto) {
            $name = time().'.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];

            \Image::make($request->image)->save(public_path('images/usuario/').$name);
            $request->merge(['image' => $name]);

            $userPhoto = public_path('images/usuario/') . $currentPhoto;
            if (file_exists($userPhoto)) {
                @unlink($userPhoto);
            }

        }

        return response()->json($User);

    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
       
        $user = User::FindOrFail($id);
        if(file_exists('images/usuario/'. $user->image) AND !empty($user->image)){
              unlink('images/usuario/'. $user->image);
           }
              try{

                  $user->delete();
                  $bug = 0;
              }
              catch(\Exception $e){
                  $bug = $e->errorInfo[1];
              }
              if($bug==0){
                  echo "success";
              }else{
                  echo 'error';
              }

    }
}
