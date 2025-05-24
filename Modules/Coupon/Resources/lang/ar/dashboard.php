<?php

return [
    'coupons'   => [
        'datatable' => [
            'code'          => 'الكود',
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'discount'      => 'الخصم ٪',
            'from'          => 'من',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'to'            => 'الى',
        ],
        'form'      => [
            'code'          => 'كود الكوبون',
            'discount'      => 'الخصم ٪',
            'doctor'        => 'الدكتور',
            'from'          => 'من',
            'services'      => 'الخدمات',
            'status'        => 'الحالة',
            'tabs'          => [
                'general'   => 'المحتوى',
            ],
            'to'            => 'الى',
            'used_times'    => 'عدد مرات الاستخدام للمريض الواحد',
            'users'         => 'المرضى',
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
