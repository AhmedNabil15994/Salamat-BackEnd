<?php

return [
    'blogs'     => [
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'image'         => 'Image',
            'options'       => 'Options',
            'status'        => 'Status',
            'title'         => 'Title',
        ],
        'form'      => [
            'clinic'            => 'Clinic',
            'description'       => 'Description',
            'doctors'           => 'Doctor',
            'image'             => 'Image',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'status'            => 'Status',
            'tabs'              => [
                'general'   => 'General Info.',
                'seo'       => 'SEO',
            ],
            'title'             => 'Title',
            'type'              => 'Blog Type',
        ],
        'routes'    => [
            'create'    => 'Create Blogs',
            'index'     => 'Blogs',
            'update'    => 'Update Blog',
        ],
        'validation'=> [
            'clinic_id'     => [
                'required'  => 'Please select clinic',
            ],
            'description'   => [
                'required'  => 'Please enter the description',
            ],
            'doctor_id'     => [
                'required'  => 'Please select doctor',
            ],
            'title'         => [
                'required'  => 'Please enter the title of blog',
                'unique'    => 'This title blog is taken before',
            ],
            'type_'         => [
                'required'  => 'Please select blog type',
            ],
        ],
    ],
    'messages'  => [
        'reached_limitation'    => 'You are reached the limitation of blogs number',
    ],
];
