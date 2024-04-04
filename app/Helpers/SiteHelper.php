<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiteHelper
{
    static $Currency = 'PKR';
    static $Decimals = 0;

    public static function settings()
    {
        $Settings = array();
        $Settings['PrimaryColor'] = '#C71738';
        $Settings['SecondaryColor'] = '#e6e6e6';
        $Settings['SiteUrl'] = '';
        $Settings['Instagram'] = '';
        $Settings['Facebook'] = '';
        $Settings['LinkedIn'] = '';
        $Settings['Twitter'] = '';
        $Settings['WhatsAppNumber'] = '+923281011019';
        return $Settings;
    }

    static function CalculatePrice($Price)
    {
        return SiteHelper::$Currency . ' ' . number_format($Price, SiteHelper::$Decimals);
    }

    static function CalculatePriceWithoutCurrency($Price, $Discount)
    {
        if ($Discount != 0) {
            $NewPrice = $Price - ($Price * floatval($Discount)) / 100;
            return $NewPrice;
        } else {
            return $Price;
        }
    }

    static function GetProductsCountByBrand($Brand = 0)
    {
        $Count = 0;
        if ($Brand == 0) {
            $Count = DB::table('products')
                ->where('deleted_at', '=', null)
                ->count();
        } else {
            $Count = DB::table('products')
                ->where('products.brand', '=', $Brand)
                ->where('deleted_at', '=', null)
                ->count();
        }
        return $Count;
    }

    static function GetCurrency()
    {
        return SiteHelper::$Currency;
    }

    static function GetUserList()
    {
        $List = array();
        if (Auth::check()) {
            $UserId = Auth::id();
            $WishList = DB::table('wish_lists')
                ->where('user_id', '=', $UserId)
                ->get();
            foreach ($WishList as $list) {
                $List[] = $list->product_id;
            }
            return $List;
        } else {
            return $List;
        }
    }

    static function CalculateShippingCost($Quantity)
    {
        $Settings = DB::table('general_settings')
            ->get();
        $ShippingQuantity = $Settings[0]->shipping_quantity;
        if (floatval($ShippingQuantity) == 0 || $ShippingQuantity == '') {
            $ShippingQuantity = 1;
        }
        $ShippingCost = $Settings[0]->shipping_cost;
        if ($ShippingCost == '' || floatval($ShippingCost) == 0) {
            $ShippingCost = 0;
        }
        $Count = ceil(floatval($Quantity) / floatval($ShippingQuantity));
        return floatval($ShippingCost) * $Count;
    }

    static function CalculateInstallationCost($Price, $Quantity)
    {
        return floatval($Price) * floatval($Quantity);
    }

    static function CalculateGSTCost($Price, $Quantity)
    {
        return floatval($Price) * floatval($Quantity);
    }

    static function CalculateDiscountCost($Price, $Quantity)
    {
        return floatval($Price) * floatval($Quantity);
    }

    // static function getproductid($productid){
    //     $data = DB::table('products')->where('id','=', $productid)->get();
    //     $code = $data[0]->code;
    //     return  $code;
    // }

    static function GetTreeTitleFromType($Type)
    {
        if($Type == "home-appliances-in-pakistan") {
            return "Large Appliances";
        } elseif($Type == "small-appliances") {
            return "Small Appliances";
        } else {
            return "Commercial Appliances";
        }
    }

    static function GetCategoryFromId($Id)
    {
        return DB::table('categories')
            ->where('id', '=', $Id)
            ->get();
    }

    static function GetSubCategoryFromId($Id)
    {
        return DB::table('subcategories')
            ->where('id', '=', $Id)
            ->get();
    }

    static function GetSubSubCategoryFromId($Id)
    {
        return DB::table('sub_subcategories')
            ->where('id', '=', $Id)
            ->get();
    }

    static function GetProductTemplate($product, $index, $index1, $List)
    {
        /* route('CheckSlugRoute', ['slug' => $product->slug]) */
        return '<div class="product-card-difference my-3">
            <a href="' . route('home.slug', ['slug1' => $product->slug]) . '">
                <div class="product-category-square text-center">' .
                    (($product->rating != null && $product->rating != 0) ? '<span class="product-category-square-rating"><i class="fa fa-star text-warning"></i>&nbsp;' . $product->rating . '</span>' : '') .
                    (floatval($product->discount) != 0 ? '<span class="product-category-square-discount bg-custom-primary text-white">' . $product->discount . '% OFF</span>' : '') .
                    '<div class="product-category-square-img">
                        <img src="' . asset('public/storage/products/' . $product->primary_img) . '" alt="Phones" class="img-fluid">
                    </div>
                    <p class="mb-2 px-2 fs-13 fw-500 primary-color">' . $product->name . '</p>
                    <p class="mb-2 px-2 text-black fs-13 fw-500">' . $product->code . '</p>
                    <div class="product-description">' . $product->short_description . '</div>
                    <div class="mx-2 fs-12">
                        <p class="text-start mb-0">' .
                            ($product->quantity > 0 ? '<i class="fa fa-circle text-success"></i>&nbsp;In stock' : '<i class="fa fa-circle text-danger"></i>&nbsp;Stock out') .
                            '<span class="text-end text-black fw-500 float-end">' . SiteHelper::CalculatePrice($product->total_price) . '</span>
                        </p>' .
                        (floatval($product->discount) != 0 ? '<p class="my-1 fs-11 text-decoration-line-through text-end">'. SiteHelper::CalculatePrice($product->total_price_without_discount) . '</p>' : '<p class="my-1 fs-11 text-end">&nbsp;</p>') .
                    '</div>
                    <div class="product-category-square-bottom" onclick="return event.preventDefault();">
                        <div class="row fs-12">
                            <div class="col-6 text-center py-2 px-2 product-category-square-btn border-right"
                                 id="addToCartDiv_' . $index . $index1 . '" style="display: none; cursor: not-allowed;">
                                Adding...
                            </div>
                            <div class="col-6 text-center py-2 px-2 product-category-square-btn border-right cursor-pointer"
                                 onclick="AddToCart(this, \'' . $product->id . '\', \'' . $index . $index1 . '\');">
                                Add to cart
                            </div>
                            <div class="col-6 text-center py-2 px-2 product-category-square-btn cursor-pointer ' . ((in_array($product->id, $List)) ? 'bg-custom-primary text-white' : '') . '" onclick="AddToWishlist(\'Please login first to add product in your list.\', \''. $product->id . '\', this);">' .
                                ((in_array($product->id, $List)) ? 'Wishlisted' : 'Wishlist') .
                            '</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>';
    }

    static function GetPageContent($pageName)
    {
        return DB::table('general_pages')
            ->where('page_name', $pageName)
            ->first();
    }

    static function CheckPromotionVisibility($type)
    {
        $settings = DB::table('general_settings')->first();
        if ($type == 'Promotion'){
            if ($settings->promotion == 1){
                return true;
            }
        } else if ($type == 'Pay Latter'){
            if ($settings->pay_latter == 1){
                return true;
            }
        }
        return false;
    }
}
