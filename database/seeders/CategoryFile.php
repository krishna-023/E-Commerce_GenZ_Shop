<?php

namespace Database\Seeders;

class CategoryFile
{
    public static function womenFashion(): array
    {

        return [
            'name' => 'Women`s Fashion',
            'children' => [
                [
                    'name' => 'Clothing',
                    'children' => [
                        [
                            'name' => 'Tops & T-shirts',
                        ],
                        [
                            'name' => 'Hoodies & Sweatshirts',
                        ],
                        [
                            'name' => 'Sweaters & Cardigans',
                        ],
                        [
                            'name' => 'Jackets & Coats',
                        ],
                        [
                            'name' => 'Pants & Leggings',
                        ],
                        [
                            'name' => 'Jeans',
                        ],
                        [
                            'name' => 'Shorts',
                        ],
                        [
                            'name' => 'Skirts',
                        ],
                        [
                            'name' => 'Dresses',
                        ],
                        [
                            'name' => 'Party Wear',
                        ],
                    ],
                ],

                [
                    'name' => 'Traditional Clothing',
                    'children' => [
                        [
                            'name' => 'Saree',
                        ],
                        [
                            'name' => 'Kurtas',
                        ],
                        [
                            'name' => 'Kurtis',
                        ],
                        [
                            'name' => 'Lehenga',
                        ],
                        [
                            'name' => 'Unstitched Fabric',
                        ],
                        [
                            'name' => 'Dupattas, Stoles & Shawls',
                        ],
                    ],
                ],
                [
                    'name' => 'Women`s Bags',
                    'children' => [
                        [
                            'name' => 'Backpacks',
                        ],
                        [
                            'name' => 'Crossbody Bags',
                        ],
                        [
                            'name' => 'Wallets & Cardholders',
                        ],
                        [
                            'name' => 'Clutches',
                        ],
                        [
                            'name' => 'Top-handle Bags',
                        ],
                    ],
                ],
                [
                    'name' => 'Shoes',
                    'children' => [
                        [
                            'name' => 'Sneakers',
                        ],
                        [
                            'name' => 'Boots',
                        ],
                        [
                            'name' => 'Flat Shoes',
                        ],
                        [
                            'name' => 'Heels',
                        ],
                        [
                            'name' => 'Sandals',
                        ],
                        [
                            'name' => 'Wedges',
                        ],
                    ],
                ],
                [
                    'name' => 'Accessories',
                    'children' => [
                        [
                            'name' => 'Belts',
                        ],
                        [
                            'name' => 'Scarves & Mufflers',
                        ],
                        [
                            'name' => 'Gloves',
                        ],
                        [
                            'name' => 'Hats & Caps',
                        ],
                        [
                            'name' => 'Hair Accessories',
                        ],
                        [
                            'name' => 'Socks & Tights',
                        ],
                    ],
                ],
                [
                    'name' => 'Lingerie, Sleep & Lounge',
                    'children' => [
                        [
                            'name' => 'Bras',
                        ],
                        [
                            'name' => 'Lingerie Sets',
                        ],
                        [
                            'name' => 'Panties',
                        ],
                        [
                            'name' => 'Sleep & Lounge Wear',
                        ],
                        [
                            'name' => 'Robes',
                        ],
                        [
                            'name' => 'Shapewear',
                        ],
                        [
                            'name' => 'Sexy Lingerie',
                        ],
                    ],
                ],
                [
                    'name' => 'Girl`s Fashion',
                    'children' => [
                        [
                            'name' => 'Girl`s Clothing',
                        ],
                        [
                            'name' => 'Girl`s Shoes',
                        ],

                        [
                            'name' => 'Girl`s Accessories',
                        ],
                    ],
                ],
            ],
        ];
    }

    public static function healthAndBeauty(): array
    {

        return [
            'name' => 'Health & Beauty',
            'children' => [
                [
                    'name' => 'Bath & Body',
                    'children' => [
                        [
                            'name' => 'Body & Massage Oils',
                        ],
                        [
                            'name' => 'Body Soaps & Shower Gels',
                        ],
                        [
                            'name' => 'Body Moisturizers',
                        ],
                        [
                            'name' => 'Foot Care',
                        ],
                        [
                            'name' => 'Hair Removal',
                        ],
                        [
                            'name' => 'Bath & Body Accessories',
                        ],
                        [
                            'name' => 'Body Scrubs',
                        ],
                        [
                            'name' => 'Hand Care',
                        ],
                    ],
                ],
                [
                    'name' => 'Beauty Tools',
                    'children' => [
                        [
                            'name' => 'Curling Irons & Wands',
                        ],
                        [
                            'name' => 'Flat Irons',
                        ],
                        [
                            'name' => 'Hair Dryers',
                        ],
                        [
                            'name' => 'Hair Removal Appliances',
                        ],
                    ],
                ],
                [
                    'name' => 'Fragrances',
                    'children' => [
                        [
                            'name' => 'Women Fragrances',

                        ],
                        [
                            'name' => 'Men Fragrances',
                        ],
                        [
                            'name' => 'Deodorants',
                        ],
                    ],
                ],
                [
                    'name' => 'Hair Care',
                    'children' => [
                        [
                            'name' => 'Shampoo',
                        ],
                        [
                            'name' => 'Hair Treatments',
                        ],
                        [
                            'name' => 'Hair Care Accessories',
                        ],
                        [
                            'name' => 'Hair Brushes & Combs',
                        ],
                        [
                            'name' => 'Hair Coloring',
                        ],
                        [
                            'name' => 'Hair Conditioner',
                        ],
                        [
                            'name' => 'Hair Styling',
                        ],
                    ],
                ],
                [
                    'name' => 'Makeup',
                    'children' => [
                        [
                            'name' => 'Makeup',
                        ],
                        [
                            'name' => 'Foundation',
                        ],
                        [
                            'name' => 'Lips',
                        ],
                        [
                            'name' => 'Eyes',
                        ],
                        [
                            'name' => 'Nails',
                        ],
                        [
                            'name' => 'Brushes & Sets',
                        ],
                        [
                            'name' => 'Makeup Accessories',
                        ],
                        [
                            'name' => 'Makeup Removers',
                        ],
                    ],
                ],
                [
                    'name' => 'Men`s Care',
                    'children' => [
                        [
                            'name' => 'Hair Care',
                        ],
                        [
                            'name' => 'Deodorants',
                        ],
                        [
                            'name' => 'Skin Care',
                        ],
                        [
                            'name' => 'Shaving & Grooming',
                        ],
                        [
                            'name' => 'Bath & Body',
                        ],
                    ],
                ],
                [
                    'name' => 'Personal Care',
                    'children' => [
                        [
                            'name' => 'Oral Care',
                        ],
                        [
                            'name' => 'Sexual Wellness',
                        ],
                        [
                            'name' => 'Deodorants',
                        ],
                    ],
                ],
                [
                    'name' => 'Skin Care',
                    'children' => [
                        [
                            'name' => 'Face Scrubs & Exfoliators',
                        ],
                        [
                            'name' => 'Facial Cleansers',
                        ],
                        [
                            'name' => 'Face Moisturizers',
                        ],
                        [
                            'name' => 'Face Treatments',
                        ],
                        [
                            'name' => 'Face Masks & Packs',
                        ],
                        [
                            'name' => 'Sun Care',
                        ],
                        [
                            'name' => 'Eye Care',
                        ],
                        [
                            'name' => 'Lip Care',
                        ],
                        [
                            'name' => 'Face Toners',
                        ],
                    ],
                ],
                [
                    'name' => 'Food Supplements',
                    'children' => [
                        [
                            'name' => 'Beauty Supplements',
                        ],
                        [
                            'name' => 'Multivitamins',
                        ],
                        [
                            'name' => 'Weight Management',
                        ],
                        [
                            'name' => 'Well Being',
                        ],
                    ],
                ],
            ],
        ];
    }

