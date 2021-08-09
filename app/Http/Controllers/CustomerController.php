<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Customer::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'cedula' => 'required|numeric|min:10|unique:customers',
            'celular' => 'required|numeric|min:10',
            'correo' => 'required|email|max:100|unique:customers',
            'direccion' => 'required|string|max:255'
        ]);

        $customer = Customer::create([
            'nombres' => $validateData['nombres'],
            'apellidos' => $validateData['apellidos'],
            'cedula' => $validateData['cedula'],
            'celular' => $validateData['celular'],
            'correo' => $validateData['correo'],
            'direccion' => $validateData['direccion']
        ]);

        $response = ['Customer created'];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);

        return response()->json($customer, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);
        $customer->update($request->all());

        return response()->json($customer, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Customer::destroy($id);

        $response = ['Customer deleted'];
        return response()->json($response, 200);
    }

    public function dni($dni)
    {
        $customer = Customer::where('cedula', $dni)->get();
        return response()->json($customer->first(), 200);
    }
}
