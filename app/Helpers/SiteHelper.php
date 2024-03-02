<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiteHelper
{
    static $Currency = 'PKR';
    static $Decimals = 2;

    public static function settings()
    {
        $Settings = array();
        $Settings['PrimaryColor'] = '#C71738';
        $Settings['SecondaryColor'] = '#e6e6e6';
        $Settings['SiteUrl'] = './';
        $Settings['Instagram'] = 'https://www.instagram.com/signvox/';
        $Settings['Facebook'] = 'https://www.facebook.com/SignvoxOnlineSignage';
        $Settings['LinkedIn'] = 'https://www.linkedin.com/company/signvox-pty-ltd/';
        $Settings['Twitter'] = './';
        $Settings['SiteUrl'] = 'https://new.roxenimmigration.com/';
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
}