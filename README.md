# findcontact-whmcs
findcontact module for ip lookups using the whmcs api

## Beta
This software is in beta. Please test and report back to us.

## installation
    
    composer require abuseio/findcontact-whmcs
     
## use the findcontact-whcm module
copy the ```extra/config/main.php``` to the config override directory of your environment (e.g. production)

#### production

    cp vendor/abuseio/findcontact-whmcs/extra/config/main.php config/production/main.php
    
#### development

    cp vendor/abuseio/findcontact-whmcs/extra/config/main.php config/development/main.php
    
add the following line to providers array in the file config/app.php:

    'AbuseIO\FindContact\Whmcs\WhmcsServiceProvider'
    
## Configuration
    
    <?php
    
    return [
        'findcontact-whmcs' => [           
            'enabled'        => true,
            'auto_notify'    => false,
        ],
    ];

