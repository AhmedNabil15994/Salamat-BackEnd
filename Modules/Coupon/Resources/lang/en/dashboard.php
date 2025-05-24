<?php

return [
    'coupons'   => [
        'datatable' => [
            'code'          => 'Code',
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'discount'      => 'Discount %',
            'from'          => 'From',
            'options'       => 'Options',
            'status'        => 'Status',
            'to'            => 'To',
        ],
        'form'      => [
            'code'          => 'Coupon code',
            'discount'      => 'Discount %',
            'doctor'        => 'Doctor',
            'from'          => 'From',
            'services'      => 'Services',
            'status'        => 'Status',
            'tabs'          => [
                'general'   => 'General info.',
            ],
            'to'            => 'To',
            'used_times'    => 'Usage time for one patient',
            'users'         => 'patients',
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
