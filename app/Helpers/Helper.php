<?php
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Haruncpi\LaravelIdGenerator\IdGenerator;

/**
 * @return mixed
 * Custom functions
 */


/**
 * @return string
 */
if ( ! function_exists('pageJsonData')){
    function pageJsonData(){


        $jobModalOpen = false;
        if (session('job_validation_fails')){
            $jobModalOpen = true;
        }

        $data = [
            'home_url'      => route('home'),
            'asset_url'     => asset('assets'),
            'csrf_token'    => csrf_token(),
            'jobModalOpen'  => $jobModalOpen,
            'flag_job_validation_fails' => session('flag_job_validation_fails'),
            'share_job_validation_fails' => session('share_job_validation_fails'),
            //'my_dashboard' => route('my_dashboard'),
        ];

        $routeLists = \Illuminate\Support\Facades\Route::getRoutes();

        $routes = [];
        foreach ($routeLists as $route){
            $routes[$route->getName()] = $data['home_url'].'/'.$route->uri;
        }
        $data['routes'] = $routes;

        return json_encode($data);
    }
}

function generate_id(string $table, string $field = 'id', int $length = 10, $prefix, $reset = false){
    $result = IdGenerator::generate(['table' => $table, 'field' => $field, 'length' => $length, 'prefix' => $prefix, 'reset_on_prefix_change' => $reset]);

    return $result;
}

/**
 * @param string $data
 * @return string
 */
function encrypt_data($data){
    $output = Crypt::encryptString($data);
    $first_key = base64_decode(config('app.salt_key_1'));
    $second_key = base64_decode(config('app.salt_key_2'));
    $method = config('app.cipher');
    
    $iv_length = openssl_cipher_iv_length($method);
    $iv = openssl_random_pseudo_bytes($iv_length);
    
    $data_encrypted = openssl_encrypt($data,$method,$first_key, OPENSSL_RAW_DATA ,$iv);
    $hmac = hash_hmac('sha256', $data_encrypted, $second_key, TRUE);
            
    $output = base64_encode($iv.$hmac.$data_encrypted);   
    return $output;
}

/**
 * @param string $input
 * @return string
 */
function decrypt_data($input_encrypted){
    $first_key = base64_decode(config('app.salt_key_1'));
    $second_key = base64_decode(config('app.salt_key_2'));
    $mix = base64_decode($input_encrypted);
    
    $method = config('app.cipher');
    $iv_length = openssl_cipher_iv_length($method);
    
    $iv = substr($mix,0,$iv_length);
    $hmac = substr($mix,$iv_length,$sha2len=32);
    $data_encrypted = substr($mix,$iv_length+$sha2len);

    $data = openssl_decrypt($data_encrypted,$method,$first_key,OPENSSL_RAW_DATA,$iv);
    $calcmac = hash_hmac('sha256', $data_encrypted, $second_key, TRUE);
    
    if (hash_equals($hmac,$calcmac))
    return $data;
    
    return false;
}

function avatar_img_url($img = '', $source){
    $url_path = '';
    if ($img){
        if ($source == 'public'){
            $url_path = asset('uploads/avatar/'.$img);
        }elseif ($source == 's3'){
            $url_path = \Illuminate\Support\Facades\Storage::disk('s3')->url('uploads/avatar/'.$img);
        }
    }
    return $url_path;
}


/**
 * @param string $option_key
 * @return string
 */
function get_option($option_key = '', $default = false){
    $options = config('options');
    if(isset($options[$option_key])) {
        return $options[$option_key];
    }
    return $default;
}


/**
 * @param string $title
 * @param $model
 * @return string
 */

function unique_slug($title = '', $model = 'Job', $col = 'slug'){
    $slug = str_slug($title);
    if ($slug === ''){
        $string = mb_strtolower($title, "UTF-8");;
        $string = preg_replace("/[\/\.]/", " ", $string);
        $string = preg_replace("/[\s-]+/", " ", $string);
        $slug = preg_replace("/[\s_]/", '-', $string);
    }

    //get unique slug...
    $nSlug = $slug;
    $i = 0;

    $model = str_replace(' ','',"\App\Models\ ".$model);
    while( ($model::where($col, '=', $nSlug)->count()) > 0){
        $i++;
        $nSlug = $slug.'-'.$i;
    }
    if($i > 0) {
        $newSlug = substr($nSlug, 0, strlen($slug)) . '-' . $i;
    } else
    {
        $newSlug = $slug;
    }
    return $newSlug;
}

/**
 * @param string $type
 * @return string
 *
 * @return stripe secret key or test key
 */

