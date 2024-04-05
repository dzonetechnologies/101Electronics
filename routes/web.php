<?php

use App\Http\Controllers\PromotionsController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\SlugController;
use \App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SubcategoriesController;
use App\Http\Controllers\SubSubcategoriesController;
use App\Http\Controllers\InstantController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\DiscountVoucherController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SaleReportController;

//Command Routes
Route::get('clear-cache', function () {
    Artisan::call('storage:link');
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    //Create storage link on hosting
    $exitCode = Artisan::call('storage:link', []);
    echo $exitCode; // 0 exit code for no errors.
});
Route::get('/link', function () {
    Artisan::call('storage:link');
});

/* Front Website Routes*/
Route::get('/', [HomeController::class, 'index'])->name('HomeRoute');
Route::post('/compare/subSubCategories', [HomeController::class, 'GetSubSubCategories'])->name('CompareRoute.subSubCategories');
Route::post('/compare/runtime', [HomeController::class, 'compareRunTime'])->name('CompareRunTimeRoute');
Route::get('/care-repair', [HomeController::class, 'CareRepair'])->name('CareRepairRoute');
Route::post('/care/table/load', [HomeController::class, 'CareRepairTableLoad'])->name('CareRepairTableLoadRoute');
Route::get('/orders-n-collect', [HomeController::class, 'OrdersCollect'])->name('OrdersCollectRoute');
Route::get('/stores', [HomeController::class, 'Stores'])->name('StoresRoute');
Route::get('/return-and-cancellations', [HomeController::class, 'ReturnCancellations'])->name('ReturnCancellationsRoute');
Route::get('/ways-to-pay', [HomeController::class, 'WaysToPay'])->name('WaysToPayRoute');
Route::get('/delivery-installation', [HomeController::class, 'DeliveryOptions'])->name('DeliveryOptionsRoute');
Route::get('/price-promise', [HomeController::class, 'PricePromise'])->name('PricePromiseRoute');
Route::get('/installment-guide', [HomeController::class, 'InstallmentGuide'])->name('InstallmentGuideRoute');
Route::get('/installation-guide', [HomeController::class, 'InstallationGuide'])->name('InstallationGuideRoute');
Route::get('/privacy-policy', [HomeController::class, 'PrivacyPolicy'])->name('PrivacyPolicyRoute');
Route::get('/terms-conditions', [HomeController::class, 'TermsConditions'])->name('TermsConditionsRoute');
Route::get('/contact-us', [HomeController::class, 'ContactUs'])->name('ContactUsRoute');
Route::get('/discount-voucher', [HomeController::class, 'DiscountVoucher'])->name('DiscountVoucherRoute');
Route::get('/about-us', [HomeController::class, 'AboutUs'])->name('AboutUsRoute');
Route::get('/track-your-order', [HomeController::class, 'trackOrder'])->name('track.order');
Route::post('/track-order/invoiceNo', [HomeController::class, 'trackOrderHtml'])->name('track.order.invoiceNo');
Route::post('/search-product', [HomeController::class, 'searchproduct'])->name('searchproduct');
Route::post('/search-product-m', [HomeController::class, 'searchproductm'])->name('searchproductm');
Route::post('/returnRequest', [HomeController::class, 'returnRequest'])->name('returnForm');
Route::post('/customer/reviews/store', [HomeController::class, 'customerReviewsStore'])->name('customer.reviews.store');
Route::post('/customer/reviews/delete', [HomeController::class, 'customerReviewsDelete'])->name('customer.reviews.delete');
Route::get('/b2b', [HomeController::class, 'b2b'])->name('B2BRoute');
Route::get('/b2b/deals/{type}', [HomeController::class, 'b2bDeals'])->name('B2BRoute.deals');
Route::post('/b2b/get-a-quote', [HomeController::class, 'b2bForm'])->name('b2bForm');
Route::post('/product/subcategory/load', [HomeController::class, 'loadProductSubCategory'])->name('product.subcategory.load');
Route::post('/subcategory/product/load', [HomeController::class, 'loadSubCategoryProduct'])->name('subcategory.product.load');
Route::get('/clearance-sale', [HomeController::class, 'clearanceSale'])->name('clearanceSale');

