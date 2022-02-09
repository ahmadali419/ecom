<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Middleware\HasPermission;

Auth::routes();
Route::get('/test', [Controllers\TestController::class, 'index'])->name('test');
Route::get('/costomerlogout', [Controllers\TestController::class, 'costomerlogout'])->name('costomerlogout');
Route::get('/logout', [Controllers\TestController::class, 'logout'])->name('logout');
Auth::routes(['register' => true]);

Route::get('/login', [Controllers\Auth\LoginController::class, 'storeLogin'])->name('login');
Route::prefix('admin')->group(function () {
    Route::get('/login', [Controllers\Auth\LoginController::class, 'adminLogin'])->name('adminLogin');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [Controllers\HomeController::class, 'index'])->name('home');
    Route::prefix('admin')->group(function () {
        Route::prefix('categories')->group(function () {
            Route::get('/', [Controllers\CategoryController::class, 'index'])->name('categoryList')->middleware('haspermission:viewCategory');
            Route::post('/list', [Controllers\CategoryController::class, 'getList'])->name('getCategoryList');
            Route::post('/submit', [Controllers\CategoryController::class, 'store'])->name('categorySubmit')->middleware('haspermission:addCategory');
            Route::post('/edit', [Controllers\CategoryController::class, 'getCategoryById'])->name('getCategoryById')->middleware('haspermission:editCategory');
            Route::post('/delete', [Controllers\CategoryController::class, 'destroy'])->name('categoryDelete')->middleware('haspermission:deleteCategory');
            Route::post('get-category-products', [Controllers\CategoryController::class, 'getProductByCategory'])->name('getProductsByCategory');
        });
        Route::prefix('contract')->group(function () {
            Route::get('/', [Controllers\ContractController::class, 'index'])->name('contractList')->middleware('haspermission:viewContract');
            Route::post('/list', [Controllers\ContractController::class, 'getList'])->name('getContractList')->middleware('haspermission:viewContract');
            Route::get('/create', [Controllers\ContractController::class, 'create'])->name('createContract')->middleware('haspermission:addContract');
            Route::post('/submit', [Controllers\ContractController::class, 'store'])->name('contractSubmit')->middleware('haspermission:addContract');
            Route::get('/edit/{id}', [Controllers\ContractController::class, 'getContractById'])->name('getContractById')->middleware('haspermission:editContract');
            Route::post('/Update', [Controllers\ContractController::class, 'updateContract'])->name('contractUpdate')->middleware('haspermission:editContract');
            Route::post('/assignedlist/{id}', [Controllers\ContractController::class, 'getProductAssignedList'])->name('contractAssignedList')->middleware('haspermission:viewContract');
            Route::post('/delete', [Controllers\ContractController::class, 'destroy'])->name('contractDelete')->middleware('haspermission:deleteContract');
            Route::post('/Remove', [Controllers\ContractController::class, 'contractRemove'])->name('contractRemove')->middleware('haspermission:deleteContract');
            Route::post('/Saved', [Controllers\ContractController::class, 'contractSaved'])->name('contractSaved')->middleware('haspermission:addContract');
        });
        Route::prefix('store')->group(function () {
            Route::get('/', [Controllers\StoreController::class, 'index'])->name('storeList')->middleware('haspermission:viewStore');
            Route::post('/list', [Controllers\StoreController::class, 'getList'])->name('getStoreList')->middleware('haspermission:viewStore');
            Route::post('/submit', [Controllers\StoreController::class, 'store'])->name('storeSubmit')->middleware('haspermission:addStore');
            Route::post('/edit', [Controllers\StoreController::class, 'getStoreById'])->name('getStoreById')->middleware('haspermission:editStore');
            Route::post('/delete', [Controllers\StoreController::class, 'destroy'])->name('storeDelete')->middleware('haspermission:deleteStore');
            Route::get('/product', [Controllers\StoreController::class, 'getProduct'])->name('storeProduct')->middleware('haspermission:storeProduct');
            Route::post('/productlist', [Controllers\StoreController::class, 'getProductList'])->name('storeProductList')->middleware('haspermission:storeProduct');
            Route::get('/product/pricing', [Controllers\StoreController::class, 'productPricing'])->name('storeProductPricing')->middleware('haspermission:storeProduct');
            Route::post('/product/store', [Controllers\StoreController::class, 'StoreProductSellingPrice'])->name('StoreProductSellingPrice')->middleware('haspermission:storeProduct');
        });
        Route::prefix('color')->group(function () {
            Route::get('/', [Controllers\ColorController::class, 'index'])->name('colorList')->middleware('haspermission:viewColor');
            Route::post('/list', [Controllers\ColorController::class, 'getList'])->name('getColorList')->middleware('haspermission:viewColor');
            Route::post('/submit', [Controllers\ColorController::class, 'store'])->name('colorSubmit')->middleware('haspermission:addColor');
            Route::post('/edit', [Controllers\ColorController::class, 'getColorById'])->name('getColorById')->middleware('haspermission:editColor');
            Route::post('/delete', [Controllers\ColorController::class, 'destroy'])->name('colorDelete')->middleware('haspermission:deleteColor');

        });
        Route::prefix('charge')->group(function () {
            Route::get('/', [Controllers\ChargeController::class, 'index'])->name('chargesList')->middleware('haspermission:viewCharge');
            Route::post('/list', [Controllers\ChargeController::class, 'getList'])->name('getChargeList')->middleware('haspermission:viewCharge');
            Route::post('/submit', [Controllers\ChargeController::class, 'store'])->name('chargeSubmit')->middleware('haspermission:addCharge');
            Route::post('/edit', [Controllers\ChargeController::class, 'getChargeById'])->name('getChargeById')->middleware('haspermission:editCharge');
            Route::post('/delete', [Controllers\ChargeController::class, 'destroy'])->name('chargeDelete')->middleware('haspermission:deleteCharge');
        });
        Route::prefix('products')->group(function () {
            Route::post('getAllProducts', [Controllers\ProductController::class, 'getAllProducts'])->name('allProduct')->middleware('haspermission:viewProduct');
            Route::get('/new', [Controllers\ProductController::class, 'create'])->name('productNew')->middleware('haspermission:addProduct');
            Route::post('/submit', [Controllers\ProductController::class, 'store'])->name('productSubmit')->middleware('haspermission:addProduct');
            Route::get('/', [Controllers\ProductController::class, 'index'])->name('productList')->middleware('haspermission:viewProduct');
            Route::post('/list', [Controllers\ProductController::class, 'getList'])->name('getProductLists')->middleware('haspermission:viewProduct');
            Route::get('editProduct/{id}', [Controllers\ProductController::class, 'edit'])->name('product.edit')->middleware('haspermission:editProduct');
            Route::post('/delete', [Controllers\ProductController::class, 'destroy'])->name('productDelete')->middleware('haspermission:deleteProduct');
            Route::post('/remove', [Controllers\ProductController::class, 'removeImage'])->name('removeImage');
            Route::get('previewProduct/{id}', [Controllers\ProductController::class, 'previewProduct'])->name('product.preview');
            Route::post('product-min-max-prices', [Controllers\ProductController::class, 'getBandMinMaxPrices'])->name('product.prices');
        });
        Route::prefix('permission')->group(function () {
            Route::get('/', [Controllers\PermissionController::class, 'index'])->name('permissionList')->middleware('haspermission:viewPermission');
            Route::post('/list', [Controllers\PermissionController::class, 'getList'])->name('getPermissionList');
            Route::post('/submit', [Controllers\PermissionController::class, 'store'])->name('permissionSubmit')->middleware('haspermission:addPermission');
            Route::post('/edit', [Controllers\PermissionController::class, 'getPermissionById'])->name('getPermissionById')->middleware('haspermission:editPermission');
            Route::post('/delete', [Controllers\PermissionController::class, 'destroy'])->name('permissionDelete')->middleware('haspermission:deletePermission');
            Route::post('/get', [Controllers\PermissionController::class, 'getPermissionByRoleId'])->name('getPermissionByRoleId')->middleware('haspermission:viewPermission');
        });
        Route::prefix('role')->group(function () {
            Route::get('/', [Controllers\RoleController::class, 'index'])->name('roleList')->middleware('haspermission:viewRole');
            Route::post('/list', [Controllers\RoleController::class, 'getList'])->name('getRoleList')->middleware('haspermission:viewRole');
            Route::post('/submit', [Controllers\RoleController::class, 'store'])->name('roleSubmit')->middleware('haspermission:addRole');
            Route::post('/edit', [Controllers\RoleController::class, 'getRoleById'])->name('getRoleById')->middleware('haspermission:editRole');
            Route::post('/delete', [Controllers\RoleController::class, 'destroy'])->name('roleDelete')->middleware('haspermission:deleteRole');
            Route::post('/permission', [Controllers\RoleController::class, 'rolePermissions'])->name('rolePermissions')->middleware('haspermission:assignPermissionRole');
            Route::post('/assign/permission', [Controllers\RoleController::class, 'assignPermissions'])->name('assignPermissions')->middleware('haspermission:assignPermissionRole');
        });
        Route::prefix('users')->group(function () {
            Route::get('/', [Controllers\UserController::class, 'index'])->name('userList')->middleware('haspermission:viewUser');
            Route::post('/list', [Controllers\UserController::class, 'getList'])->name('getUserList')->middleware('haspermission:viewUser');
            Route::post('/submit', [Controllers\UserController::class, 'store'])->name('userSubmit')->middleware('haspermission:viewUser');
            Route::post('/edit', [Controllers\UserController::class, 'getUserById'])->name('getUserById')->middleware('haspermission:editUser');
            Route::post('/delete', [Controllers\UserController::class, 'destroy'])->name('userDelete')->middleware('haspermission:deleteUser');
            Route::post('update', [Controllers\UserController::class, 'updateProfile'])->name('updateProfile');
            Route::get('/profile', [Controllers\UserController::class, 'EdituserProfile'])->name('userProfile');
            Route::post('/password', [Controllers\UserController::class, 'PasswordUpdate'])->name('userPassword');
        });
        Route::prefix('store')->group(function () {
            Route::get('setting/{id}', [Controllers\StoreSettingController::class, 'index'])->name('setting.index')->middleware('haspermission:viewStoreSetting');
            Route::post('siteinfo', [Controllers\StoreSettingController::class, 'siteInfo'])->name('setting.siteinfo')->middleware('haspermission:viewStoreSiteInfo');
            Route::post('socialinfo', [Controllers\StoreSettingController::class, 'socialInfo'])->name('setting.socialinfo')->middleware('haspermission:viewStoreSocialInfo');
            Route::post('addressInfo', [Controllers\StoreSettingController::class, 'addressInfo'])->name('setting.addressInfo')->middleware('haspermission:viewStoreAddressInfo');
            Route::post('pannelInfo', [Controllers\StoreSettingController::class, 'pannelInfo'])->name('setting.panelInfo')->middleware('haspermission:viewStorePannelInfo');
            Route::post('sitepages', [Controllers\StoreSettingController::class, 'sitepages'])->name('setting.sitepages')->middleware('haspermission:viewStorePannelInfo');
            Route::post('sitetheme', [Controllers\StoreSettingController::class, 'sitetheme'])->name('setting.sitetheme')->middleware('haspermission:viewStorePannelInfo');
            Route::post('/remove', [Controllers\StoreSettingController::class, 'removeCoverImage'])->name('removeCoverImage');
        });
        Route::prefix('tag')->group(function () {
            Route::get('/', [Controllers\TagController::class, 'index'])->name('tagList')->middleware('haspermission:viewTag');
            Route::post('/list', [Controllers\TagController::class, 'getList'])->name('getTagList')->middleware('haspermission:viewTag');
            Route::post('/submit', [Controllers\TagController::class, 'store'])->name('tagSubmit')->middleware('haspermission:addTag');
            Route::post('/edit', [Controllers\TagController::class, 'getTagById'])->name('getTagById')->middleware('haspermission:editTag');
            Route::post('/delete', [Controllers\TagController::class, 'destroy'])->name('tagDelete')->middleware('haspermission:deleteTag');
        });
        Route::prefix('band')->group(function () {
            Route::get('/', [Controllers\BandController::class, 'index'])->name('bandList')->middleware('haspermission:viewBand');
            Route::post('/list', [Controllers\BandController::class, 'getList'])->name('getBandList')->middleware('haspermission:viewBand');
            Route::get('/add', [Controllers\BandController::class, 'add'])->name('bandAdd')->middleware('haspermission:addBand');
            Route::post('/submit', [Controllers\BandController::class, 'store'])->name('bandSubmit')->middleware('haspermission:addBand');
            Route::get('/edit/{id}', [Controllers\BandController::class, 'getBandById'])->name('getBandById')->middleware('haspermission:editBand');
            Route::post('/delete', [Controllers\BandController::class, 'destroy'])->name('bandDelete')->middleware('haspermission:deleteBand');
        });
        Route::prefix('order')->group(function () {
            Route::get('/', [Controllers\OrderController::class, 'index'])->name('orderList')->middleware('haspermission:viewOrder');
            Route::post('/list', [Controllers\OrderController::class, 'getList'])->name('getOrderList')->middleware('haspermission:viewOrder');
            Route::get('/detail/{id}', [Controllers\OrderItemController::class, 'detailProduct'])->name('detailProduct')->middleware('haspermission:orderDetail');
            Route::post('/delete', [Controllers\OrderController::class, 'destroy'])->name('orderDelete')->middleware('haspermission:deleteOrder');
            Route::post('/Update', [Controllers\OrderController::class, 'orderUpdate'])->name('orderUpdate')->middleware('haspermission:updateOrder');
            Route::post('filterStatus', [Controllers\OrderController::class, 'filterStatus'])->name('filterStatus');
        });
        Route::prefix('customer')->group(function () {
            Route::get('/', [Controllers\CustomerController::class, 'index'])->name('customerList');
            Route::post('/list', [Controllers\CustomerController::class, 'getList'])->name('getCustomerList');
            Route::get('nonregistered', [Controllers\CustomerController::class, 'nonRegisterCustomer'])->name('nonRegister');
            Route::post('/nonlist', [Controllers\CustomerController::class, 'nonCustomer'])->name('nonCustomer');
            Route::get('/orderList/{id}', [Controllers\CustomerController::class, 'customerOrders'])->name('customerOrders');
            Route::post('userOrder', [Controllers\CustomerController::class, 'userOrdersList'])->name('getUserOrderList');
        });
    });
    Route::prefix('storeproductpricstoree')->group(function () {
        Route::post('/pricing', [Controllers\StoreProductPricingMappingController::class, 'getStoreProductPrice'])->name('getStoreProductPrice');
        Route::post('/submit', [Controllers\StoreProductPricingMappingController::class, 'storeProductPricing'])->name('storeproductpricesubmit');
        Route::post('/update', [Controllers\StoreProductPricingMappingController::class, 'updateStoreSingleProductPrice'])->name('updateStoreSingleProductPrice');
    });

       // this space for order submit fome front side
        Route::prefix('store/{slug?}')->group(function () {
            Route::get('/account', [Controllers\UserController::class, 'userProfile'])->name('userAccount');
            Route::get('/wishlist', [Controllers\WishListController::class, 'index'])->name('userWhishList');
        });
        Route::prefix('whishlist')->group(function () {
            Route::post('addWhish', [Controllers\WishListController::class, 'store'])->name('addWhishList');
            Route::post('removeWish', [Controllers\WishListController::class, 'destroy'])->name('removeWishList');
        });
    });

    Route::middleware(['XSS'])->namespace('Web')->group(function () {
        Route::get('/', [Controllers\HomeController::class, 'homePage'])->name('welcome');
        Route::prefix('category')->group(function () {
            Route::get('{id}', [Controllers\CategoryController::class, 'getProductByCategory'])->name('getProductByCategory');
            Route::post('get-cat-products', [Controllers\CategoryController::class, 'getProductByCat'])->name('getProductByCat');
        });
        Route::prefix('color')->group(function () {
            Route::get('{id}', [Controllers\ColorController::class, 'getProductByColor'])->name('getProductByColor');
        });
        Route::prefix('tag')->group(function () {
            Route::get('{id}', [Controllers\TagController::class, 'getProductByTag'])->name('getProductByTag');
        });
    });
    Route::prefix('product')->group(function () {
        Route::get('color/{id?}', [Controllers\StoreController::class, 'storeProductColor'])->name('store.color.product');
       // Route::get('/categorie/{id?}', [Controllers\StoreController::class, 'storeProduct'])->name('store.categorie.product');
        Route::get('/tag/{id?}', [Controllers\StoreController::class, 'storeProductTag'])->name('store.tag.product');
        Route::get('product-lists', [Controllers\StoreController::class, 'storeProductPagniate'])->name('storeProductPagniate');
        Route::post('/product_quote/{id?}', [Controllers\StoreController::class, 'storeProductQuote'])->name('store.produt.quote');
        Route::post('/product_detail/{id?}', [Controllers\StoreController::class, 'storeProductShow'])->name('store.produt.show');
    });
