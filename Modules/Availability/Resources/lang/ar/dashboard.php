<?php

return [
    'availability'  => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'form'      => [
            'description'       => 'الوصف',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'status'            => 'الحالة',
            'tabs'              => [
                'general'   => 'بيانات عامة',
                'seo'       => 'SEO',
            ],
            'title'             => 'عنوان',
        ],
        'routes'    => [
            'create'    => 'اضافة الاقسام',
            'index'     => 'الاقسام',
            'update'    => 'تعديل الاقسام',
        ],
        'validation'=> [
            'description'   => [
                'required'  => 'من فضلك ادخل وصف الاقسام',
            ],
            'title'         => [
                'required'  => 'من فضلك ادخل عنوان الاقسام',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
];
