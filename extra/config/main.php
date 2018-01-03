<?php

/*
 * Config override to use the findcontact-ripe
 */

return [
    'external' => [
        'prefer_local'                      => true,
        'findcontact'                       => [
            'id' => [
                [
                    'class'                     => 'Whmcs',
                    'method'                    => 'getContactById',
                ],
            ],
            'ip' => [
                [
                    'class'                     => 'Whmcs',
                    'method'                    => 'getContactByIp',
                ],
            ],
            'domain' => [
                [
                    'class'                     => 'Whmcs',
                    'method'                    => 'getContactByDomain',
                ],
            ],
        ],
    ],
];
