@php
    $menus = [
        [
            'name' => 'Dashboard',
            'icon' => 'ti-dashboard',
            'link' => url('dashboard'),
            'page' => 'dashboard',
            'dropdown' => false,
        ],
        // [
        //     'name' => 'Users',
        //     'icon' => 'fa fa-users',
        //     'link' => url('user'),
        //     'page' => 'user',
        //     'dropdown' => false,
        // ],
        [
            'name' => 'Banners',
            'icon' => 'fa fa-info',
            'link' => '#',
            'page' => '',
            'dropdown' => [['name' => 'All Banners', 'link' => url('banner'), 'page' => 'banner'], ['name' => 'Add Banner', 'link' => url('banner/create'), 'page' => 'banner/create']],
        ],
        [
            'name' => 'Category',
            'icon' => 'fa fa-info',
            'link' => '#',
            'page' => '',
            'dropdown' => [['name' => 'All Category', 'link' => url('category'), 'page' => 'category'], ['name' => 'Add Category', 'link' => url('category/create'), 'page' => 'category/create']],
        ],
        [
            'name' => 'Brand',
            'icon' => 'fa fa-info',
            'link' => '#',
            'page' => '',
            'dropdown' => [['name' => 'All Brands', 'link' => url('brand'), 'page' => 'brand'], ['name' => 'Add Brand', 'link' => url('brand/create'), 'page' => 'brand/create']],
        ],
        // [
        //     'name' => 'Sub Category',
        //     'icon' => 'fa fa-info',
        //     'link' => '#',
        //     'page' => '',
        //     'dropdown' => [
        //         ['name' => 'All Sub Category', 'link' => url('sub-category'), 'page' => 'sub-category'],
        //         [
        //             'name' => 'Add Sub Category',
        //             'link' => url('sub-category/create'),
        //             'page' => 'sub-category/create',
        //         ],
        //     ],
        // ],
        // [
        //     'name' => 'Coupon',
        //     'icon' => 'fa fa-info',
        //     'link' => '#',
        //     'page' => '',
        //     'dropdown' => [['name' => 'All Coupon', 'link' => url('coupon'), 'page' => 'coupon'], ['name' => 'Add Coupon', 'link' => url('coupon/create'), 'page' => 'coupon/create']],
        // ],
        [
            'name' => 'Blogs',
            'icon' => 'fa fa-file',
            'link' => '#',
            'page' => '',
            'dropdown' => [['name' => 'All Blogs', 'link' => url('blog'), 'page' => 'blog'], ['name' => 'Add Blog', 'link' => url('blog/create'), 'page' => 'blog/create']],
        ],
        [
            'name' => 'Products',
            'icon' => 'fa fa-file',
            'link' => '#',
            'page' => '',
            'dropdown' => [['name' => 'All Products', 'link' => url('product'), 'page' => 'product'], ['name' => 'Add Product', 'link' => url('product/create'), 'page' => 'product/create']],
        ],
        // [
        //     'name' => 'Orders',
        //     'icon' => 'fa fa-file',
        //     'link' => url('orders'),
        //     'page' => 'orders',
        //     'dropdown' => false,
        // ],
    ];
@endphp
@include('layout/sidebar', $menus)
