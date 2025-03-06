<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Exception;
use Illuminate\Http\Request;


class ClienteController extends Controller
{
     protected $respusta_exitosa ='Exitoso';
     protected $respuesta_error ='lo siento mucho, error';

    public function index()
    {
        try {
                $cliente = Cliente::all();

                $repuesta = $this->get_response($this->respusta_exitosa,200,$cliente);
                
                return response()->json($repuesta,200);

        }catch (Exception $e) {

            $repuesta = $this->get_response($this->respuesta_error,500,[]);
            return response()->json($repuesta,500);

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    try{
        $data = $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string',
            'ruc' => 'required|string|max:100',
            'email' => 'string|email|max:100',
            'direccion' => 'nullable|string|max:255',
            'razon_social' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable||date|max:255',
            'telefono' => 'nullable|string|max:255'

        ]);
        $response = Cliente::create($data);
        $repuesta = $this->get_response($this->respusta_exitosa,200,$response);
        return response()->json($repuesta,200);

    } catch (Exception $e) {

        return response()->json($this->get_response($e->getMessage(),500,[]),504);
    }



    }

    /**
     * Display the specified resource. 
     */
    public function show(string $id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            $repuesta = $this->get_response(
                $this->respusta_exitosa,
                200,
                $cliente
            );

            return response()->json($repuesta);


        }
        catch (Exception $e) {
            return [
                'error'=>true,
                'data'=>$e->getMessage()
            ];

        }


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = $request->validate([
                'nombre' => 'required|string|max:50',
                'apellido' => 'required|string',
                'ruc' => 'required|string|max:100',
                'email' => 'string|email|max:100',
                'direccion' => 'nullable|string|max:255',
                'razon_social' => 'nullable|string|max:255',
                'fecha_nacimiento' => 'nullable||date|max:255',
                'telefono' => 'nullable|string|max:255'
    
            ]);

            $cliente = Cliente::findOrFail($id);

            $cliente->update($data);

            return response()->json(
                                $this->get_response(    
                                                    $this->respusta_exitosa,200,$cliente
                                                    )

                                );

        }
        catch (Exception $e) {

            return $this->get_response($e->getMessage(),503,[]);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    try {

        $cliente = Cliente::findOrFail($id);
        $cliente->delete();
        return response()->json($this->get_response('Eiminado correctamente'.$id, 200,$cliente));

    }catch (Exception $e) {
        return $this->get_response($e->getMessage(),500,[]);
    }


    }
}
