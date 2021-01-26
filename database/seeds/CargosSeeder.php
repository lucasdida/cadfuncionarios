<?php

use Illuminate\Database\Seeder;

class CargosSeeder extends Seeder
{
    
    public function run()
    {
        DB::table('cargos')->insert(['nome_cargo' => 'Desenvolvedor PHP']);
        DB::table('cargos')->insert(['nome_cargo' => 'Desenvolvedor C#']);
        DB::table('cargos')->insert(['nome_cargo' => 'Desenvolvedor ASP.NET']);
    }
}