function get_stripe_key($type = 'publishable'){
    $stripe_key = '';

    if ($type == 'publishable'){
        if (get_option('stripe_test_mode') == 1){
            $stripe_key = get_option('stripe_test_publishable_key');
        }else{
            $stripe_key = get_option('stripe_live_publishable_key');
        }
    }elseif ($type == 'secret'){
        if (get_option('stripe_test_mode') == 1){
            $stripe_key = get_option('stripe_test_secret_key');
        }else{
            $stripe_key = get_option('sk_live_ojldRoMZ3j14I5pwpfCxidvT');
        }
    }

    return $stripe_key;
}

/**
 * @param int $ad_id
 * @param string $status
 */
function ad_status_change($ad_id = 0, $status = 1){
    if ($ad_id > 0){
        $ad = \App\Models\Ad::find($ad_id);
        
        if ($ad){
            $previous_status = $ad->status;
            //Publish ad
            $ad->status = $status;
            $ad->save();
        }
    }

    return false;
}
function update_option($key, $value){
    $option = \App\Models\Option::firstOrCreate(['option_key' => $key]);
    $option -> option_value = $value;
    return $option->save();
}

function e_form_error($field = '', $errors){
    $output = $errors->has($field)? '<span class="invalid-feedback" role="alert"><strong>'.$errors->first($field).'</strong></span>':'';
    return $output;
}

function e_form_invalid_class($field = '', $errors){
    return $errors->has($field) ? ' is-invalid' : '';
}




/**
 * @param int $amount
 * @return string
 */
function get_amount($amount = 0, $currency = null){
    $currency_position = get_option('currency_position');

    if ( ! $currency){
        $currency = get_option('currency_sign');
    }

    $currency_sign = get_currency_symbol($currency);
    $get_price = get_amount_raw($amount);

    if ($currency_position == 'right'){
        $show_price = $get_price.$currency_sign;
    }else{
        $show_price = $currency_sign.$get_price;
    }

    return $show_price;
}


function get_amount_raw($amount = 0 ){
    $get_price = '0.00';
    $none_decimal_currencies = get_zero_decimal_currency();

    if (in_array(get_option('currency_sign'), $none_decimal_currencies)){
        $get_price = (int) $amount;
    }else{
        if ($amount > 0){
            $get_price = number_format($amount,2);
        }
    }

    return $get_price;
}


if ( ! function_exists('get_zero_decimal_currency')) {
    function get_zero_decimal_currency(){
        $zero_decimal_currency = [
            'BIF',
            'MGA',
            'CLP',
            'PYG',
            'DJF',
            'RWF',
            'GNF',
            'UGX',
            'JPY',
            'VND',
            'VUV',
            'KMF',
            'XAF',
            'KRW',
            'XOF',
            'XPF',
        ];

        return $zero_decimal_currency;
    }
}
if ( ! function_exists('get_stripe_amount')) {
    function get_stripe_amount($amount = 0, $type = 'to_cents'){
        if ( ! $amount){
            return $amount;
        }

        $non_decimal_currency = get_zero_decimal_currency();

        if (in_array(get_option('currency_sign'), $non_decimal_currency)) {
            return $amount;
        }

        if ($type === 'to_cents'){
            return ($amount * 100);
        }
        return $amount / 100;
    }
}

/**
 * @return array
 *
 * Get currencies
 */

