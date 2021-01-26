# CadFuncionarios
Cadastro de funcionários, onde é possível cadastrar, editar, remover funcionários e cadastrar e remover cargos.

# Modelo e Dicionário de dados
Modelo e Dicionário de dados se encontram em apenas um arquivo ".pdf" com o nome: "Modelo e Dicionario de Dados.pdf" na pasta database do projeto.

# Pré-Requisitos
- PHP + MySQL (Aconselho a baixar o XAMPP que ja vem com os dois inclusos);
- Composer (https://getcomposer.org/download/);
- Algum navegador Web (de preferência o Google Chrome).

# Execução
- Depois de baixar o PHP + MySQL (Aconselhavel baixar o Xampp que já baixa os dois juntos) e instalar, é aconselhavel adicionar o php como variavel de ambiente. Caso o uso seja no sistema operacional Windows basta ir na parte de propriedades em "Meu Computador", selecionar a opção variaveis de ambiente, na parte de variaveis de sistema selecionar o campo "path" e editar, colocar no final do conteudo o caminho da pasta php, no meu caso como utilizo o xampp basta adicinar: C:\xampp\php e confirmar a alteração.
- Para a instalação do Composer caso utilize o Windows é aconselhavel baixar o .exe fo próprio site do composer:https://getcomposer.org/download/ e executa-lo, pois além de fazer a instalação do composer em si de uma forma fácil e rápida também já irá adicionar o composer como varável de ambiente.

**É extremamente importante seguir todos os passos a baixo para o funcionamento do projeto**

- Entrar na pasta do projeto cadfuncionarios, abrir o prompt de comando (cmd) e utilizar os seguintes comandos:
    - **composer install** - Instalação das dependências do composer no projeto;
    - **copy .env.example .env** - Copia o arquivo .env.example da pasta do projeto com um novo nome .env;
    - **php artisan key:generate** - Gera a Chave para o novo arquivo .env;
    
- **Banco de Dados:** Deve-se criar o banco em sua base dados e alterar o arquivo .env no campo de Database com o nome do banco de dados criado, é importante também deixar configurado as opções como username e password da base de dados;
- No prompt de comando (cmd) novamente, inserir os comandos:
    - **php artisan migrate** - Irá criar todas as tabelas no banco de dados criado anteriormente;
    - **php artisan db:seed** - Irá adicionar o conteúdo de determinadas tabelas para que a funcionalidade delas no site/sistema não sejam prejudicadas;
    
- Depois de todas essas etapas com o banco de dados criado, tabelas criadas e o comando seed ja executado, utilizar o comando **php artisan serve** no prompt de comando. Irá fazer com que os arquivos sejam compilados e executados e você poderá acessá-los através do navegador com o endereço: http://127.0.0.1:8000/ .

# Ferramentas utilizadas no desenvolvimento
- Sistema Operacional: Windows 10;
- Linguagem: PHP com Framework: Laravel;
- Visual Studio Code.
- HTML
- CSS
- JavaScript
- JQuery
- MySQL
- AJAX
- SweetAlert
 
