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
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:ControleOnline/zf2-essentials.git"
        }
    ],
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
);
```
### Zend 2 ###
In your config/application.config.php confiruration add the following:

```
<?php
$modules = array(
    'ZF2Essentials'
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