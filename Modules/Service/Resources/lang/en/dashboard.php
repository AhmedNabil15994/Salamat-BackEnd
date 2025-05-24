<?php

return [
    'services'  => [
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'description'   => 'Description',
            'image'         => 'Image',
            'options'       => 'Options',
            'price'         => 'Price',
            'status'        => 'Status',
            'title'         => 'Title',
        ],
        'form'      => [
            'categories'        => 'Service Type',
            'clinics'           => 'Clinic',
            'description'       => 'Description',
            'doctors'           => 'Doctors',
            'hidden'            => 'Hidden from app',
            'ignore_doctor'     => 'Ignore doctor timing',
            'image'             => 'Image',
            'is_consultation'   => 'Consultation first',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'operators'         => 'Operators for this service',
            'point_amount'      => 'Amount will give 1 point',
            'points_per_amount' => 'This points for every 1 KWD',
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
            'clinic_category_id'    => [
                'required'  => 'Please select type of service',
            ],
            'clinic_id'             => [
                'required'  => 'Please select the clinic',
            ],
            'description'           => [
                'required'  => 'Please enter the description',
            ],
            'doctor_id'             => [
                'required'  => 'Please select the doctor',
            ],
            'point_amount'          => [
                'lte'       => 'Amount will give points should be less than the price of service',
                'numeric'   => 'Amount will give points should be price format',
            ],
            'points_per_amount'     => [
                'numeric'       => 'Buy with points should be numeric',
                'required_with' => 'Buy with points required',
            ],
            'price'                 => [
                'numeric'   => 'Please enter the right format of the price ( 4.000 )',
                'required'  => 'Please insert the price',
            ],
            'time_to_take'          => [
                'date_format'   => 'Please insert the correct format of the take service time ( 0:30 , 1:00 , 1:30 , etc. )',
                'required'      => 'Please insert the service take time',
            ],
            'title'                 => [
                'required'  => 'Please enter the title of service',
                'unique'    => 'This title service is taken before',
            ],
        ],
    ],
];
