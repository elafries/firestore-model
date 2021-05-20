# FirestoreModel for laravel or lumen

## Creating a model

This will create a model, which will connect to the `users` table
```php

use Elafries\FirestoreModel\FirestoreModel;

class User extends FirestoreModel {

}
```

### Handle model fields
```php

use Elafries\FirestoreModel\FirestoreModel;

class User extends FirestoreModel {

    protected array $fillable = [
       'email', 'division' // When you insert to the database these fields will be added ONLY!
    ];

    protected array $hidden = [
        'password', // When you fetch from the database, these fields will be hidden
    ];

    protected array $secure = [
        'password', // When you insert/update the database these fields will be encrypted.
    ];
}
```

### Using a model via dependency injection
```php 

class UserController extends Controller 
{
    public function __construct(private User $user) {}
}

```

## Queries

### List queries

#### Fetch all item in the database `:array`
```php
$this->user->all();
```

#### Fetch items in the database with filtering `:array`
```php
$this->user->where('name', '=', 'test')->get();
```

#### Fetch items in the database with multiple where filtering `:array`
```php
$this->user
    ->where('name', '=', 'test')
    ->where('age', '>', '33')
    ->where('weight', '>', '110')
    ->get();
```

#### Fetch items in the database with filtering and with all the hidden properties `:array`
```php
$this->user->where('name', '=', 'test')->getRaw();
```

### Single result queries

#### Fetch the first in the database with filtering `:array`
```php
$this->user
    ->where('name', '=', 'test')
    ->where('age', '>', '33')
    ->first();
```

#### Fetch the first in the database with filtering and with all the hidden properties `:array`
```php
$this->user
    ->where('name', '=', 'test')
    ->where('age', '>', '33')
    ->firstRaw();
```

#### Fetch the first in the database by id `:array`
```php
$this->user->findById('2asd123a23a');
```

#### Fetch the first in the database by id, with all the hidden properties `:array`
```php
$this->user->findByIdRaw('2asd123a23a');
```

### Existence queries

#### Count all items in a query `:int`
```php
$this->user
    ->where('name', '=', 'test')
    ->where('age', '>', '33')
    ->count();
```

#### Check if there is at least one result (exists) `:bool`
```php
$this->user
    ->where('name', '=', 'test')
    ->where('age', '>', '33')
    ->exists();
```