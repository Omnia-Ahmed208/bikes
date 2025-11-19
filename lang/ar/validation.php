<?php

return [
    'attributes' => [
        'email' => 'البريد الإلكتروني',
        'password' => 'كلمة المرور',
        'phone' => 'الهاتف',
        'img' => 'الصورة',
        'name' => 'الاسم',
        'logo' => 'اللوجو',
        'icon' => 'الأيقون',
        'another_phone' => 'الهاتف',
        'address' => 'العنوان',
    ],

    'required' => 'حقل :attribute مطلوب.',
    'string' => 'يجب أن يكون :attribute نصًا.',
    'url' => 'يجب أن يكون :attribute رابطًا (URL) صالحًا.',
    'image' => 'يجب أن يكون :attribute صورة بصيغة صحيحة.',
    'file' => 'يجب أن يكون :attribute ملفًا.',
    'email' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صالح.',
    'min' => [
        'string' => 'يجب أن يكون :attribute على الأقل :min أحرف.',
    ],
    'max' => [
        'string' => 'يجب ألا يزيد :attribute عن :max أحرف.',
    ],
    'unique' => ':attribute مستخدم بالفعل.',
    'confirmed' => 'تأكيد :attribute غير متطابق.',
];
