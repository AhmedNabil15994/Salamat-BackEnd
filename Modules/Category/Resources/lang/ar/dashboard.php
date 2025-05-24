<?php

return [
    'categories'    => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'image'         => 'العنوان',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'form'      => [
            'clinics'           => 'العيادة',
            'description'       => 'الوصف',
            'doctors'           => 'الدكتور',
            'hidden'            => 'عدم الاظهار ف التطبيق',
            'image'             => 'الصورة',
            'is_consultation'   => 'Consultation first',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'price'             => 'Price',
            'status'            => 'الحالة',
            'tabs'              => [
                'general'   => 'بيانات عامة',
                'seo'       => 'SEO',
            ],
            'title'             => 'عنوان نوع الخدمة',
        ],
        'routes'    => [
            'create'    => 'اضافة انواع الخدمات',
            'index'     => 'انواع الخدمات',
            'sorting'   => 'الترتيب',
            'update'    => 'تعديل نوع الخدمة',
        ],
        'validation'=> [
            'clinic_id' => [
                'required'  => 'من فضلك اختر عيادة',
            ],
            'title'     => [
                'required'  => 'من فضلك ادخل عنوان نوع الخدمة',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
];
