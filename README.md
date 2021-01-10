# Multitenancy

Painel de gerenciamento de sistemas multitenancy e multidatabase. Faça todo o gerenciamento desde a criação do banco de dados e monitoramento.

Esse pacote foi desenvolvido para ser um starter kit de um projeto Multitenancy e Multidatabase. Não utilize em um projeto em andamento.

> Pacote em desenvolvimento.

## Requisitos

Para que funcione corretamente, será necessário configurar 3 domínios para nossa aplicação, são eles:

1. master.tenancy.test (dmonínio utilizado para gerenciar os tenants)
2. client1.tenancy.test
3. client2.tenancy.test

Para isso, edite seu arquivo `hosts` localizado em `/etc/hosts` no caso do Linux. Adicione as seguintes linhas no final do arquivo:

```
127.0.0.1   master.tenancy.test
127.0.0.1   client1.tenancy.test
127.0.0.1   client2.tenancy.test
```

Agora quando você acessar pelo seu navegador a url `master.tenancy.test` será redirecionado para a porta 80 da sua máquina local, onde estará executando sua aplicação Laravel.

## Instalando o Laravel

Instale o laravel.

```bash
composer create-project laravel/laravel multitenancy
```

O Laravel 8 contém um arquivo `docker-compose.yml` na raiz do projeto. Substitue o conteúdo do arquivo por esse:

```yml
# For more information: https://laravel.com/docs/sail
version: '3'
services:
  app:
    build:
      context: ./vendor/laravel/sail/runtimes/8.0
      dockerfile: Dockerfile
      args:
        WWWGROUP: '1000'
    image: sail-8.0/app
    ports:
      - '${APP_PORT:-80}:80'
    environment:
      WWWUSER: '1000'
      LARAVEL_SAIL: 1
    volumes:
      - '.:/var/www/html'
    networks:
      - tenancy
    depends_on:
      - mysql

  mysql:
    image: 'mysql:5.7'
    ports:
      - '${FORWARD_DB_PORT:-3307}:3306'
    environment:
      MYSQL_ROOT_PASSWORD: '${DB_PASSWORD}'
      MYSQL_DATABASE: '${DB_DATABASE}'
      MYSQL_USER: '${DB_USERNAME}'
      MYSQL_PASSWORD: '${DB_PASSWORD}'
      MYSQL_ALLOW_EMPTY_PASSWORD: 'yes'
    volumes:
      - 'tenancydb:/var/lib/mysql'
    networks:
      - tenancy

networks:
  tenancy:
    driver: bridge

volumes:
  tenancydb:
    driver: local
```

Altere no arquivo `.env` a conexão com o banco de dados e deixe da seguinte forma.

```yml
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

Execute o docker compose e aguarde a criação dos containers:

```
docker-compose up -d
```

Acesse seu container da aplicação:

```
docker-compose exec app bash
su - sail 
cd /var/www/html
```

## Instalando o pacote Multitenancy

Você pode instalar o pacote via composer:

```bash
composer require aristidesneto/multitenancy
```


### Configuração Tenant

É necessário criar uma nova conexão que será utilizada pelos tenants. Para isso abra o arquivo `config/database.php` e duplique a conexão atual `mysql` e crie outra com o nome de `tenant`.

```php
'connections' => [
    'tenant' => [
        'driver' => 'mysql',
        'url' => env('DATABASE_URL'),
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_DATABASE', 'forge'),
        'username' => env('DB_USERNAME', 'forge'),
        'password' => env('DB_PASSWORD', ''),
        'unix_socket' => env('DB_SOCKET', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => null,
        'options' => extension_loaded('pdo_mysql') ? array_filter([
            PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
        ]) : [],
    ],
]
...
```

### Comando Install

Para finalizar a instalação é necessário executar o comando:

```bash
php artisan multitenancy:install
```

### Requisitos do pacote

Um dos requisitos do pacote é o Laravel Breeze. Ao executar o comando acima será instalado o Laravel Breeze e todo seus arquivos referentes a autenticação.


## Uso

Após a instalação finalizar com sucesso acesse `http://master.tenancy.test` e clique no menu para fazer login. Utilize os dados de acesso abaixo:

```bash
E-mail: admin@admin.com
Senha: password
```

Após o login, você pode gerenciar os tenants, cadastrando e se necessário o zerando banco do tenant enquanto estiver em desenvolvimento.

Tela de gerenciamento de tenants:

![Listagens de Tenants](./docs/imgs/listagens-tenants.png)

Após cadastrar um tenant, na listagem clique sobre a URL disponível. Irá abrir uma nova aba com a URL criada, utilize os dados abaixo para realizar login:

```bash
E-mail: admin@tenant.com
Senha: password
```

## Teste

```bash
composer test
```


## Contribuição

Por favor veja CONTRIBUINDO para mais detalhes.


## Créditos

- [Arisides Neto](https://github.com/aristidesneto)
- [Todos](../../contributors)

## Licença


MIT License (MIT). Por favor veja Licença para mais informações.
