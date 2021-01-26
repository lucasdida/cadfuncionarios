<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cargo;

class CargosController extends Controller
{
    
    public function store(Request $request)
    {

        $cargo = new Cargo();

        $cargo->nome_cargo = $request->nome_cargo;
        $cargo->save();

        return true;

    }

    public function destroy($id)
    {
        //Função que desativa o cargo selecionado, modificação o campo ativo
        $cargo = Cargo::find($id);

        if(isset($cargo)) {
            $cargo->ativo = 0;

            $cargo->save();
            return true;
        } else {
            return false;
        }
    }

    public function show() {
        //Coleta todos os cargos cadastrados
        $cargos = Cargo::where('ativo', 1)->get();

        if (isset($cargos))
            return json_encode($cargos);
        else
            return json_encode($cargos = false);
    }

}
