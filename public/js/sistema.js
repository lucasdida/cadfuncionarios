$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {

    // ----- Máscaras -----
    $('#salario').mask('000.000,00', {reverse: true});
    $("#telefone").mask("(00) 0000-0000");
    $("#celular").mask("(00) 00000-0000");
    $('#cep').mask('00000-000');
    $('#numero_logradouro').mask('00000');
    
    var configurahora = function (val) {
        return val.replace(/\D/g, '')[0] === '2' ? 'AE:CD' : 'AB:CD';
      },
      opcoes = {
        onKeyPress: function(val, e, field, options) {
            field.mask(configurahora.apply({}, arguments), options);
          },
          translation: {
             "A": { pattern: /[0-2]/, optional: false},
             "B": { pattern: /[0-9]/, optional: false},
             "C": { pattern: /[0-5]/, optional: false},
             "D": { pattern: /[0-9]/, optional: false},
             "E": { pattern: /[0-3]/, optional: false}
          }
      };
      
      $('#horario_entrada').mask(configurahora, opcoes);
      $('#horario_saida').mask(configurahora, opcoes);

    //Disabled de dados do endereço
    $('#logradouro').prop("disabled", true);
    $('#bairro').prop("disabled", true);
    $('#cidade').prop("disabled", true);
    $('#uf').prop("disabled", true);



});

$("#cep").blur(function() {
    //Nova variável "cep" somente com dígitos.
    var cep = $(this).val().replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {
        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {
            //Preenche os campos com "..." enquanto consulta webservice.
            $("#logradouro").val("...");
            $("#bairro").val("...");
            $("#cidade").val("...");
            $("#uf").val("...");

            //Consulta o webservice viacep.com.br/
            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                if (!("erro" in dados)) {
                    //Atualiza os campos com os valores da consulta.
                    $("#logradouro").val(dados.logradouro);
                    $("#bairro").val(dados.bairro);
                    $("#cidade").val(dados.localidade);
                    $("#uf").val(dados.uf);
                }
                else {
                    //CEP pesquisado não foi encontrado.
                    $('#cep').val('');
                    swal({
                        title: "CEP não encontrado!",
                        text: "Por favor, digite um número de CEP válido.",
                        icon: "error",  
                        confirmButtonText: "OK",
                    });
                }
            });
        }
        else {
            //cep é inválido.
            $('#cep').val('');
            swal({
                title: "CEP não encontrado!",
                text: "Por favor, digite um número de CEP válido.",
                icon: "error",  
                confirmButtonText: "OK",
            });
        }
    }
    else {
        //cep sem valor, limpa formulário.
        swal({
            title: "Campo CEP vazio!",
            text: "Por favor, não deixar o campo CEP em branco",
            icon: "error",  
            confirmButtonText: "OK",
        });
    }
});

$('#btn_novo').on('click', function() {
    //Limpa todos os campos e mostra o modal
    $('#id_funcionario').val('');
    $('#nome_funcionario').val('');
    $('#data_nascimento').val('');
    $('#telefone').val('');
    $('#celular').val('');
    $('#sexo_masculino').prop('checked', true);
    $('#cep').val('');
    $('#logradouro').val('');
    $('#numero_logradouro').val('');
    $('#complemento').val('');
    $('#bairro').val('');
    $('#cidade').val('');
    $('#uf').val('');
    $('#cargo').val('');
    $('#salario').val('');
    $('#horario_entrada').val('');
    $('#horario_saida').val('');
    $('#data_contratacao').val('');
    $('#data_demissao').val('');
    $('#modal_cadastro').modal('show');
    
});

$('#btn_novo_cargo').on('click', function() {
    $('#nome_cargo').val('');
    $('#modal_cargo').modal('show');
});

$('form[name="form_cargo"]').submit(function(event){
    //Impedir que faça o reload por conta do submit
    event.preventDefault();

    //Impede de continuar caso o campo cargo esteja vazio
    if ($('#cargo').val() == '') {
        swal({
            title: "Erro!",
            text: "O campo cargo deve ser preenchido.",
            icon: "error",  
            confirmButtonText: "OK",
        });
        
        return false;
    }

    $.ajax({
        url: 'gravar_cargo',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            swal({
                title: "Cargo cadastrado com sucesso!",
                text: "Pressione o botão para voltar",
                icon: "success",  
                confirmButtonText: "OK",
                closeOnClickOutside: false,
              }).then((result) => {
                if(result){
                    atualiza_cargos();
                }
             });            
        },
        error: function (erro) {
            mensagem_erro();
        }
    });
});

