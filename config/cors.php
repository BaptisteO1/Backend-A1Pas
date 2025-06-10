<?php

return [
    'paths' => ['api/*', 'login', 'logout', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:3000'], //frontend React
    'allowed_headers' => ['*'],
    'supports_credentials' => false,
];
