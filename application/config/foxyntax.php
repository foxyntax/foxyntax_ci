<?php

/*
|--------------------------------------------------------------------------
| Customized Configs
|--------------------------------------------------------------------------
*/
$config['alpha_generate'] = '1234567890asdfghjklqwertMyuiopzxcvbnZXCVBNAmSDFGHJKL';
$config['salt_file_length'] = 8;


$config['base_media_dir'] = dirname(__DIR__, 2);
$config['allowed_types_uploaded'] = 'png|txt|html';
$config['max_size_uploaded'] = '9999999';
$config['max_width_uploaded'] = '9000';
$config['max_height_uploaded'] = '9000';
$config['encrypt_name_uploaded'] = true;
$config['remove_space_uploaded'] = true;


$config['auth_method']   = 'JWT'; // Also you can choose 'OTP'
$config['sign_data']     = 'username, password, mobile, type, status, timestamp';
$config['login_data']    = 'username, password';
$config['jwt_payload']   = '';
$config['sms_key']       = '';
$config['api_key']       = 'afDGS6Msdf9smdf1sEFS98PO21SVdfsfm';
$config['jwt_key']       = '3dfFGsdf23D1G6fgdf65SsdfG31ADsdoi';
$config['token_timeout'] = 1;
/*Generated token will expire in 1 minute for sample code
* Increase this value as per requirement for production
*/
