<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('options')->insert([
            0 => array(
                'id' => 1,
                'option_key' => 'category_count_cached',
                'option_value' => time(),
            ),
            1 => array(
                'id' => 2,
                'option_key' => 'enable_stripe',
                'option_value' => '1',
            ),
            2 => array(
                'id' => 3,
                'option_key' => 'date_format',
                'option_value' => 'Y-m-d',
            ),
            3 => array(
                'id' => 4,
                'option_key' => 'default_timezone',
                'option_value' => 'Asia/Jakarta',
            ),
            4 => array(
                'id' => 5,
                'option_key' => 'date_format_custom',
                'option_value' => 'd/m/Y',
            ),
            5 => array(
                'id' => 6,
                'option_key' => 'site_title',
                'option_value' => 'App Caritalenta',
            ),
            6 => array(
                'id' => 7,
                'option_key' => 'email_address',
                'option_value' => 'sysadmin@demo.com',
            ),
            7 => array(
                'id' => 8,
                'option_key' => 'time_format',
                'option_value' => 'g:i A',
            ),
            8 => array(
                'id' => 9,
                'option_key' => 'time_format_custom',
                'option_value' => 'g:i A',
            ),
            9 => array(
                'id' => 10,
                'option_key' => 'number_of_premium_ads_in_home',
                'option_value' => '8',
            ),
            10 => array(
                'id' => 11,
                'option_key' => 'number_of_free_ads_in_home',
                'option_value' => '8',
            ),
            11 => array(
                'id' => 12,
                'option_key' => 'ads_per_page',
                'option_value' => '12',
            ),
            12 => array(
                'id' => 13,
                'option_key' => 'regular_ads_price',
                'option_value' => '3',
            ),
            13 => array(
                'id' => 14,
                'option_key' => 'premium_ads_price',
                'option_value' => '8',
            ),
            14 => array(
                'id' => 15,
                'option_key' => 'ads_price_plan',
                'option_value' => 'regular_ads_free_premium_paid',
            ),
            15 => array(
                'id' => 16,
                'option_key' => 'ads_moderation',
                'option_value' => 'need_moderation',
            ),
            16 => array(
                'id' => 17,
                'option_key' => 'site_name',
                'option_value' => 'Caritalenta',
            ),
            17 => array(
                'id' => 18,
                'option_key' => 'default_storage',
                'option_value' => 'public',
            ),
            18 => array(
                'id' => 19,
                'option_key' => 'enable_facebook_login',
                'option_value' => '0',
            ),
            19 => array(
                'id' => 20,
                'option_key' => 'enable_google_login',
                'option_value' => '0',
            ),
            20 => array(
                'id' => 21,
                'option_key' => 'fb_app_id',
                'option_value' => '',
            ),
            21 => array(
                'id' => 22,
                'option_key' => 'fb_app_secret',
                'option_value' => '',
            ),
            22 => array(
                'id' => 23,
                'option_key' => 'google_client_id',
                'option_value' => '',
            ),
            23 => array(
                'id' => 24,
                'option_key' => 'google_client_secret',
                'option_value' => '',
            ),
            24 => array(
                'id' => 25,
                'option_key' => 'enable_social_login',
                'option_value' => '0',
            ),
            25 => array(
                'id' => 26,
                'option_key' => 'enable_social_sharing_in_ad_box',
                'option_value' => '0',
            ),
            26 => array(
                'id' => 27,
                'option_key' => 'order_by_premium_ads_in_listing',
                'option_value' => 'random',
            ),
            27 => array(
                'id' => 28,
                'option_key' => 'number_of_premium_ads_in_listing',
                'option_value' => '3',
            ),
            28 => array(
                'id' => 29,
                'option_key' => 'number_of_last_days_premium_ads',
                'option_value' => '30',
            ),
            29 => array(
                'id' => 30,
                'option_key' => 'enable_slider',
                'option_value' => '1',
            ),
            30 => array(
                'id' => 31,
                'option_key' => 'premium_ads_max_impressions',
                'option_value' => '50',
            ),
            31 => array(
                'id' => 32,
                'option_key' => 'footer_left_text',
                'option_value' => '',
            ),
            32 => array(
                'id' => 33,
                'option_key' => 'footer_right_text',
                'option_value' => '',
            ),
            33 => array(
                'id' => 34,
                'option_key' => 'copyright_text',
                'option_value' => '[copyright_sign] [year] [site_name]',
            ),
            34 => array(
                'id' => 35,
                'option_key' => 'facebook_url',
                'option_value' => '#',
            ),
            35 => array(
                'id' => 36,
                'option_key' => 'twitter_url',
                'option_value' => '#',
            ),
            36 => array(
                'id' => 37,
                'option_key' => 'linked_in_url',
                'option_value' => '#',
            ),
            37 => array(
                'id' => 38,
                'option_key' => 'google_plus_url',
                'option_value' => '#',
            ),
            38 => array(
                'id' => 39,
                'option_key' => 'youtube_url',
                'option_value' => '#',
            ),
            39 => array(
                'id' => 40,
                'option_key' => 'footer_company_name',
                'option_value' => '[site_name]',
            ),
            40 => array(
                'id' => 41,
                'option_key' => 'footer_address',
                'option_value' => '',
            ),
            41 => array(
                'id' => 42,
                'option_key' => 'site_phone_number',
                'option_value' => '',
            ),
            42 => array(
                'id' => 43,
                'option_key' => 'site_email_address',
                'option_value' => ' ',
            ),
            43 => array(
                'id' => 44,
                'option_key' => 'footer_about_us',
                'option_value' => '',
            ),
            44 => array(
                'id' => 45,
                'option_key' => 'footer_about_us_read_more_text',
                'option_value' => '',
            ),
            45 => array(
                'id' => 46,
                'option_key' => 'show_blog_in_footer',
                'option_value' => '0',
            ),
            46 => array(
                'id' => 47,
                'option_key' => 'show_blog_in_header',
                'option_value' => '0',
            ),
            47 => array(
                'id' => 48,
                'option_key' => 'blog_post_amount_in_homepage',
                'option_value' => '6',
            ),
            48 => array(
                'id' => 49,
                'option_key' => 'show_latest_blog_in_homepage',
                'option_value' => '0',
            ),
            49 => array(
                'id' => 50,
                'option_key' => 'currency_sign',
                'option_value' => 'IDR',
            ),
            50 => array(
                'id' => 51,
                'option_key' => 'meta_description',
                'option_value' => 'meta_description',
            ),
        ]);
    }
}
