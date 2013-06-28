# Pagee
independent PHP pagination library

## what?
- independent from any other library, works stand alone
- distributed by composer
- generate limit and offset for sql
- generate links for pagination

## usage
```php
$total_user_counts = 1000;

$pagee = new Pagee(

);

```

```php
$sql = "
    SELECT
        *
    FROM
        users
    LIMIT
        {$pagee->limit()}
    OFFSET
        {$pagee->offset()}
";
```

```php
$pagee->links();
```

## more usage


## todo
- i18n