function get_currencies(){
    return array(
        'USD' => 'United States dollar',
        'EUR' => 'Euro',
        'AED' => 'United Arab Emirates dirham',
        'AFN' => 'Afghan afghani',
        'ALL' => 'Albanian lek',
        'AMD' => 'Armenian dram',
        'ANG' => 'Netherlands Antillean guilder',
        'AOA' => 'Angolan kwanza',
        'ARS' => 'Argentine peso',
        'AUD' => 'Australian dollar',
        'AWG' => 'Aruban florin',
        'AZN' => 'Azerbaijani manat',
        'BAM' => 'Bosnia and Herzegovina convertible mark',
        'BBD' => 'Barbadian dollar',
        'BDT' => 'Bangladeshi taka',
        'BGN' => 'Bulgarian lev',
        'BHD' => 'Bahraini dinar',
        'BIF' => 'Burundian franc',
        'BMD' => 'Bermudian dollar',
        'BND' => 'Brunei dollar',
        'BOB' => 'Bolivian boliviano',
        'BRL' => 'Brazilian real',
        'BSD' => 'Bahamian dollar',
        'BTC' => 'Bitcoin',
        'BTN' => 'Bhutanese ngultrum',
        'BWP' => 'Botswana pula',
        'BYR' => 'Belarusian ruble',
        'BZD' => 'Belize dollar',
        'CAD' => 'Canadian dollar',
        'CDF' => 'Congolese franc',
        'CHF' => 'Swiss franc',
        'CLP' => 'Chilean peso',
        'CNY' => 'Chinese yuan',
        'COP' => 'Colombian peso',
        'CRC' => 'Costa Rican col&oacute;n',
        'CUC' => 'Cuban convertible peso',
        'CUP' => 'Cuban peso',
        'CVE' => 'Cape Verdean escudo',
        'CZK' => 'Czech koruna',
        'DJF' => 'Djiboutian franc',
        'DKK' => 'Danish krone',
        'DOP' => 'Dominican peso',
        'DZD' => 'Algerian dinar',
        'EGP' => 'Egyptian pound',
        'ERN' => 'Eritrean nakfa',
        'ETB' => 'Ethiopian birr',
        'FJD' => 'Fijian dollar',
        'FKP' => 'Falkland Islands pound',
        'GBP' => 'Pound sterling',
        'GEL' => 'Georgian lari',
        'GGP' => 'Guernsey pound',
        'GHS' => 'Ghana cedi',
        'GIP' => 'Gibraltar pound',
        'GMD' => 'Gambian dalasi',
        'GNF' => 'Guinean franc',
        'GTQ' => 'Guatemalan quetzal',
        'GYD' => 'Guyanese dollar',
        'HKD' => 'Hong Kong dollar',
        'HNL' => 'Honduran lempira',
        'HRK' => 'Croatian kuna',
        'HTG' => 'Haitian gourde',
        'HUF' => 'Hungarian forint',
        'IDR' => 'Indonesian rupiah',
        'ILS' => 'Israeli new shekel',
        'IMP' => 'Manx pound',
        'INR' => 'Indian rupee',
        'IQD' => 'Iraqi dinar',
        'IRR' => 'Iranian rial',
        'ISK' => 'Icelandic kr&oacute;na',
        'JEP' => 'Jersey pound',
        'JMD' => 'Jamaican dollar',
        'JOD' => 'Jordanian dinar',
        'JPY' => 'Japanese yen',
        'KES' => 'Kenyan shilling',
        'KGS' => 'Kyrgyzstani som',
        'KHR' => 'Cambodian riel',
        'KMF' => 'Comorian franc',
        'KPW' => 'North Korean won',
        'KRW' => 'South Korean won',
        'KWD' => 'Kuwaiti dinar',
        'KYD' => 'Cayman Islands dollar',
        'KZT' => 'Kazakhstani tenge',
        'LAK' => 'Lao kip',
        'LBP' => 'Lebanese pound',
        'LKR' => 'Sri Lankan rupee',
        'LRD' => 'Liberian dollar',
        'LSL' => 'Lesotho loti',
        'LYD' => 'Libyan dinar',
        'MAD' => 'Moroccan dirham',
        'MDL' => 'Moldovan leu',
        'MGA' => 'Malagasy ariary',
        'MKD' => 'Macedonian denar',
        'MMK' => 'Burmese kyat',
        'MNT' => 'Mongolian t&ouml;gr&ouml;g',
        'MOP' => 'Macanese pataca',
        'MRO' => 'Mauritanian ouguiya',
        'MUR' => 'Mauritian rupee',
        'MVR' => 'Maldivian rufiyaa',
        'MWK' => 'Malawian kwacha',
        'MXN' => 'Mexican peso',
        'MYR' => 'Malaysian ringgit',
        'MZN' => 'Mozambican metical',
        'NAD' => 'Namibian dollar',
        'NGN' => 'Nigerian naira',
        'NIO' => 'Nicaraguan c&oacute;rdoba',
        'NOK' => 'Norwegian krone',
        'NPR' => 'Nepalese rupee',
        'NZD' => 'New Zealand dollar',
        'OMR' => 'Omani rial',
        'PAB' => 'Panamanian balboa',
        'PEN' => 'Peruvian nuevo sol',
        'PGK' => 'Papua New Guinean kina',
        'PHP' => 'Philippine peso',
        'PKR' => 'Pakistani rupee',
        'PLN' => 'Polish z&#x142;oty',
        'PRB' => 'Transnistrian ruble',
        'PYG' => 'Paraguayan guaran&iacute;',
        'QAR' => 'Qatari riyal',
        'RON' => 'Romanian leu',
        'RSD' => 'Serbian dinar',
        'RUB' => 'Russian ruble',
        'RWF' => 'Rwandan franc',
        'SAR' => 'Saudi riyal',
        'SBD' => 'Solomon Islands dollar',
        'SCR' => 'Seychellois rupee',
        'SDG' => 'Sudanese pound',
        'SEK' => 'Swedish krona',
        'SGD' => 'Singapore dollar',
        'SHP' => 'Saint Helena pound',
        'SLL' => 'Sierra Leonean leone',
        'SOS' => 'Somali shilling',
        'SRD' => 'Surinamese dollar',
        'SSP' => 'South Sudanese pound',
        'STD' => 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe dobra',
        'SYP' => 'Syrian pound',
        'SZL' => 'Swazi lilangeni',
        'THB' => 'Thai baht',
        'TJS' => 'Tajikistani somoni',
        'TMT' => 'Turkmenistan manat',
        'TND' => 'Tunisian dinar',
        'TOP' => 'Tongan pa&#x2bb;anga',
        'TRY' => 'Turkish lira',
        'TTD' => 'Trinidad and Tobago dollar',
        'TWD' => 'New Taiwan dollar',
        'TZS' => 'Tanzanian shilling',
        'UAH' => 'Ukrainian hryvnia',
        'UGX' => 'Ugandan shilling',
        'UYU' => 'Uruguayan peso',
        'UZS' => 'Uzbekistani som',
        'VEF' => 'Venezuelan bol&iacute;var',
        'VND' => 'Vietnamese &#x111;&#x1ed3;ng',
        'VUV' => 'Vanuatu vatu',
        'WST' => 'Samoan t&#x101;l&#x101;',
        'XAF' => 'Central African CFA franc',
        'XCD' => 'East Caribbean dollar',
        'XOF' => 'West African CFA franc',
        'XPF' => 'CFP franc',
        'YER' => 'Yemeni rial',
        'ZAR' => 'South African rand',
        'ZMW' => 'Zambian kwacha',
    );
}

