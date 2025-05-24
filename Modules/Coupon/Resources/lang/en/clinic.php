<?php

return [
    'coupons'   => [
        'datatable' => [
            'code'          => 'Code',
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'discount'      => 'Discount %',
            'from'          => 'From',
            'image'         => 'Image',
            'options'       => 'Options',
            'status'        => 'Status',
            'title'         => 'Title',
            'to'            => 'To',
        ],
        'form'      => [
            'clinics'           => 'Clinic',
            'code'              => 'Coupon code',
            'description'       => 'Description',
            'discount'          => 'Discount %',
            'doctor'            => 'Doctor',
            'doctors'           => 'Doctor',
            'from'              => 'From',
            'hidden'            => 'Hidden From App',
            'image'             => 'Image',
            'is_consultation'   => 'Consultation first',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'price'             => 'Price',
            'services'          => 'Services',
            'status'            => 'Status',
            'tabs'              => [
                'general'   => 'General Info.',
                'seo'       => 'SEO',
            ],
            'title'             => 'Title',
            'to'                => 'To',
            'used_times'        => 'Usage time for one patient',
            'users'             => 'patients',
        ],
        'routes'    => [
            'create'    => 'Create Services Coupons',
            'index'     => 'Services Coupons',
            'update'    => 'Update Services Coupons',
        ],
        'validation'=> [
            'title' => [
                'required'  => 'Please enter the title of coupon',
                'unique'    => 'This title coupon is taken before',
            ],
        ],
    ],
];
