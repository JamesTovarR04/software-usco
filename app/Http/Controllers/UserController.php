<?php

namespace App\Http\Controllers;

use App\Helpers\HTTPRequest;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Get information from logged in user
     *
     * @return Response
     */
    public function getMyData(Request $request)
    {

        return response()->json([
            'User' => $request->user()
        ]);

    }

    /**
     * Add program to User
     *
     * @return Response
     */
    public function addProgram(Request $request)
    {

        $validacion = Validator::make($request->all(),[
            'cohorte' => 'required|integer'
        ]);

        if($validacion->fails())
            return response(['errors' => $validacion->errors()->all()], 422);

        $corte = $request['cohorte'];
        $codigo = $request->user()->codigo;

        $programaRequest = HTTPRequest::getStudentProgram($corte, $codigo);

        $idPrograma = strstr($programaRequest,' ',true);

        // Si no pertenece a ninguno de los programas de software
        if($idPrograma != 418 && $idPrograma != 393){

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            User::where('id', $request->user()->id)->delete();

            return response([
                'Unauthorized' => 'El usuario no pertenece a ninguno de los programas de software.',
                'Program' => $idPrograma,
            ], 403);

        }

        $programa = Program::where('id', $idPrograma)->first();

        if (!$programa){
            $programa = Program::create([
                'id' => $idPrograma,
                'name' => substr(strstr($programaRequest,' '), 3)
            ]);
        }

        $user = User::where('id', $request->user()->id)->first();
        $user->program_id = $idPrograma;

        $user->save();

        return response()->json([
            'Message' => 'Programa del usuario actualizado',
            'Program' => $programa->name,
        ]);

    }

}
