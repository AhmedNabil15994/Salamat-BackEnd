<?php

return [
    'clinics'   => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'image'         => 'العنوان',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'form'      => [
            'address'               => 'العنوان',
            'address_details'       => 'بيانات اضافية',
            'another_phone_number'  => 'رقم اخر',
            'availability'          => 'مواعيد العمل',
            'availability_date'     => 'التاريخ',
            'availability_from'     => 'من',
            'availability_off'      => 'عطلة',
            'availability_to'       => 'الى',
            'block'                 => 'القطعة',
            'blogs_limit'           => 'العدد المسموح للمقالات',
            'building'              => 'المبنى',
            'categories'            => 'قسم العيادة',
            'close_time'            => 'وقت الاغلاق',
            'contact_number'        => 'رقم للتواصل',
            'contacts'              => 'ارقام التواصل',
            'custom_off'            => 'اجازات خاصة',
            'dates'                 => 'اجازات بالتواريخ',
            'days'                  => 'ايام الراحة',
            'description'           => 'الوصف',
            'open_time_message'     => 'رسالة مواقيت العمل',
            'doctors'               => 'الدكاترة',
            'exception'             => 'مواعيد غير متاحة',
            'facebook'              => 'facebook',
            'gallery'               => 'معرض الصور',
            'hidden'                => 'مخفي من التطبيق',
            'image'                 => 'الصورة',
            'instagram'             => 'instagram',
            'is_busy'               => 'مشغول',
            'is_consultation'       => 'استشارة اولا',
            'lang'                  => 'Langtude',
            'lat'                   => 'Latitude',
            'linkedin'              => 'linkedin',
            'meta_description'      => 'Meta Description',
            'meta_keywords'         => 'Meta Keywords',
            'open_time'             => 'وقت البدء',
            'opening'               => 'اوقت البدء /  وقت الاغلاق',
            'operators'             => 'المشغلين',
            'phone_number'          => 'رقم الهاتف',
            'price'                 => 'السعر',
            'rooms'                 => 'الغرف',
            'social_media'          => 'التواصل الاجتماعي',
            'staff'                 => 'الطاقم',
            'state'                 => 'المحافظة / المنطقة',
            'status'                => 'الحالة',
            'street'                => 'الشارع',
            'tabs'                  => [
                'general'   => 'بيانات عامة',
                'seo'       => 'SEO',
            ],
            'times'                 => 'الراحات اليومية',
            'title'                 => 'عنوان العيادة',
            'twitter'               => 'twitter',
            'youtube'               => 'youtube',
        ],
        'routes'    => [
            'create'    => 'اضافة العيادات',
            'index'     => 'العيادات',
            'sorting'   => 'ترتيب',
            'update'    => 'تعديل العيادة',
        ],
        'validation' => [
            'blogs_limit'   => [
                'nemric'    => 'عدد المقالات المتاحة للعيادة ارقام فقط',
                'numeric'   => 'عدد المقالات المتاحة للعيادة ارقام فقط',
                'required'  => 'من فضلك ادخل عدد المقالات المتاحة لهذه العيادة',
            ],
            'close_time'    => [
                'after'     => 'يجب وقت الانتهاء ان يكون بعد وقت البدء - [ 12:00 AM to 12:59 PM ]',
                'required'  => 'من فضلك اختر وقت انتهاء الدوام',
                'time'      => 'من فضلك قم ب ادخال وقت صحيح ل انتهاء الدوام',
            ],
            'description'   => [
                'required'  => 'من فضلك ادخل الوصف',
            ],
            'open_time'     => [
                'required'  => 'من فضلك اختر وقت بدء الدوام',
                'time'      => 'من فضلك قم ب ادخال وقت صحيح ل بدء الدوام',
            ],
            'state_id'      => [
                'required'  => 'من فضلك اختر المنطقة للعنوان',
            ],
            'title'         => [
                'required'  => 'من فضلك ادخل عنوان العيادة',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
];
