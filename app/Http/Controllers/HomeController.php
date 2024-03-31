<?php

namespace App\Http\Controllers;

use App\Helpers\SiteHelper;
use App\Models\b2bRequest;
use App\Models\CustomerReviews;
use App\Models\ReturnRequests;
use App\Models\WishList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index()
    {
        $Content = SiteHelper::GetPageContent('Home Page');
        $Title = !empty($Content) ? $Content->meta_title : env('APP_NAME');
        $Description = !empty($Content) ? $Content->meta_description : env('META_DESCRIPTION');
        return view('site.index', compact('Title', 'Description'));
    }

    function GetSubcategoriesFromCategory(Request $request)
    {
        $Subcategories = DB::table('subcategories')
            ->where('category', '=', $request->post('Category'))
            ->where('deleted_at', '=', null)
            ->get();
        echo json_encode($Subcategories);
        exit();
    }

    function GetSubSubcategoriesFromSubCategory(Request $request)
    {
        $SubSubcategorySql = "SELECT * FROM sub_subcategories WHERE ((FIND_IN_SET(:subCategoryId, subcategory) > 0) AND category = :categoryId) AND ISNULL(deleted_at);";
        $SubSubcategories = DB::select(DB::raw($SubSubcategorySql), array($request->post('SubCategory'), $request->post('Category')));
        echo json_encode($SubSubcategories);
        exit();
    }

    function compareRunTime(Request $request)
    {
        $SelectedSubCategory = $request['SubCategory'];
        $SelectedSubSubCategory = json_decode($request['SubSubCategories']);
        $SelectedBrands = json_decode($request['Brands']);
        $StartPrice = $request['StartPrice'];
        $EndPrice = $request['EndPrice'];
        $FilterType = $request['FilterType'];
        $slug = $request['slug'];
        if ($StartPrice == "") {
            $StartPrice = 0;
        }
        if ($EndPrice == "") {
            $EndPrice = 0;
        }
        $Category = DB::table('categories')
            ->where('slug2', '=', $slug)
            ->where('deleted_at', '=', null)
            ->get();
        $SubCategory = DB::table('subcategories')
            ->where('id', '=', $SelectedSubCategory)
            ->where('deleted_at', '=', null)
            ->get();
        /*Sub Sub Category*/
        $SubSubCategories = null;
        $SubSubCategoryCondition = "";
        $__SubSubCategories = array();
        if ($FilterType == "subcategory") {
            $__SubSubCategories = DB::table('sub_subcategories')
                ->join('subcategories', 'sub_subcategories.subcategory', '=', 'subcategories.id')
                ->whereRaw('FIND_IN_SET(?, sub_subcategories.subcategory) > 0', array($SelectedSubCategory))
                ->where('sub_subcategories.category', $Category[0]->id)
                ->where('sub_subcategories.deleted_at', '=', null)
                ->select('sub_subcategories.*', 'subcategories.slug AS SubCatSlug', 'subcategories.slug2 AS SubCatSlug2')
                ->orderBy('sub_subcategories.order_no', 'ASC')
                ->get();
        } else {
            $__SubSubCategories = DB::table('sub_subcategories')
                ->join('subcategories', 'sub_subcategories.subcategory', '=', 'subcategories.id')
                ->whereRaw('FIND_IN_SET(?, sub_subcategories.subcategory) > 0', array($SelectedSubCategory))
                ->where('sub_subcategories.category', $Category[0]->id)
                ->whereIn('sub_subcategories.id', $SelectedSubSubCategory)
                ->where('sub_subcategories.deleted_at', '=', null)
                ->select('sub_subcategories.*', 'subcategories.slug AS SubCatSlug', 'subcategories.slug2 AS SubCatSlug2')
                ->orderBy('sub_subcategories.order_no', 'ASC')
                ->get();
        }
        $PriceRange = DB::table('price_ranges')
            ->get();
        $Brands = DB::table('brands')
            ->where('deleted_at', '=', null)
            ->whereIn('id', explode(',', $Category[0]->brand))
            ->orderBy('order_no', 'ASC')
            ->get();
        $html = "";
        /*$subcategoryslug = "all";
         url('/' . $Category[0]->slug . '/' . $subcategoryslug . '/' . $sub_subcategory->slug)*/
        foreach ($__SubSubCategories as $index => $sub_subcategory) {
            $html .=
                '<div class="row line-height-1-3 mb-2">
                <div class="col-7 col-sm-8">
                    <h2 class="section-title text-custom-primary fs-15 mb-2">
                        ' . $sub_subcategory->title . '
                    </h2>
                </div>
                <div class="col-5 col-sm-4">
                    <a href="' . route('home.slug', ['slug1' => $Category[0]->slug, 'slug2' => $sub_subcategory->SubCatSlug, 'slug3' => $sub_subcategory->slug2]) . '" class="float-end">
                        <label for="" class="form-check-label text-custom-primary cursor-pointer fs-14 float-right">
                            See all deals <i class="fa fa-arrow-right" aria-hidden="true"></i>
                        </label>
                    </a>
                </div>
                <!-- Products -->
                <div class="col-12">
                    <div class="products-category-slider ltn__product-gallery-slider-compare slick-arrow-1">';
            $Products = [];
            if ($StartPrice != 0 && $EndPrice != 0) {
                $Products = DB::table('products')
                    ->where('deleted_at', '=', null)
                    ->where('category', '=', $Category[0]->id)
                    ->where('sub_subcategory', '=', $sub_subcategory->id)
                    ->where(function ($query) use ($SelectedBrands, $SelectedSubCategory) {
                        if (sizeof($SelectedBrands) > 0) {
                            $query->whereIn('products.brand', $SelectedBrands);
                        }
                        $query->where('products.sub_category', $SelectedSubCategory);
                    })
                    ->whereRaw(DB::raw('total_price >= ? AND total_price <= ?'), array($StartPrice, $EndPrice))
                    ->orderBy('order_no', 'ASC')
                    ->get();
            } else {
                $Products = DB::table('products')
                    ->where('deleted_at', null)
                    ->where('category', $Category[0]->id)
                    ->where('sub_subcategory', $sub_subcategory->id)
                    ->where(function ($query) use ($SelectedBrands, $SelectedSubCategory) {
                        if (sizeof($SelectedBrands) > 0) {
                            $query->whereIn('products.brand', $SelectedBrands);
                        }
                        $query->where('products.sub_category', $SelectedSubCategory);
                    })
                    ->orderBy('order_no', 'ASC')
                    ->get();
            }
            $List = SiteHelper::GetUserList();
            foreach ($Products as $index1 => $product) {
                $html .= SiteHelper::GetProductTemplate($product, $index, $index1, $List);
            }
            $html .=
                '</div>
                </div>
            </div>';
        }
        echo json_encode($html);
    }

    function GetSubSubCategories(Request $request)
    {
        $SubCategory = $request->post('id');
        $SubSubCategories = DB::table('sub_subcategories')
            ->whereRaw('FIND_IN_SET(?, subcategory) > 0', array($SubCategory))
            ->where('deleted_at', '=', null)
            ->orderBy('order_no', 'ASC')
            ->get();
        echo json_encode($SubSubCategories);
        exit();
    }

    function CareRepair()
    {
        $PageDetails = DB::table('general_pages')
            ->where('id', 13)
            ->get();
        $Title = !empty($PageDetails) ? $PageDetails[0]->meta_title : env('APP_NAME');
        $Description = !empty($PageDetails) ? $PageDetails[0]->meta_description : env('META_DESCRIPTION');
        $OfferDetail = DB::table('offers')->get();
        $FaqDetails = DB::table('faqs')->get();
        $CareRepair = DB::table('care_repairs')->get();
        $PricingDetail = DB::table('pricings')->get();
        $DeliveryDetails = DB::table('delivery_service_charges')->get();
        $RateList = DB::table('rate_lists')->get();
        $DeliveryParts = DB::table('delivery_parts_designs')->get();
        return view('site.care-repair', compact('PageDetails', 'Title', 'Description', 'OfferDetail', 'FaqDetails', 'CareRepair', 'PricingDetail', 'DeliveryDetails', 'RateList', 'DeliveryParts'));
    }

    function CareRepairTableLoad(Request $request)
    {
        $RateList = DB::table('rate_lists')->get();
        $Type = $request['Type'];
        $Heading = '';
        $Body = '';
        if ($Type == 'Tv parts') {
            $Heading = 'TV';
            $Body = 'tv';
        } elseif ($Type == 'WM Parts') {
            $Heading = 'WM';
            $Body = 'wm';
        } elseif ($Type == 'NF REF Parts') {
            $Heading = 'REF';
            $Body = 'rff';
        } elseif ($Type == 'Dishwasher Parts') {
            $Heading = 'DW';
            $Body = 'dw';
        } elseif ($Type == 'AC Parts') {
            $Heading = 'AC';
            $Body = 'ac';
        } elseif ($Type == 'SDA Parts') {
            $Heading = 'OTHERS';
            $Body = 'others';
        } elseif ($Type == 'Cooking Appliances Parts') {
            $Heading = 'OTHERS';
            $Body = 'others';
        } elseif ($Type == 'Built-In Appliances Parts') {
            $Heading = 'OTHERS';
            $Body = 'others';
        } else {
            /*No Data to Display*/
            echo json_encode(base64_encode(''));
            exit();
        }

        /*Formatting Header and Body*/
        $DataHtmlHeader = '<tr>
                                <th style="font-size:13px; width: 35%;">Description</th>
                                <th style="font-size:13px; width: 65%;">' . $Heading . '</th>
                           </tr>';
        $DataHtmlBody = '';
        foreach ($RateList as $index => $list) {
            /*  Code for display all values including empty  */
            /*$Sub = "";
            if ($list->$Body == "") {
                $Sub = '<td style="font-size:12px; width: 65%;"><i class="fa fa-times" aria-hidden="true"></i></td>';
            } else {
                $Sub = '<td style="font-size:12px; width: 65%;">' . $list->$Body . '</td>';
            }
            $DataHtmlBody .= '<tr>
                                <td style="font-size:12px; width: 35%;">' . $list->description . '</td>'
                                . $Sub .
                             '</tr>';*/
            /*  Code for display only non empty values  */
            if ($list->$Body != "") {
                $DataHtmlBody .= '<tr>
                                    <td style="font-size:12px; width: 35%;">' . $list->description . '</td>
                                    <td style="font-size:12px; width: 65%;">' . $list->$Body . '</td>
                                 </tr>';
            }
        }

        /*Formatting HTML*/
        $Html = '<p style="text-align: center;font-size: 15px;background-color: gainsboro;color: black">
                    Service Rate List
                 </p>';
        $Html .= '<table class="table table-striped">
                        <thead>
                        ' . $DataHtmlHeader . '
                        </thead>
                        <tbody>';
        $Html .= $DataHtmlBody;
        $Html .= '      </tbody>
                 </table>';

        echo json_encode(base64_encode($Html));
        exit();
    }

    function OrdersCollect()
    {
        $PageDetails = DB::table('general_pages')
            ->where('id', 9)
            ->get();
        $Title = !empty($PageDetails) ? $PageDetails[0]->meta_title : env('APP_NAME');
        $Description = !empty($PageDetails) ? $PageDetails[0]->meta_description : env('META_DESCRIPTION');
        return view('site.orders-collect', compact('PageDetails', 'Title', 'Description'));
    }

    function Stores()
    {
        $PageDetails = DB::table('general_pages')
            ->where('id', 1)
            ->get();
        $Title = !empty($PageDetails) ? $PageDetails[0]->meta_title : env('APP_NAME');
        $Description = !empty($PageDetails) ? $PageDetails[0]->meta_description : env('META_DESCRIPTION');
        return view('site.stores', compact('PageDetails', 'Title', 'Description'));
    }

    function ReturnCancellations()
    {
        $PageDetails = DB::table('general_pages')
            ->where('id', 2)
            ->get();
        $Title = !empty($PageDetails) ? $PageDetails[0]->meta_title : env('APP_NAME');
        $Description = !empty($PageDetails) ? $PageDetails[0]->meta_description : env('META_DESCRIPTION');
        return view('site.return-cancellations', compact('PageDetails', 'Title', 'Description'));
    }

    function WaysToPay()
    {
        $PageDetails = DB::table('general_pages')
            ->where('id', 3)
            ->get();
        $Title = !empty($PageDetails) ? $PageDetails[0]->meta_title : env('APP_NAME');
        $Description = !empty($PageDetails) ? $PageDetails[0]->meta_description : env('META_DESCRIPTION');
        return view('site.ways-to-pay', compact('PageDetails', 'Title', 'Description'));
    }

    function DeliveryOptions()
    {
        $PageDetails = DB::table('general_pages')
            ->where('id', 4)
            ->get();
        $Title = !empty($PageDetails) ? $PageDetails[0]->meta_title : env('APP_NAME');
        $Description = !empty($PageDetails) ? $PageDetails[0]->meta_description : env('META_DESCRIPTION');
        return view('site.delivery-options', compact('PageDetails', 'Title', 'Description'));
    }

    function PricePromise()
    {
        $PageDetails = DB::table('general_pages')
            ->where('id', 5)
            ->get();
        $Title = !empty($PageDetails) ? $PageDetails[0]->meta_title : env('APP_NAME');
        $Description = !empty($PageDetails) ? $PageDetails[0]->meta_description : env('META_DESCRIPTION');
        return view('site.price-promise', compact('PageDetails', 'Title', 'Description'));
    }

    function InstallmentGuide()
    {
        $PageDetails = DB::table('general_pages')
            ->where('id', 6)
            ->get();
        $Title = !empty($PageDetails) ? $PageDetails[0]->meta_title : env('APP_NAME');
        $Description = !empty($PageDetails) ? $PageDetails[0]->meta_description : env('META_DESCRIPTION');
        return view('site.installment-guide', compact('PageDetails', 'Title', 'Description'));
    }

    function InstallationGuide()
    {
        $PageDetails = DB::table('general_pages')
            ->where('id', 17)
            ->get();
        $Title = !empty($PageDetails) ? $PageDetails[0]->meta_title : env('APP_NAME');
        $Description = !empty($PageDetails) ? $PageDetails[0]->meta_description : env('META_DESCRIPTION');
        return view('site.installation-guide', compact('PageDetails', 'Title', 'Description'));
    }

    function PrivacyPolicy()
    {
        $PageDetails = DB::table('general_pages')
            ->where('id', 7)
            ->get();
        $Title = !empty($PageDetails) ? $PageDetails[0]->meta_title : env('APP_NAME');
        $Description = !empty($PageDetails) ? $PageDetails[0]->meta_description : env('META_DESCRIPTION');
        return view('site.privacy-policy', compact('PageDetails', 'Title', 'Description'));
    }

    function TermsConditions()
    {
        $PageDetails = DB::table('general_pages')
            ->where('id', 8)
            ->get();
        $Title = !empty($PageDetails) ? $PageDetails[0]->meta_title : env('APP_NAME');
        $Description = !empty($PageDetails) ? $PageDetails[0]->meta_description : env('META_DESCRIPTION');
        return view('site.terms-conditions', compact('PageDetails', 'Title', 'Description'));
    }

    function ContactUs()
    {
        $PageDetails = DB::table('general_pages')
            ->where('id', 12)
            ->get();
        $Title = !empty($PageDetails) ? $PageDetails[0]->meta_title : env('APP_NAME');
        $Description = !empty($PageDetails) ? $PageDetails[0]->meta_description : env('META_DESCRIPTION');
        return view('site.contact-us', compact('PageDetails', 'Title', 'Description'));
    }

    //Contact us email function
    function send_email(Request $request)
    {
        $name = $request->post('name');
        $email = $request->post('email');
        $phone = $request->post('phone');
        $subject = $request->post('subject');
        $_message = $request->post('message');


        try {
            $data = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'subject' => $subject,
                '_message' => $_message,

            ];
            Mail::send('email.contact', $data, function ($message) use ($email) {
                $message->to(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))->subject('Contact Us Query');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });
            return redirect('/contact-us')->with('contact-success', true);

        } catch (exception $e) {
            //code to handle the exception
        }
    }

    function contact()
    {
        return view('email.contact');
    }

    function DiscountVoucher()
    {
        $PageDetails = DB::table('general_pages')
            ->where('id', 10)
            ->get();
        $Title = !empty($PageDetails) ? $PageDetails[0]->meta_title : env('APP_NAME');
        $Description = !empty($PageDetails) ? $PageDetails[0]->meta_description : env('META_DESCRIPTION');
        // Discount Voucher Details
        $DiscountVouchers = DB::table('discount_vouchers')
            ->where('deleted_at', null)
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->whereDate('start_date', '<=', date("Y-m-d"))
            ->whereDate('end_date', '>=', date("Y-m-d"))
            ->get();

        //Discount Voucher
        $DiscountQuestions = DB::table('discount_questions')
            ->where('deleted_at', null)
            ->get();
        return view('site.discount-voucher', compact('PageDetails', 'Title', 'Description', 'DiscountVouchers', 'DiscountQuestions'));
    }

    function AboutUs()
    {
        $PageDetails = DB::table('general_pages')
            ->where('id', 11)
            ->get();
        $Title = !empty($PageDetails) ? $PageDetails[0]->meta_title : env('APP_NAME');
        $Description = !empty($PageDetails) ? $PageDetails[0]->meta_description : env('META_DESCRIPTION');
        $AboutUsDetails = DB::table('about_us')
            ->get();
        return view('site.about-us', compact('PageDetails', 'Title', 'Description', 'AboutUsDetails'));
    }

    function AddToWishlist(Request $request)
    {
        $UserId = Auth::id();
        $ProductId = $request->post('ProductId');
        $Check = DB::table('wish_lists')
            ->where('user_id', '=', $UserId)
            ->where('product_id', '=', $ProductId)
            ->get();
        if (sizeof($Check) > 0) {
            $Affected = DB::table('wish_lists')
                ->where('user_id', '=', $UserId)
                ->where('product_id', '=', $ProductId)
                ->delete();
            echo 'Removed';
            exit();
        } else {
            $Affected = WishList::create([
                'user_id' => $UserId,
                'product_id' => $ProductId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            echo 'Added';
            exit();
        }
    }

    function WishlistCount(Request $request)
    {
        $WishList = SiteHelper::GetUserList();
        echo sizeof($WishList);
        exit();
    }

    function trackOrder()
    {
        $PageDetails = DB::table('general_pages')
            ->where('id', 16)
            ->get();
        $Title = !empty($PageDetails) ? $PageDetails[0]->meta_title : env('APP_NAME');
        $Description = !empty($PageDetails) ? $PageDetails[0]->meta_description : env('META_DESCRIPTION');
        return view('site.track-order', compact('PageDetails', 'Title', 'Description'));
    }

    function trackOrderHtml(Request $request)
    {
        $Order = DB::table('orders')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->where('orders.invoice_no', '=', $request->post('InvoiceNo'))
            ->where('orders.deleted_at', '=', null)
            ->select('orders.*', 'customers.first_name', 'customers.last_name')
            ->get();

        $Html = "";
        if (sizeof($Order) > 0) {
            $Status = "";
            if ($Order[0]->order_status == 0) {
                $Status = '<span class="badge-custom-warning">Pending</span>';
            } elseif ($Order[0]->order_status == 1) {
                $Status = '<span class="badge-custom-info">In progress</span>';
            } elseif ($Order[0]->order_status == 2) {
                $Status = '<span class="badge-custom-primary">Delivered</span>';
            } elseif ($Order[0]->order_status == 3) {
                $Status = '<span class="badge-custom-success">Completed</span>';
            } elseif ($Order[0]->order_status == 4) {
                $Status = '<span class="badge-custom-danger">Cancelled</span>';
            }
            $Html = '<table class="table table-bordered w-100">
                        <thead>
                        <tr>
                            <th>Invoice No.</th>
                            <th>Date</th>
                            <th>Customer Name</th>
                            <th>GST</th>
                            <th>Discount</th>
                            <th>Order Total</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>' . $Order[0]->invoice_no . '</td>
                            <td>' . Carbon::parse($Order[0]->created_at)->format('d-M-Y') . '</td>
                            <td>' . $Order[0]->first_name . ' ' . $Order[0]->last_name . '</td>
                            <td>' . SiteHelper::$Currency . ' ' . number_format($Order[0]->gst, SiteHelper::$Decimals) . '</td>
                            <td>' . SiteHelper::$Currency . ' ' . number_format($Order[0]->discount, SiteHelper::$Decimals) . '</td>
                            <td>' . SiteHelper::$Currency . ' ' . number_format($Order[0]->order_total, SiteHelper::$Decimals) . '</td>
                            <td>' . $Status . '</td>
                        </tr>
                        </tbody>
                    </table>';
        } else {
            $Html = '<div class="alert alert-warning">
                        <strong>Message:</strong>&nbsp;
                        No order found matching given invoice number.
                    </div>';
        }
        echo json_encode(base64_encode($Html));
        exit();
    }

    //Search function
    function searchproduct(Request $request)
    {
        $search = $request->post('search');
        $products = DB::Table('products')
            ->select('*')
            ->where('name', 'LIKE', '%' . $search . '%')->where('deleted_at', '=', null)->get();
        $html = '';
        foreach ($products as $product) {
            $html .= '' .
                '<li class="row justify-content-end items productList">' .
                '    <span class="col-12 item" id="product-0" role="option">' .
                '        <div class="row">' .
                '            <div class="col-xs-12 col-sm-9 prod-detail">' .
                '                <a href="' . route('home.slug', ['slug1' => $product->slug]) . '" ' .
                '                   aria-label="INDESIT IWC 71453 W UK N 7 kg 1400 Spin Washing Machine - White">' .
                '                    <img class="swatch-circle" ' .
                '                         alt="INDESIT IWC 71453 W UK N 7 kg 1400 Spin Washing Machine - White" ' .
                '                         src="' . asset("public/storage/products" . '/' . $product->primary_img) . '">' .
                '                    <span class="name">' . $product->name . ' </span>' .
                '                </a>' .
                '            </div>' .
                '            <div class="col-xs-12 col-sm-3 pricing">' .
                '                <span style="font-size: 13px">' . SiteHelper::CalculatePrice($product->total_price) . '</span>' .
                '            </div>' .
                '         </div>' .
                '    </span>' .
                ' </li>';
        }
        if ($html == "") {
            $html =
                '<li class="row justify-content-end items productList">' .
                '    <span class="col-12 item" id="product-0" role="option">' .
                '        <div class="row ltn__no-gutter">' .
                '            <div class="col-xs-12 col-sm-9 col-9 prod-detail">' .
                '                    <span style="font-size:15px;text-align:centre" class="name">No Product Found </span>' .
                '                </a>' .
                '            </div>' .
                '         </div>' .
                '    </span>' .
                ' </li>';
        }
        echo json_encode($html);
    }

    //Mobile search function
    function searchproductm(Request $request)
    {
        $search = $request->post('search');
        $products = DB::Table('products')
            ->where('name', 'LIKE', '%' . $search . '%')
            ->where('deleted_at', null)
            ->select('*')
            ->get();
        $html = '';
        foreach ($products as $product) {
            $html .= '' .
                '<li class="row justify-content-end items productList mt-3">' .
                '    <span class="col-12 item" id="product-0" role="option">' .
                '        <div class="row ltn__no-gutter">' .
                '            <div class="col-xs-12 col-sm-9 col-9 prod-detail">' .
                '                <a href="' . route('home.slug', ['slug1' => $product->slug]) . '" ' .
                '                   aria-label="INDESIT IWC 71453 W UK N 7 kg 1400 Spin Washing Machine - White">' .
                '                   <div class="row">' .
                '                      <div class="col-2">' .
                '                         <img style="max-width:40px;" class="swatch-circle" ' .
                '                         alt="INDESIT IWC 71453 W UK N 7 kg 1400 Spin Washing Machine - White" ' .
                '                         src="' . asset("public/storage/products" . '/' . $product->primary_img) . '">' .
                '                      </div>' .
                '                      <div class="col-10">' .
                '                         <span style="font-size: 10px" class="name">' . $product->name . ' </span>' .
                '                      </div>' .
                '                   </div>' .
                '                </a>' .
                '            </div>' .
                '            <div class="col-xs-12 col-sm-3 col-3 pricing" style="margin-top:13px">' .
                '                <span style="font-size: 10px;">' . SiteHelper::CalculatePrice($product->total_price) . '</span>' .
                '            </div>' .
                '         </div>' .
                '    </span>' .
                ' </li>';
        }
        if ($html == "") {
            $html =
                '<li class="row justify-content-end items productList">' .
                '    <span class="col-12 item" id="product-0" role="option">' .
                '        <div class="row ltn__no-gutter">' .
                '            <div class="col-xs-12 col-sm-9 col-9 prod-detail">' .
                '                    <span style="font-size:15px;text-align:centre" class="name">No Product Found </span>' .
                '                </a>' .
                '            </div>' .
                '         </div>' .
                '    </span>' .
                ' </li>';
        }
        echo json_encode($html);
    }

    function returnRequest(Request $request)
    {
        $Affected = "";
        DB::beginTransaction();
        $Affected = ReturnRequests::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'order_no' => $request['order_no'],
            'serial_no' => $request['serial_no'],
            'reason' => $request['reason'],
            'status' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        if ($Affected) {
            DB::commit();
            return redirect()->route('ReturnCancellationsRoute')->with('success-message', 'Your request has been sent successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('ReturnCancellationsRoute')->with('error-message', 'An unhandled error occurred.');
        }
    }

    function customerReviewsStore(Request $request)
    {
        $ProductId = $request->post('reviewProductId');
        $Slug = $request->post('reviewProductSlug');
        $Rating = $request->post('review-star-rating');
        $Text = $request->post('rating_text');
        $Recommendation = $request->post('recommendation') == 'true' ? 1 : 0;
        DB::beginTransaction();
        $Affected = CustomerReviews::create([
            'user_id' => Auth::id(),
            'product_id' => $ProductId,
            'rating' => $Rating,
            'message' => $Text,
            'recommendation' => $Recommendation,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        if ($Affected) {
            DB::commit();
            return redirect()->route('CheckSlugRoute', array($Slug))->with('success-message', 'Review posted successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('CheckSlugRoute', array($Slug))->with('error-message', 'An unhandled error occurred.');
        }

    }

    function customerReviewsDelete(Request $request)
    {
        $Id = $request->post('Id');
        DB::table('customer_reviews')
            ->where('id', '=', $Id)
            ->update([
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now()
            ]);
        echo 'Success';
        exit();
    }

    function b2b()
    {
        $CategoriesDetails = DB::table('categories')
            ->where('deleted_at', null)
            ->get();
        $Content = SiteHelper::GetPageContent('B2B');
        $Title = !empty($Content) ? $Content->meta_title : env('APP_NAME');
        $Description = !empty($Content) ? $Content->meta_description : env('META_DESCRIPTION');
        return view('site.b2b', compact('CategoriesDetails', 'Title', 'Description'));
    }

    function b2bDeals($Type)
    {
        $B2BTree = DB::table('b2b_trees')
            ->where('tree_type', '=', $Type)
            ->get();
        if ($B2BTree[0]->tree_type == 'large') {
            $Content = SiteHelper::GetPageContent('B2B Large Appliances');
            $Title = !empty($Content) ? $Content->meta_title : env('APP_NAME');
            $Description = !empty($Content) ? $Content->meta_description : env('META_DESCRIPTION');
        } else if ($B2BTree[0]->tree_type == 'small') {
            $Content = SiteHelper::GetPageContent('B2B Small Appliances');
            $Title = !empty($Content) ? $Content->meta_title : env('APP_NAME');
            $Description = !empty($Content) ? $Content->meta_description : env('META_DESCRIPTION');
        } else {
            $Content = SiteHelper::GetPageContent('B2B Commercial Appliances');
            $Title = !empty($Content) ? $Content->meta_title : env('APP_NAME');
            $Description = !empty($Content) ? $Content->meta_description : env('META_DESCRIPTION');
        }
        if (sizeof($B2BTree) == 0) {
            return redirect()->route('B2BRoute');
        }

        $Categories = $B2BTree[0]->categories != '' ? explode(',', $B2BTree[0]->categories) : array();
        $SubCategories = $B2BTree[0]->sub_categories != '' ? explode(',', $B2BTree[0]->sub_categories) : array();
        $SubSubCategories = $B2BTree[0]->sub_sub_categories != '' ? explode(',', $B2BTree[0]->sub_sub_categories) : array();
        $Products = DB::table('products')
            ->where('deleted_at', null)
            ->where(function ($query) use ($Categories, $SubCategories, $SubSubCategories) {
                $query->orWhereIn('products.category', $Categories);
                $query->orWhereIn('products.sub_category', $SubCategories);
                $query->orWhereIn('products.sub_subcategory', $SubSubCategories);
            })
            ->orderBy('order_no', 'ASC')
            ->get();
        $List = SiteHelper::GetUserList();
        $index = 0;

        return view('site.b2b-deals', compact('Type', 'Title', 'Description', 'Products', 'List', 'index'));
    }

    function b2bForm(Request $request)
    {
        /*echo '<pre>';
        echo print_r($request->all());
        echo '</pre>';
        exit();*/

        DB::beginTransaction();
        $Affected = b2bRequest::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'city' => $request['city'],
            'product' => implode(',', $request['products']),
            'time_frame' => $request['time_frame'],
            'quantity' => $request['quantity'],
            'comments' => $request['comments'],
            'created_at' => carbon::now(),
        ]);

        try {
            $data = [
                'name' => $request['name'],
                'email' => $request['email'],
                'phone' => $request['phone'],
                'city' => $request['city'],
                'product' => implode(',', $request['products']),
                'product_subcategory' => '',
                'model_no' => '',
                'time_frame' => $request['time_frame'],
                'quantity' => $request['quantity'],
                'comments' => $request['comments'],
            ];
            Mail::send('email.b2b-request', $data, function ($message) {
                $message->to(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))->subject('B2B Request');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });

            $email = $request['email'];
            $response = "Your B2B request has been forward to admin. We will respond on it shortly. Thankyou";
            $data_user = [
                'response' => $response,
            ];
            //user-email
            Mail::send('email.b2b-user-request', $data_user, function ($message) use ($email) {
                $message->to($email, env('MAIL_FROM_NAME'))->subject('B2B Request Submitted');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });
        } catch (exception $e) {
            //code to handle the exception
        }
        if ($Affected) {
            DB::commit();
            return redirect()->route('B2BRoute')->with('success-message', 'Form submitted  successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('B2BRoute')->with('error-message', 'An unhandled error occurred.');
        }
    }

    function loadProductSubCategory(Request $request)
    {
        $options = '<option value="">Select</option>';
        if ($request['Product'] == 'Large Appliances') {
            $Categories = DB::table('categories')
                ->where('deleted_at', null)
                ->whereIn('id', array(2, 3, 4, 5, 6))
                ->get();

            foreach ($Categories as $key => $value) {
                $options .= '<option value="' . $value->id . '">' . $value->title . '</option>';
            }
        } else if ($request['Product'] == 'Small Appliances') {
            $Categories = DB::table('sub_subcategories')
                ->where('deleted_at', null)
                ->where('category', 8)
                ->get();

            foreach ($Categories as $key => $value) {
                $options .= '<option value="' . $value->id . '">' . $value->title . '</option>';
            }
        } else if ($request['Product'] == 'Commercial Appliances') {
            $Categories = DB::table('subcategories')
                ->where('deleted_at', null)
                ->where('id', 17)
                ->get();
            $SubsubCategories = DB::table('sub_subcategories')
                ->where('deleted_at', null)
                ->whereIn('id', array(73, 90))
                ->get();

            foreach ($Categories as $key => $value) {
                $options .= '<option value="' . $value->id . '">' . $value->title . '</option>';
            }

            foreach ($SubsubCategories as $key => $value) {
                $options .= '<option value="' . $value->id . '">' . $value->title . '</option>';
            }
        }
        echo json_encode($options);
    }

    function loadSubCategoryProduct(Request $request)
    {

        $options = '<option value="">Select</option>';
        if ($request['ProductType'] == 'Large Appliances') {
            $Products = DB::table('products')
                ->where('deleted_at', null)
                ->where('category', $request['category_id'])
                ->get();

            foreach ($Products as $key => $value) {
                $options .= '<option value="' . $value->id . '">' . $value->name . '</option>';
            }
        } elseif ($request['ProductType'] == 'Small Appliances') {
            $Products = DB::table('products')
                ->where('deleted_at', null)
                ->where('sub_subcategory', $request['category_id'])
                ->get();

            foreach ($Products as $key => $value) {
                $options .= '<option value="' . $value->id . '">' . $value->name . '</option>';
            }
        } elseif ($request['ProductType'] == 'Commercial Appliances') {
            if ($request['category_title'] == 'Built-In Dishwasher') {
                $Products = DB::table('products')
                    ->where('deleted_at', null)
                    ->where('subcategory', 17)
                    ->get();
            } else if ($request['category_title'] == 'Built In Hood') {
                $Products = DB::table('products')
                    ->where('deleted_at', null)
                    ->where('sub_subcategory', 73)
                    ->get();
            } else if ($request['category_title'] == 'Built In Oven') {
                $Products = DB::table('products')
                    ->where('deleted_at', null)
                    ->where('sub_subcategory', 90)
                    ->get();
            }
            foreach ($Products as $key => $value) {
                $options .= '<option value="' . $value->id . '">' . $value->name . '</option>';
            }
        }
        echo json_encode($options);
    }

    //Clearamce-Sale
    function clearanceSale()
    {
        $PageDetails = DB::table('general_pages')
            ->where('id', 20)
            ->get();
        $Title = !empty($PageDetails) ? $PageDetails[0]->meta_title : env('APP_NAME');
        $Description = !empty($PageDetails) ? $PageDetails[0]->meta_description : env('META_DESCRIPTION');
        return view('site.clearance-sale', compact('PageDetails', 'Title', 'Description'));
    }
}
