# Multitenancy

Painel de gerenciamento de sistemas multitenancy e multidatabase. Faça todo o gerenciamento desde a criação do banco de dados e monitoramento.

> Pacote em desenvolvimento.

## Instalação

Você pode instalar o pacote via composer:

```bash
composer require aristides/multitenancy
```

Você pode publicar e rodar as migrations com:

```bash
php artisan vendor:publish --provider="Aristides\Multitenancy\MultitenancyServiceProvider" --tag="migrations"
php artisan migrate
```

Você pode publicar o arquivo de configuração com:

```bash
php artisan vendor:publish --provider="Aristides\Multitenancy\MultitenancyServiceProvider" --tag="config"
```

Conteúdo do arquivo de configuração:

```php
return [
];
```

## Configuração

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
