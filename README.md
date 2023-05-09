# Sumário

- [Sumário](#sumário)
  - [Resumo do sistema](#resumo-do-sistema)
  - [Configurando projeto para execução local](#configurando-projeto-para-execução-local)
    - [Programas necessários](#programas-necessários)
    - [Rotas](#rotas)

## Resumo do sistema

Sistema básico de gerenciamento de pessoas e contatos, com foco no aprendizado e demonstração de boas práticas e padrões de desenvolvimento. A estrutura do projeto está baseada em MVC, utilizando Doctrine como ORM.
A única linguagem de programação back-end utilizada foi o PHP na sua versão 8. A parte front-end da aplicação foi desenvolvida com base no framework Bootstrap.

## Configurando projeto para execução local

O sistema foi desenvolvido para a execução em modo local. Por conta disso, siga as instruções abaixo para conseguir rodar o sistema em sua máquina.

### Programas necessários

| Nome       | Versão           |
|------      |-------           |
| Composer   | >= 2.5.5         |
| pgAdmin    | >= 4             |
| PostgreSQL | >= 15.2          |
| PHP        | >= 8.0           |
| vscode     | Não específicado |
| XAMP       | >= 3.3.0         |

- Executar o comando no terminal estando dentro do diretório do projeto:

> composer install

- Após baixar as depêndencias do projeto, crie um  arquivo ".env" baseado no template ".env.example", informando os dados do seu servidos/database local.

- Inicie a execução do servidor local com o XAMPP;

- Abra a aplicação em seu navegador;

- Com o sistema rodando, é possível verificar que não há registros nas consultas. Para isso execute os comandos SQL abaixo no pgAdmin:

> INSERT INTO PERSON (id, name, cpf) VALUES
  (1, 'Luiz', '111.111.111-11'),
  (2, 'Ruan', '222.222.222-22'),
  (3, 'Eduardo', '333.333.333-33'),
  (4, 'José', '555.555.555-55');

>INSERT INTO contact (id, person_id, type, description) VALUES
  (1, 1, 0, '<email@example.com>'),
  (2, 2, 1, '<2mail@example.com>'),
  (3, 3, 0, '<3mail@example.com>'),
  (4, 4, 1, '4mail-123-4567'),

### Rotas

O sistema possui uma tratativa sob as rotas informadas pelo usuário. São aceitas apenas as rotas abaixo, e todo tipo de URL diferente das abaixo será tratada pelo sistema.

> Todas as rolas serão compostas por: "localhost" + caminho rota. Exemplo: localhost = "<http://localhost/contatos-php>", rota = "/". URL completa: "<http://localhost/contatos-php/>"

. Página inicial

- <http://localhost/contatos-php/>

. Rotas de "Pessoa"

- <http://localhost/contatos-php/pessoas>
- <http://localhost/contatos-php/pessoas/cadastrar>
- <http://localhost/contatos-php/pessoas/visualizar/{id}>
- <http://localhost/contatos-php/pessoas/alterar/{id}/edit>
- <http://localhost/contatos-php/pessoas/deletar/{id}/delete>

. Rotas de "Contatos"

- <http://localhost/contatos-php/pessoas>
- <http://localhost/contatos-php/pessoas/cadastrar>
- <http://localhost/contatos-php/pessoas/visualizar/{id}>
- <http://localhost/contatos-php/pessoas/alterar/{id}/edit>
- <http://localhost/contatos-php/pessoas/deletar/{id}/delete>
