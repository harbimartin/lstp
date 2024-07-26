<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class Some of these rules have multiple versions such
    | as the size rules Feel free to tweak each of these messages here
    |
    */

    'accepted' => ':attribute harus diterima',
    'active_url' => ':attribute bukan URL yang valid',
    'after' => ':attribute harus setelah :date',
    'after_or_equal' => ':attribute harus setelah atau sama dengan :date',
    'alpha' => ':attribute hanya boleh berisi huruf',
    'alpha_dash' => ':attribute hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah',
    'alpha_num' => ':attribute hanya boleh berisi huruf dan angka',
    'array' => ':attribute harus berupa array',
    'before' => ':attribute harus sebelum :date',
    'before_or_equal' => ':attribute harus sebelum atau sama dengan hari ini',
    'between' => [
        'numeric' => ':attribute harus antara :min dan :max',
        'file' => ':attribute harus antara :min dan :max kilobytes',
        'string' => ':attribute harus antara :min dan :max karakter',
        'array' => ':attribute harus memiliki antara :min dan :max item',
    ],
    'boolean' => 'Masukan :attribute harus benar atau salah',
    'confirmed' => 'Konfirmasi :attribute tidak cocok',
    'date' => ':attribute bukan tanggal yang valid',
    'date_equals' => ':attribute harus berupa tanggal yang sama dengan :date',
    'date_format' => ':attribute tidak cocok dengan format :format',
    'different' => ':attribute dan :other harus berbeda',
    'digits' => ':attributenya harus :digits digits',
    'digits_between' => ':attribute harus antara :min dan :max digits',
    'dimensions' => ':attribute memiliki dimensi gambar yang tidak valid',
    'distinct' => 'Masukan :attribute memiliki nilai duplikat',
    'email' => ':attribute harus berupa alamat email yang valid',
    'ends_with' => ':attribute harus diakhiri dengan salah satu dari berikut ini: :values',
    'exists' => ':attribute yang dipilih tidak valid',
    'file' => ':attribute harus berupa file',
    'filled' => 'Masukan :attribute harus memiliki nilai',
    'gt' => [
        'numeric' => ':attribute harus lebih besar dari :value',
        'file' => ':attribute harus lebih besar dari :value kilobytes',
        'string' => ':attribute harus lebih besar dari :nilai karakter',
        'array' => ':attribute harus memiliki lebih dari :nilai item',
    ],
    'gte' => [
        'numeric' => ':attribute harus lebih besar dari atau sama dengan :value',
        'file' => ':attribute harus lebih besar atau sama dengan :value kilobytes',
        'string' => ':attribute harus lebih besar dari atau sama dengan :nilai karakter',
        'array' => ':attribute harus memiliki :nilai item atau lebih',
    ],
    'image' => ':attribute harus berupa gambar',
    'in' => ':attribute yang dipilih tidak valid',
    'in_array' => 'Masukan :attribute tidak ada di :other',
    'integer' => ':attribute harus berupa bilangan bulat',
    'ip' => ':attribute harus berupa alamat IP yang valid',
    'ipv4' => ':attribute harus berupa alamat IPv4 yang valid',
    'ipv6' => ':attribute harus berupa alamat IPv6 yang valid',
    'json' => ':attribute harus berupa string JSON yang valid',
    'lt' => [
        'numeric' => ':attribute harus lebih kecil dari :value',
        'file' => ':attribute harus kurang dari :value kilobytes',
        'string' => ':attribute harus kurang dari :nilai karakter',
        'array' => ':attribute harus memiliki kurang dari :nilai item',
    ],
    'lte' => [
        'numeric' => ':attribute harus kurang dari atau sama dengan :value',
        'file' => ':attribute harus kurang dari atau sama dengan :value kilobytes',
        'string' => ':attribute harus kurang dari atau sama dengan :nilai karakter',
        'array' => ':attribute tidak boleh memiliki lebih dari :nilai item',
    ],
    'maks' => [
        'numeric' => ':attribute tidak boleh lebih besar dari :max',
        'file' => ':attribute tidak boleh lebih besar dari :max kilobytes',
        'string' => ':attribute tidak boleh lebih besar dari :maks karakter',
        'array' => ':attribute tidak boleh memiliki lebih dari :max item',
    ],
    'mimes' => ':attribute harus berupa file dengan tipe: :values',
    'mimetypes' => ':attribute harus berupa file dengan tipe: :values',
    'min' => [
        'numeric' => ':attribute minimal harus :min',
        'file' => ':attribute minimal harus : min kilobytes',
        'string' => ':attribute harus minimal : karakter min',
        'array' => ':attribute harus memiliki minimal :min item',
    ],
    'not_in' => ':attribute yang dipilih tidak valid',
    'not_regex' => 'Format :attribute tidak valid',
    'numeric' => ':attribute harus berupa angka',
    'password' => 'Password salah',
    'present' => 'Masukan :attribute harus ada',
    'regex' => 'Format :attribute tidak valid',
    'required' => 'Masukan :attribute wajib diisi',
    'required_if' => 'Masukan :attribute wajib diisi bila :lainnya adalah :nilai',
    'required_unless' => 'Masukan :attribute wajib diisi kecuali :other ada di :values',
    'required_with' => 'Masukan :attribute wajib diisi jika :nilai ada',
    'required_with_all' => 'Masukan :attribute wajib diisi jika :nilai ada',
    'required_without' => 'Masukan :attribute wajib diisi jika :values ​​tidak ada',
    'required_without_all' => 'Masukan :attribute diperlukan bila tidak ada :nilai yang ada',
    'same' => ':attribute dan :other harus cocok',
    'size' => [
        'numeric' => ':attribute harus :values',
        'file' => ':attribute harus :values kilobyte',
        'string' => ':attribute harus :values karakter',
        'array' => ':attribute harus berisi :values item',
    ],
    'starts_with' => ':attribute harus dimulai dengan salah satu dari berikut ini: :values',
    'string' => ':attribute harus berupa string',
    'timezone' => ':attribute harus berupa zona yang valid',
    'unik' => ':attribute sudah diambil',
    'uploaded' => ':attribute gagal diunggah',
    'url' => 'Format :attribute tidak valid',
    'uuid' => ':attribute harus berupa UUID yang valid',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attributerule" to name the lines This makes it quick to
    | specify a specific custom language line for a given attribute rule
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email" This simply helps us make our message more expressive
    |
    */

    'attributes' => [
        'budget_date' => 'MRA Date',
        'document_type' => 'MRA Document',
        'note_header' => 'Header Text',
        'qty_proposed' => 'Quantity',
        'currency' => 'Currency',
        'vendor_name' => 'Vendor Name',
        'po_date' => 'PO Date',
        'po_amount' => 'PO Amount',
        'budget_version_code' => 'Name',
        'budget_name' => 'Deskripsi Budget',
        'budget' => 'Amount Budget',
        'version_type' => 'Tipe',
        'budget_period' => 'Tahun',
        'budget_period_desc' => 'Deskripsi',
        'io_code' => 'Code',
        'io_date' => 'Date',
        'material' => 'Kode',
        'material_type'=>'Tipe',
        'material_desc'=>'Desc'
    ],

];
