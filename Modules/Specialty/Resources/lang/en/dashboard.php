<?php

return [
    'specialties' => [
      'form'  => [
          'meta_description'  => 'Meta Description',
          'meta_keywords'     => 'Meta Keywords',
          'status'            => 'Status',
          'title'             => 'Title',
          'image'             => 'Image',
          'tabs'  => [
            'general'           => 'General Info.',
            'seo'               => 'SEO',
          ]
      ],
      'datatable' => [
          'created_at'    => 'Created At',
          'date_range'    => 'Search By Dates',
          'options'       => 'Options',
          'status'        => 'Status',
          'title'         => 'Title',
          'image'         => 'Image',
      ],
      'routes'     => [
          'create' => 'Create Specialties',
          'index' => 'Specialties',
          'update' => 'Update Specialty',
      ],
      'validation'=> [
          'title'         => [
              'required'  => 'Please enter the title of specialty',
              'unique'    => 'This title specialty is taken before',
          ],
      ],
    ],
];
