<?php

namespace App\Http\Controllers;

use App\Helpers\SiteHelper;
use App\Models\Brands;
use App\Models\Categories;
use App\Models\Product;
use App\Models\SubSubcategories;
use Illuminate\Support\Facades\DB;

class SlugController extends Controller
{
    function index($Slug1, $Slug2 = null, $Slug3 = null)
    {
        $Brand = Brands::query()
            ->where("slug2", "=", $Slug1)
            ->where("deleted_at", "=", null)
            ->first();
        if(isset($Brand->id)) {
            return $this->brand($Slug1);
        }
        $Product = Product::query()
            ->where("slug", "=", $Slug1)
            ->where("deleted_at", "=", null)
            ->first();
        if(isset($Product->id)) {
            return $this->product($Slug1);
        }
        if($Slug2 != "" && $Slug3 != "") {
            $_SubSubCategory = DB::table('sub_subcategories')
                ->where('slug2', '=', $Slug3)
                ->where('deleted_at', '=', null)
                ->first();
            if(isset($_SubSubCategory->id)) {
                return $this->subSubcategory($Slug1, $Slug2, $Slug3);
            }
        } elseif($Slug2 != "") {
            $_SubCategory = DB::table('subcategories')
                ->where('slug2', '=', $Slug2)
                ->where('deleted_at', '=', null)
                ->first();
            if(isset($_SubCategory->id)) {
                return $this->subcategory($Slug1, $Slug2);
            }
        } else {
            $_Category = Categories::query()
                ->where("slug2", "=", $Slug1)
                ->where("deleted_at", "=", null)
                ->first();
            if(isset($_Category->id)) {
                return $this->category($Slug1);
            }
        }
        abort(404);
        exit();
    }

    function brand($slug)
    {
        $Brand = DB::table('brands')
            ->where('slug2', '=', $slug)
            ->where('deleted_at', '=', null)
            ->get();
        $Title = $Brand[0]->meta_title;
        $Description = $Brand[0]->description;

        // get brand categories
        $CategorySql = "SELECT * FROM categories WHERE ((FIND_IN_SET(:brandId, brand) > 0)) AND ISNULL(deleted_at);";
        $Categories = DB::select(DB::raw($CategorySql), array($Brand[0]->id));

        return view('site.brand', compact('Brand', 'Categories', 'Title', 'Description'));
    }

    function product($slug)
    {
        $Product = DB::table('products')
            ->leftJoin('brands', 'products.brand', '=', 'brands.id')
            ->where('products.slug', '=', $slug)
            ->where('products.deleted_at',null)
            ->select('products.*', 'brands.title AS BrandTitle', 'brands.image AS BrandImage')
            ->get();
        if (sizeof($Product) == 0) {
            return redirect()->route('HomeRoute');
        }
        $Title = $Product[0]->meta_title;
        $Description = $Product[0]->meta_desc;
        $ProductGalleryImages = DB::table('product_galleries')
            ->where('product_id', '=', $Product[0]->id)
            ->get();
        $ProductColors = DB::table('product_colors')
            ->leftJoin('colors', 'product_colors.color_id', '=', 'colors.id')
            ->where('product_colors.product_id', '=', $Product[0]->id)
            ->select('product_colors.*', 'colors.name AS ColorName', 'colors.code AS ColorCode')
            ->get();
        $ProductSizes = DB::table('product_sizes')
            ->leftJoin('units', 'product_sizes.unit_id', '=', 'units.id')
            ->where('product_id', '=', $Product[0]->id)
            ->select('product_sizes.*', 'units.name AS UnitName')
            ->get();
        $ProductDetails = DB::table('product_details')
            ->where("product_id", "=", $Product[0]->id)
            ->where("deleted_at", "=", null)
            ->first();
        // Delivery Options, Return Cancellations, Discount Voucher Pages Details
        $GeneralPages = DB::table('general_pages')
            ->whereIn('id', array(2, 4, 6, 10))
            ->get();
        // Discount Voucher Details
        $DiscountVouchers = DB::table('discount_vouchers')
            ->where('deleted_at', null)
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->whereDate('start_date', '<=', date("Y-m-d"))
            ->whereDate('end_date', '>=', date("Y-m-d"))
            ->get();
        // Size and Packaging Dimension Image
        $SizePackagingDetails = DB::table('size_packaging_images')
            ->where('category', $Product[0]->category)
            ->get();
        //social share buttons code
        $shareButtons = \Share::page('https://localhost/101Electronics/'.$slug)
            ->facebook()
            ->twitter()
            ->linkedin()
            ->whatsapp();
        $DiscountQuestions = DB::table('discount_questions')
            ->where('deleted_at',null)
            ->get();
        return view('site.product-details', compact('Product', 'ProductGalleryImages', 'ProductSizes', 'ProductDetails', 'Title', 'Description', 'GeneralPages', 'DiscountVouchers', 'SizePackagingDetails','shareButtons','DiscountQuestions', 'ProductColors'));
    }

