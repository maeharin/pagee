# Pagee
independent PHP pagination library

## what?
- independent from any other library, works stand alone
- distributed by composer
- generate limit and offset for sql
- generate links for pagination

## usage
```php
$pagee = new Pagee(array(
    'base_url'       => 'http://www.hoge.com/answers.php',
    'total_count'    => 100,
    'requested_page' => 3
));


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

## customize setting
```php
$pagee = new Pagee(array(
    'base_url'       => 'http://www.hoge.com/answers.php',
    'total_count'    => 100,
    'requested_page' => 3
));


$this->pagee->append_params(array(
    'project_id' => 100, 'user_type' => 'hoge'
));
```



## todo
- i18n
