<?php
return [
    'paypal' => [
        'fields' => [
            'client_id' => ['type' => 'text', 'label' => 'Client ID', 'required' => true],
            'client_secret' => ['type' => 'password', 'label' => 'Client Secret', 'required' => true],
        ]
    ],
    'stripe' => [
        'fields' => [
            'publishable_key' => ['type' => 'text', 'label' => 'Publishable Key', 'required' => true],
            'secret_key' => ['type' => 'password', 'label' => 'Secret Key', 'required' => true],
        ]
    ],
    'myfatoorah' => [
        'fields' => [
            'apiKey' => ['type' => 'password', 'label' => 'API Key (Token ID)', 'required' => true],
            'vcCode' => ['type' => 'text', 'label' => 'vcCode', 'required' => false],
            'currency' => ['type' => 'select', 'label' => 'العملة الرئيسية', 'required' => true, 'options' => [
                'SAR' => 'ريال سعودي (SAR)',
                'KWD' => 'دينار كويتي (KWD)',
                'AED' => 'درهم إماراتي (AED)',
                'BHD' => 'دينار بحريني (BHD)',
                'OMR' => 'ريال عماني (OMR)',
                'QAR' => 'ريال قطري (QAR)',
                'EGP' => 'جنيه مصري (EGP)',
            ]],
        ]
    ],
    // أضف بوابات أخرى هنا
]; 