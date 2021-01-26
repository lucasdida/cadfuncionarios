@extends('layouts.app')

@section('pageTitle', 'Cadastro de Funcionários')

@section('content')

<div class="bg-image" style="padding-bottom:5%; height:740px;">
    <div class="card border center" style="width:90%">
        <div class="card-body">
            <div class="form-row" style="padding-bottom:1%">
                <h5 class="card-title title-config fonte-padrao" style="font-size:40px; margin-left:10px;">Listagem de Funcionários</h5>
                <button class="btn btn-sm btn-padrao fonte-padrao" style="position: absolute; right: 20px;" id="btn_novo">Novo Funcionário</button>
            </div>
    
            
            <table class="table table-striped table-hover fonte-site">
            @if(count($funcs) > 0)
                <thead class="table-config">
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Cargo</th>
                        <th scope="col" style="text-align:center">Horário de Entrada</th>
                        <th scope="col" style="text-align:center">Horário de Saída</th>
                        <th scope="col" style="text-align:center">Data da Contratação</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($funcs as $func)
                    <tr>
                        <td width=400>{{$func->nome_funcionario}}</td>
                        <td>{{$func->cargo}}</td>
                        <td align=center>{{$func->horario_entrada}}</td>
                        <td align=center>{{$func->horario_saida}}</td>
                        <td align=center>{{date( 'd/m/Y', strtotime($func->data_contratacao))}}</td>
                        <td>
                            <span class="fa fa-pencil fa-lg" style="padding-right:10px;" onclick="editar({{$func->id}})"></span>
                            <span class="fa fa-times fa-lg" onclick="remover({{$func->id}})"></span>
                        </td>
                    </tr>    
                @endforeach
                </tbody>
            </table>
            @else

                <thead class="table-config" style="background-color:#bbbbbb">
                    <tr>
                        <td align=center>Não há nenhum funcionário cadastrado até o momento</td>
                    </tr>
                </thead>
            </table>

            @endif
            
            {{ $funcs->links() }}

            <div class="errors"></div>

        </div>
    </div>
</div>

<!-- Modal de Cadastrar / Editar Funcionario -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_cadastro" style="overflow: scroll;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"> 

            <form autocomplete="off" name="form_cadastro">
        
                {{ csrf_field() }}

                <div class="modal-header">
                    <h5 class="modal-title" id="titulo_cadastro">Novo Funcionário</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_funcionario" name="id_funcionario" class="form-control">

                    <div class="form-row">
                        <div class="form-group col-md-7">
                            <label for="nome_funcionario" class="control-label">Nome Completo</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="nome_funcionario" id="nome_funcionario" placeholder="Nome Completo" maxlength="100">
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="data_nascimento" class="control-label">Data de Nascimento</label>
                            <div class="input group">
                                <input class="form-control" type="date" id="data_nascimento" name="data_nascimento" min="1900-01-01" max="9999-12-31">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="telefone" class="control-label">Telefone</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="telefone" id="telefone" placeholder="Telefone">
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="celular" class="control-label">Celular</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="celular" id="celular" placeholder="Celular">
                            </div>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="radio_buttons" class="control-label">Sexo</label>
                            <div class="card" style="padding-bottom:6px; padding-top:6px; padding-left:30px;">
                                <div id="radio_buttons">
                                    <div class="custom-control custom-radio custom-control-inline" style="padding-right:20px;">
                                        <input type="radio" class="custom-control-input" id="sexo_masculino" name="sexo" value="M" checked>
                                        <label class="custom-control-label" for="sexo_masculino">Masculino</label>
                                    </div>

                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="sexo_feminino" name="sexo" value="F"> 
                                        <label class="custom-control-label" for="sexo_feminino">Feminino</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="cep" class="control-label">CEP</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="cep" id="cep" placeholder="CEP">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="logradouro" class="control-label">Logradouro</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="logradouro" id="logradouro" placeholder="Logradouro">
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="numero_logradouro" class="control-label">Número</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="numero_logradouro" id="numero_logradouro" placeholder="Número">
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="complemento" class="control-label">Complemento</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="complemento" id="complemento" placeholder="Complemento" maxlength="30">
                            </div>
                        </div> 
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="bairro" class="control-label">Bairro</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="bairro" id="bairro" placeholder="Bairro">
                            </div>
                        </div>                
                        <div class="form-group col-md-4">
                            <label for="cidade" class="control-label">Cidade</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="cidade" id="cidade" placeholder="Cidade">
                            </div>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="uf" class="control-label">UF</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="uf" id="uf" placeholder="UF">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="cargo" class="control-label">Cargo</label>
                            <select class="form-control" id="cargos_select" name="cargos_select">
                                @foreach ($cargos as $cargo)
                                <option value="{{$cargo->id}}">{{$cargo->nome_cargo}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <button type="button" class="btn btn-sm btn-adicionar-cargo fonte-padrao" id="btn_novo_cargo">Adicionar Cargo</button>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="salario" class="control-label">Salário (R$)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="salario" id="salario" placeholder="Salário">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="horario_entrada" class="control-label">Entrada</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="horario_entrada" id="horario_entrada" placeholder="00:00">
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="horario_saida" class="control-label">Saída</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="horario_saida" id="horario_saida" placeholder="00:00">
                            </div>
                        </div>                
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="data_contratacao" class="control-label">Data de Contratação</label>
                            <div class="input group">
                                <input class="form-control" type="date" id="data_contratacao" name="data_contratacao" min="1900-01-01" max="3000-12-31">
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="data_demissao" class="control-label">Data de Demissão</label>
                            <div class="input group">
                                <input class="form-control" type="date" id="data_demissao" name="data_demissao" min="1900-01-01" max="3000-12-31">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-padrao" id="btn_salvar_funcionario">Salvar</button>
                    <button type="cancel" class="btn btn-padrao btn-cancelar" data-dismiss="modal">Cancelar</button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Modal de Visualizar, Cadastrar e Remover Cargos -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_cargo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"> 

            <form autocomplete="off" name="form_cargo">
                <div class="form-row" style="margin-top:20px; margin-left:20px; margin-right:20px">
                    <div class="form-group col-md-6">
                    
                        <table class="table table-striped table-hover fonte-site" id="tabela_cargos">
                        @if(count($cargos) > 0)
                            <thead class="table-config">
                                <tr>
                                    <th scope="col">Cargo</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_cargos">
                            @foreach($cargos as $cargo)
                                <tr>
                                    <td>{{ $cargo->nome_cargo }}</td>
                                    <td width=100>
                                        <span class="fa fa-times fa-lg" onclick="remover_cargo({{$cargo->id}})" style="padding-left:20px"></span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                        @else
                        
                            <thead class="table-config" style="background-color:#bbbbbb">
                                <tr>
                                    <td align=center>Não há nenhum cargo cadastrado até o momento</td>
                                </tr>
                            </thead>
                        </table>
                        @endif
                    </div>

                    <div class="form-group col-md-5" style="margin-left:20px">
                            <label for="novo_cargo" class="control-label">Cargo</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="nome_cargo" id="nome_cargo" placeholder="Cargo" maxlength="100">
                            </div>
                    
                            <button class="btn btn-sm btn-padrao fonte-padrao"  style="margin-top:10px" id="btn_adiciona_cargo">Salvar Cargo</button>
                            <button type="cancel" class="btn btn-padrao btn-cancelar"  style="margin-top:10px; margin-left:10px" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                    
                </div>
            </form>

        </div>
    </div>
</div>

@endsection