/**
 * Get Currency symbol.
 *
 * @param string $currency (default: '')
 * @return string
 */
if ( ! function_exists('get_currency_symbol')) {
    function get_currency_symbol($currency = ''){
        if (!$currency) {
            $currency = 'USD';
        }

        $symbols = array(
            'AED' => '&#x62f;.&#x625;',
            'AFN' => '&#x60b;',
            'ALL' => 'L',
            'AMD' => 'AMD',
            'ANG' => '&fnof;',
            'AOA' => 'Kz',
            'ARS' => '&#36;',
            'AUD' => '&#36;',
            'AWG' => '&fnof;',
            'AZN' => 'AZN',
            'BAM' => 'KM',
            'BBD' => '&#36;',
            'BDT' => '&#2547;&nbsp;',
            'BGN' => '&#1083;&#1074;.',
            'BHD' => '.&#x62f;.&#x628;',
            'BIF' => 'Fr',
            'BMD' => '&#36;',
            'BND' => '&#36;',
            'BOB' => 'Bs.',
            'BRL' => '&#82;&#36;',
            'BSD' => '&#36;',
            'BTC' => '&#3647;',
            'BTN' => 'Nu.',
            'BWP' => 'P',
            'BYR' => 'Br',
            'BZD' => '&#36;',
            'CAD' => '&#36;',
            'CDF' => 'Fr',
            'CHF' => '&#67;&#72;&#70;',
            'CLP' => '&#36;',
            'CNY' => '&yen;',
            'COP' => '&#36;',
            'CRC' => '&#x20a1;',
            'CUC' => '&#36;',
            'CUP' => '&#36;',
            'CVE' => '&#36;',
            'CZK' => '&#75;&#269;',
            'DJF' => 'Fr',
            'DKK' => 'DKK',
            'DOP' => 'RD&#36;',
            'DZD' => '&#x62f;.&#x62c;',
            'EGP' => 'EGP',
            'ERN' => 'Nfk',
            'ETB' => 'Br',
            'EUR' => '&euro;',
            'FJD' => '&#36;',
            'FKP' => '&pound;',
            'GBP' => '&pound;',
            'GEL' => '&#x10da;',
            'GGP' => '&pound;',
            'GHS' => '&#x20b5;',
            'GIP' => '&pound;',
            'GMD' => 'D',
            'GNF' => 'Fr',
            'GTQ' => 'Q',
            'GYD' => '&#36;',
            'HKD' => '&#36;',
            'HNL' => 'L',
            'HRK' => 'Kn',
            'HTG' => 'G',
            'HUF' => '&#70;&#116;',
            'IDR' => 'Rp',
            'ILS' => '&#8362;',
            'IMP' => '&pound;',
            'INR' => '&#8377;',
            'IQD' => '&#x639;.&#x62f;',
            'IRR' => '&#xfdfc;',
            'ISK' => 'kr.',
            'JEP' => '&pound;',
            'JMD' => '&#36;',
            'JOD' => '&#x62f;.&#x627;',
            'JPY' => '&yen;',
            'KES' => 'KSh',
            'KGS' => '&#x441;&#x43e;&#x43c;',
            'KHR' => '&#x17db;',
            'KMF' => 'Fr',
            'KPW' => '&#x20a9;',
            'KRW' => '&#8361;',
            'KWD' => '&#x62f;.&#x643;',
            'KYD' => '&#36;',
            'KZT' => 'KZT',
            'LAK' => '&#8365;',
            'LBP' => '&#x644;.&#x644;',
            'LKR' => '&#xdbb;&#xdd4;',
            'LRD' => '&#36;',
            'LSL' => 'L',
            'LYD' => '&#x644;.&#x62f;',
            'MAD' => '&#x62f;. &#x645;.',
            'MDL' => 'L',
            'MGA' => 'Ar',
            'MKD' => '&#x434;&#x435;&#x43d;',
            'MMK' => 'Ks',
            'MNT' => '&#x20ae;',
            'MOP' => 'P',
            'MRO' => 'UM',
            'MUR' => '&#x20a8;',
            'MVR' => '.&#x783;',
            'MWK' => 'MK',
            'MXN' => '&#36;',
            'MYR' => '&#82;&#77;',
            'MZN' => 'MT',
            'NAD' => '&#36;',
            'NGN' => '&#8358;',
            'NIO' => 'C&#36;',
            'NOK' => '&#107;&#114;',
            'NPR' => '&#8360;',
            'NZD' => '&#36;',
            'OMR' => '&#x631;.&#x639;.',
            'PAB' => 'B/.',
            'PEN' => 'S/.',
            'PGK' => 'K',
            'PHP' => '&#8369;',
            'PKR' => '&#8360;',
            'PLN' => '&#122;&#322;',
            'PRB' => '&#x440;.',
            'PYG' => '&#8370;',
            'QAR' => '&#x631;.&#x642;',
            'RMB' => '&yen;',
            'RON' => 'lei',
            'RSD' => '&#x434;&#x438;&#x43d;.',
            'RUB' => '&#8381;',
            'RWF' => 'Fr',
            'SAR' => '&#x631;.&#x633;',
            'SBD' => '&#36;',
            'SCR' => '&#x20a8;',
            'SDG' => '&#x62c;.&#x633;.',
            'SEK' => '&#107;&#114;',
            'SGD' => '&#36;',
            'SHP' => '&pound;',
            'SLL' => 'Le',
            'SOS' => 'Sh',
            'SRD' => '&#36;',
            'SSP' => '&pound;',
            'STD' => 'Db',
            'SYP' => '&#x644;.&#x633;',
            'SZL' => 'L',
            'THB' => '&#3647;',
            'TJS' => '&#x405;&#x41c;',
            'TMT' => 'm',
            'TND' => '&#x62f;.&#x62a;',
            'TOP' => 'T&#36;',
            'TRY' => '&#8378;',
            'TTD' => '&#36;',
            'TWD' => '&#78;&#84;&#36;',
            'TZS' => 'Sh',
            'UAH' => '&#8372;',
            'UGX' => 'UGX',
            'USD' => '&#36;',
            'UYU' => '&#36;',
            'UZS' => 'UZS',
            'VEF' => 'Bs F',
            'VND' => '&#8363;',
            'VUV' => 'Vt',
            'WST' => 'T',
            'XAF' => 'Fr',
            'XCD' => '&#36;',
            'XOF' => 'Fr',
            'XPF' => 'Fr',
            'YER' => '&#xfdfc;',
            'ZAR' => '&#82;',
            'ZMW' => 'ZK',
        );

        $currency_symbol = isset($symbols[$currency]) ? $symbols[$currency] : '';

        return $currency_symbol;
    }
}

