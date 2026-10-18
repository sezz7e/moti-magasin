<?php

return [
    'shipping_fee' => 250, // PKR, placeholder: set your real rate
    'free_shipping_over' => 3000, // e.g. 5000 turns on free shipping and the progress bar; null = off

    'contact' => [
        'whatsapp' => '923238405815',   // digits with country code, no + or spaces, e.g. '923001234567'
        'instagram' => 'https://instagram.com/moti.magasin/',  // full URL, e.g. 'https://instagram.com/yourhandle'
        'email' => null,
        'phone' => '+92 323 8405815',      // e.g. '+92 300 1234567'
    ],

    'metals' => ['Gold', 'Silver', 'Rose Gold', 'Oxidised'],

    'stone_colors' => [
        'Red' => '#b3262e',
        'Pink' => '#e58aa8',
        'Blue' => '#2f5d9e',
        'Green' => '#2e7d5b',
        'White' => '#f4f1ea',
        'Black' => '#1f1b18',
        'Multicolour' => 'linear-gradient(135deg, #c0392b, #2f5d9e, #2e7d5b)',
    ],

        'metal_swatches' => [
        'Gold' => '#d4af37',
        'Silver' => '#c0c0c0',
        'Rose Gold' => '#e0a899',
        'Oxidised' => '#4a4a4a',
    ],

    'sizes' => ['Free size', 'S', 'M', 'L'],

    // Price steps for the filter: "Under 1,000", "Under 2,500", "Under 5,000", "Over 5,000"
    'price_filters' => [1000, 2500, 5000],

    'currency' => 'PKR',
];
