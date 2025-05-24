<?php

return [
    'coupons'   => [
        'datatable' => [
            'code'          => 'الكود',
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'discount'      => 'الخصم ٪',
            'from'          => 'من',
            'image'         => 'العنوان',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
            'to'            => 'الى',
        ],
        'form'      => [
            'clinics'           => 'العيادة',
            'code'              => 'كود الكوبون',
            'description'       => 'الوصف',
            'discount'          => 'الخصم ٪',
            'doctor'            => 'الدكتور',
            'doctors'           => 'الدكتور',
            'from'              => 'من',
            'hidden'            => 'عدم الاظهار ف التطبيق',
            'image'             => 'الصورة',
            'is_consultation'   => 'Consultation first',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'price'             => 'Price',
            'services'          => 'الخدمات',
            'status'            => 'الحالة',
            'tabs'              => [
                'general'   => 'بيانات عامة',
                'seo'       => 'SEO',
            ],
            'title'             => 'عنوان القسم',
            'to'                => 'الى',
            'used_times'        => 'عدد مرات الاستخدام للمريض الواحد',
            'users'             => 'المرضى',
        ],
        'routes'    => [
            'create'    => 'اضافة الاقسام',
            'index'     => 'الاقسام',
            'update'    => 'تعديل القسم',
        ],
        'validation'=> [
            'title' => [
                'required'  => 'من فضلك ادخل عنوان القسم',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
];