/**
 * @return array
 *
 * Get phone code
 */

function get_phone_code(){
    return array(
        // '44' => 'UK (+44)',
        // '1' => 'USA (+1)',
        // '213' => 'Algeria (+213)',
        // '376' => 'Andorra (+376)',
        // '244' => 'Angola (+244)',
        // '1264' => 'Anguilla (+1264)',
        // '1268' => 'Antigua & Barbuda (+1268)',
        // '54' => 'Argentina (+54)',
        // '374' => 'Armenia (+374)',
        // '297' => 'Aruba (+297)',
        // '61' => 'Australia (+61)',
        // '43' => 'Austria (+43)',
        // '994' => 'Azerbaijan (+994)',
        // '1242' => 'Bahamas (+1242)',
        // '973' => 'Bahrain (+973)',
        // '880' => 'Bangladesh (+880)',
        // '1246' => 'Barbados (+1246)',
        // '375' => 'Belarus (+375)',
        // '32' => 'Belgium (+32)',
        // '501' => 'Belize (+501)',
        // '229' => 'Benin (+229)',
        // '1441' => 'Bermuda (+1441)',
        // '975' => 'Bhutan (+975)',
        // '591' => 'Bolivia (+591)',
        // '387' => 'Bosnia Herzegovina (+387)',
        // '267' => 'Botswana (+267)',
        // '55' => 'Brazil (+55)',
        // '673' => 'Brunei (+673)',
        // '359' => 'Bulgaria (+359)',
        // '226' => 'Burkina Faso (+226)',
        // '257' => 'Burundi (+257)',
        // '855' => 'Cambodia (+855)',
        // '237' => 'Cameroon (+237)',
        // '1' => 'Canada (+1)',
        // '238' => 'Cape Verde Islands (+238)',
        // '1345' => 'Cayman Islands (+1345)',
        // '236' => 'Central African Republic (+236)',
        // '56' => 'Chile (+56)',
        // '86' => 'China (+86)',
        // '57' => 'Colombia (+57)',
        // '269' => 'Comoros (+269)',
        // '242' => 'Congo (+242)',
        // '682' => 'Cook Islands (+682)',
        // '506' => 'Costa Rica (+506)',
        // '385' => 'Croatia (+385)',
        // '53' => 'Cuba (+53)',
        // '90392' => 'Cyprus North (+90392)',
        // '357' => 'Cyprus South (+357)',
        // '42' => 'Czech Republic (+42)',
        // '45' => 'Denmark (+45)',
        // '253' => 'Djibouti (+253)',
        // '1809' => 'Dominica (+1809)',
        // '1809' => 'Dominican Republic (+1809)',
        // '593' => 'Ecuador (+593)',
        // '20' => 'Egypt (+20)',
        // '503' => 'El Salvador (+503)',
        // '240' => 'Equatorial Guinea (+240)',
        // '291' => 'Eritrea (+291)',
        // '372' => 'Estonia (+372)',
        // '251' => 'Ethiopia (+251)',
        // '500' => 'Falkland Islands (+500)',
        // '298' => 'Faroe Islands (+298)',
        // '679' => 'Fiji (+679)',
        // '358' => 'Finland (+358)',
        // '33' => 'France (+33)',
        // '594' => 'French Guiana (+594)',
        // '689' => 'French Polynesia (+689)',
        // '241' => 'Gabon (+241)',
        // '220' => 'Gambia (+220)',
        // '7880' => 'Georgia (+7880)',
        // '49' => 'Germany (+49)',
        // '233' => 'Ghana (+233)',
        // '350' => 'Gibraltar (+350)',
        // '30' => 'Greece (+30)',
        // '299' => 'Greenland (+299)',
        // '1473' => 'Grenada (+1473)',
        // '590' => 'Guadeloupe (+590)',
        // '671' => 'Guam (+671)',
        // '502' => 'Guatemala (+502)',
        // '224' => 'Guinea (+224)',
        // '245' => 'Guinea - Bissau (+245)',
        // '592' => 'Guyana (+592)',
        // '509' => 'Haiti (+509)',
        // '504' => 'Honduras (+504)',
        // '852' => 'Hong Kong (+852)',
        // '36' => 'Hungary (+36)',
        // '354' => 'Iceland (+354)',
        // '91' => 'India (+91)',
        '62' => 'Indonesia (+62)',
        // '98' => 'Iran (+98)',
        // '964' => 'Iraq (+964)',
        // '353' => 'Ireland (+353)',
        // '972' => 'Israel (+972)',
        // '39' => 'Italy (+39)',
        // '1876' => 'Jamaica (+1876)',
        // '81' => 'Japan (+81)',
        // '962' => 'Jordan (+962)',
        // '7' => 'Kazakhstan (+7)',
        // '254' => 'Kenya (+254)',
        // '686' => 'Kiribati (+686)',
        // '850' => 'Korea North (+850)',
        // '82' => 'Korea South (+82)',
        // '965' => 'Kuwait (+965)',
        // '996' => 'Kyrgyzstan (+996)',
        // '856' => 'Laos (+856)',
        // '371' => 'Latvia (+371)',
        // '961' => 'Lebanon (+961)',
        // '266' => 'Lesotho (+266)',
        // '231' => 'Liberia (+231)',
        // '218' => 'Libya (+218)',
        // '417' => 'Liechtenstein (+417)',
        // '370' => 'Lithuania (+370)',
        // '352' => 'Luxembourg (+352)',
        // '853' => 'Macao (+853)',
        // '389' => 'Macedonia (+389)',
        // '261' => 'Madagascar (+261)',
        // '265' => 'Malawi (+265)',
        // '60' => 'Malaysia (+60)',
        // '960' => 'Maldives (+960)',
        // '223' => 'Mali (+223)',
        // '356' => 'Malta (+356)',
        // '692' => 'Marshall Islands (+692)',
        // '596' => 'Martinique (+596)',
        // '222' => 'Mauritania (+222)',
        // '269' => 'Mayotte (+269)',
        // '52' => 'Mexico (+52)',
        // '691' => 'Micronesia (+691)',
        // '373' => 'Moldova (+373)',
        // '377' => 'Monaco (+377)',
        // '976' => 'Mongolia (+976)',
        // '1664' => 'Montserrat (+1664)',
        // '212' => 'Morocco (+212)',
        // '258' => 'Mozambique (+258)',
        // '95' => 'Myanmar (+95)',
        // '264' => 'Namibia (+264)',
        // '674' => 'Nauru (+674)',
        // '977' => 'Nepal (+977)',
        // '31' => 'Netherlands (+31)',
        // '687' => 'New Caledonia (+687)',
        // '64' => 'New Zealand (+64)',
        // '505' => 'Nicaragua (+505)',
        // '227' => 'Niger (+227)',
        // '234' => 'Nigeria (+234)',
        // '683' => 'Niue (+683)',
        // '672' => 'Norfolk Islands (+672)',
        // '670' => 'Northern Marianas (+670)',
        // '47' => 'Norway (+47)',
        // '968' => 'Oman (+968)',
        // '680' => 'Palau (+680)',
        // '507' => 'Panama (+507)',
        // '675' => 'Papua New Guinea (+675)',
        // '595' => 'Paraguay (+595)',
        // '51' => 'Peru (+51)',
        // '63' => 'Philippines (+63)',
        // '48' => 'Poland (+48)',
        // '351' => 'Portugal (+351)',
        // '1787' => 'Puerto Rico (+1787)',
        // '974' => 'Qatar (+974)',
        // '262' => 'Reunion (+262)',
        // '40' => 'Romania (+40)',
        // '7' => 'Russia (+7)',
        // '250' => 'Rwanda (+250)',
        // '378' => 'San Marino (+378)',
        // '239' => 'Sao Tome & Principe (+239)',
        // '966' => 'Saudi Arabia (+966)',
        // '221' => 'Senegal (+221)',
        // '381' => 'Serbia (+381)',
        // '248' => 'Seychelles (+248)',
        // '232' => 'Sierra Leone (+232)',
        // '65' => 'Singapore (+65)',
        // '421' => 'Slovak Republic (+421)',
        // '386' => 'Slovenia (+386)',
        // '677' => 'Solomon Islands (+677)',
        // '252' => 'Somalia (+252)',
        // '27' => 'South Africa (+27)',
        // '34' => 'Spain (+34)',
        // '94' => 'Sri Lanka (+94)',
        // '290' => 'St. Helena (+290)',
        // '1869' => 'St. Kitts (+1869)',
        // '1758' => 'St. Lucia (+1758)',
        // '249' => 'Sudan (+249)',
        // '597' => 'Suriname (+597)',
        // '268' => 'Swaziland (+268)',
        // '46' => 'Sweden (+46)',
        // '41' => 'Switzerland (+41)',
        // '963' => 'Syria (+963)',
        // '886' => 'Taiwan (+886)',
        // '7' => 'Tajikstan (+7)',
        // '66' => 'Thailand (+66)',
        // '228' => 'Togo (+228)',
        // '676' => 'Tonga (+676)',
        // '1868' => 'Trinidad & Tobago (+1868)',
        // '216' => 'Tunisia (+216)',
        // '90' => 'Turkey (+90)',
        // '7' => 'Turkmenistan (+7)',
        // '993' => 'Turkmenistan (+993)',
        // '1649' => 'Turks & Caicos Islands (+1649)',
        // '688' => 'Tuvalu (+688)',
        // '256' => 'Uganda (+256)',
        // '380' => 'Ukraine (+380)',
        // '971' => 'United Arab Emirates (+971)',
        // '598' => 'Uruguay (+598)',
        // '7' => 'Uzbekistan (+7)',
        // '678' => 'Vanuatu (+678)',
        // '379' => 'Vatican City (+379)',
        // '58' => 'Venezuela (+58)',
        // '84' => 'Vietnam (+84)',
        // '84' => 'Virgin Islands - British (+1284)',
        // '84' => 'Virgin Islands - US (+1340)',
        // '681' => 'Wallis & Futuna (+681)',
        // '969' => 'Yemen (North)(+969)',
        // '967' => 'Yemen (South)(+967)',
        // '260' => 'Zambia (+260)',
        // '263' => 'Zimbabwe (+263)',
    );
}