Route::prefix('store')->group(function () {
    Route::prefix('product')->group(function () {
    });
    Route::get('/', [Controllers\StoreController::class, 'storeSlug'])->name('store.slug');
    Route::get('/categorie/{id?}', [Controllers\StoreController::class, 'storeProduct'])->name('store.categorie.product');

    //Route::get('/tag/{id?}', [Controllers\StoreController::class, 'storeProductTag'])->name('store.tag.product');
    Route::get('/product/{id?}', [Controllers\StoreController::class, 'storeProductDetail'])->name('store.product.detail');
    // Route::post('/product_quote/{id?}', [Controllers\StoreController::class, 'storeProductQuote'])->name('store.produt.quote');
    //Route::post('/product_detail/{id?}', [Controllers\StoreController::class, 'storeProductShow'])->name('store.produt.show');
    Route::get('/checkout', [Controllers\StoreController::class, 'cartCheckout'])->name('cart.checkout');
    Route::get('/{id}', [Controllers\StoreController::class, 'storePages'])->name('store.page');
});
Route::prefix('order')->group(function () {
    Route::post('submit-order', [Controllers\OrderController::class, 'storeOrder'])->name('confirmOrder');
    Route::post('user-payment', [Controllers\OrderController::class, 'payment'])->name('userpayment')->middleware(['XSS']);
});
Route::post('add-quantity-item', [Controllers\StoreController::class, 'quantityCart'])->name('user.addCartQuantity');
Route::post('add-to-cart/{slug?}/{id?}', [Controllers\StoreController::class, 'addToCart'])->name('user.addToCart');
Route::post('store-to-cart', [Controllers\StoreController::class, 'getStoreCart'])->name('user.storeCart');
Route::post('remove-cart-item', [Controllers\StoreController::class, 'removesCartItem'])->name('user.removesCartItem');
Route::get('store-to-cart/{slug?}', [Controllers\StoreController::class, 'viewCart'])->name('user.viewCart');
Route::post('paymentVerify', [Controllers\OrderController::class, 'verifyPayment'])->name('verifyPayment');
