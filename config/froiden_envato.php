<?php
//directory at updates.froid.works
$product = 'worksuite-saas';

$envato_item_id = 23263417;

$productUrl = 'https://1.envato.market/worksuitesaas';

$updatesUrl = 'https://s3.ap-south-1.amazonaws.com/updates.froid.works';

$verifyDomain = 'https://envato.froid.works';

return [

    /*
     * Model name of where purchase code is stored
     */
    'setting' => \App\GlobalSetting::class,

    /*
     * Add redirect route here route('login') will be used
     */
    'redirectRoute' => 'login',

    'envato_item_id' => $envato_item_id,

    'envato_product_name' => $product,

    'envato_product_url' => $productUrl,
    'plugins_url' => $verifyDomain.'/plugins/'.$envato_item_id,

    /*
    * Temp folder to store update before to install it.
    */
    'tmp_path' => storage_path() . '/app',
    /*
    * URL where your updates are stored ( e.g. for a folder named 'updates', under http://site.com/yourapp ).
    */
    'update_baseurl' => $updatesUrl . '/' . $product,
    /*
    * URL to verify your purchase code
    */
    'verify_url' => $verifyDomain . '/verify-purchase',

    /*
     *
     */
    'updater_file_path' => $updatesUrl . '/' . $product . '/laraupdater.json',

    /*
    * Set a middleware for the route: updater.update
    * Only 'auth' NOT works (manage security using 'allow_users_id' configuration)
    */
    'middleware' => ['web', 'auth'],

    /*
    * Set which users can perform an update;
    * This parameter accepts: ARRAY(user_id) ,or FALSE => for example: [1]  OR  [1,3,0]  OR  false
    * Generally, ADMIN have user_id=1; set FALSE to disable this check (not recommended)
    */

    'allow_users_id' => false,

    'versionLog' => $verifyDomain . '/version-log/'.$product,
];
