<?php

return [
    'services'  => [
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'image'         => 'Image',
            'options'       => 'Options',
            'status'        => 'Status',
            'title'         => 'Title',
        ],
        'form'      => [
            'categories'        => 'Sevice type',
            'clinics'           => 'Clinic',
            'description'       => 'Description',
            'doctors'           => 'Doctors',
            'hidden'            => 'Hidden from app',
            'ignore_doctor'     => 'Ignore time doctor',
            'image'             => 'Image',
            'is_consultation'   => 'Consultation first',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'operators'         => 'Operators for this service',
            'point_amount'      => '1 Point / KWD',
            'points_per_amount' => '1 KWD for points',
            'price'             => 'Price',
            'rooms'             => 'Rooms for this service',
            'status'            => 'Status',
            'tabs'              => [
                'details'   => 'Details',
                'general'   => 'General Info.',
                'seo'       => 'SEO',
            ],
            'time_to_take'      => 'Service take time / +30 min',
            'title'             => 'Title',
        ],
        'routes'    => [
            'create'    => 'Create Services',
            'index'     => 'Services',
            'update'    => 'Update Service',
        ],
        'validation'=> [
            'description'   => [
                'required'  => 'Please enter the description',
            ],
            'title'         => [
                'required'  => 'Please enter the title of service',
                'unique'    => 'This title service is taken before',
            ],
        ],
    ],
];