/*Wishlist Routes*/
Route::post('/add-to-wishlist', [HomeController::class, 'AddToWishlist'])->name('AddToWishList');
Route::post('/wishlist/count', [HomeController::class, 'WishlistCount'])->name('WishListCount');

/*Contact us email Routes*/
Route::post('/contact_email',[HomeController::class,'send_email'])->name('send_email');
Route::get('/contact',[HomeController::class,'contact'])->name('contact');


/*Cart Routes*/
Route::get('cart', [CartController::class, 'index'])->name('CartRoute');
Route::post('add-to-cart', [CartController::class, 'addToCart'])->name('add.to.cart');
Route::post('remove-from-cart', [CartController::class, 'removeFromCart'])->name('remove.from.cart');
Route::post('cart-modal-html', [CartController::class, 'LoadCartModalHtml'])->name('cart.modal.html');
Route::post('cart-page-html', [CartController::class, 'LoadCartPageHtml'])->name('cart.page.html');
Route::post('cart-quantity-update', [CartController::class, 'CartQuantityUpdate'])->name('cart.quantity.update');
Route::post('/cart/count', [CartController::class, 'CartCount'])->name('CartCount');
Route::get('read-cart', [CartController::class, 'readCart'])->name('read.cart');
/*Cart Routes*/

/*Checkout Routes*/
Route::get('checkout', [CheckoutController::class, 'index'])->name('CheckoutRoute');
Route::post('checkout-page-html', [CheckoutController::class, 'LoadCheckoutPageHtml'])->name('checkout.page.html');
Route::post('checkout/check', [CheckoutController::class, 'StockCheckAndCalculateOrder'])->name('checkout.check');
Route::post('checkout/order', [CheckoutController::class, 'SaveOrder'])->name('checkout.order');
Route::get('checkout/order/complete', [CheckoutController::class, 'OrderComplete'])->name('checkout.order.complete');
/*Checkout Routes*/

/*Discount Code*/
Route::post('apply-discount-code', [CheckoutController::class, 'ApplyDiscountCode'])->name('apply.discount.code');
/*Discount Code*/

/*Account Page*/
Route::get('/account', [DashboardController::class, 'accountPage'])->name('home.account');
Route::post('/account/address/update', [DashboardController::class, 'updateAddress'])->name('home.account.address.update');
Route::post('/account/details/update', [DashboardController::class, 'updateDetails'])->name('home.account.details.update');
Route::post('/account/orders/all', [DashboardController::class, 'loadOrders'])->name('home.account.orders.all');

//SOCIAL LOGINS-START
// Google login
Route::get(  'login/google', [App\Http\Controllers\Auth\RegisterController::class, 'redirectToGoogle'])->name('Login.google');
Route::get( 'google/callback', [App\Http\Controllers\Auth\RegisterController::class, 'handleGoogleCallback']);

//Facebook
Route::get(  'login/facebook', [App\Http\Controllers\Auth\RegisterController::class, 'redirectToFacebook'])->name('Login.facebook');
Route::get( 'facebook/callback', [App\Http\Controllers\Auth\RegisterController::class, 'handleFacebookCallback']);
//SOCIAL LOGIN-END

//social share route
Route::get('social-share', [HomeController::class, 'product']);