/**
 * Form Helper
 */

/**
 * @param $checked
 * @param bool $current
 * @param bool $echo
 * @return string
 */

if ( ! function_exists('checked')) {
    function checked($checked, $current = true, $echo = true)
    {
        return __checked_selected_helper($checked, $current, $echo, 'checked');
    }
}
/**
 * @param $selected
 * @param bool $current
 * @param bool $echo
 * @return string
 */

if ( ! function_exists('selected')) {
    function selected($selected, $current = true, $echo = true)
    {
        return __checked_selected_helper($selected, $current, $echo, 'selected');
    }
}

/**
 * @param $helper
 * @param $current
 * @param $echo
 * @param $type
 * @return string
 */

if ( ! function_exists('__checked_selected_helper')) {
    function __checked_selected_helper($helper, $current, $echo, $type)
    {
        if ((string)$helper === (string)$current)
            $result = " $type='$type'";
        else
            $result = '';

        if ($echo)
            echo $result;

        return $result;
    }
}
/**
 * End Form Helper
 */


/**
 * @param null $code
 * @return array|mixed
 *
 * Get Company Size
 */

if ( ! function_exists('company_size')) {
    function company_size($code = null){
        $size = [
            'A' => __('app.1-10')." ".__('app.employees'),
            'B' => __('app.11-50')." ".__('app.employees'),
            'C'  => __('app.51-200')." ".__('app.employees'),
            'D'  => __('app.201-500')." ".__('app.employees'),
            'E'  => __('app.501-1000')." ".__('app.employees'),
            'F'  => __('app.1001-5000')." ".__('app.employees'),
            'G'  => __('app.5001-10,000')." ".__('app.employees'),
            'H'  => __('app.10,001+')." ".__('app.employees'),
        ];

        if ($code && isset($size[$code])){
            return $size[$code];
        }
        return $size;
    }
}

