<?php

namespace App\Http\Controllers;

use App\Models\EnviarEmail;
use App\Models\ApiCorreios;
use Illuminate\Http\Request;

class ApiCorreiosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApiCorreios  $apiCorreios
     * @return \Illuminate\Http\Response
     */
    //Soma o valor
    public function rastrear($codigo)
    {

        $resultado = (new ApiCorreios())->rastrear($codigo);
        (new EnviarEmail())->enviar($resultado);
        return $resultado;
    }
}
