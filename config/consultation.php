<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Pengaturan untuk Fitur Konsultasi
    |--------------------------------------------------------------------------
    |
    | Di sini kita menyimpan semua informasi yang berkaitan dengan
    | fitur konsultasi via WhatsApp.
    |
    */

    'trainer_name' => 'Ler',

    // PENTING: Gunakan format internasional tanpa '+', spasi, atau '-'.
    'whatsapp_number' => '6281223800070', 

    // Template pesan. {user_name} akan kita ganti dengan nama user secara dinamis.
    'message_template' => 'Halo Kak {trainer_name}, saya {user_name} dari aplikasi Fitnest. Saya ingin bertanya seputar program latihan saya.',
];