<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Funcionario;
use App\Cargo;
use Exception;

class FuncionariosController extends Controller
{

    public function index()
    {
        //Verifica no banco de dados todos o funcionários com o campo ativo = 1
        $funcs = Funcionario::where('ativo', 1)->paginate(7);

        foreach ($funcs as $func) {
            //Formatando em Real
            $func->salario = number_format($func->salario, 2, ',', '.');
            $func->salario = 'R$ '.$func->salario;

            //Formatando Horas
            $func->horario_entrada = substr($func->horario_entrada, 0, -3);
            $func->horario_saida = substr($func->horario_saida, 0, -3);

        }

        $cargos = Cargo::where('ativo', 1)->get();

        return view('funcionarios', compact('funcs', 'cargos'));
    }

    public function store(Request $request)
    {

        $result_validacao = $this->validation($request);

        //Verifica se houve algum campo que foi pego pega validação 
        if($result_validacao != false) {
            return json_encode(array('sucesso'=>$result_validacao['sucesso'], 'erros'=>$result_validacao['erros']));
        
        } else {
            
            //formata a variável salário para ser inserida no banco de dados
            $salario = $request->salario;
            $salario = str_replace('.', '', $salario);
            $salario = str_replace(',', '.', $salario);
    
            $func = new Funcionario();
       
            $func->nome_funcionario = $request->nome_funcionario;
            $func->data_nascimento = $request->data_nascimento;
            $func->telefone = $request->telefone;
            $func->celular = $request->celular;
            $func->sexo = $request->sexo;
            $func->cep = $request->cep;
            $func->logradouro = $request->logradouro;
            $func->numero_logradouro = $request->numero_logradouro;
            $func->complemento = $request->complemento;
            $func->bairro = $request->bairro;
            $func->cidade = $request->cidade;
            $func->uf = $request->uf;
            $func->cargo_id = $request->cargos_select;
            $func->salario = $salario;
            $func->horario_entrada = $request->horario_entrada;
            $func->horario_saida = $request->horario_saida;
            $func->data_contratacao = $request->data_contratacao;
            $func->data_demissao = $request->data_demissao;

            $func->save();
            return true; 
        }

        return false;
    }

    public function edit($id)
    {
        //Procura o funcionário de acordo o ID passado e retorna todos os dados do mesmo
        $func = Funcionario::find($id);

        $func->salario = number_format($func->salario,2,",",".");

        $func->horario_entrada = substr($func->horario_entrada, 0, -3);
        $func->horario_saida = substr($func->horario_saida, 0, -3);

        if (isset($func))
            return json_encode($func);

    }

    public function update(Request $request, $id)
    {
        //Procura o funcionário pelo ID 
        $func = Funcionario::find($id);

        $result_validacao = $this->validation($request);
        
        //Verifica se houve algum campo que foi pego pega validação 
        if($result_validacao != false) {
            return json_encode(array('sucesso'=>$result_validacao['sucesso'], 'erros'=>$result_validacao['erros']));

        } else {
            //formata a variável salário para ser atualizada no banco de dados
            $salario = $request->salario;
            $salario = str_replace('.', '', $salario);
            $salario = str_replace(',', '.', $salario);
    
            if(isset($func)) {
                $func->nome_funcionario = $request->nome_funcionario;
                $func->data_nascimento = $request->data_nascimento;
                $func->telefone = $request->telefone;
                $func->celular = $request->celular;
                $func->sexo = $request->sexo;
                $func->cep = $request->cep;
                $func->logradouro = $request->logradouro;
                $func->numero_logradouro = $request->numero_logradouro;
                $func->complemento = $request->complemento;
                $func->bairro = $request->bairro;
                $func->cidade = $request->cidade;
                $func->uf = $request->uf;
                $func->cargo_id = $request->cargos_select;
                $func->salario = $salario;
                $func->horario_entrada = $request->horario_entrada;
                $func->horario_saida = $request->horario_saida;
                $func->data_contratacao = $request->data_contratacao;
                $func->data_demissao = $request->data_demissao;
        
                $func->save();
                return true;
            } else {
                return false;
            }
        }
    }


    public function destroy($id)
    {
        //Função que desativa o funcionário selecionado, modificação o campo ativo
        $func = Funcionario::find($id);

        if(isset($func)) {
            $func->ativo = 0;

            $func->save();
            return true;
        } else {
            return false;
        }
    }

    public function validation($request) {

        $mens_campo_vazio = array();
        $mens_erros = "";
    
        //Verifica se campos estão vazios
        if ($request->nome_funcionario == null) 
            array_push($mens_campo_vazio, " nome,");
        
        if ($request->data_nascimento == null) 
            array_push($mens_campo_vazio, " data de nascimento,");
        
        if ($request->telefone == null) 
            array_push($mens_campo_vazio, " telefone,");
            
        if ($request->celular == null) 
            array_push($mens_campo_vazio, " celular,");

        if ($request->cep == null) 
            array_push($mens_campo_vazio, " CEP,");

        if ($request->numero_logradouro == null) 
            array_push($mens_campo_vazio, " número,");
            
        if ($request->cargos_select == null) 
            array_push($mens_campo_vazio, " cargo,");
        
        if ($request->salario == null) 
            array_push($mens_campo_vazio, " salário,");

        if ($request->horario_entrada == null) 
            array_push($mens_campo_vazio, " horário de entrada,");

        if ($request->horario_saida == null) 
            array_push($mens_campo_vazio, " horário de saída,");
            
        if ($request->data_contratacao == null) 
            array_push($mens_campo_vazio, " data de contratação,");

        if (!empty($mens_campo_vazio)) {

            foreach ($mens_campo_vazio as $mens) {
                $mens_erros = $mens_erros . $mens;
            }

            $mens_erros = substr($mens_erros, 0, -1);

            //Mensagem no singular ou plural de acordo com a quantidade de erros
            if(count($mens_campo_vazio) > 1) 
                $mens_erros = " Os campos: " . $mens_erros . " devem ser preenchidos!";
            else
                $mens_erros = " O campo: " . $mens_erros . " deve ser preenchido!";


            //return json_encode(array('sucesso'=>'0', 'erros'=>$mens_erros));
            $resposta = array('sucesso'=>'0', 'erros'=>$mens_erros);
            return $resposta;

        } else {
            return false;
        }

    }
}
