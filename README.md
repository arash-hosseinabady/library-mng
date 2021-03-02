

## Library Management
Simple app that admin can define writers to add, update, delete and get list of own book(s).

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.6.0.


INSTALLATION
------------
Download this project in your path.
### Install vendor
for install vendor in project run:
 `composer install`

### Database
create `library_mng`  database.

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=library_mng',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```
### Migrations
run blow commands:
```./yii migrate --migrationPath=vendor/webvimark/module-user-management/migrations/```
```./yii migrate```

## Run
run `./yii serve -p {port}`

## Admin panel user:
username: `superadmin`
password: `superadmin`

## API
#### login
url: `/api/login`
method: POST
fields: `username` and `password`
return:
```json
[
  {
    "status": {true or false},
    "message": {message},
    "token": {token}
   }
]
```

#### get book list
url: `/api/book`
method: GET
header fields: `Authorization => 'Bearer {token}'`
return:
```json
[
  {
    "status": {true or false},
    "message": {message}
   }
]
```

or array of books:
```json
{
  "status": {true or false},
  "data": [
    {
      "id": {book_id},
      "name": {book_name},
      "desc": {book_description},
      "writer_id": {book_writer_id},
      "created_at": {book_created_at},
      "updated_at": {book_updated_at}
    }
  ]
}
```

#### add book
url: `/api/book`
method: POST
header fields: `Authorization => 'Bearer {token}'`
input fields: `name` and `desc`
return:
```json
[
  {
    "status": {true or false},
    "message": {message}
   }
]
```

#### delete book
url: `/api/book/{book_id}`
method: DELETE
header fields: `Authorization => 'Bearer {token}'`
return:
```json
[
  {
    "status": {true or false},
    "message": {message}
   }
]
```


#### update book
url: `/api/book/{book_id}`
method: PUT or PATCH
header fields: `Authorization => 'Bearer {token}'`
input fields: `name` or `desc` or both
return:
```json
[
  {
    "status": {true or false},
    "message": {message}
   }
]
```
