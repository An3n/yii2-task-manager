# Yii2 Task Manager

O Yii2 Task Manager é uma aplicação web simples para gerir tarefas, construída usando o framework Yii2. Esta permite que os utilizadores criem, visualizem, atualizem e excluam tarefas. A aplicação também suporta registo de utilizadores e autenticação.

## Índice

- [Requisitos](#requisitos)
- [Instalação e Configuração](#instalaçãoeconfuração)
- [Configuração](#configuração)
- [Uso](#uso)
- [Funcionalidades](#funcionalidades)
- [Estrutura do Projeto](#estrutura-do-projeto)

## Requisitos

- PHP 8.1 (utilizado no desenvolvimento)
- Composer
- Servidor de Base de Dados (SQL Server)
- Extensões PHP necessárias:
  - php_pdo_sqlsrv (para SQL Server)
  - php_sqlsrv (para SQL Server)

## Instalação e Configuração

### Passo 1: Clonar o Repositório
```bash
git clone https://github.com/An3n/yii2-task-manager.git
cd yi2-task-manager
cd yi2-task-manager-app
```

### Passo 2: Instalar Dependências
Utilize o Composer para instalar as dependências do projeto:
```bash
composer install
```

### Passo 3: Configurar o Banco de Dados
Crie uma base de dados no SQL Server. Depois, configure a conexão com a base de dados no arquivo `config/db.php`:
```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlsrv:Server=localhost;Database=task_manager',
    'charset' => 'utf8',
    'username' => '', // Deixe vazio para autenticação do Windows
    'password' => '', // Deixe vazio para autenticação do Windows
];
```

### Passo 4: Aplicar Migrações
Execute as migrações para criar as tabelas na base de dados:
```bash
php yii migrate
```

## Uso
### Aceder à aplicação
Inicie a aplicação e abra o navegador e aceda a `http://localhost` para aceder à aplicação:
```bash
php yii serve
```

### Registo e Login
Registre-se como um novo utilizador.
Faça login com as credenciais criadas.

### Gerir tarefas
Crie, visualize, atualize e exclua tarefas.

## Funcionalidades
Registo e autenticação de utilizadores
Criação, visualização, atualização e exclusão de tarefas
Status das tarefas (pendente, em andamento, concluída)
Interface amigável e responsiva

## Estrutura do projeto
```bash
yi2-task-manager/
├── assets/             # Arquivos de assets (CSS, JS, imagens)
├── commands/           # Comandos de consola personalizados
├── config/             # Arquivos de configuração
├── controllers/        # Controladores da aplicação
├── mail/               # Templates de e-mail
├── migrations/         # Arquivos de migração de base de dados
├── models/             # Modelos da aplicação
├── runtime/            # Arquivos de runtime
├── tests/              # Testes automatizados
├── vendor/             # Dependências do Composer
├── views/              # Arquivos de visualização (HTML, PHP)
├── web/                # Arquivos acessíveis pelo servidor web
└── widgets/            # Widgets personalizados
```