    function subSubcategory($Slug1, $Slug2, $Slug3)
    {
        $Category = DB::table('categories')
            ->where('slug', '=', $Slug1)
            ->where('deleted_at', '=', null)
            ->get();
        $SubCategories = DB::table('subcategories')
            ->where('slug', '=', $Slug2)
            ->where('deleted_at', '=', null)
            ->get();
        $SubSubCategories = SubSubcategories::query()
            ->where('slug2', '=', $Slug3)
            ->where('deleted_at', '=', null)
            ->get();
        $SubSubCategoryId = null;
        $SubSubCategoryName = null;
        $Title = null;
        $Description = null;
        if (count($SubSubCategories) > 0) {
            $SubSubCategoryId = $SubSubCategories[0]->id;
            $SubSubCategoryName = $SubSubCategories[0]->title;
            $Title = $SubSubCategories[0]->meta_title;
            $Description = $SubSubCategories[0]->description;
        }
        return view('site.deals', compact('Category', 'SubCategories', 'SubSubCategories', 'Slug2', 'SubSubCategoryId', 'SubSubCategoryName', 'Title', 'Description'));
    }

    function subcategory($Slug1, $Slug2)
    {
        $_SubCategory = DB::table('subcategories')
            ->where('slug2', '=', $Slug2)
            ->where('deleted_at', '=', null)
            ->get();
        $SubCategory = $_SubCategory;
        $SubCategoryId = $SubCategory[0]->id;
        $Title = $SubCategory[0]->meta_title;
        $Description = $SubCategory[0]->description;
        $Category = DB::table('categories')
            ->where('id', '=', $SubCategory[0]->category)
            ->where('deleted_at', '=', null)
            ->get();
        $SubCategories = DB::table('subcategories')
            ->where('category', '=', $Category[0]->id)
            ->where('deleted_at', '=', null)
            ->orderBy('order_no', 'ASC')
            ->get();
        $SubSubCategories = DB::table('sub_subcategories')
            ->join('subcategories', 'sub_subcategories.subcategory', '=', 'subcategories.id')
            ->where('sub_subcategories.category', '=', $Category[0]->id)
            ->where('sub_subcategories.deleted_at', '=', null)
            ->whereRaw('FIND_IN_SET(?, subcategory) > 0', [$SubCategory[0]->id])
            ->select('sub_subcategories.*', 'subcategories.slug AS SubCatSlug', 'subcategories.slug2 AS SubCatSlug2')
            ->orderBy('sub_subcategories.order_no', 'ASC')
            ->get();
        /*$SubSubcategorySql = "SELECT * FROM sub_subcategories WHERE ((FIND_IN_SET(:subCategoryId, subcategory) > 0) AND category = :categoryId) AND ISNULL(deleted_at) ORDER BY order_no ASC;";
        $SubSubCategories = DB::select(DB::raw($SubSubcategorySql), array($SubCategory[0]->id, $Category[0]->id));*/
        $SubCategorySlug = $Slug2;
        return view('site.category', compact('Category', 'SubCategories', 'SubSubCategories', 'SubCategoryId', 'Title', 'Description', 'SubCategorySlug'));
    }

    function category($Slug1)
    {
        $Category = DB::table('categories')
            ->where('slug2', '=', $Slug1)
            ->where('deleted_at', '=', null)
            ->get();
        $Title = $Category[0]->meta_title;
        $Description = $Category[0]->description;
        $SubCategoryId = "";
        $SubCategories = DB::table('subcategories')
            ->where('category', '=', $Category[0]->id)
            ->where('deleted_at', '=', null)
            ->orderBy('order_no', 'ASC')
            ->get();
        $SubSubCategories = DB::table('sub_subcategories')
            ->join('subcategories', 'sub_subcategories.subcategory', '=', 'subcategories.id')
            ->where('sub_subcategories.category', '=', $Category[0]->id)
            ->where('sub_subcategories.deleted_at', '=', null)
            ->select('sub_subcategories.*', 'subcategories.slug AS SubCatSlug', 'subcategories.slug2 AS SubCatSlug2')
            ->orderBy('sub_subcategories.order_no', 'ASC')
            ->get();
        $SubCategorySlug = "all";
        return view('site.category', compact('Category', 'SubCategories', 'SubSubCategories', 'SubCategoryId', 'Title','Slug1', 'Description', 'SubCategorySlug'));
    }

