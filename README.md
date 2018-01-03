# findcontact-cpanel
findcontact module for ip lookups using the cpanel api

## Beta
This software is in beta. Please test and report back to us.

## installation
    
    composer require abuseio/findcontact-cpanel
     
## use the findcontact-cpanel module
copy the ```extra/config/main.php``` to the config override directory of your environment (e.g. production)

#### production

    cp vendor/abuseio/findcontact-cpanel/extra/config/main.php config/production/main.php
    
#### development

    cp vendor/abuseio/findcontact-cpanel/extra/config/main.php config/development/main.php
    
add the following line to providers array in the file config/app.php:

    'AbuseIO\FindContact\Cpanel\CpanelServiceProvider'
    
## Configuration
    
    <?php
    
    return [
        'findcontact-cpanel' => [           
            'enabled'        => true,
            'auto_notify'    => false,
        ],
    ];