    public static function autoMobile(): array
    {
        return [
            'name' => 'Automotive',
            'children' => [
                [
                    'name' => 'Auto Tools & Equipment',
                    'children' => [
                        [
                            'name' => 'Auto Parts & Spares',
                            'children' => [
                                [
                                    'name' => 'GPS',
                                ],
                                [
                                    'name' => 'Consoles & Organizers',
                                ],
                            ],
                        ],
                        [
                            'name' => 'Motorcycles',
                            'children' => [
                                [
                                    'name' => 'Standard Bikes',
                                ],
                                [
                                    'name' => 'Scooters',
                                ],
                                [
                                    'name' => 'Electric Bikes',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'Auto Care',
                    'children' => [
                        [
                            'name' => 'Polishes & Waxes',
                        ],
                        [
                            'name' => 'Floor Mats & Cargo Liners',
                        ],
                        [
                            'name' => 'Air Fresheners',
                        ],
                    ],
                ],
                [
                    'name' => 'Auto Electronics',
                    'children' => [
                        [
                            'name' => 'Car Video',
                        ],
                        [
                            'name' => 'Car Stereo Receivers',
                        ],
                        [
                            'name' => 'In-Dash DVD & Video',
                        ],
                        [
                            'name' => 'Speakers',
                        ],
                    ],
                ],
                [
                    'name' => 'Moto Parts & Accessories',
                    'children' => [
                        [
                            'name' => 'Drivetrain & Transmission',
                        ],
                        [
                            'name' => 'Tires & Wheels',
                        ],
                        [
                            'name' => 'Moto Covers',
                        ],
                        [
                            'name' => 'Parts & Spares',
                        ],
                        [
                            'name' => 'Motorcycle Riding Gear',
                            'children' => [
                                [
                                    'name' => 'Eye wear',
                                ],
                                [
                                    'name' => 'Face Masks',
                                ],
                                [
                                    'name' => 'Helmets',
                                ],
                                [
                                    'name' => 'Gloves',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'Interior Accessories',
                ],
                [
                    'name' => 'Auto Oils & Fluids',
                ],
                [
                    'name' => 'Auto Tires & Wheels',
                ],
                [
                    'name' => 'Lubricants',
                ],
            ],
        ];
    }

    public static function mensFashion(): array
    {

        return [
            'name' => 'Men`s Fashion',
            'children' => [
                [
                    'name' => 'Clothing',
                    'children' => [
                        [
                            'name' => 'Casual Tops',
                        ],
                        [
                            'name' => 'Polo Shirts',
                        ],
                        [
                            'name' => 'Shirts',
                        ],
                        [
                            'name' => 'Jeans',
                        ],
                        [
                            'name' => 'Pants',
                        ],
                        [
                            'name' => 'Suits',
                        ],
                        [
                            'name' => 'Jackets & Coats',
                        ],
                        [
                            'name' => 'Hoodies & Sweatshirts',
                        ],
                        [
                            'name' => 'Sweaters & Cardigans',
                        ],
                    ],
                ],
                [
                    'name' => 'Men`s Bags',
                    'children' => [
                        [
                            'name' => 'Backpacks',
                        ],
                        [
                            'name' => 'Crossbody Bags',
                        ],
                        [
                            'name' => 'Messenger Bags',
                        ],
                        [
                            'name' => 'Business Bags',
                        ],
                        [
                            'name' => 'Wallets & Accessories',
                        ],
                    ],
                ],
                [
                    'name' => 'Shoes',
                    'children' => [
                        [
                            'name' => 'Slip-Ons & Loafers',
                        ],
                        [
                            'name' => 'Flip Flops & Sandals',
                        ],
                        [
                            'name' => 'Sneakers',
                        ],
                        [
                            'name' => 'Formal Shoes',
                        ],
                        [
                            'name' => 'Boots',
                        ],
                        [
                            'name' => 'Shoes Accessories',
                        ],
                    ],
                ],
                [
                    'name' => 'Accessories',
                    'children' => [
                        [
                            'name' => 'Scarves',
                        ],
                        [
                            'name' => 'Ties & Bow Ties',
                        ],
                        [
                            'name' => 'Socks',
                        ],
                        [
                            'name' => 'Belts',
                        ],
                        [
                            'name' => 'Hats & Caps',
                        ],
                        [
                            'name' => 'Gloves',
                        ],
                    ],
                ],
                [
                    'name' => 'Boy`s Fashion',
                    'children' => [
                        [
                            'name' => 'Boy`s Clothing',
                        ],
                        [
                            'name' => 'Boy`s Shoes',
                        ],
                        [
                            'name' => 'Boy`s Accessories',
                        ],
                    ],
                ],
                [
                    'name' => 'Men`s Underwear',
                    'children' => [
                        [
                            'name' => 'Briefs',
                        ],
                        [
                            'name' => 'Vests',
                        ],
                        [
                            'name' => 'Trunks & Boxers',
                        ],
                    ],
                ],
            ],

        ];
    }

    public static function watchesAndAccessories(): array
    {

        return [
            'name' => 'Watches & Accessories',
            'children' => [
                [
                    'name' => 'Men`s Watches',
                    'children' => [
                        [
                            'name' => 'Analog Watches',
                        ],
                        [
                            'name' => 'Digital Watches',
                        ],
                        [
                            'name' => 'Sports Watches',
                        ],
                        [
                            'name' => 'Smart Watches',
                        ],
                        [
                            'name' => 'Watch Accessories',
                        ],
                    ],

                ],
                [
                    'name' => 'Women`s Watches',
                    'children' => [
                        [
                            'name' => 'Analog Watches',
                        ],
                        [
                            'name' => 'Digital Watches',
                        ],
                        [
                            'name' => 'Sports Watches',
                        ],
                        [
                            'name' => 'Smart Watches',
                        ],
                        [
                            'name' => 'Watch Accessories',
                        ],
                    ],
                ],
                [
                    'name' => 'Kids Watches',
                    'children' => [
                        [
                            'name' => 'Analog Watches',
                        ],
                        [
                            'name' => 'Digital Watches',
                        ],
                        [
                            'name' => 'Sports Watches',
                        ],
                        [
                            'name' => 'Smart Watches',
                        ],
                        [
                            'name' => 'Watch Accessories',
                        ],
                    ],
                ],
                [
                    'name' => 'Sunglasses',
                    'children' => [
                        [
                            'name' => 'Men Sunglasses',
                        ],
                        [
                            'name' => 'Women Sunglasses',
                        ],
                        [
                            'name' => 'Kids Sunglasses',
                        ],
                    ],
                ],
                [
                    'name' => 'Eyeglasses',
                    'children' => [
                        [
                            'name' => 'Men Eyeglasses',
                        ],
                        [
                            'name' => 'Women Eyeglasses',
                        ],
                    ],
                ],
                [
                    'name' => 'Women Fashion Jewellery',
                    'children' => [
                        [
                            'name' => 'Earrings',
                        ],
                        [
                            'name' => 'Bracelets',
                        ],
                        [
                            'name' => 'Jewellery sets',
                        ],
                        [
                            'name' => 'Necklaces',
                        ],
                        [
                            'name' => 'Pendants',
                        ],
                        [
                            'name' => 'Rings',
                        ],
                    ],
                ],
                [

                    'name' => 'Men Fashion Jewellery',
                    'children' => [
                        [
                            'name' => 'Bracelets',
                        ],
                        [
                            'name' => 'Rings',
                        ],
                    ],

                ],

            ],

        ];
    }

    // public static function electronicDevices(): array
    // {

    //     return [
    //         'name' => 'Electronic Devices',
    //         'children' => [
    //             [
    //                 'name' => 'Smartphones',
    //                 'children' => [
    //                     [
    //                         'name' => 'Samsung Mobiles',
    //                     ],
    //                     [
    //                         'name' => 'Realme Mobiles',
    //                     ],
    //                     [
    //                         'name' => 'Redmi/Poco Mobiles',
    //                     ],
    //                     [
    //                         'name' => 'Apple iPhones',
    //                     ],
    //                     [
    //                         'name' => 'OnePlus Mobiles',
    //                     ],
    //                     [
    //                         'name' => 'Narzo by Realme',
    //                     ],
    //                     [
    //                         'name' => 'INFINIX Mobiles',
    //                     ],
    //                     [
    //                         'name' => 'Nokia Mobiles',
    //                     ],
    //                     [
    //                         'name' => 'Motorola Mobiles',
    //                     ],
    //                     [
    //                         'name' => 'VIVO Mobiles',
    //                     ],
    //                     [
    //                         'name' => 'OPPO Mobiles',
    //                     ],
    //                     [
    //                         'name' => 'Micromax Mobiles',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Tablets',
    //                 'children' => [
    //                     [
    //                         'name' => 'Apple iPads',
    //                     ],
    //                     [
    //                         'name' => 'Samsung Tablets',
    //                     ],
    //                     [
    //                         'name' => 'Lenovo Tablets',
    //                     ],
    //                     [
    //                         'name' => 'Amazon Tablets',
    //                     ],
    //                     [
    //                         'name' => 'TCL Tablets',
    //                     ],
    //                     [
    //                         'name' => 'XP-PEN Graphic Tablet',
    //                     ],
    //                     [
    //                         'name' => 'Wacom Graphic Tablet',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Laptops',
    //                 'children' => [
    //                     [
    //                         'name' => 'Macbooks',
    //                     ],
    //                     [
    //                         'name' => 'Dell Laptops',
    //                     ],
    //                     [
    //                         'name' => 'Lenovo Laptops',
    //                     ],
    //                     [
    //                         'name' => 'Acer Laptops',
    //                     ],
    //                     [
    //                         'name' => 'HP Laptops',
    //                     ],
    //                     [
    //                         'name' => 'ASUS Laptops',
    //                     ],
    //                     [
    //                         'name' => 'MI Laptops',
    //                     ],
    //                     [
    //                         'name' => 'CHUWI Laptops',
    //                     ],
    //                     [
    //                         'name' => 'MSI Laptops',
    //                     ],
    //                     [
    //                         'name' => 'AVITA Laptops',
    //                     ],
    //                     [
    //                         'name' => 'Microsoft Laptops',
    //                     ],
    //                     [
    //                         'name' => 'Huawei Laptops',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Desktops',
    //                 'children' => [
    //                     [
    //                         'name' => 'All-In-One',
    //                     ],
    //                     [
    //                         'name' => 'Gaming Desktops',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Monitors',
    //                 'children' => [
    //                     [
    //                         'name' => 'Gaming Monitors',
    //                     ],
    //                     [
    //                         'name' => 'Office Monitors',
    //                     ],
    //                     [
    //                         'name' => 'Curved Monitors',
    //                     ],
    //                     [
    //                         'name' => '4K Monitors',
    //                     ],
    //                     [
    //                         'name' => 'Gaming Consoles',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Cameras',
    //                 'children' => [
    //                     [
    //                         'name' => 'Action/Video Cameras',
    //                     ],
    //                     [
    //                         'name' => 'Security Cameras',
    //                     ],
    //                     [
    //                         'name' => 'DSLR Cameras',
    //                     ],
    //                     [
    //                         'name' => 'Instant Cameras',
    //                     ],
    //                     [
    //                         'name' => 'Camera Accessories',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Printers',
    //                 'children' => [
    //                     [
    //                         'name' => 'Printers',
    //                     ],
    //                     [
    //                         'name' => 'Ink & Toners',
    //                     ],
    //                 ],
    //             ],
    //         ],
    //     ];
    // }

    // public static function tvAndHomeAppliance(): array
    // {

    //     return [
    //         'name' => 'TV & Home Appliances',
    //         'children' => [
    //             [
    //                 'name' => 'Televisions',
    //                 'children' => [
    //                     [
    //                         'name' => 'Smart TVs',
    //                     ],
    //                     [
    //                         'name' => 'LED TVs',
    //                     ],
    //                     [
    //                         'name' => 'OLED TVs',
    //                     ],
    //                     [
    //                         'name' => 'QLED TVs',
    //                     ],
    //                     [
    //                         'name' => '4K Ultra HD TVs',
    //                     ],
    //                     [
    //                         'name' => 'Full HD TVs',
    //                     ],
    //                     [
    //                         'name' => 'HD Ready TVs',
    //                     ],
    //                     [
    //                         'name' => 'Curved TVs',
    //                     ],
    //                     [
    //                         'name' => 'Projectors',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Home Audio',
    //                 'children' => [
    //                     [
    //                         'name' => 'Home Theaters',
    //                     ],
    //                     [
    //                         'name' => 'Soundbars',
    //                     ],
    //                     [
    //                         'name' => 'Speakers',
    //                     ],
    //                     [
    //                         'name' => 'Hi-Fi Systems',
    //                     ],
    //                     [
    //                         'name' => 'MP3 Players',
    //                     ],
    //                     [
    //                         'name' => 'CD Players',
    //                     ],
    //                     [
    //                         'name' => 'DVD Players',
    //                     ],
    //                     [
    //                         'name' => 'Radios',
    //                     ],
    //                     [
    //                         'name' => 'Voice Recorders',
    //                     ],
    //                     [
    //                         'name' => 'DJ & Party Systems',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Kitchen Appliances',
    //                 'children' => [
    //                     [
    //                         'name' => 'Refrigerators',
    //                     ],
    //                     [
    //                         'name' => 'Freezers',
    //                     ],
    //                     [
    //                         'name' => 'Washing Machines',
    //                     ],
    //                     [
    //                         'name' => 'Dryers',
    //                     ],
    //                     [
    //                         'name' => 'Dishwashers',
    //                     ],
    //                     [
    //                         'name' => 'Cooking Appliances',
    //                     ],
    //                     [
    //                         'name' => 'Water Dispensers',
    //                     ],
    //                     [
    //                         'name' => 'Water Purifiers',
    //                     ],
    //                     [
    //                         'name' => 'Microwave Ovens',
    //                     ],
    //                     [
    //                         'name' => 'Ovens',
    //                     ],
    //                     [
    //                         'name' => 'Hobs',
    //                     ],
    //                     [
    //                         'name' => 'Hoods',
    //                     ],
    //                     [
    //                         'name' => 'Coffee Machines',
    //                     ],
    //                     [
    //                         'name' => 'Blenders & Juicers',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Cooling & Heating',
    //                 'children' => [
    //                     [
    //                         'name' => 'Air Conditioners',
    //                     ],
    //                     [
    //                         'name' => 'Fans',
    //                     ],
    //                     [
    //                         'name' => 'Air Coolers',
    //                     ],
    //                     [
    //                         'name' => 'Heaters',
    //                     ],
    //                     [
    //                         'name' => 'Air Purifiers',
    //                     ],
    //                     [
    //                         'name' => 'Humidifiers',
    //                     ],
    //                     [
    //                         'name' => 'Dehumidifiers',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Vacuum & Floor Care',
    //                 'children' => [
    //                     [
    //                         'name' => 'Vacuum Cleaners',
    //                     ],
    //                     [
    //                         'name' => 'Steam Cleaners',
    //                     ],
    //                     [
    //                         'name' => 'Floor Polishers',
    //                     ],
    //                     [
    //                         'name' => 'Sewing Machines',
    //                     ],
    //                     [
    //                         'name' => 'Irons',
    //                     ],
    //                     [
    //                         'name' => 'Garment Steamers',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Small Kitchen Appliances',
    //                 'children' => [
    //                     [
    //                         'name' => 'Food Preparation',
    //                     ],
    //                     [
    //                         'name' => 'Food Processors',
    //                     ],
    //                     [
    //                         'name' => 'Mixers & Blenders',
    //                     ],
    //                     [
    //                         'name' => 'Juicers',
    //                     ],
    //                     [
    //                         'name' => 'Grinders',
    //                     ],
    //                     [
    //                         'name' => 'Toasters & Sandwich Makers',
    //                     ],
    //                     [
    //                         'name' => 'Kettles',
    //                     ],
    //                     [
    //                         'name' => 'Coffee Machines',
    //                     ],
    //                     [
    //                         'name' => 'Fryers',
    //                     ],
    //                     [
    //                         'name' => 'Rice Cookers',
    //                     ],
    //                     [
    //                         'name' => 'Steamers',
    //                     ],
    //                     [
    //                         'name' => 'Cookers',
    //                     ],
    //                     [
    //                         'name' => 'Food Warmers',
    //                     ],
    //                     [
    //                         'name' => 'Microwaves',
    //                     ],
    //                     [
    //                         'name' => 'Cooktops',
    //                     ],
    //                     [
    //                         'name' => 'Ovens',
    //                     ],
    //                     [
    //                         'name' => 'Hobs',
    //                     ],
    //                     [
    //                         'name' => 'Hoods',
    //                     ],
    //                     [
    //                         'name' => 'Water Dispensers',
    //                     ],
    //                     [
    //                         'name' => 'Water Purifiers',
    //                     ],
    //                     [
    //                         'name' => 'Ice Makers',
    //                     ],
    //                     [
    //                         'name' => 'Soda Makers',
    //                     ],
    //                     [
    //                         'name' => 'Waffle Makers',
    //                     ],
    //                     [
    //                         'name' => 'Popcorn Makers',
    //                     ],
    //                     [
    //                         'name' => 'Bread Makers',
    //                     ],
    //                     [
    //                         'name' => 'Crepe Makers',
    //                     ],
    //                     [
    //                         'name' => 'Egg Boilers',
    //                     ],
    //                     [
    //                         'name' => 'Electric Slicers',
    //                     ],

    //                 ],
    //             ],
    //         ],
    //     ];
    // }

    // public static function electronicAccessories(): array
    // {

    //     return [
    //         'name' => 'Electronic Accessories',
    //         'children' => [
    //             [
    //                 'name' => 'Mobile Accessories',
    //                 'children' => [
    //                     [
    //                         'name' => 'Phone Cases',
    //                     ],
    //                     [
    //                         'name' => 'Screen Protectors',
    //                     ],
    //                     [
    //                         'name' => 'Power Banks',
    //                     ],
    //                     [
    //                         'name' => 'Cables & Converters',
    //                     ],
    //                     [
    //                         'name' => 'Wall Chargers',
    //                     ],
    //                     [
    //                         'name' => 'Wireless Chargers',
    //                     ],
    //                     [
    //                         'name' => 'Tablet Accessories',
    //                     ],
    //                     [
    //                         'name' => 'Parts & Tools',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Audio',
    //                 'children' => [
    //                     [
    //                         'name' => 'Headphones & Headsets',
    //                     ],
    //                     [
    //                         'name' => 'Gaming Headsets',
    //                     ],
    //                     [
    //                         'name' => 'Bluetooth Speakers',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Wearable',
    //                 'children' => [
    //                     [
    //                         'name' => 'Smartwatches',
    //                     ],
    //                     [
    //                         'name' => 'Virtual Reality',
    //                     ],
    //                     [
    //                         'name' => 'Fitness & Activity Trackers',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Console Accessories',
    //                 'children' => [
    //                     [
    //                         'name' => 'PlayStation Controllers',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Camera Accessories',
    //                 'children' => [
    //                     [
    //                         'name' => 'Memory Cards',
    //                     ],
    //                     [
    //                         'name' => 'Lenses',
    //                     ],
    //                     [
    //                         'name' => 'Tripods & Monopods',
    //                     ],
    //                     [
    //                         'name' => 'Camera Cases, Covers and Bags',
    //                     ],
    //                     [
    //                         'name' => 'Action Camera Accessories',
    //                     ],
    //                     [
    //                         'name' => 'Lighting & Studio Equipment',
    //                     ],
    //                     [
    //                         'name' => 'Batteries',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Computer Accessories',
    //                 'children' => [
    //                     [
    //                         'name' => 'Monitors',
    //                     ],
    //                     [
    //                         'name' => 'Keyboards',
    //                     ],
    //                     [
    //                         'name' => 'Mice',
    //                     ],
    //                     [
    //                         'name' => 'Adapters & Cables',
    //                     ],
    //                     [
    //                         'name' => 'PC Audio',
    //                     ],
    //                     [
    //                         'name' => 'DIY Desktop Parts',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Storage',
    //                 'children' => [
    //                     [
    //                         'name' => 'External Hard Drives',
    //                     ],
    //                     [
    //                         'name' => 'Internal Hard Drives',
    //                     ],
    //                     [
    //                         'name' => 'SSD',
    //                     ],
    //                     [
    //                         'name' => 'USB Flash Drives',
    //                     ],
    //                     [
    //                         'name' => 'Memory Cards',
    //                     ],
    //                     [
    //                         'name' => 'Network Attached Storage',
    //                     ],
    //                     [
    //                         'name' => 'Optical Drives',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Computer Components',
    //                 'children' => [
    //                     [
    //                         'name' => 'Motherboards',
    //                     ],
    //                     [
    //                         'name' => 'Processors',
    //                     ],
    //                     [
    //                         'name' => 'Graphic Cards',
    //                     ],
    //                     [
    //                         'name' => 'Power Supply Units',
    //                     ],
    //                     [
    //                         'name' => 'Memory',
    //                     ],
    //                     [
    //                         'name' => 'Casing',
    //                     ],
    //                     [
    //                         'name' => 'Cooling',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Network Components',
    //                 'children' => [
    //                     [
    //                         'name' => 'Routers',
    //                     ],
    //                     [
    //                         'name' => 'Switches',
    //                     ],
    //                     [
    //                         'name' => 'Access Points',
    //                     ],
    //                     [
    //                         'name' => 'Network Adapters',
    //                     ],
    //                     [
    //                         'name' => 'Network Storage',
    //                     ],
    //                     [
    //                         'name' => 'Modems',
    //                     ],
    //                     [
    //                         'name' => 'Network Usb Adapters',
    //                     ],
    //                 ],
    //             ],
    //         ],
    //     ];
    // }

    // public static function groceriesAndPets(): array
    // {
    //     return [
    //         'name' => 'Groceries & Pets',
    //         'children' => [
    //             [
    //                 'name' => 'Food Staples',
    //                 'children' => [
    //                     [
    //                         'name' => 'Rice',
    //                     ],
    //                     [
    //                         'name' => 'Flour',
    //                     ],
    //                     [
    //                         'name' => 'Pulses',
    //                     ],
    //                     [
    //                         'name' => 'Sugar',
    //                     ],
    //                     [
    //                         'name' => 'Salt',
    //                     ],
    //                     [
    //                         'name' => 'Edible Oil',
    //                     ],
    //                     [
    //                         'name' => 'Spices',
    //                     ],
    //                     [
    //                         'name' => 'Nuts & Seeds',
    //                     ],
    //                     [
    //                         'name' => 'Dry Fruits',
    //                     ],
    //                     [
    //                         'name' => 'Honey',
    //                     ],
    //                     [
    //                         'name' => 'Sauces & Ketchup',
    //                     ],
    //                     [
    //                         'name' => 'Pickles',
    //                     ],
    //                     [
    //                         'name' => 'Vinegar',
    //                     ],
    //                     [
    //                         'name' => 'Chutneys',
    //                     ],

    //                     [
    //                         'name' => 'Soy Sauce',
    //                     ],
    //                     [
    //                         'name' => 'Mayonnaise',
    //                     ],
    //                     [
    //                         'name' => 'Mustard',
    //                     ],
    //                     [
    //                         'name' => 'Olive Oil',
    //                     ],
    //                     [
    //                         'name' => 'Coconut Oil',
    //                     ],
    //                     [
    //                         'name' => 'Ghee',
    //                     ],
    //                     [
    //                         'name' => 'Butter',
    //                     ],
    //                     [
    //                         'name' => 'Cheese',
    //                     ],
    //                     [
    //                         'name' => 'Milk',
    //                     ],
    //                     [
    //                         'name' => 'Yogurt',
    //                     ],
    //                     [
    //                         'name' => 'Cream',
    //                     ],
    //                     [
    //                         'name' => 'Ice Cream',
    //                     ],
    //                     [
    //                         'name' => 'Curd',
    //                     ],
    //                     [
    //                         'name' => 'Cottage Cheese',
    //                     ],
    //                     [
    //                         'name' => 'Eggs',
    //                     ],
    //                     [
    //                         'name' => 'Bread',
    //                     ],
    //                     [
    //                         'name' => 'Bakery',
    //                     ],
    //                     [
    //                         'name' => 'Biscuits',
    //                     ],
    //                     [
    //                         'name' => 'Cookies',
    //                     ],
    //                     [
    //                         'name' => 'Cakes',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Beverages',
    //                 'children' => [
    //                     [
    //                         'name' => 'Tea',
    //                     ],
    //                     [
    //                         'name' => 'Coffee',
    //                     ],
    //                     [
    //                         'name' => 'Juices',
    //                     ],
    //                     [
    //                         'name' => 'Soft Drinks',
    //                     ],
    //                     [
    //                         'name' => 'Powdered Drink Mixes',
    //                     ],
    //                     [
    //                         'name' => 'Energy Drinks',
    //                     ],
    //                     [
    //                         'name' => 'Syrups',
    //                     ],
    //                     [
    //                         'name' => 'Soda',
    //                     ],
    //                     [
    //                         'name' => 'Water',
    //                     ],
    //                     [
    //                         'name' => 'Milk',
    //                     ],
    //                     [
    //                         'name' => 'Milk Powder',
    //                     ],
    //                     [
    //                         'name' => 'Milk Shake',
    //                     ],
    //                     [
    //                         'name' => 'Soy Milk',
    //                     ],
    //                     [
    //                         'name' => 'Coconut Water',
    //                     ],
    //                     [
    //                         'name' => 'Lassi',
    //                     ],
    //                     [
    //                         'name' => 'Buttermilk',
    //                     ],
    //                     [
    //                         'name' => 'Yogurt Drink',
    //                     ],
    //                     [
    //                         'name' => 'Spirits',
    //                     ],

    //                 ],

    //             ],
    //             [
    //                 'name' => 'Breakfast, Choco & Snacks',
    //                 'children' => [
    //                     [
    //                         'name' => 'Biscuit',
    //                     ],
    //                     [
    //                         'name' => 'Breakfast Cereals',
    //                     ],
    //                     [
    //                         'name' => 'Chocolate',
    //                     ],
    //                     [
    //                         'name' => 'Chips & Crisps',
    //                     ],
    //                     [
    //                         'name' => 'Jam,Spreads & Honey',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Food Staples',
    //                 'children' => [
    //                     [
    //                         'name' => 'Home Baking & Sugar',
    //                     ],
    //                     [
    //                         'name' => 'Instant & Ready-to-Eat',
    //                     ],
    //                     [
    //                         'name' => 'Rice',
    //                     ],
    //                     [
    //                         'name' => 'Daal',
    //                     ],
    //                     [
    //                         'name' => 'Cooking Ingredients',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Cooking Ingredients',
    //                 'children' => [
    //                     [
    //                         'name' => 'Oil & Ghee',
    //                     ],
    //                     [
    //                         'name' => 'Seasoning',
    //                     ],
    //                     [
    //                         'name' => 'Herbs & Spices',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Laundry & Household',
    //                 'children' => [
    //                     [
    //                         'name' => 'AirCare',
    //                     ],
    //                     [
    //                         'name' => 'Cleaning',
    //                     ],
    //                     [
    //                         'name' => 'Dishwashing',
    //                     ],
    //                     [
    //                         'name' => 'Laundry',
    //                     ],
    //                     [
    //                         'name' => 'Pest Control',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Wines, Beers & Spirits',
    //                 'children' => [
    //                     [
    //                         'name' => 'Wines',
    //                     ],
    //                     [
    //                         'name' => 'Beer',
    //                     ],
    //                     [
    //                         'name' => 'Spirits',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Pet Supplies',
    //                 'children' => [
    //                     [
    //                         'name' => 'Dogs',
    //                     ],
    //                     [
    //                         'name' => 'Cats',
    //                     ],
    //                 ],
    //             ],
    //         ],
    //     ];
    // }

    // public static function babyAndToys(): array
    // {

    //     return [
    //         'name' => 'Baby & Toys',
    //         'children' => [
    //             [
    //                 'name' => 'Baby Gear',
    //                 'children' => [
    //                     [
    //                         'name' => 'Baby Walkers',
    //                     ],
    //                     [
    //                         'name' => 'Backpacks & Carriers',
    //                     ],
    //                     [
    //                         'name' => 'Car Seats',
    //                     ],
    //                     [
    //                         'name' => 'Kids Bag',
    //                     ],
    //                     [
    //                         'name' => 'Strollers',
    //                     ],
    //                     [
    //                         'name' => 'Swings, Jumpers & Bouncers',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Baby Personal Care',
    //                 'children' => [
    //                     [
    //                         'name' => 'Baby Bath',
    //                     ],
    //                     [
    //                         'name' => 'Bathing Tubs & Seats',
    //                     ],
    //                     [
    //                         'name' => 'Soaps, Cleansers & Bodywash',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Clothing & Accessories',
    //                 'children' => [
    //                     [
    //                         'name' => 'Girls` Clothing',
    //                     ],
    //                     [
    //                         'name' => 'Girls` Shoes',
    //                     ],
    //                     [
    //                         'name' => 'Boys` Clothing',
    //                     ],
    //                     [
    //                         'name' => 'New Born Unisex (0 - 6 months)',
    //                     ],
    //                     [
    //                         'name' => 'New Born Sets & Packs',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Diapering & Potty',
    //                 'children' => [
    //                     [
    //                         'name' => 'Potty Chair',
    //                     ],
    //                     [
    //                         'name' => 'Wipes & Holders',
    //                     ],
    //                     [
    //                         'name' => 'Disposable Diapers',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Feeding',
    //                 'children' => [
    //                     [
    //                         'name' => 'Milk Formula',
    //                     ],
    //                     [
    //                         'name' => 'Utensils',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Nursery',
    //                 'children' => [
    //                     [
    //                         'name' => 'Mattresses & Bedding',
    //                     ],
    //                     [
    //                         'name' => 'Sanitizers',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Baby & Toddler Toys',
    //                 'children' => [
    //                     [
    //                         'name' => 'Activity Gym & Playmats',
    //                     ],
    //                     [
    //                         'name' => 'Basic & Life Skills Toys',
    //                     ],
    //                     [
    //                         'name' => 'Bath Toys',
    //                     ],
    //                     [
    //                         'name' => 'Crib Toys & Attachments',
    //                     ],
    //                     [
    //                         'name' => 'Early Development Toys',
    //                     ],
    //                     [
    //                         'name' => 'Reading & Writing',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Toys & Games',
    //                 'children' => [
    //                     [
    //                         'name' => 'Action Figures & Collectibles',
    //                     ],
    //                     [
    //                         'name' => 'Arts & Crafts for Kids',
    //                     ],
    //                     [
    //                         'name' => 'Blocks & Building Toys',
    //                     ],
    //                     [
    //                         'name' => 'Dolls & Accessories',
    //                     ],
    //                     [
    //                         'name' => 'Dress Up & Pretend Play',
    //                     ],
    //                     [
    //                         'name' => 'Electronic Toys',
    //                     ],
    //                     [
    //                         'name' => 'Learning & Education',
    //                     ],
    //                     [
    //                         'name' => 'Party Supplies',
    //                     ],
    //                     [
    //                         'name' => 'Puzzle',
    //                     ],
    //                     [
    //                         'name' => 'Stuffed Toys',
    //                     ],
    //                     [
    //                         'name' => 'Traditional Games',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Remote Control & Vehicles',
    //                 'children' => [
    //                     [
    //                         'name' => 'Die-Cast Vehicles',
    //                     ],
    //                     [
    //                         'name' => 'Drones & Accessories',
    //                     ],
    //                     [
    //                         'name' => 'Play Trains & Railway Sets',
    //                     ],
    //                     [
    //                         'name' => 'Play Vehicles',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Sports & Outdoor Play',
    //                 'children' => [
    //                     [
    //                         'name' => 'Swimming Pool & Water Toys',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Pacifiers & Accessories',
    //             ],
    //         ],
    //     ];
    // }

    // public static function homeAndLifestyle(): array
    // {

    //     return [
    //         'name' => 'Home & Lifestyle',
    //         'children' => [
    //             [
    //                 'name' => 'Bath',
    //                 'children' => [
    //                     [
    //                         'name' => 'Bath Mats',
    //                     ],
    //                     [
    //                         'name' => 'Bath Towels',
    //                     ],
    //                     [
    //                         'name' => 'Bathrobes',
    //                     ],
    //                     [
    //                         'name' => 'Bathroom Scales',
    //                     ],
    //                     [
    //                         'name' => 'Bathroom Shelving',
    //                     ],
    //                     [
    //                         'name' => 'Shower Caddies & Hangers',
    //                     ],
    //                     [
    //                         'name' => 'Shower Curtains',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Bedding',
    //                 'children' => [
    //                     [
    //                         'name' => 'Bed Sheets',
    //                     ],
    //                     [
    //                         'name' => 'Bedding Accessories',
    //                     ],
    //                     [
    //                         'name' => 'Blankets & Throws',
    //                     ],
    //                     [
    //                         'name' => 'Comforters, Quilts & Duvets',
    //                     ],
    //                     [
    //                         'name' => 'Mattress Protectors',
    //                     ],
    //                     [
    //                         'name' => 'Pillow Cases',
    //                     ],
    //                     [
    //                         'name' => 'Pillows & Bolsters',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Decor',
    //                 'children' => [
    //                     [
    //                         'name' => 'Artificial Flowers & Plants',
    //                     ],
    //                     [
    //                         'name' => 'Candles & Candle Holders',
    //                     ],
    //                     [
    //                         'name' => 'Clocks',
    //                     ],
    //                     [
    //                         'name' => 'Curtains',
    //                     ],
    //                     [
    //                         'name' => 'Cushions & Covers',
    //                     ],
    //                     [
    //                         'name' => 'Mirrors',
    //                     ],
    //                     [
    //                         'name' => 'Picture Frames',
    //                     ],
    //                     [
    //                         'name' => 'Rugs & Carpets',
    //                     ],
    //                     [
    //                         'name' => 'Vases & Vessels',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Furniture',
    //                 'children' => [
    //                     [
    //                         'name' => 'Bedroom',
    //                     ],
    //                     [
    //                         'name' => 'Home Office',
    //                     ],
    //                     [
    //                         'name' => 'Kitchen & Dining',
    //                     ],
    //                     [
    //                         'name' => 'Living Room',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Kitchen & Dining',
    //                 'children' => [
    //                     [
    //                         'name' => 'Bakeware',
    //                     ],
    //                     [
    //                         'name' => 'Coffee & Tea',
    //                     ],
    //                     [
    //                         'name' => 'Cookware',
    //                     ],
    //                     [
    //                         'name' => 'Dinnerware',
    //                     ],
    //                     [
    //                         'name' => 'Drinkware',
    //                     ],
    //                     [
    //                         'name' => 'Kitchen & Table Linen',
    //                     ],
    //                     [
    //                         'name' => 'Kitchen Storage & Accessories',
    //                     ],
    //                     [
    //                         'name' => 'Kitchen Utensils',
    //                     ],
    //                     [
    //                         'name' => 'Knives & Accessories',
    //                     ],
    //                     [
    //                         'name' => 'Serveware',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Lighting',
    //                 'children' => [
    //                     [
    //                         'name' => 'Ceiling Lights',
    //                     ],
    //                     [
    //                         'name' => 'Floor Lamps',
    //                     ],
    //                     [
    //                         'name' => 'Lamp Shades',
    //                     ],
    //                     [
    //                         'name' => 'Light Bulbs',
    //                     ],
    //                     [
    //                         'name' => 'Lighting Fixtures & Components',
    //                     ],
    //                     [
    //                         'name' => 'Outdoor Lighting',
    //                     ],
    //                     [
    //                         'name' => 'Rechargeables & Flashlights',
    //                     ],
    //                     [
    //                         'name' => 'Table Lamps',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Laundry & Cleaning',
    //                 'children' => [
    //                     [
    //                         'name' => 'Brushes, Sponges & Wipers',
    //                     ],
    //                     [
    //                         'name' => 'Brooms, Mops & Sweepers',
    //                     ],
    //                     [
    //                         'name' => 'Laundry Baskets & Hampers',
    //                     ],
    //                     [
    //                         'name' => 'Clothes Line & Drying Racks',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Tools, DIY & Outdoor',
    //                 'children' => [
    //                     [
    //                         'name' => 'Mask & Filters',
    //                     ],
    //                     [
    //                         'name' => 'Lawn & Garden',
    //                     ],
    //                     [
    //                         'name' => 'Power Tools',
    //                     ],
    //                     [
    //                         'name' => 'Fixtures & Plumbing',
    //                     ],
    //                     [
    //                         'name' => 'Electrical',
    //                     ],
    //                     [
    //                         'name' => 'Security',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Stationery & Craft',
    //                 'children' => [
    //                     [
    //                         'name' => 'Art Supplies',
    //                     ],
    //                     [
    //                         'name' => 'Gifts & Wrapping',
    //                     ],
    //                     [
    //                         'name' => 'Packaging & Cartons',
    //                     ],
    //                     [
    //                         'name' => 'Paper Products',
    //                     ],
    //                     [
    //                         'name' => 'School & Office Equipment',
    //                     ],
    //                     [
    //                         'name' => 'Writing & Correction',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Media, Music & Books',
    //                 'children' => [
    //                     [
    //                         'name' => 'Books',
    //                     ],
    //                     [
    //                         'name' => 'Magazines',
    //                     ],
    //                     [
    //                         'name' => 'Musical Instruments',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Digital Goods',
    //                 'children' => [
    //                     [
    //                         'name' => 'Home Services',
    //                     ],
    //                     [
    //                         'name' => 'Activities & Entertainment',
    //                     ],
    //                     [
    //                         'name' => 'Beauty & Wellness',
    //                     ],
    //                     [
    //                         'name' => 'Food & Beverage',
    //                     ],
    //                     [
    //                         'name' => 'Hotels & Travel',
    //                     ],
    //                 ],
    //             ],
    //         ],

    //     ];
    // }

    // public static function sportsAndOutdoor(): array
    // {

    //     return  [
    //         'name' => 'Sports & Outdoor',
    //         'children' => [
    //             [
    //                 'name' => 'Men Shoes & Clothing',
    //                 'children' => [
    //                     [
    //                         'name' => 'Clothing',
    //                     ],
    //                     [
    //                         'name' => 'Shoes',
    //                     ],
    //                     [
    //                         'name' => 'Accessories',
    //                     ],
    //                     [
    //                         'name' => 'Bags',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Women Shoes & Clothing',
    //                 'children' => [
    //                     [
    //                         'name' => 'Clothing',
    //                     ],
    //                     [
    //                         'name' => 'Shoes',
    //                     ],
    //                     [
    //                         'name' => 'Accessories',
    //                     ],
    //                     [
    //                         'name' => 'Bags',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Outdoor Recreation',
    //                 'children' => [
    //                     [
    //                         'name' => 'Camping & Hiking',
    //                     ],
    //                     [
    //                         'name' => 'Bikes',
    //                     ],
    //                     [
    //                         'name' => 'Bike lights & reflectors',
    //                     ],
    //                     [
    //                         'name' => 'Fishing',
    //                     ],
    //                     [
    //                         'name' => 'Golf',
    //                     ],
    //                     [
    //                         'name' => 'Skateboards',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Exercise & Fitness',
    //                 'children' => [
    //                     [
    //                         'name' => 'Yoga',
    //                     ],
    //                     [
    //                         'name' => 'Fitness Accessories',
    //                     ],
    //                     [
    //                         'name' => 'Cardio Equipment',
    //                     ],
    //                     [
    //                         'name' => 'Weights',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Water Sports',
    //                 'children' => [
    //                     [
    //                         'name' => 'Goggles',
    //                     ],
    //                     [
    //                         'name' => 'Diving and Snorkelling',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Racket Sports',
    //                 'children' => [
    //                     [
    //                         'name' => 'Badminton',
    //                     ],
    //                     [
    //                         'name' => 'Table Tennis',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Team Sports',
    //                 'children' => [
    //                     [
    //                         'name' => 'Football',
    //                     ],
    //                     [
    //                         'name' => 'Basketball',
    //                     ],
    //                     [
    //                         'name' => 'Cricket',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Travel & Luggage',
    //                 'children' => [
    //                     [
    //                         'name' => 'Suitcases',
    //                     ],
    //                     [
    //                         'name' => 'Travel Accessories',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Sports Nutrition',
    //             ]
    //         ]

    //     ];
    // }

    // public static function motorAndDie(): array
    // {

    //     return  [

    //         'name' => 'Motor, Tools & DIY',
    //         'children' => [
    //             [
    //                 'name' => 'Automotive',
    //                 'children' => [
    //                     [
    //                         'name' => 'Auto Tools & Equipment',
    //                     ],
    //                     [
    //                         'name' => 'Auto Parts & Spares',
    //                     ],
    //                     [
    //                         'name' => 'GPS',
    //                     ],
    //                     [
    //                         'name' => 'Consoles & Organizers',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Motorcycles',
    //                 'children' => [
    //                     [
    //                         'name' => 'Standard Bikes',
    //                     ],
    //                     [
    //                         'name' => 'Scooters',
    //                     ],
    //                     [
    //                         'name' => 'Electric Bikes',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Auto Care',
    //                 'children' => [
    //                     [
    //                         'name' => 'Polishes & Waxes',
    //                     ],
    //                     [
    //                         'name' => 'Floor Mats & Cargo Liners',
    //                     ],
    //                     [
    //                         'name' => 'Air Fresheners',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Auto Electronics',
    //                 'children' => [
    //                     [
    //                         'name' => 'Car Video',
    //                     ],
    //                     [
    //                         'name' => 'Car Stereo Receivers',
    //                     ],
    //                     [
    //                         'name' => 'In-Dash DVD & Video',
    //                     ],
    //                     [
    //                         'name' => 'Speakers',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Moto Parts & Accessories',
    //                 'children' => [
    //                     [
    //                         'name' => 'Drivetrain & Transmission',
    //                     ],
    //                     [
    //                         'name' => 'Tires & Wheels',
    //                     ],
    //                     [
    //                         'name' => 'Moto Covers',
    //                     ],
    //                     [
    //                         'name' => 'Parts & Spares',
    //                     ],
    //                 ],
    //             ],
    //             [
    //                 'name' => 'Motorcycle Riding Gear',
    //                 'children' => [
    //                     [
    //                         'name' => 'Eyewear',
    //                     ],
    //                     [
    //                         'name' => 'Face Masks',
    //                     ],
    //                     [
    //                         'name' => 'Helmets',
    //                     ],
    //                     [
    //                         'name' => 'Gloves',
    //                     ],
    //                 ],
    //             ],

    //             [
    //                 'name' => 'Helmet',
    //             ],
    //             [
    //                 'name' => 'Gloves',
    //             ],
    //             [
    //                 'name' => 'Interior Accessories',
    //             ],
    //             [
    //                 'name' => 'Auto Oils & Fluids',
    //             ],
    //             [
    //                 'name' => 'Auto Tires & Wheels',
    //             ],
    //             [
    //                 'name' => 'Lubricants',
    //             ]

    //         ]
    //     ];
    // }
}
