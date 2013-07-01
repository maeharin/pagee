# Pagee(ver 0.x)
independent PHP pagination library

## what?
- independent from any other library, works stand alone
- generate limit and offset for sql
- generate links for pagination

## usage
first: set
```php
// requested url: http://www.hoge.com/users.php?page=3
// total_count: the results of 'select count(*) from users;'
$pagee = Pagee::create(array(
    'base_url'       => 'http://www.hoge.com/users.php',
    'total_count'    => 100,
    'requested_page' => 3
));
```

second: find this page's records
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

throd: generate pagination links
```php
$pagee->links();
```

## customize setting
```php
$pagee = Pagee::create(array(
            'base_url'       => 'http://www.hoge.com/answers.php',
            'total_count'    => 100,
            'requested_page' => 3
        ))
        ->append_params(array(
            'project_id' => 100,
            'user_type' => 'hoge'
        ));

$pagee->links();
```

## install
download composer
```
curl -sS https://getcomposer.org/installer | php
```

composer.json
```
{
    "require": {
        "maeharin/pagee": "dev-master"
    }
}
```

install
```
$ php composer.phar install
```

## todo
- i18n
