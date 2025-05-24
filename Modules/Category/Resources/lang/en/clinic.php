<?php

return [
    'categories'    => [
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'image'         => 'Image',
            'options'       => 'Options',
            'status'        => 'Status',
            'title'         => 'Title',
        ],
        'form'      => [
            'clinics'           => 'Clinic',
            'description'       => 'Description',
            'doctors'           => 'Doctor',
            'hidden'            => 'Hidden From App',
            'image'             => 'Image',
            'is_consultation'   => 'Consultation first',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'price'             => 'Price',
            'status'            => 'Status',
            'tabs'              => [
                'general'   => 'General Info.',
                'seo'       => 'SEO',
            ],
            'title'             => 'Title',
        ],
        'routes'    => [
            'create'    => 'Create Services Type',
            'index'     => 'Services Type',
            'sorting'   => 'Sorting',
            'update'    => 'Update Services Type',
        ],
        'validation'=> [
            'title' => [
                'required'  => 'Please enter the title of service type',
                'unique'    => 'This title service type is taken before',
            ],
        ],
    ],
];
