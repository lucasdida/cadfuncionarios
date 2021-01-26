<?php

use Illuminate\Support\Facades\Route;

//Rotas Funcionarios
Route::get('/', 'FuncionariosController@index')->name('lista_funcionarios');
Route::post('/gravar', 'FuncionariosController@store')->name('gravar_funcionario');
Route::get('/editar/{id}', 'FuncionariosController@edit')->name('editar_funcionario');
Route::post('/atualizar/{id}', 'FuncionariosController@update')->name('atualizar_funcionario');
Route::post('/remover/{id}', 'FuncionariosController@destroy')->name('remover_funcionario');

//Rotas Cargos
Route::post('/gravar_cargo', 'CargosController@store')->name('gravar_cargo');
Route::post('/remover_cargo/{id}', 'CargosController@destroy')->name('remover_cargo');
Route::get('/atualiza_cargos', 'CargosController@show')->name('atualizar_cargos');


