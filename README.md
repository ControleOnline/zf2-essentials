[![Build Status](https://travis-ci.org/ControleOnline/zf2-essentials.svg)](https://travis-ci.org/ControleOnline/zf2-essentials)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ControleOnline/zf2-essentials/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ControleOnline/zf2-essentials/)
[![Code Coverage](https://scrutinizer-ci.com/g/ControleOnline/zf2-essentials/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ControleOnline/zf2-essentials/)
[![Build Status](https://scrutinizer-ci.com/g/ControleOnline/zf2-essentials/badges/build.png?b=master)](https://scrutinizer-ci.com/g/ControleOnline/zf2-essentials/)

# ZF2Essentials #

This software aims to be engaged in any system and without any additional line programming is required, the final code is automatically optimized.

## Features ##
* Automatic Routes (Like ZF1)
* Automatic get content in Json (If Array or Object return from Controller)
* Automatic create Entities from Doctrine

## Installation ##
### Composer ###
Add these lines to your composer.json:

```
    "require": {
        "controleonline/zf2-essentials": "*"        
    }

```


### Settings ###

**Default settings**
```
<?php
$config = array(
        'APP_ENV' => 'production', //Default configs to production or development      
        'jsonStrategy' => true, // Default True 
);
```

### Configure DB ###
In your config/autoload/database.local.php confiruration add the following:

```
<?php
return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host' => 'localhost',
                    'port' => '3306',
                    'user' => 'user',
                    'password' => 'pass',
                    'dbname' => 'db',
                    'driver' => 'pdo_mysql'
                )
            )
        )
    )
);
```


### Zend 2 ###
In your config/application.config.php confiruration add the following:

```
<?php
$modules = array(
    'ZF2Essentials' //Must be the first
);
return array(
    'modules' => $modules,
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor',
        ),
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
    ),
);
```
In your module.config.php file:

```
<?php
namespace YourNameSpace;

return array(
        'zf2_essentials' => array(
                //Configs of ZF2Essentials here
         )
);
```

## Usage ##

### Ajax ###
Get return from your Controller via Ajax:
```
$.ajax({
    headers: {
        Accept: "application/json; charset=utf-8",
        "Content-Type": "application/json; charset=utf-8"
    },
    url:'http://localhost/<Module>/<Controller>/<Action>/<Parameters>',
    data: "data",
    success: function (response) {
        console.log(response);
    }});
```
Or simply add the .json suffix at the end of the URL:
```
http://localhost/<Module>/<Controller>/<Action>.json?<Parameters>
```

### REST ###
To return directly your Entity, use the REST standard
```
http://localhost/<Entity>/id/<ID>.json?<Parameters> //Find By ID
http://localhost/<Entity>.json?<Parameters> //Return all records
```
#### Pagination ####
```
http://localhost/<Entity>.json?page=2&limit=100 //Return second page limited by 100 records
```
#### Override methods ####
If the browser does not support PUT, DELETE and OPTIONS use :
```
http://localhost/<Entity>.json?method=PUT //Return second page limited by 100 records
```