    function brandDeals($slug)
    {
        $Category = DB::table('categories')
            ->where('slug2', '=', $slug)
            ->where('deleted_at', '=', null)
            ->get();
        $PageDetails = DB::table('general_pages')
            ->where('id', '=', 18)
            ->get();
        if (count($Category) > 0) {
            $Products = DB::table('products')
                ->where('deleted_at', null)
                ->where('category', '=', $Category[0]->id)
                ->orderBy('sub_subcategory', 'ASC')
                ->orderBy('order_no', 'ASC')
                ->get();
            return view('site.category-deals', compact('Category', 'Products', 'PageDetails'));
        } else {
            return abort(404);
        }
    }

    function compare($slug)
    {
        $Category = Categories::with(['subCategories' => function($subQuery){
            $subQuery->where("deleted_at", "=", null);
            $subQuery->orderBy("order_no", "asc");
        }])
            ->where("slug2", "=", $slug)
            ->where("deleted_at", "=", null)
            ->get();
        if(!isset($Category[0]->id)) {
            abort(404);
            exit();
        }
        $SubCategoryId = $Category[0]->subCategories[0]->id;
        /*echo '<pre>';
        echo print_r($Category[0]->subCategories);
        echo '</pre>';
        exit();*/
        $SubSubCategories = DB::table('sub_subcategories')
            ->join('subcategories', 'sub_subcategories.subcategory', '=', 'subcategories.id')
            ->where('sub_subcategories.subcategory', '=', $SubCategoryId)
            ->where('sub_subcategories.deleted_at', '=', null)
            ->select('sub_subcategories.*', 'subcategories.slug AS SubCatSlug', 'subcategories.slug2 AS SubCatSlug2')
            ->orderBy('sub_subcategories.order_no', 'ASC')
            ->get();
        $StartPrice = 1;
        $EndPrice = 1000000;
        $Brands = DB::table('brands')
            ->where('deleted_at', '=', null)
            ->whereIn('id', explode(',', $Category[0]->brand))
            ->orderBy('order_no', 'ASC')
            ->get();
        if ($slug == 'buy-tv-online-Pakistan') {
            $Content = SiteHelper::GetPageContent('Compare LED TV In Pakistan TV');
        } else if ($slug == 'best-ac-in-pakistan') {
            $Content = SiteHelper::GetPageContent('Compare Air Conditioner');
        } else if ($slug == 'washing-machine-price-in-pakistan') {
            $Content = SiteHelper::GetPageContent('Compare Fully Automatic Washing Machine');
        } else if ($slug == 'refrigerator-price-in-pakistan') {
            $Content = SiteHelper::GetPageContent('Compare Refrigerator');
        } else if ($slug == 'dishwasher-price-in-pakistan') {
            $Content = SiteHelper::GetPageContent('Compare Dishwasher');
        } else if ($slug == 'kitchen-appliances-in-pakistan') {
            $Content = SiteHelper::GetPageContent('Compare Kitchen Appliances');
        } else if ($slug == 'small-domestic-appliances') {
            $Content = SiteHelper::GetPageContent('Compare Home Small Domestic Appliances');
        } else if ($slug == 'coffee-machine-price-in-pakistan') {
            $Content = SiteHelper::GetPageContent('Compare Coffee Machine');
        }
        $Title = !empty($Content) ? $Content->meta_title : env('APP_NAME');
        $Description = !empty($Content) ? $Content->meta_description : env('META_DESCRIPTION');
        return view('site.compare', compact('Title', 'Description', 'Category', 'SubSubCategories', 'SubCategoryId', 'slug', 'Brands', 'StartPrice', 'EndPrice'));



        /*$SelectedSubCategory = isset($_GET['sub']) ? $_GET['sub'] : 0;
        $SelectedSubSubCategory = isset($_GET['subSub']) ? $_GET['subSub'] : '';
        $SelectedRange = isset($_GET['range']) ? $_GET['range'] : 0;
        $SelectedBrands = isset($_GET['brands']) ? $_GET['brands'] : '';*/
        /*$SubCategoryId = "";*/
        /*$SubCategories = DB::table('subcategories')
            ->where('category', '=', $Category[0]->id)
            ->where('deleted_at', '=', null)
            ->orderBy('order_no', 'ASC')
            ->get();*/

        /*$SubSubCategories = null;*/

        /*Sub Sub Category*/
        /*$SubSubCategoryCondition = "";
        $__SubSubCategories = null;
        if ($SelectedSubSubCategory != '') {
            $SelectedSubSubCategory = implode(',', json_decode(base64_decode($SelectedSubSubCategory)));
            $SubSubCategoryCondition = " AND id IN ($SelectedSubSubCategory) ";
        }

        if ($SelectedSubCategory != '') {
            if (intval($SelectedSubCategory) != 0) {
                $SubSubcategorySql = "SELECT * FROM sub_subcategories WHERE ((FIND_IN_SET(:subCategoryId, subcategory) > 0) AND category = :categoryId) $SubSubCategoryCondition AND ISNULL(deleted_at) ORDER BY order_no ASC;";
                $SubSubCategories = DB::select(DB::raw($SubSubcategorySql), array($SelectedSubCategory, $Category[0]->id));

                $__SubSubCategories = DB::table('sub_subcategories')
                    ->whereRaw('FIND_IN_SET(?, subcategory) > 0', array($SelectedSubCategory))
                    ->where('deleted_at', '=', null)
                    ->orderBy('order_no', 'ASC')
                    ->get();
            } else {
                $SubSubCategories = DB::table('sub_subcategories')
                    ->where(function ($query) use ($Category, $SelectedSubSubCategory) {
                        if ($SelectedSubSubCategory != '') {
                            $query->whereIn('sub_subcategories.id', json_decode(base64_decode($SelectedSubSubCategory)));
                        }
                        $query->where('category', '=', $Category[0]->id);
                        $query->where('deleted_at', '=', null);
                    })
                    ->orderBy('order_no', 'ASC')
                    ->get();
            }
        } else {
            $SubSubCategories = DB::table('sub_subcategories')
                ->where(function ($query) use ($Category, $SelectedSubSubCategory) {
                    if ($SelectedSubSubCategory != '') {
                        $query->whereIn('sub_subcategories.id', json_decode($SelectedSubSubCategory));
                    }
                    $query->where('category', '=', $Category[0]->id);
                    $query->where('deleted_at', '=', null);
                })
                ->orderBy('order_no', 'ASC')
                ->get();
        }
        $StartPrice = 0;
        $EndPrice = 0;
        if ($SelectedRange != 0) {
            $StartPrice = explode('_', $SelectedRange)[0];
            $EndPrice = explode('_', $SelectedRange)[1];
        }
        $PriceRange = DB::table('price_ranges')
            ->get();
        $Brands = DB::table('brands')
            ->where('deleted_at', '=', null)
            ->whereIn('id', explode(',', $Category[0]->brand))
            ->orderBy('order_no', 'ASC')
            ->get();
        if ($slug == 'buy-tv-online-Pakistan') {
            $Content = SiteHelper::GetPageContent('Compare LED TV In Pakistan TV');
        } else if ($slug == 'best-ac-in-pakistan') {
            $Content = SiteHelper::GetPageContent('Compare Air Conditioner');
        } else if ($slug == 'washing-machine-price-in-pakistan') {
            $Content = SiteHelper::GetPageContent('Compare Fully Automatic Washing Machine');
        } else if ($slug == 'refrigerator-price-in-pakistan') {
            $Content = SiteHelper::GetPageContent('Compare Refrigerator');
        } else if ($slug == 'dishwasher-price-in-pakistan') {
            $Content = SiteHelper::GetPageContent('Compare Dishwasher');
        } else if ($slug == 'kitchen-appliances-in-pakistan') {
            $Content = SiteHelper::GetPageContent('Compare Kitchen Appliances');
        } else if ($slug == 'small-domestic-appliances') {
            $Content = SiteHelper::GetPageContent('Compare Home Small Domestic Appliances');
        } else if ($slug == 'coffee-machine-price-in-pakistan') {
            $Content = SiteHelper::GetPageContent('Compare Coffee Machine');
        }
        $Title = !empty($Content) ? $Content->meta_title : env('APP_NAME');
        $Description = !empty($Content) ? $Content->meta_description : env('META_DESCRIPTION');
        return view('site.compare', compact('Title', 'Description', 'Category', 'SubSubCategories', 'SubCategoryId', 'slug', 'SelectedSubCategory', 'SelectedRange', 'SelectedBrands', 'PriceRange', 'Brands', 'StartPrice', 'EndPrice', 'SelectedSubSubCategory', '__SubSubCategories'));*/
        /* SubCategories */
    }
}