/*Dashboard Routes*/
Auth::routes();
Route::get('/logout', [App\Http\Controllers\DashboardController::class, 'logout'])->name('user.logout');
Route::middleware(['admin_validator'])->group(function (){
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Brands
    Route::get('brands', [BrandsController::class, 'index'])->name('brands');
    Route::get('brands/create', [BrandsController::class, 'create'])->name('brands.add');
    Route::post('brands/store', [BrandsController::class, 'store'])->name('brands.store');
    Route::post('brands/load', [BrandsController::class, 'load'])->name('brands.load');
    Route::get('brands/edit/{brandId}', [BrandsController::class, 'edit'])->name('brands.edit');
    Route::post('brands/update', [BrandsController::class, 'update'])->name('brands.update');
    Route::post('brands/delete', [BrandsController::class, 'delete'])->name('brands.delete');
    Route::post('brands/order/up', [BrandsController::class, 'orderUp'])->name('brands.order.up');
    Route::post('brands/order/down', [BrandsController::class, 'orderDown'])->name('brands.order.down');
    Route::post('category/brand', [BrandsController::class, 'loadCategoryBrand'])->name('category.brand');
    Route::post('subcategory/brand', [BrandsController::class, 'loadSubCategoryBrand'])->name('subcategory.brand');
    Route::post('subcategory/multiple/brand', [BrandsController::class, 'loadMultipleSubCategoryBrand'])->name('subcategory.multiple.brand');
    Route::post('sub-subcategory/brand', [BrandsController::class, 'loadSubSubCategoryBrand'])->name('sub-subcategory.brand');

    // Categories
    Route::get('categories', [CategoriesController::class, 'index'])->name('categories');
    Route::get('categories/create', [CategoriesController::class, 'create'])->name('categories.add');
    Route::post('categories/store', [CategoriesController::class, 'store'])->name('categories.store');
    Route::post('categories/load', [CategoriesController::class, 'load'])->name('categories.load');
    Route::get('categories/edit/{CategoryId}', [CategoriesController::class, 'edit'])->name('categories.edit');
    Route::post('categories/update', [CategoriesController::class, 'update'])->name('categories.update');
    Route::post('categories/delete', [CategoriesController::class, 'delete'])->name('categories.delete');
    Route::post('categories/order/up', [CategoriesController::class, 'orderUp'])->name('categories.order.up');
    Route::post('categories/order/down', [CategoriesController::class, 'orderDown'])->name('categories.order.down');

    // SubCategories
    Route::get('subcategories', [SubcategoriesController::class, 'index'])->name('subcategories');
    Route::get('subcategories/create', [SubcategoriesController::class, 'create'])->name('subcategories.add');
    Route::post('subcategories/store', [SubcategoriesController::class, 'store'])->name('subcategories.store');
    Route::post('subcategories/load', [SubcategoriesController::class, 'load'])->name('subcategories.load');
    Route::get('subcategories/edit/{SubCategoryId}', [SubcategoriesController::class, 'edit'])->name('subcategories.edit');
    Route::post('subcategories/update', [SubcategoriesController::class, 'update'])->name('subcategories.update');
    Route::post('subcategories/delete', [SubcategoriesController::class, 'delete'])->name('subcategories.delete');
    Route::post('subcategories/order/up', [SubcategoriesController::class, 'orderUp'])->name('subcategories.order.up');
    Route::post('subcategories/order/down', [SubcategoriesController::class, 'orderDown'])->name('subcategories.order.down');

    // SubCategories
    Route::get('sub-subcategories', [SubSubcategoriesController::class, 'index'])->name('sub_subcategories');
    Route::get('sub-subcategories/create', [SubSubcategoriesController::class, 'create'])->name('sub_subcategories.add');
    Route::post('sub-subcategories/store', [SubSubcategoriesController::class, 'store'])->name('sub_subcategories.store');
    Route::post('sub-subcategories/load', [SubSubcategoriesController::class, 'load'])->name('sub_subcategories.load');
    Route::get('sub-subcategories/edit/{CategoryId}', [SubSubcategoriesController::class, 'edit'])->name('sub_subcategories.edit');
    Route::post('sub-subcategories/update', [SubSubcategoriesController::class, 'update'])->name('sub_subcategories.update');
    Route::post('sub-subcategories/delete', [SubSubcategoriesController::class, 'delete'])->name('sub_subcategories.delete');
    Route::post('sub-subcategories/order/up', [SubSubcategoriesController::class, 'orderUp'])->name('sub_subcategories.order.up');
    Route::post('sub-subcategories/order/down', [SubSubcategoriesController::class, 'orderDown'])->name('sub_subcategories.order.down');

    // Instant Calculator
    Route::get('instantcalculator', [InstantController::class, 'index'])->name('instantcalculator');
    Route::get('instantcalculator/create', [InstantController::class, 'create'])->name('instantcalculator.add');
    Route::post('instantcalculator/store', [InstantController::class, 'store'])->name('instantcalculator.store');
    Route::post('instantcalculator/load', [InstantController::class, 'load'])->name('instantcalculator.load');
    Route::get('instantcalculator/edit', [InstantController::class, 'edit'])->name('instantcalculator.edit');
    Route::post('instantcalculator/update', [InstantController::class, 'update'])->name('instantcalculator.update');

    // Attributes - Color
    Route::get('color', [AttributeController::class, 'index'])->name('color');
    Route::post('color/load', [AttributeController::class, 'load'])->name('color.load');
    Route::get('color/edit', [AttributeController::class, 'edit'])->name('color.edit');
    Route::post('color/update', [AttributeController::class, 'update'])->name('color.update');

    // Attributes - Unit
    Route::get('unit', [AttributeController::class, 'unit'])->name('unit');
    Route::post('unit/load', [AttributeController::class, 'loadUnits'])->name('unit.load');
    Route::get('unit/edit', [AttributeController::class, 'editUnit'])->name('unit.edit');
    Route::post('unit/update', [AttributeController::class, 'updateUnit'])->name('unit.update');

    // Product
    Route::get('product', [ProductController::class, 'index'])->name('product');
    Route::get('product/create', [ProductController::class, 'create'])->name('product.add');
    Route::post('product/store', [ProductController::class, 'store'])->name('product.store');
    Route::post('product/load', [ProductController::class, 'load'])->name('product.load');
    Route::get('product/details/edit/{ProductId}', [ProductController::class, 'editDetails'])->name('product.edit.details');
    Route::post('product/details/update', [ProductController::class, 'updateDetails'])->name('product.details.update');
    Route::get('product/edit/{ProductId}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('product/update', [ProductController::class, 'update'])->name('product.update');
    Route::post('product/delete', [ProductController::class, 'delete'])->name('product.delete');
    Route::post('product/duplicate', [ProductController::class, 'duplicate'])->name('product.duplicate');
    Route::post('product/order/up', [ProductController::class, 'orderUp'])->name('product.order.up');
    Route::post('product/order/down', [ProductController::class, 'orderDown'])->name('product.order.down');
    Route::post('product/homepagestatus/update', [ProductController::class, 'updateHomepageStatus'])->name('product.homepagestatus.update');

    // Common Routes
    Route::post('category/subcategories', [HomeController::class, 'GetSubcategoriesFromCategory'])->name('category.subcategories');
    Route::post('subcategory/sub-subcategories', [HomeController::class, 'GetSubSubcategoriesFromSubCategory'])->name('subcategory.sub-subcategories');

    // Slug Checking
    Route::post('brand/title-duplicate-check', [BrandsController::class, 'titleDuplicationCheck'])->name('brand.title-duplicate-check');

    // Slider
    Route::get('sliders', [SliderController::class, 'index'])->name('sliders');
    Route::get('slider/create', [SliderController::class, 'create'])->name('slider.add');
    Route::post('slider/store', [SliderController::class, 'store'])->name('slider.store');
    Route::post('slider/load', [SliderController::class, 'load'])->name('slider.load');
    Route::get('slider/edit/{SliderId}', [SliderController::class, 'edit'])->name('slider.edit');
    Route::post('slider/update', [SliderController::class, 'update'])->name('slider.update');
    Route::post('slider/delete', [SliderController::class, 'delete'])->name('slider.delete');
    Route::post('slider/order/up', [SliderController::class, 'orderUp'])->name('slider.order.up');
    Route::post('slider/order/down', [SliderController::class, 'orderDown'])->name('slider.order.down');

    // Setting
    Route::get('settings', [GeneralSettingController::class, 'index'])->name('settings');
    Route::post('settings/update', [GeneralSettingController::class, 'update'])->name('settings.update');

    // Pages
    Route::get('settings/pages', [GeneralSettingController::class, 'pages'])->name('settings.pages');
    Route::get('settings/pages/{PageId}', [GeneralSettingController::class, 'editPage'])->name('settings.pages.edit');
    Route::post('settings/pages/update', [GeneralSettingController::class, 'updatePage'])->name('settings.pages.update');

    //About-Us
    Route::get('settings/aboutUs', [GeneralSettingController::class, 'AboutUs'])->name('settings.AboutUs');
    Route::post('settings/aboutUs/update', [GeneralSettingController::class, 'AboutUpdate'])->name('settings.AboutUs.update');

    //Care & Repair
    Route::get('care-repair/index', [GeneralSettingController::class, 'careRepair'])->name('CareRepair.index');
    Route::post('care-repair/index/update', [GeneralSettingController::class, 'updateCareRepair'])->name('CareRepair.index.update');
    Route::get('care-repair/faq', [GeneralSettingController::class, 'Faq'])->name('CareRepair.faq');
    Route::post('car-repair/faq/update', [GeneralSettingController::class, 'updateFaq'])->name('CareRepair.faq.update');
    Route::get('care-repair/offers', [GeneralSettingController::class, 'Offers'])->name('CareRepair.offers');
    Route::post('care-repair/offers/update', [GeneralSettingController::class, 'updateOffer'])->name('CareRepair.offers.update');
    Route::get('care-repair/pricing', [GeneralSettingController::class, 'pricing'])->name('CareRepair.pricing');
    Route::post('care-repair/pricing/update', [GeneralSettingController::class, 'pricingUpdate'])->name('CareRepair.pricing.update');
    Route::get('care-repair/service-charges', [GeneralSettingController::class, 'serviceCharges'])->name('CareRepair.serviceCharges');
    Route::post('care-repair/service-charges/update', [GeneralSettingController::class, 'serviceChargesUpdate'])->name('CareRepair.serviceCharges.update');
    Route::post('care-repair/rate-list/update', [GeneralSettingController::class, 'rateListUpdate'])->name('CareRepair.rateList.update');

    // Page Banners
    Route::get('settings/banners', [GeneralSettingController::class, 'banners'])->name('settings.banners');
    Route::get('settings/banners/{PageId}', [GeneralSettingController::class, 'editPageBanner'])->name('settings.banners.edit');
    Route::post('settings/banners/update', [GeneralSettingController::class, 'updatePageBanner'])->name('settings.banners.update');

    //Size and Packaging
    Route::get('size-packaging', [GeneralSettingController::class, 'sizePackaging'])->name('settings.SizePackagingRoute');
    Route::get('size-packaging/{CategoryId}', [GeneralSettingController::class, 'editSizePackagingImage'])->name('settings.size-packaging.edit');
    Route::post('size-packaging/update', [GeneralSettingController::class, 'updateSizePackagingImage'])->name('settings.size-packaging.update');

    // Discount Voucher
    Route::get('discountvouchers', [DiscountVoucherController::class, 'index'])->name('discountvouchers');
    Route::get('discountvouchers/create', [DiscountVoucherController::class, 'create'])->name('discountvouchers.add');
    Route::post('discountvouchers/store', [DiscountVoucherController::class, 'store'])->name('discountvouchers.store');
    Route::post('discountvouchers/load', [DiscountVoucherController::class, 'load'])->name('discountvouchers.load');
    Route::get('discountvouchers/edit/{SliderId}', [DiscountVoucherController::class, 'edit'])->name('discountvouchers.edit');
    Route::post('discountvouchers/update', [DiscountVoucherController::class, 'update'])->name('discountvouchers.update');
    Route::post('discountvouchers/delete', [DiscountVoucherController::class, 'delete'])->name('discountvouchers.delete');
    Route::post('discountvouchers/order/up', [DiscountVoucherController::class, 'orderUp'])->name('discountvouchers.order.up');
    Route::post('discountvouchers/order/down', [DiscountVoucherController::class, 'orderDown'])->name('discountvouchers.order.down');
    Route::post('discountvouchers/status/update', [DiscountVoucherController::class, 'updateVoucherStatus'])->name('discountvouchers.status.update');

    /* Orders */
    Route::get('orders', [DashboardController::class, 'adminOrders'])->name('orders');
    Route::get('orders/details/{Id}', [DashboardController::class, 'adminOrderDetails'])->name('orders.details');
    Route::post('orders/load', [DashboardController::class, 'adminOrdersLoad'])->name('orders.load');
    Route::post('orders/update/status', [DashboardController::class, 'adminOrderUpdateStatus'])->name('orders.update.status');
    Route::post('orders/delete', [DashboardController::class, 'adminOrderDelete'])->name('orders.delete');

    //Return Requests
    Route::get('return-request', [DashboardController::class, 'ReturnRequest'])->name('return-request');
    Route::post('return-request/all',[DashboardController::class, 'ReturnRequestLoad'])->name('returnRequest.load');
    Route::get('return-request/view/{RequestId}', [DashboardController::class, 'viewRequest'])->name('request.view');
    Route::post('return-request/action',[DashboardController::class, 'requestAction'])->name('request.action');
    Route::post('return-request/delete', [DashboardController::class, 'returnRequestDelete'])->name('returnRequest.delete');

    //Quote-Request
    Route::get('quote-request', [DashboardController::class, 'QuoteRequest'])->name('quote-request');
    Route::post('quote-request/all',[DashboardController::class, 'QuoteRequestLoad'])->name('quoteRequest.load');
    Route::get('quote-request/view/{QuoteId}', [DashboardController::class, 'viewQuoteRequest'])->name('quote.view');
    Route::post('quote-request/delete', [DashboardController::class, 'quoteRequestDelete'])->name('quoteRequest.delete');
    Route::post('quote-request/action',[DashboardController::class, 'quoteRequestAction'])->name('quoteRequest.action');

    //Discount-Questions
    Route::get('discount-questions/create', [DashboardController::class, 'discountQuestioncreate'])->name('discountQuestion.add');
    Route::post('discount-questions/store', [DashboardController::class, 'discountQuestionstore'])->name('discountQuestion.store');
    Route::post('discount-questions/code', [DashboardController::class, 'discountCode'])->name('discount.code');

    //Sales Report
    Route::get('sale-report',[SaleReportController::class,'index'])->name('sale-report');
    Route::post('sale-report/filter',[SaleReportController::class, 'FilterSaleReport'])->name('sale-report.filter');
    Route::get('sale-report/export/excel/{startDate}/{endDate}/{status}/{product}', [SaleReportController::class, 'ExportExcelSaleReport'])->name('sale-report.export.excel');

    // Promotions
    Route::get('promotions', [PromotionsController::class, 'index'])->name('promotions');
    Route::get('promotions/create', [PromotionsController::class, 'create'])->name('promotions.add');
    Route::post('promotions/store', [PromotionsController::class, 'store'])->name('promotions.store');
    Route::post('promotions/load', [PromotionsController::class, 'load'])->name('promotions.load');
    Route::get('promotions/edit/{brandId}', [PromotionsController::class, 'edit'])->name('promotions.edit');
    Route::post('promotions/update', [PromotionsController::class, 'update'])->name('promotions.update');
    Route::post('promotions/delete', [PromotionsController::class, 'delete'])->name('promotions.delete');

    //Profile Routes
    Route::get('dashboard/profile', [DashboardController::class, 'profileIndex'])->name('profile');
    Route::post('dashboard/update-account', [DashboardController::class, 'UpdateAccount'])->name('update.account');
});

// Front website Slug Routes
Route::get('/deals/{slug}', [SlugController::class, 'brandDeals'])->name('home.brands.deals');
Route::get('/compare/{slug}', [SlugController::class, 'compare'])->name('CompareRoute');
Route::get('/{slug1}/{slug2?}/{slug3?}', [SlugController::class, 'index'])->name('home.slug');
/*Route::get('/{slug}', [HomeController::class, 'checkSlug'])->name('CheckSlugRoute');
Route::get('/{categoryslug}/{subcategoryslug}/{subsubcategoryslug}', [HomeController::class, 'checkSubSubCategorySlug'])->name('CheckSubSubCategorySlugRoute');*/
