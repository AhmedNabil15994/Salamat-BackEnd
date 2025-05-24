<?php

return [
    'services'  => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'image'         => 'العنوان',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'form'      => [
            'categories'        => 'نوع الخدمة',
            'clinics'           => 'العيادة',
            'description'       => 'الوصف',
            'doctors'           => 'الدكاترة',
            'hidden'            => 'مخفي من التطبيق',
            'ignore_doctor'     => 'حظر وقت الدكتور',
            'image'             => 'الصورة',
            'is_consultation'   => 'استشارة اولا',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'operators'         => 'مشغلين / مساعدين العياده لهذه الخدمة',
            'point_amount'      => 'نقطة واحده / لكل قيمة ( KWD)',
            'points_per_amount' => 'دينار لمجموعة نقاط',
            'price'             => 'السعر',
            'rooms'             => 'غرف العياده لهذه الخدمة',
            'status'            => 'الحالة',
            'tabs'              => [
                'details'   => 'التفاصيل',
                'general'   => 'بيانات عامة',
                'seo'       => 'SEO',
            ],
            'time_to_take'      => 'تستغرق الخدمه وقت +٣٠',
            'title'             => 'عنوان الخدمه',
        ],
        'routes'    => [
            'create'    => 'اضافة الخدمات',
            'index'     => 'الخدمات',
            'update'    => 'تعديل الخدمه',
        ],
        'validation'=> [
            'description'   => [
                'required'  => 'من فضلك ادخل الوصف',
            ],
            'title'         => [
                'required'  => 'من فضلك ادخل عنوان الخدمه',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
];
