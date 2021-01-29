<h1 align="center">
     CadFuncionarios
</h1>

<p align="center">
    <a href="#sobre">Sobre</a> - 
    <a href="#preview">Preview</a> -
    <a href="#modelo-e-dicionário-de-dados">Modelo e Dicionário de Dados</a> - 
    <a href="#pré-requisitos">Pré-Requisitos</a> - 
    <a href="#guia-para-execução">Guia para execução</a> - 
    <a href="#tecnologias">Tecnologias</a> - 
    <a href="#autor">Autor</a>
</p>

### Sobre
Pequeno sistema de cadastro de funcionários e cargos aonde é possível fazer a inclusão, alterção e remoção dos mesmos. 

### Preview
<img src="/public/imagens/screenshots/01.png" width="600">
<img src="/public/imagens/screenshots/02.png" width="600">

### Modelo e Dicionário de Dados
Abaixo consta imagens do modelo e do dicionário de dados utilizados no desenvolvimento da aplicação:

<img src="/public/imagens/dm-dados/01.png">
<img src="/public/imagens/dm-dados/02.png">
<img src="/public/imagens/dm-dados/03.png">
<img src="/public/imagens/dm-dados/04.png">
<img src="/public/imagens/dm-dados/05.png">

Pode-se também ter acesso a tais documentações através da pasta do projeto nomeado como: "Modelo e Dicionario de Dados.pdf".

### Pré-Requisitos
- Linhagem de programação PHP + banco de dados MySQL;
- Composer (https://getcomposer.org/download/);
- Navegador WEB (preferencialmente o navegador Google Chrome).

### Guia para Execução
- Depois de baixar a linguagem PHP e o banco de dados MySQL e realizar a instalação dos mesmos, é aconselhavel adicionar o php como variavel de ambiente. Para realizar tal procedimento, caso o uso da aplicação seja no sistema operacional Windows, será necessário:
    - Selecionar a opção de propriedades em "Meu Computador";
    - Selecionar a opção variaveis de ambiente;
    - Na parte de variaveis de sistema, selecionar o campo "path" e clicar em editar;
    - Colocar no final do conteudo o caminho da pasta php e confirmar a alteração.

- Para a instalação do Composer caso o sistema operacional for Windows é aconselhavel baixar o .exe do próprio site do composer:https://getcomposer.org/download/ e executa-lo, pois além de fazer a instalação do composer em si de uma forma fácil e rápida também já irá adicionar o composer como varável de ambiente.

** Execução do Projeto - É extremamente importante seguir todos os passos a baixo para o funcionamento do projeto**

- Entrar na pasta do projeto cadfuncionarios, abrir o prompt de comando (cmd) e utilizar os seguintes comandos:
    - **composer install** - Instalação das dependências do composer no projeto;
    - **copy .env.example .env** - Copia o arquivo .env.example da pasta do projeto com um novo nome .env;
    - **php artisan key:generate** - Gera a Chave para o novo arquivo .env;
    
- **Banco de Dados:** Deve-se criar o banco em sua base dados e alterar o arquivo .env no campo de Database com o nome do banco de dados criado, é importante também deixar configurado as opções como username e password da base de dados. Após os procedimentos anteriores, abrir o prompt de comando (cmd) novamente e utilizar os comandos:
    - **php artisan migrate** - Irá criar todas as tabelas no banco de dados criado anteriormente;
    - **php artisan db:seed** - Irá adicionar o conteúdo de determinadas tabelas para que a funcionalidade delas no site/sistema não sejam prejudicadas;
    
- Depois de todas essas etapas com o banco de dados criado, tabelas criadas e o comando seed ja executado, utilizar o comando **php artisan serve** no prompt de comando. Irá fazer com que os arquivos sejam compilados e executados e você poderá acessá-los através do seu navegador com o endereço: http://127.0.0.1:8000/ .

### Tecnologia
- Linguagem: PHP com Framework: Laravel;
- Visual Studio Code.
- HTML
- CSS
- JavaScript
- JQuery
- MySQL
- AJAX
- SweetAlert

### Autor

<p align="center">
    <a href="https://github.com/lucasdida">
        <img style="border-radius: 50%" src="https://avatars.githubusercontent.com/u/52303950?s=460&u=18929e0813677708a8105a4b77209e4986ad8d0b&v=4" width="100px">
        <br>
        <sub>
            <b>
                Lucas Manoel Dida
            </b>
        </sub>
    </a>
    <a href="https://github.com/lucasdida" title="Lucas Dida Projects"></a>
    <br>
</p>
<p align="center">
    --- Contato ---
    <br>
    E-mail: lucasdida@hotmail.com 
</p>
 