$('form[name="form_cadastro"]').submit(function(event){
    //impedir reload automatico da página
    event.preventDefault();
    
    var id = $('#id_funcionario').val();

    //Tirando o disabled para pegar as informações
    $('#logradouro').prop("disabled", false);
    $('#bairro').prop("disabled", false);
    $('#cidade').prop("disabled", false);
    $('#uf').prop("disabled", false);

    if(valida_datas() == false) { return false; }
    if(valida_horarios() == false) { return false; }
    
    if(id == '') {
        //Novo Funcionário
        $.ajax({
            url: '/gravar',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.sucesso == '0') {
                    swal({
                        title: "Erro! Algo deu errado...",
                        text: response.erros,
                        icon: "error",  
                        confirmButtonText: "OK",
                    });

                } else {
                    swal({
                        title: "Funcionário cadastrado com sucesso!",
                        text: "Pressione o botão para voltar",
                        icon: "success",  
                        confirmButtonText: "OK",
                        closeOnClickOutside: false,
                      }).then((result) => {
                        if(result){
                          location.reload();
                        }
                     });
                }
            },
            error: function (erro) {
                mensagem_erro();
            }
        });
    } else {
        //Atualizar Funcionário
        $.ajax({
            url: '/atualizar/'+id,
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.sucesso == '0') {
                    swal({
                        title: "Erro! Algo deu errado...",
                        text: response.erros,
                        icon: "error",  
                        confirmButtonText: "OK",
                    });

                } else {
                    swal({
                        title: "Funcionário atualizado com sucesso!",
                        text: "Pressione o botão para voltar",
                        icon: "success",  
                        confirmButtonText: "OK",
                        closeOnClickOutside: false,
                      }).then((result) => {
                        if(result){
                          location.reload();
                        }
                     });
                }
                
            },
            error: function (erro) {
                mensagem_erro();
            }
        });
    }

    //Ativando o disabled novamente
    $('#logradouro').prop("disabled", true);
    $('#bairro').prop("disabled", true);
    $('#cidade').prop("disabled", true);
    $('#uf').prop("disabled", true);
    
});

function editar(id) {
    //Pega todos os dados do funcionário de acordo com o ID e preenche os campos do  formulário
    $.ajax({
        url: '/editar/'+id,
        type: 'GET',
        data: id,
        dataType: 'json',
        success: function(response) {
            $('#id_funcionario').val(response.id);
            $('#nome_funcionario').val(response.nome_funcionario);
            $('#data_nascimento').val(response.data_nascimento);
            $('#telefone').val(response.telefone);
            $('#celular').val(response.celular);
            if(response.sexo == 'M') {
                $('#sexo_masculino').prop('checked', true);
            } else {
                $('#sexo_feminino').prop('checked', true);
            }
            $('#cep').val(response.cep);
            $('#logradouro').val(response.logradouro);
            $('#numero_logradouro').val(response.numero_logradouro);
            $('#complemento').val(response.complemento);
            $('#bairro').val(response.bairro);
            $('#cidade').val(response.cidade);
            $('#uf').val(response.uf);
            $('#cargos_select').val(response.cargo_id);
            $('#salario').val(response.salario);
            $('#horario_entrada').val(response.horario_entrada);
            $('#horario_saida').val(response.horario_saida);
            $('#data_contratacao').val(response.data_contratacao);
            $('#data_demissao').val(response.data_demissao);
            $('#modal_cadastro').modal('show');
        },
        error: function (erro) {
            mensagem_erro();
        }
    });
}

function remover(id) {
    //Função de remover funcionário, altera o valor do campo ativo, ficando assim 
    //desativado e não aparecendo para o usuário
    swal({
        title: "Deseja mesmo remover esse funcionário?",
        icon: "warning",
        buttons: ["Cancelar", "Remover"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: '/remover/'+id,
                type: 'POST',
                data: id,
                dataType: 'json',
                success: function(response) {
                    swal({
                        title: "Funcionário removido com sucesso!",
                        text: "Pressione o botão para voltar",
                        icon: "success",  
                        confirmButtonText: "OK",
                        closeOnClickOutside: false,
                      }).then((result) => {
                        if(result){
                          location.reload();
                        }
                     });
                },
                error: function (erro) {
                    mensagem_erro();
                }
            });
        }
      });

}

