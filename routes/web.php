<?php

use App\Helpers\Api;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Middleware\NoAuth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashboardContoller;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductBulkPriceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VariationController;
use App\Http\Middleware\Auth;



Route::middleware([NoAuth::class])->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name("login");
    Route::post('/action_login', [AuthController::class, 'action_login'])->name("auth");
});
Route::middleware([Auth::class])->group(function () {
    Route::get('/logout', function (Request $request) {
        $request->session()->forget(Api::AUTH_KEY);
        return redirect()->route('login');
    });
    Route::get('/dashboard', [DashboardContoller::class, 'index'])->name("dashboard");
    Route::get('/profile', [DashboardContoller::class, 'profile'])->name("profile");
    Route::post('/update-profile', [DashboardContoller::class, 'update_profile'])->name("profile.update");

    // Users
    Route::get("/user", [UserController::class, 'index'])->name("user.list");
    Route::get("/user/fetch", [UserController::class, 'fetchUser'])->name("user.fetch");

    // Categories
    Route::get("/category", [CategoryController::class, 'index'])->name("category.list");
    Route::get("/category/fetch", [CategoryController::class, 'fetchCategory'])->name("category.fetch");
    Route::get("/category/create", [CategoryController::class, 'create'])->name("category.create");
    Route::post("/category/store", [CategoryController::class, 'store'])->name("category.store");
    Route::get("/category/{id}/edit", [CategoryController::class, 'edit'])->name("category.edit");
    Route::post("/category/{id}/update", [CategoryController::class, 'update'])->name("category.update");
    Route::delete("/category/{id}/delete", [CategoryController::class, 'delete'])->name("category.delete");

    // Brands
    Route::get("/brand", [BrandController::class, 'index'])->name("brand.list");
    Route::get("/brand/fetch", [BrandController::class, 'fetchBrand'])->name("brand.fetch");
    Route::get("/brand/create", [BrandController::class, 'create'])->name("brand.create");
    Route::post("/brand/store", [BrandController::class, 'store'])->name("brand.store");
    Route::get("/brand/{id}/edit", [BrandController::class, 'edit'])->name("brand.edit");
    Route::post("/brand/{id}/update", [BrandController::class, 'update'])->name("brand.update");
    Route::delete("/brand/{id}/delete", [BrandController::class, 'delete'])->name("brand.delete");

    // Sub Categories
    Route::get("/sub-category", [SubCategoryController::class, 'index'])->name("subCategory.list");
    Route::get("/sub-category/fetch", [SubCategoryController::class, 'fetchSubCategory'])->name("subCategory.fetch");
    Route::get("/sub-category/create", [SubCategoryController::class, 'create'])->name("subCategory.create");
    Route::post("/sub-category/store", [SubCategoryController::class, 'store'])->name("subCategory.store");
    Route::get("/sub-category/{id}/edit", [SubCategoryController::class, 'edit'])->name("subCategory.edit");
    Route::post("/sub-category/{id}/update", [SubCategoryController::class, 'update'])->name("subCategory.update");
    Route::delete("/sub-category/{id}/delete", [SubCategoryController::class, 'delete'])->name("subCategory.delete");
    Route::delete('/sub-category/{id}/delete-file', [SubCategoryController::class, 'deleteFile'])->name("subCategory.deleteFile");

    // Coupon
    Route::get("/coupon", [CouponController::class, 'index'])->name("coupon.list");
    Route::get("/coupon/fetch", [CouponController::class, 'fetchCategory'])->name("coupon.fetch");
    Route::get("/coupon/create", [CouponController::class, 'create'])->name("coupon.create");
    Route::post("/coupon/store", [CouponController::class, 'store'])->name("coupon.store");
    Route::get("/coupon/{id}/edit", [CouponController::class, 'edit'])->name("coupon.edit");
    Route::post("/coupon/{id}/update", [CouponController::class, 'update'])->name("coupon.update");
    Route::delete("/coupon/{id}/delete", [CouponController::class, 'delete'])->name("coupon.delete");

    //  Blogs
    Route::get('/blog', [BlogController::class, 'index'])->name("blog.list");
    Route::get('/blog/create', [BlogController::class, 'create'])->name("blog.create");
    Route::post('/blog/store', [BlogController::class, 'store'])->name("blog.store");
    Route::post('/blog/upload', [BlogController::class, 'upl        oadBlogs'])->name("blog.upload");
    Route::delete('/blog/{id}/delete-file', [BlogController::class, 'deleteBlogFile'])->name("blog.deleteFile");
    Route::get('/blog/{id}/edit', [BlogController::class, 'edit'])->name("blog.edit");
    Route::post('/blog/{id}/update', [BlogController::class, 'update'])->name("blog.update");
    Route::delete('/blog/{id}/delete', [BlogController::class, 'delete'])->name("blog.delete");
    Route::get('/blog/fetch-blogs', [BlogController::class, 'fetchBlogs'])->name("blog.fetch");


    // Upload File
    Route::post('/admin/upload', [UploadController::class, 'uploadFile'])->name("upload");

    // Products
    Route::get("/product", [ProductController::class, 'index'])->name("product.list");
    Route::get("/product/fetch", [ProductController::class, 'fetchProducts'])->name("product.fetch");
    Route::get("/product/create", [ProductController::class, 'create'])->name("product.create");
    Route::post("/product/store", [ProductController::class, 'store'])->name("product.store");
    Route::get("/product/{id}/edit", [ProductController::class, 'edit'])->name("product.edit");
    Route::post("/product/{id}/update", [ProductController::class, 'update'])->name("product.update");
    Route::delete("/product/{id}/delete", [ProductController::class, 'delete'])->name("product.delete");

    // Bulk Price
    Route::get("/product/{pid}/bulk-price", [ProductBulkPriceController::class, 'index'])->name("bulk-price.list");
    Route::get("/product/{pid}/bulk-price/fetch", [ProductBulkPriceController::class, 'fetchProductBulkPrice'])->name("bulk-price.fetch");
    Route::get("/product/{pid}/bulk-price/form", [ProductBulkPriceController::class, 'form'])->name("bulk-price.form");
    Route::post("/product/{pid}/bulk-price/store", [ProductBulkPriceController::class, 'store'])->name("bulk-price.store");
    Route::get("/product/{pid}/bulk-price/{id}/edit", [ProductBulkPriceController::class, 'edit'])->name("bulk-price.edit");
    Route::post("/product/{pid}/bulk-price/{id}/update", [ProductBulkPriceController::class, 'update'])->name("bulk-price.update");
    Route::delete("/product/bulk-price/{id}/delete", [ProductBulkPriceController::class, 'delete'])->name("bulk-price.delete");

    // orders
    Route::get("/orders", [OrderController::class, 'index'])->name("order.list");
    Route::get("/orders/fetch", [OrderController::class, 'fetchOrders'])->name("order.fetch");
    Route::get("/orders/{id}/detail", [OrderController::class, 'detail'])->name("order.detail");
    Route::post("/orders/{id}/update", [OrderController::class, 'update'])->name("order.update");
    Route::get('/orders/{id}/invoice', [OrderController::class, 'orderPrint'])->name("order.print");
    Route::post("/orders/{id}/updateShipping", [OrderController::class, 'updateShipping'])->name("order.updateShipping");
});

Route::post('/dropzone', function () {
    echo 'dropzone';
});
