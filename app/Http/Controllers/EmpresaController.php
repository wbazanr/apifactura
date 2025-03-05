<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

use function PHPSTORM_META\type;

class EmpresaController extends Controller
{

    protected $respuesta_exitosa = "Respuesta exitosa";
    protected $respuesta_error = "Error inesperado";

    /**
     * Todos los datos. 
     */
    public function index()
    {
        try { 
            $empresa = Empresa::all();
            //   return response()->json($empresa,200);
            $respuesta = $this->get_response($this->respuesta_exitosa, 200, $empresa);
            return response()->json($respuesta, 200);
        } catch (Exception $e) {
            $respuesta = $this->get_response($this->respuesta_error, 500, []);
            return response()->json($respuesta, 500);
        }
    }

    /**
     * Guardar .
     */
    public function store(Request $request)
    {

        //validar los datos que el cliente esta enviando
        try {
            $data = $request->validate([
                'nombre' => 'required|string|max:50',
                'ruc' => 'required|string',
                'razon_social' => 'string|max:100',
                'direccion' => 'nullable|string|max:255',
                'telefono' => 'nullable|string|max:255'

            ]);
            $response = Empresa::create($data);

            $respuesta = $this->get_response($this->respuesta_exitosa, 200, $response);

            return response()->json($respuesta, 200);
        } catch (Exception $e) {

            return response()->Json($this->get_response($e->getMessage(), 500, []), 503);
        }
    }

    /**
     * Filtrar.
     */
    public function show(string $id)
    {
        try {
            $empresa = Empresa::findOrFail($id);
            // $respuesta = [
            //     "error" =>false,
            //     //     "estado"=>200,
            //     //     "data" => $empresa
            // ];
            $respuesta = $this->get_response(
                $this->respuesta_exitosa,
                200,
                $empresa
            );
            return response()->json($respuesta);
        } catch (Exception $e) {
            return [
                "errror" => true,
                "data" => $e->getMessage()
            ];
        }
    }
    /**
     * Modificar e.
     */
    public function update(Request $request, string $id)
    {

        try {
            $data = $request->validate([
                'nombre' => 'required|string|max:50',
                'ruc' => 'required|string',
                'razon_social' => 'string|max:100',
                'direccion' => 'nullable|string|max:255',
                'telefono' => 'nullable|string|max:255'

            ]);
            $empresa = Empresa::findOrFail($id);

            $empresa->update($data);

            return response()->json(
                $this->get_response(
                    $this->respuesta_exitosa,
                    200,
                    $empresa
                )
            );
        } catch (Exception $e) {

            return $this->get_response(
                $e->getMessage(),
                503,
                []
            );
        }
    }

    /**
     * EliminR .
     */
    public function destroy(string $id)
    {
        try {
            $empresa = Empresa::findOrFail($id);
            $empresa->delete();
            return response()->json(
                $this->get_response("Se elimino correctamente el registro  " . $id, 200, $empresa )
            );
        } catch (Exception $e) {

            return $this->get_response($e->getMessage(), 500, []);
        }
    }
}