function remover_cargo(id) {
    //Função de remover cargo, altera o valor do campo ativo, ficando assim 
    //desativado e não aparecendo para o usuário
    swal({
        title: "Deseja mesmo remover esse cargo?",
        icon: "warning",
        buttons: ["Cancelar", "Remover"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: '/remover_cargo/'+id,
                type: 'POST',
                data: id,
                dataType: 'json',
                success: function(response) {
                    swal({
                        title: "Cargo removido com sucesso!",
                        text: "Pressione o botão para voltar",
                        icon: "success",  
                        confirmButtonText: "OK",
                        closeOnClickOutside: false,
                      }).then((result) => {
                        if(result){
                            atualiza_cargos();
                        }
                     });
                },
                error: function (erro) {
                    mensagem_erro();
                }
            });
        }
      });
}

function mensagem_erro() {
    //Mensagem de erro desconhecido, caso ocorra
    swal({
        title: "Erro! Algo deu errado...",
        text: "Tente novamente ou contate o desenvolvedor.",
        icon: "error",  
        confirmButtonText: "OK",
    });
}

function valida_horarios() {
    //Tratamento pra verificar se o usuário esta digitando os horários corretos
    var tamanho_entrada = $('#horario_entrada').val();
    var tamanho_saida = $('#horario_saida').val();

    if (tamanho_entrada.length < 5 ) {
        swal({
            title: "Erro! Horário de entrada incorreto",
            text: "Por favor, digite o horário completo.",
            icon: "error",  
            confirmButtonText: "OK",
        });

        return false;

    } else if (tamanho_saida.length < 5) {
        swal({
            title: "Erro! Horário de saida incorreto",
            text: "Por favor, digite o horário completo.",
            icon: "error",  
            confirmButtonText: "OK",
        });

        return false;
    }
}

function valida_datas() {
    var data = new Date(),
    dia  = data.getDate().toString().padStart(2, '0'),
    mes  = (data.getMonth()+1).toString().padStart(2, '0'), //+1 pois no getMonth Janeiro começa com zero.
    ano  = data.getFullYear();
    data = ano + "-" + mes + "-" + dia;

    var data_nascimento = $('#data_nascimento').val().split('/');
    var data_contratacao = $('#data_contratacao').val().split('/');
    
    //Compara a data informada com a data atual, prevenindo que adicione 
    //datas futuras como data de nascimento
    if (data_nascimento >= data) {
        swal({
            title: "Erro! Data incorreta",
            text: "Por favor, verifique a data de nascimento informada e tente novamente.",
            icon: "error",  
            confirmButtonText: "OK",
        });

        return false;
    }

    if (data_contratacao < data_nascimento) {
        swal({
            title: "Erro! Data incorreta",
            text: "A data de contratação não pode ser menor que a data de nascimento.",
            icon: "error",  
            confirmButtonText: "OK",
        });

        return false;
    }

    if($('#data_demissao').val() != '') {
        var data_demissao = $('#data_demissao').val().split('/');
        
        if (data_demissao < data_nascimento || data_demissao < data_contratacao) {
            swal({
                title: "Erro! Data incorreta",
                text: "A data de demissão não pode ser menor que as datas de nascimento e de contratação.",
                icon: "error",  
                confirmButtonText: "OK",
            });
    
            return false;
        }
        
    }
}

function atualiza_cargos() {
    $.ajax({
        url: '/atualiza_cargos',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            //Modifica o select de cargos e a tabela de cargos de acordo com o que tem no banco de dados
            $('#cargos_select').html('');

            if(response == false) {
                $('#tabela_cargos').html('<thead class="table-config" style="background-color:#bbbbbb">' +
                                            '<tr>' +
                                                '<td align=center>Não há nenhum cargo cadastrado até o momento</td>' +
                                            '</tr>'+
                                         '</thead>');
                
            } else {
                $('#tabela_cargos').html('<thead class="table-config">' +
                                            '<tr>' +
                                                '<th scope="col">Cargo</th>' +
                                                '<th scope="col">Ações</th>' +
                                            '</tr>' +
                                         '</thead>'+
                                         '<tbody id="tbody_cargos">');

                for (var i = 0; i < response.length; i++) {
                    $('#tabela_cargos').append('<tr>' +
                                                    '<td>'+ response[i].nome_cargo +'</td>' +
                                                    '<td width=100>' +
                                                        '<span class="fa fa-times fa-lg" onclick="remover_cargo('+ response[i].id +')" style="padding-left:20px"></span>' +
                                                    '</td>' +
                                                '</tr>');

                    $('#cargos_select').append('<option value="'+ response[i].id +'">'+ response[i].nome_cargo +'</option>');

                }

                $('#tabela_cargos').append('</tbody>');

            }
        },
        error: function (erro) {
            mensagem_erro();
        }
    });
}