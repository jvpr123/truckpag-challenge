# Backend Challenge 20230105

>  This is a challenge by [Coodesh](https://coodesh.com/)

## Apresentação: https://www.loom.com/share/fa09c2d1ff3e412585ca0a6f4c59ec9f?sid=a7ec5fbc-7caa-495f-a1c0-f6ad3085246e

### Tecnologias utilizadas

- Linguagem: PHP
- Framework: Laravel 11
- Framework para testes: PEST
- Banco de Dados MySQL e SQLite (testes)

### Fases de Desenvolvimento

#### Configuração inicial

- Instalação do Laravel e suas dependências
- Configuração de framework PEST para testes unitários
- Implementação de arquivos Dockerfile e docker-compose.yml

#### Implementação de rotas da aplicação

- Criação de todas as rotas necessárias para a API REST retornando apenas uma mensagem de sucesso, para assegurar que o projeto está executando sem problemas de configuração
- Após isso, foi seguida a seguinte sequência pra implementar as camads do projeto:
  1. Implementar Entidade na camada de Domínio
  2. Implementar Model com migrations e factories na camada de infra
  3. Implementar Repositório para a entidade com respectivas interfaces com testes unitários
  4. Implementar caso de uso e configurar injeção de dependência para o repositório com testes unitários
  5. Implementar rota no controlador com caso de uso aplicado, adicionando validações para Requests e testes de feature

#### Implementação do CRON

Após as rotas terem sido implementadas, chegou a hora de desenvolver o CRON para importar produtos. Inicialmente foi desenvolvida a lógica de descompressão e processamento de dados do arquivo JSON, e depois configuradas as injeções de dependências de repositórios necessários para a persistência de dados. O CRON também foi configurado para ser executado diariamente.

### Instruções para execução do projeto

Para executar o projeto, basta executar o comando para iniciar o build e execução dos containers Docker configurados:

```bash
docker compose up --build -d
```

Os containers serão iniciados e as dependências necessárias instaladas, além de as migrations serem executadas também.

É possível executar os testes unitários e de feature por meio do comando:

```bash
php artisan test
```

E para executar o CRON manualmente, basta utilizar o comando:

```bash
php artisan import:open-food-data
```
