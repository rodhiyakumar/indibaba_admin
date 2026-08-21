<?php

defined('USER_PROFILE_PHOTO_PATH') || define('USER_PROFILE_PHOTO_PATH', 'uploads/profilePhoto');

/******************* ADMIN APIS ***********************/
$ADMIN_API_BASE_URL = '';
$USER_API_BASE_URL = '';
if (env('APP_ENV') == 'local') {
    // $ADMIN_API_BASE_URL = 'http://localhost:7005/v1/';
    $ADMIN_API_BASE_URL = 'http://195.35.20.180:7005/v1/';
    // $USER_API_BASE_URL = 'http://localhost:7006/v1/';
    $USER_API_BASE_URL = 'http://195.35.20.180:7006/v1/';
} elseif (env('APP_ENV') == 'production') {
    $ADMIN_API_BASE_URL = 'http://195.35.20.180:7005/v1/';
    $USER_API_BASE_URL = 'http://195.35.20.180:7006/v1/';
}

return [
    'endpoints' => [
        'login'          => $ADMIN_API_BASE_URL . 'auth/login',
        'profile'        => $ADMIN_API_BASE_URL . 'auth/profile',
        'updateProfile'  => $ADMIN_API_BASE_URL . 'auth/update-profile',
        'updatePassword' => $ADMIN_API_BASE_URL . 'auth/update-password',
        'user'           => [
            'get' => $ADMIN_API_BASE_URL . 'get-user',
        ],
        'category'       => [
            'get'    => $ADMIN_API_BASE_URL . 'get-category',
            'store'  => $ADMIN_API_BASE_URL . 'add-category',
            'update' => $ADMIN_API_BASE_URL . 'update-category',
            'delete' => $ADMIN_API_BASE_URL . 'delete-category',
        ],
        'brand'       => [
            'get'    => $ADMIN_API_BASE_URL . 'get-brand',
            'store'  => $ADMIN_API_BASE_URL . 'add-brand',
            'update' => $ADMIN_API_BASE_URL . 'update-brand',
            'delete' => $ADMIN_API_BASE_URL . 'delete-brand',
        ],
        'subCategory'    => [
            'get'    => $ADMIN_API_BASE_URL . 'get-sub-category',
            'store'  => $ADMIN_API_BASE_URL . 'add-sub-category',
            'update' => $ADMIN_API_BASE_URL . 'update-sub-category',
            'delete' => $ADMIN_API_BASE_URL . 'delete-sub-category',
        ],
        // 'coupon'         => [
        //     'get'    => $ADMIN_API_BASE_URL . 'get-coupon',
        //     'store'  => $ADMIN_API_BASE_URL . 'add-coupon',
        //     'update' => $ADMIN_API_BASE_URL . 'update-coupon',
        //     'delete' => $ADMIN_API_BASE_URL . 'delete-coupon',
        // ],
        'blog'           => [
            'get'    => $ADMIN_API_BASE_URL . 'get-blog',
            'store'  => $ADMIN_API_BASE_URL . 'add-blog',
            'update' => $ADMIN_API_BASE_URL . 'update-blog',
            'delete' => $ADMIN_API_BASE_URL . 'delete-blog',
        ],
        'file'           => [
            'upload' => $ADMIN_API_BASE_URL . 'uploads',
            'delete' => $ADMIN_API_BASE_URL . 'delete-file',
        ],
        'product'        => [
            'get'    => $ADMIN_API_BASE_URL . 'get-product',
            'search' => $ADMIN_API_BASE_URL . 'get-product-by-name',
            'store'  => $ADMIN_API_BASE_URL . 'add-product',
            'update' => $ADMIN_API_BASE_URL . 'update-product',
            'delete' => $ADMIN_API_BASE_URL . 'delete-product',
        ],
        'bulkPrice'      => [
            'get'    => $ADMIN_API_BASE_URL . 'get-product-bulk-price',
            'add' => $ADMIN_API_BASE_URL . 'add-product-bulk-price',
            'update' => $ADMIN_API_BASE_URL . 'update-product-bulk-price',
            'delete' => $ADMIN_API_BASE_URL . 'delete-product-bulk-price',
        ],
        'order'          => [
            'get'    => $ADMIN_API_BASE_URL . 'get-all-orders',
            'detail' => $ADMIN_API_BASE_URL . 'get-order-details',
            'update' => $ADMIN_API_BASE_URL . 'update-order-status',
            'updateShipping' => $ADMIN_API_BASE_URL . 'update-order-shipping',
        ],
    ],

    'messages' => [
        'login_success'  => 'Login successful!',
        'login_failed'   => 'Invalid email or password.',
        'logout_success' => 'You have been logged out.',
        'error_occurred' => 'An error occurred, please try again later.',
        'unauthorized'   => 'You are not authorized to access this resource.',
    ],
];
