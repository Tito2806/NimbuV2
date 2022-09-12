<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Actividad;
use DataTables;


class ActividadesClienteController extends Controller {

    public function index(Request $request)
    {
        $data = [
            'count_actividad' => Actividad::latest()->count(),
            'title'    => 'Tabla Actividad'
        ];

        if ($request->ajax()) {
            $q_user = Actividad::select('*')->orderByDesc('created_at');
            return Datatables::of($q_user)
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('Client.actividades',$data);
    }

}