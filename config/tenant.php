<?php

return [
    'domains' => [
        // IC Edu
        'ic-edu.com' => 'ic_edu',
        'ic-edu.test' => 'ic_edu',
        
        // TOEIC Simulator
        'pkm.ic-edu.com' => 'toeic',
        'toeic.ic-edu.test' => 'toeic',
        
        // Localhost testing (127.0.0.1 -> IC Edu, localhost -> TOEIC Simulator)
        '127.0.0.1' => 'ic_edu',
        'localhost' => 'toeic', 
    ],

    'data' => [
        'ic_edu' => [
            'app_name' => 'iC.Edu',
            'logo_light' => 'assets/ic_edu_logo.png',
            'logo_dark' => 'assets/ic_edu_logo.png',
            'favicon' => 'assets/icidu_logo.png',
            'logo_auth' => 'assets/icidu_logo.png',
            'logo_sidebar' => 'assets/ic_edu_logo.png',
        ],
        'toeic' => [
            'app_name' => 'TOEIC Simulator',
            'logo_light' => 'assets/Logo-Toeic-Biru.png',
            'logo_dark' => 'assets/Logo-Toeic-Putih.png',
            'favicon' => 'assets/Logo-Toeic-Square.png',
            'logo_auth' => 'assets/Logo-Toeic-Biru.png',
            'logo_sidebar' => 'assets/Logo-Toeic-Putih.png',
        ],
    ],
    
    'default' => 'ic_edu',
];
