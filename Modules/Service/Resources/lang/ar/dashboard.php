<?php

return [
    'services'  => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'description'   => 'الوصف',
            'image'         => 'العنوان',
            'options'       => 'الخيارات',
            'price'         => 'السعر',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'form'      => [
            'categories'        => 'نوع الخدمة',
            'clinics'           => 'العيادة',
            'description'       => 'الوصف',
            'doctors'           => 'الدكاترة',
            'hidden'            => 'مخفي من التطبيق',
            'ignore_doctor'     => 'حظر توقيت الدكتور',
            'image'             => 'الصورة',
            'is_consultation'   => 'استشارة اولا',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'operators'         => 'مشغلين / مساعدين العياده لهذه الخدمة',
            'point_amount'      => 'نقطة واحده / لكل قيمة (KWD)',
            'points_per_amount' => 'دينار لمجموع النقاط',
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
            'clinic_category_id'    => [
                'required'  => 'من فضلك اختر نوع الخدمة',
            ],
            'clinic_id'             => [
                'required'  => 'من فضلك اختر العيادة',
            ],
            'description'           => [
                'required'  => 'من فضلك ادخل الوصف',
            ],
            'doctor_id'             => [
                'required'  => 'من فضلك اختر الدكتور',
            ],
            'point_amount'          => [
                'lte'       => 'المبلغ المتاح لاعطاء نقطة واحده يجب ان يقل عن سعر الخدمة الاصلي او يساويه',
                'numeric'   => 'من فضلك ادخل المبلغ لاعطاء نقطة واحده بشكل صحيح',
            ],
            'points_per_amount'     => [
                'numeric'       => 'من فضلك ادخل النقاط المتاحة لخصم دينار ارقام فقط',
                'required_with' => 'من فضلك ادخل النقاط المتاحة لخصم دينار',
            ],
            'price'                 => [
                'numeric'   => 'من فضلك ادخل السعر بشكل صحيح',
                'required'  => 'من فضلك ادخل السعر للخدمة',
            ],
            'time_to_take'          => [
                'date_format'   => 'من فضلك اختر الوقت بشكل صحيح',
                'required'      => 'من فضلك اختر وقت استغراق الخدمة',
            ],
            'title'                 => [
                'required'  => 'من فضلك ادخل عنوان الخدمه',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
];
