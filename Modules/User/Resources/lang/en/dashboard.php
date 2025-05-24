<?php

return [
    'admins'    => [
        'create'    => [
            'form'  => [
                'confirm_password'  => 'Confirm Password',
                'email'             => 'Email',
                'general'           => 'General Info.',
                'image'             => 'Profile Image',
                'info'              => 'Info.',
                'mobile'            => 'Mobile',
                'name'              => 'Name',
                'password'          => 'Password',
                'roles'             => 'Roles',
            ],
            'title' => 'Create Admins',
        ],
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'email'         => 'Email',
            'image'         => 'Image',
            'mobile'        => 'Mobile',
            'name'          => 'Name',
            'options'       => 'Options',
        ],
        'index'     => [
            'title' => 'Admins',
        ],
        'update'    => [
            'form'  => [
                'confirm_password'  => 'Confirm Password',
                'email'             => 'Email',
                'general'           => 'General info.',
                'image'             => 'Profile Image',
                'mobile'            => 'Mobile',
                'name'              => 'Name',
                'password'          => 'Change Password',
                'roles'             => 'Roles',
            ],
            'title' => 'Update Admins',
        ],
        'validation'=> [
            'email'     => [
                'required'  => 'Please enter the email of admin',
                'unique'    => 'This email is taken before',
            ],
            'mobile'    => [
                'digits_between'    => 'Please add mobile number only 8 digits',
                'numeric'           => 'Please enter the mobile only numbers',
                'required'          => 'Please enter the mobile of admin',
                'unique'            => 'This mobile is taken before',
            ],
            'name'      => [
                'required'  => 'Please enter the name of admin',
            ],
            'password'  => [
                'min'       => 'Password must be more than 6 characters',
                'required'  => 'Please enter the password of admin',
                'same'      => 'The Password confirmation not matching',
            ],
            'roles'     => [
                'required'  => 'Please select the role of admin',
            ],
        ],
    ],
    'users'     => [
        'create'    => [
            'form'  => [
                'confirm_password'  => 'Confirm Password',
                'email'             => 'Email',
                'general'           => 'General Info.',
                'image'             => 'Profile Image',
                'info'              => 'Info.',
                'mobile'            => 'Mobile',
                'name'              => 'Name',
                'password'          => 'Password',
            ],
            'title' => 'Create Patients',
        ],
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'email'         => 'Email',
            'image'         => 'Image',
            'mobile'        => 'Mobile',
            'name'          => 'Name',
            'options'       => 'Options',
        ],
        'index'     => [
            'title' => 'Patients',
        ],
        'update'    => [
            'form'  => [
                'confirm_password'  => 'Confirm Password',
                'email'             => 'Email',
                'general'           => 'General info.',
                'image'             => 'Profile Image',
                'mobile'            => 'Mobile',
                'name'              => 'Name',
                'password'          => 'Change Password',
            ],
            'title' => 'Update Patient',
        ],
        'validation'=> [
            'email'     => [
                'required'  => 'Please enter the email of Patients',
                'unique'    => 'This email is taken before',
            ],
            'mobile'    => [
                'digits_between'    => 'Please add mobile number only 8 digits',
                'numeric'           => 'Please enter the mobile only numbers',
                'required'          => 'Please enter the mobile of Patients',
                'unique'            => 'This mobile is taken before',
            ],
            'name'      => [
                'required'  => 'Please enter the name of Patients',
            ],
            'password'  => [
                'min'       => 'Password must be more than 6 characters',
                'required'  => 'Please enter the password of Patients',
                'same'      => 'The Password confirmation not matching',
            ],
        ],
    ],
];
