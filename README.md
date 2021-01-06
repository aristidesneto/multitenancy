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

## Uso

```php
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