if ( ! function_exists('gender')) {
    function gender($code = null){
        $size = [
            'not_specified' => __('app.not_specified'),
            'male' => __('app.male'),
            'female' => __('app.female'),
        ];

        if ($code && isset($size[$code])){
            return $size[$code];
        }
        return $size;
    }
}

if ( ! function_exists('job_types')) {
    function job_types($code = null){
        $size = [
            'full_time' => __('app.full_time'),
            'part_time' => __('app.part_time'),
            'contract' => __('app.contract'),
            'temporary' => __('app.temporary'),
            'internship' => __('app.internship'),
            'permanent' => __('app.permanent')
        ];

        if ($code && isset($size[$code])){
            return $size[$code];
        }
        return $size;
    }
}

if ( ! function_exists('exp_level')) {
    function exp_levels($code = null){
        $size = [
            'junior' => __('app.junior'),
            'middle' => __('app.middle'),
            'senior' => __('app.senior'),
        ];

        if ($code && isset($size[$code])){
            return $size[$code];
        }
        return $size;
    }
}

if ( ! function_exists('salary_cycle')) {
    function salary_cycle($code = null){
        $size = [
            'monthly' => __('app.monthly'),
            'yearly' => __('app.yearly'),
            'weekly' => __('app.weekly'),
            'daily' => __('app.daily'),
            'hourly' => __('app.hourly'),
        ];

        if ($code && isset($size[$code])){
            return $size[$code];
        }
        return $size;
    }
}

