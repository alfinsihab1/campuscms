<?php

use Illuminate\Database\Seeder;
use Ajifatur\FaturCMS\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            // General
            ['key' => 'site.name', 'name' => 'Nama Website', 'category' => kategori_setting('general'), 'rules' => 'required'],
            ['key' => 'site.tagline', 'name' => 'Tagline', 'category' => kategori_setting('general'), 'rules' => ''],
            ['key' => 'site.description', 'name' => 'Deskripsi', 'category' => kategori_setting('general'), 'rules' => ''],
            ['key' => 'site.keywords', 'name' => 'Kata Kunci', 'category' => kategori_setting('general'), 'rules' => ''],
            ['key' => 'site.address', 'name' => 'Alamat Lengkap', 'category' => kategori_setting('general'), 'rules' => 'required'],
            ['key' => 'site.city', 'name' => 'Kota', 'category' => kategori_setting('general'), 'rules' => 'required'],
            ['key' => 'site.email', 'name' => 'Email', 'category' => kategori_setting('general'), 'rules' => 'required'],
            ['key' => 'site.phone_number', 'name' => 'Nomor Telepon', 'category' => kategori_setting('general'), 'rules' => 'required'],
            ['key' => 'site.whatsapp', 'name' => 'Nomor WhatsApp', 'category' => kategori_setting('general'), 'rules' => 'required'],
            ['key' => 'site.medsos.instagram', 'name' => 'Akun Instagram', 'category' => kategori_setting('general'), 'rules' => ''],
            ['key' => 'site.medsos.facebook', 'name' => 'Akun Facebook', 'category' => kategori_setting('general'), 'rules' => ''],
            ['key' => 'site.medsos.twitter', 'name' => 'Akun Twitter', 'category' => kategori_setting('general'), 'rules' => ''],
            ['key' => 'site.google_analytics', 'name' => 'Kode Google Analytics', 'category' => kategori_setting('general'), 'rules' => ''],

            // Color
            ['key' => 'site.color.primary', 'name' => 'Warna Primer', 'category' => kategori_setting('color'), 'rules' => 'required'],
            ['key' => 'site.color.secondary', 'name' => 'Warna Sekunder', 'category' => kategori_setting('color'), 'rules' => 'required'],

            // Price
            ['key' => 'site.komisi_student', 'name' => 'Komisi (Student)', 'category' => kategori_setting('price'), 'rules' => 'required'],
            ['key' => 'site.komisi_trainer', 'name' => 'Komisi (Trainer)', 'category' => kategori_setting('price'), 'rules' => 'required'],
            ['key' => 'site.biaya_aktivasi', 'name' => 'Biaya Aktivasi', 'category' => kategori_setting('price'), 'rules' => 'required'],
            ['key' => 'site.harga_dicoret', 'name' => 'Harga Dicoret', 'category' => kategori_setting('price'), 'rules' => 'required'],
            ['key' => 'site.min_withdrawal', 'name' => 'Minimal Penarikan / Withdrawal', 'category' => kategori_setting('price'), 'rules' => 'required'],

            // Certificate
            ['key' => 'site.sertifikat.kode', 'name' => 'Kode Untuk Sertifikat', 'category' => kategori_setting('certificate'), 'rules' => 'required|alpha_dash'],
            ['key' => 'site.sertifikat.background_color', 'name' => 'Warna Background Sertifikat', 'category' => kategori_setting('certificate'), 'rules' => 'required'],

            // Receivers
            ['key' => 'site.receivers', 'name' => 'Penerima Notifikasi', 'category' => kategori_setting('receivers'), 'rules' => 'required'],

            // View
            ['key' => 'site.view.login', 'name' => 'View Login', 'category' => kategori_setting('view'), 'rules' => 'required'],
            ['key' => 'site.view.register', 'name' => 'View Register', 'category' => kategori_setting('view'), 'rules' => 'required'],
            ['key' => 'site.view.forgot_password', 'name' => 'View Forgot Password', 'category' => kategori_setting('view'), 'rules' => 'required'],
            ['key' => 'site.view.email_verification', 'name' => 'View Email Verification', 'category' => kategori_setting('view'), 'rules' => 'required'],
            ['key' => 'site.view.sertifikat_trainer', 'name' => 'View Sertifikat Trainer', 'category' => kategori_setting('view'), 'rules' => 'required'],
            ['key' => 'site.view.sertifikat_peserta', 'name' => 'View Sertifikat Peserta', 'category' => kategori_setting('view'), 'rules' => 'required'],

            // Logo
            ['key' => 'site.logo', 'name' => 'Logo', 'category' => kategori_setting('logo'), 'rules' => ''],

            // Icon
            ['key' => 'site.icon', 'name' => 'Icon', 'category' => kategori_setting('icon'), 'rules' => ''],

            // Referral
            ['key' => 'site.referral', 'name' => 'Default Kode Referral', 'category' => kategori_setting('referral'), 'rules' => ''],
        ];

        foreach($array as $key=>$data){
            Setting::updateOrCreate(['setting_key' => $data['key']], ['setting_name' => $data['name'], 'setting_category' => $data['category'], 'setting_rules' => $data['rules'], 'setting_order' => ($key+1)]);
        }
    }
}
