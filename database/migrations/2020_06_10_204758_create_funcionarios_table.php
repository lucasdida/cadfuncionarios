<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionariosTable extends Migration
{

    public function up()
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome_funcionario', 100);
            $table->date('data_nascimento');
            $table->string('telefone', 15);
            $table->string('celular', 16);
            $table->char('sexo', 1);
            $table->string('cep', 10);
            $table->string('logradouro');
            $table->string('bairro');
            $table->string('cidade');
            $table->integer('numero_logradouro');
            $table->string('complemento', 30)->nullable($value = true);
            $table->char('uf', 2);
            $table->decimal('salario', 8, 2);
            $table->time('horario_entrada');
            $table->time('horario_saida');
            $table->date('data_contratacao');
            $table->date('data_demissao')->nullable($value = true);
            $table->char('ativo', 1)->default('1');
            $table->integer('cargo_id')->unsigned();
            $table->foreign('cargo_id')->references('id')->on('cargos');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('funcionarios');
    }
}
