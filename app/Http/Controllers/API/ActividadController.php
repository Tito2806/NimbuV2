<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Actividad;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ActividadController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    } 

    public function index(Request $request)
    {
        $data = [
            'count_actividad' => Actividad::latest()->count(),
            'menu'       => 'admin.menu.v_menu_admin',
            'content'    => 'admin.content.view_actividad',
            'title'    => 'Tabla Actividad'
        ];

        if ($request->ajax()) {
            $q_user = Actividad::select('*')->orderByDesc('created_at');
            return Datatables::of($q_user)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = '<div data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2 edit editActividades"><i class=" fi-rr-edit"></i></div>';
                        $btn = $btn.' <div data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2 deleteActividad"><i class="fi-rr-trash"></i></div>';
 
                         return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.layouts.v_template',$data);
    }

    public function store(Request $request)
    {
        if($request->imagen){
            $name = time().'.' . explode('/', explode(':', substr($request->imagen, 0, strpos
            ($request->imagen, ';')))[1])[1];

           \Image::make($request->imagen)->save(public_path('images/actividades/').$name);
           $request->merge(['imagen' => $name]);

        }
        Actividad::updateOrCreate(['id' => $request->id],
                [
                 'titulo' => $request->titulo,
                 'descripcion' => $request->descripcion,
                 'lugar' => $request->lugar,
                 'fecha' => $request->fecha,
                 'hora' => $request->hora,
                 'imagen' => $request->imagen,
                ]);        

        return response()->json(['success'=>'Actividad Guardado!']);
    }

    public function edit(Request $request, $id)
    {
        $actividad = Actividad::find($id);

        $currentPhoto = $actividad->photo;

        if ($request->imagen != $currentPhoto) {
            $name = time().'.' . explode('/', explode(':', substr($request->imagen, 0, strpos($request->imagen, ';')))[1])[1];

            \Image::make($request->imagen)->save(public_path('images/actividades/').$name);
            $request->merge(['imagen' => $name]);

            $userPhoto = public_path('images/actividades/') . $currentPhoto;
            if (file_exists($userPhoto)) {
                @unlink($userPhoto);
            }
        }
        return response()->json($actividad);

    }




    public function destroy($id)
    {
       
        $actividad = Actividad::FindOrFail($id);
        if(file_exists('images/actividades/'. $actividad->imagen) AND !empty($actividad->imagen)){
              unlink('images/actividades/'. $actividad->imagen);
           }
              try{

                  $actividad->delete();
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