if (! function_exists('limit_words')){
    function limit_words($text = null, $limit = 30) {
        $text = strip_tags($text);
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }
}

function get_text_tpl($text = ''){
    $tpl = ['[year]', '[copyright_sign]', '[site_name]'];
    $variable = [date('Y'), '&copy;', get_option('site_name')];

    $tpl_option = str_replace($tpl,$variable,$text);
    return $tpl_option;
}


if ( ! function_exists('paypal_ipn_verify')){
    function paypal_ipn_verify(){
        $paypal_action_url = "https://www.paypal.com/cgi-bin/webscr";
        if (get_option('enable_paypal_sandbox') == 1)
            $paypal_action_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";

        // STEP 1: read POST data
        // Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
        // Instead, read raw POST data from the input stream.
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode ('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }
        // read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
        $req = 'cmd=_notify-validate';
        if(function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

        // STEP 2: POST IPN data back to PayPal to validate
        $ch = curl_init($paypal_action_url);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        if( !($res = curl_exec($ch)) ) {
            // error_log("Got " . curl_error($ch) . " when processing IPN data");
            curl_close($ch);
            exit;
        }
        curl_close($ch);

        // STEP 3: Inspect IPN validation result and act accordingly
        if (strcmp ($res, "VERIFIED") == 0) {
            return true;
        } else if (strcmp ($res, "INVALID") == 0) {
            return false;
        }
    }
}
