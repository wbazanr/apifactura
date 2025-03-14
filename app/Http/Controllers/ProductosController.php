<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductosController extends Controller
{

    protected $respuesta_exitosa = "Respuesta exitosa";
    protected $respuesta_error = "Error inesperado";


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $productos = Productos::all();

            $respuesta = $this->get_response($this->respuesta_exitosa, 200, $productos);

            return response()->json($respuesta, 200);
        } catch (Exception $e) {

            $respuesta = $this->get_response($this->respuesta_error, 500, []);

            return response()->json($respuesta, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:500',
        ]);

      
        if ($request->hasFile('imagen')) {
            
            $data['imagen'] = $request->file('imagen')->store('productos');
        }

        $response = Productos::create($data);


        return response()->json($this->get_response("se creo el producto de manera exitosa", 200, $response), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $productos = Productos::findOrFail($id);

            $respuesta = $this->get_response(
                $this->respuesta_exitosa,
                200,
                $productos
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    try {
        $data = $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:500',
        ]);

        $productos=Productos::findOrFail($id);

        if ($request->hasFile('imagen'))  {

            if ($productos->imagen) {
                Storage::disk('public')->delete($productos->imagen);

            }
            $data ['imagen']=$request->file('imagen')->store('productos','public');

    }

       $response =  $productos->update($data);

        return response()->json($this->get_response($this->respuesta_exitosa,200,$response));
        
    } catch (Exception $e) {  
        return $this->get_response($e->getMessage(),503,[]);

    }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $producto = Productos ::findOrFail($id);
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $response = $producto->delete();

            return response()->json($this->get_response($this->respuesta_exitosa,200,$response));
        } catch (Exception $e) 
        {
            return $this->get_response($e->getMessage(),503,[]);
        }


    }
}
