<?php

return [
    'specialties' => [
        'form'  => [
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'status'            => 'الحالة',
            'image'             => 'الصورة',
            'title'             => 'عنوان التخصصص',
            'tabs'  => [
              'general'   => 'بيانات عامة',
              'seo'               => 'SEO',
            ],
        ],
        'routes'    => [
          'create'  => 'اضافة التخصصات',
          'index'   => 'التخصصات',
          'update'  => 'تعديل التخصصص',
        ],
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
            'image'         => 'العنوان',
        ],
        'validation'=> [
            'title'         => [
                'required'  => 'من فضلك ادخل عنوان التخصصص',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
];
