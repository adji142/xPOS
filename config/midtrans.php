<?php

return [
    'server_key'    => env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-HX4SGB3FVpxVm-CpeOCyo4MS'),
    'client_key'    => env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-qz748Jy7S9f3_srA'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized'  => env('MIDTRANS_IS_SANITIZED', true),
    'is_3ds'        => env('MIDTRANS_IS_3DS', true),
];
