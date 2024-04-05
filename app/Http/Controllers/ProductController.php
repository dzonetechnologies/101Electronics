<?php

namespace App\Http\Controllers;

use App\Helpers\SiteHelper;
use App\Models\Product;
use App\Models\ProductColors;
use App\Models\ProductDetail;
use App\Models\ProductWeight;
use App\Models\ProductGallery;
use App\Models\ProductSize;
use App\Models\Categories;
use App\Models\Color;
use App\Models\Unit;
use App\Models\Brands;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        return view('dashboard.products.index');
    }

    function create()
    {
        $categories = DB::table('categories')
            ->where('deleted_at', null)
            ->orderBy('order_no', 'ASC')
            ->get();
        $colors = Color::all();
        $units = Unit::all();
        return view('dashboard.products.add', compact('categories', 'colors', 'units'));
    }

    function store(Request $request)
    {
        /*echo '<pre>';
        echo print_r($request->all());
        echo '</pre>';
        exit();*/

        $ProductName = $request['product_name'];
        $ProductCode = $request['product_code'];
        $ProductCategory = $request['category'];
        $ProductSubCategory = $request['subcategory'];
        $ProductSubSubCategory = $request['sub-subcategory'];
        $ProductBrand = $request['brand'];
        $ProductClearanceSale = $request['product_clearance_sale'];
        $ProductRating = $request['product_rating'];
        $ProductReview = $request['product_review'];
        $ProductDescription = $request['product_description'];
        $ProductCompareDescription = $request['product_compare_description'];
        $ProductShortDescription = $request['product_short_description'];
        $ProductInstallmentCalculator = 0;
        if (isset($request['product_installment_calculator'])) {
            $ProductInstallmentCalculator = 1;
        }
        $ProductPrimaryImage = null;
        if ($request->has('primaryPicture')) {
            foreach ($request->file('primaryPicture') as $key => $photo) {
                $Name = 'ProductPrimaryImage_' . Carbon::now()->format('Ymd') . '-' . Carbon::now()->format('His') . '.' . $photo->extension();
                $path = $photo->storeAs('/public/products/', $Name);
                $ProductPrimaryImage = $Name;
            }
        }

        $ProductSizePackagingImage = null;
        if ($request->has('sizePackagingPicture')) {
            foreach ($request->file('sizePackagingPicture') as $key => $photo) {
                $Name = 'ProductSizePackagingImage_' . Carbon::now()->format('Ymd') . '-' . Carbon::now()->format('His') . '.' . $photo->extension();
                $path = $photo->storeAs('/public/products/', $Name);
                $ProductSizePackagingImage = $Name;
            }
        }

        $ProductVideoLink = $request['product_video_link'];
        $ProductVideoFile = null;
        if ($request->has('product_video_file')) {
            $video = $request->file('product_video_file');
            $Name = 'ProductVideo_' . Carbon::now()->format('Ymd') . '-' . Carbon::now()->format('His') . '.' . $video->extension();
            $path = $video->storeAs('/public/products/', $Name);
            $ProductVideoFile = $Name;
        }
        $ProductMetaTitle = $request['product_meta_title'];
        $ProductMetaDesc = $request['product_meta_desc'];
        $ProductMetaTags = $request['product_meta_tags'];
        $ProductMetaImage = null;
        if ($request->has('metaPicture')) {
            foreach ($request->file('metaPicture') as $key => $photo) {
                $Name = 'ProductMetaImage_' . Carbon::now()->format('Ymd') . '-' . Carbon::now()->format('His') . '.' . $photo->extension();
                $path = $photo->storeAs('/public/products/', $Name);
                $ProductMetaImage = $Name;
            }
        }
        /*$ProductColorVariants = null;
        if (isset($request['product_color'])) {
            $ProductColorVariants = implode(",", $request['product_color']);
        }*/
        $ProductPurchasePrice = $request['product_purchase_price'];
        $ProductTax = $request['product_tax'] == '' ? 0 : $request['product_tax'];
        $ProductTaxPrice = ceil((floatval($ProductPurchasePrice) / 100) * floatval($ProductTax));
        $ProductDiscount = $request['product_discount'] == '' ? 0 : $request['product_discount'];
        $DiscountPrice = 0;
        $TotalPriceWithoutDiscount = 0;
        $TotalPrice = 0;
        /*Tax*/
        $TotalPriceWithoutDiscount = ceil(floatval($ProductPurchasePrice) + ((floatval($ProductPurchasePrice) / 100) * floatval($ProductTax)));
        /*Discount*/
        if ($ProductDiscount > 0) {
            $TotalPrice = ceil(floatval($TotalPriceWithoutDiscount) - ((floatval($TotalPriceWithoutDiscount) / 100) * floatval($ProductDiscount)));
        } else {
            $TotalPrice = ceil($TotalPriceWithoutDiscount);
        }
        $DiscountPrice = ceil($TotalPriceWithoutDiscount - $TotalPrice);
        $ProductQuantity = $request['product_quantity'];
        $ProductFreeShipping = 1;
        $ProductShippingFlatRate = 0;
        if (isset($request['product_shipping_type'])) {
            $ProductFreeShipping = 0;
        } else {
            $ProductShippingFlatRate = $request['product_flat_rate_shipping'];
        }
        $ProductFast24HoursDelivery = $request['product_fast_delivery'];
        $ProductNormal2to3DaysDelivery = $request['product_normal_delivery'];
        $ProductZeroFreeInstallation = $request['product_free_installation'];
        $ProductInstallationPrice = 0;
        if ($ProductZeroFreeInstallation == 0) {
            $ProductInstallationPrice = $request['installation_price'];
        }
        $ProductPDFSpecification = null;
        if ($request->has('product_pdf_specification')) {
            $pdf = $request->file('product_pdf_specification');
            $Name = 'ProductPdf_' . Carbon::now()->format('Ymd') . '-' . Carbon::now()->format('His') . '.' . $pdf->extension();
            $path = $pdf->storeAs('/public/products/', $Name);
            $ProductPDFSpecification = $Name;
        }

        DB::beginTransaction();
        $Affected = Product::create([
            'order_no' => $this->getLastOrderNo(),
            'name' => $ProductName,
            'code' => $ProductCode,
            'brand' => $ProductBrand,
            'category' => $ProductCategory,
            'sub_category' => $ProductSubCategory,
            'sub_subcategory' => $ProductSubSubCategory,
            'clearance_sale' => $ProductClearanceSale,
            'rating' => $ProductRating,
            'review' => $ProductReview,
            'installment_calculator' => $ProductInstallmentCalculator,
            'description' => $ProductDescription,
            'short_description' => $ProductShortDescription,
            'compare_description' => $ProductCompareDescription,
            'primary_img' => $ProductPrimaryImage,
            'size_packaging_img' => $ProductSizePackagingImage,
            'video_link' => $ProductVideoLink,
            'video_file' => $ProductVideoFile,
            'meta_title' => $ProductMetaTitle,
            'meta_desc' => $ProductMetaDesc,
            'meta_tags' => $ProductMetaTags,
            'meta_img' => $ProductMetaImage,
            /*'color_variants' => $ProductColorVariants,*/
            'unit_price' => $TotalPriceWithoutDiscount,
            'purchase_price' => $ProductPurchasePrice,
            'tax' => $ProductTax,
            'tax_price' => $ProductTaxPrice,
            'discount' => $ProductDiscount,
            'discount_price' => $DiscountPrice,
            'total_price_without_discount' => $TotalPriceWithoutDiscount,
            'total_price' => $TotalPrice,
            'quantity' => $ProductQuantity,
            'free_shipping' => $ProductFreeShipping,
            'shipping_flat_rate' => $ProductShippingFlatRate,
            'fast_24hour_delivery' => $ProductFast24HoursDelivery,
            'normal_2to3days_delivery' => $ProductNormal2to3DaysDelivery,
            'zero_free_installation' => $ProductZeroFreeInstallation,
            'installation_price' => $ProductInstallationPrice,
            'pdf_specification' => $ProductPDFSpecification,
            'slug' => $request['slug'],
            'created_at' => Carbon::now()
        ]);

        if ($request->has('galleryPictures')) {
            $Count = 1;
            foreach ($request->file('galleryPictures') as $key => $photo) {
                $Name = 'ProductGalleryImage_' . $Count . ' ' . Carbon::now()->format('Ymd') . '-' . Carbon::now()->format('His') . '.' . $photo->extension();
                $path = $photo->storeAs('/public/products/', $Name);
                ProductGallery::create([
                    'product_id' => $Affected->id,
                    'gallery' => $Name,
                    'created_at' => Carbon::now()
                ]);
                $Count++;
            }
        }

        if (isset($request['sizes'])) {
            foreach ($request->post('sizes') as $index => $size) {
                if (isset($size['size_unit']) && isset($size['size_height']) && isset($size['size_width'])) {
                    if ($size['size_unit'] != "" && $size['size_height'] != "" && $size['size_width'] != "") {
                        ProductSize::create([
                            'product_id' => $Affected->id,
                            'unit_id' => $size['size_unit'],
                            'height' => $size['size_height'],
                            'width' => $size['size_width'],
                            'depth' => $size['size_depth'],
                            'created_at' => Carbon::now()
                        ]);
                    }
                }
            }
        }

        $ProductColors = array();
        $ProductColorImages = array();
        if ($request->has('productColors')) {
            foreach ($request['productColors'] as $index => $productColor) {
                if (isset($request['productColors'][$index]['product_color_image'])) {
                    $CurrentFile = $request['productColors'][$index]['product_color_image'];
                    $Extension = $CurrentFile->extension();
                    $FileStoragePath = '/public/products/';
                    $Name = 'ProductColorImage_' . $index . ' ' . Carbon::now()->format('Ymd') . '-' . Carbon::now()->format('His') . '.' . $Extension;
                    $result = $CurrentFile->storeAs($FileStoragePath, $Name);
                    $ProductColors[] = $productColor['product_color'];
                    $ProductColorImages[] = $Name;
                }
            }
        }

        foreach ($ProductColorImages as $index => $productColorImage) {
            ProductColors::create([
                'product_id' => $Affected->id,
                'color_id' => $ProductColors[$index],
                'color_image' => $productColorImage,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        if ($Affected) {
            DB::commit();
            return redirect()->route('product')->with('success-message', 'Product created successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('product')->with('error-message', 'An unhandled error occurred.');
        }
    }

    function load(Request $request)
    {
        $limit = $request->post('length');
        $start = $request->post('start');
        $searchTerm = $request->post('search')['value'];

        $columnIndex = $request->post('order')[0]['column']; // Column index
        $columnName = $request->post('columns')[$columnIndex]['data']; // Column name
        $columnSortOrder = $request->post('order')[0]['dir']; // asc or desc

        $fetch_data = null;
        $recordsTotal = null;
        $recordsFiltered = null;
        if ($searchTerm == '') {
            $fetch_data = DB::table('products')
                ->join('brands', 'products.brand', '=', 'brands.id')
                ->join('categories', 'products.category', '=', 'categories.id')
                ->join('subcategories', 'products.sub_category', '=', 'subcategories.id')
                ->join('sub_subcategories', 'products.sub_subcategory', '=', 'sub_subcategories.id')
                ->where('products.deleted_at', null)
                ->select('products.*', 'brands.title AS brandName', 'categories.title AS categoryName', 'subcategories.title AS subCategoryName', 'sub_subcategories.title AS subSubCategoryName')
                ->orderBy('products.id', 'DESC')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('products')
                ->join('brands', 'products.brand', '=', 'brands.id')
                ->join('categories', 'products.category', '=', 'categories.id')
                ->join('subcategories', 'products.sub_category', '=', 'subcategories.id')
                ->join('sub_subcategories', 'products.sub_subcategory', '=', 'sub_subcategories.id')
                ->where('products.deleted_at', null)
                ->select('products.*', 'brands.title AS brandName', 'categories.title AS categoryName', 'subcategories.title AS subCategoryName', 'sub_subcategories.title AS subSubCategoryName')
                ->orderBy('products.id', 'DESC')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        } else {
            $fetch_data = DB::table('products')
                ->join('brands', 'products.brand', '=', 'brands.id')
                ->join('categories', 'products.category', '=', 'categories.id')
                ->join('subcategories', 'products.sub_category', '=', 'subcategories.id')
                ->join('sub_subcategories', 'products.sub_subcategory', '=', 'sub_subcategories.id')
                ->where('products.deleted_at', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('products.name', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('brands.title', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('subcategories.title', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('sub_subcategories.title', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('products.unit_price', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('products.quantity', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('products.*', 'brands.title AS brandName', 'categories.title AS categoryName', 'subcategories.title AS subCategoryName', 'sub_subcategories.title AS subSubCategoryName')
                ->orderBy('products.id', 'DESC')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('products')
                ->join('brands', 'products.brand', '=', 'brands.id')
                ->join('categories', 'products.category', '=', 'categories.id')
                ->join('subcategories', 'products.sub_category', '=', 'subcategories.id')
                ->join('sub_subcategories', 'products.sub_subcategory', '=', 'sub_subcategories.id')
                ->where('products.deleted_at', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('products.name', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('products.code', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('brands.title', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('subcategories.title', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('sub_subcategories.title', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('products.unit_price', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('products.quantity', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('products.*', 'brands.title AS brandName', 'categories.title AS categoryName', 'subcategories.title AS subCategoryName', 'sub_subcategories.title AS subSubCategoryName')
                ->orderBy('products.id', 'DESC')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        }

        $data = array();
        $SrNo = $start + 1;
        foreach ($fetch_data as $row => $item) {
            $sub_array = array();
            $sub_array['order_no'] = $item->order_no;
            $sub_array['id'] = $SrNo;
            $sub_array['name'] = '<span>' . wordwrap($item->name, 15, '<br>') . '</span>';
            $sub_array['code'] = '<span>' . wordwrap($item->code, 15, '<br>') . '</span>';
            $sub_array['brand'] = '<span>' . wordwrap($item->brandName, 15, '<br>') . '</span>';
            $sub_array['category'] = '<span>' . wordwrap($item->categoryName, 15, '<br>') . '</span>';
            $sub_array['subcategory'] = '<span>' . wordwrap($item->subCategoryName, 15, '<br>') . '</span>';
            $sub_array['sub-subcategory'] = '<span>' . wordwrap($item->subSubCategoryName, 15, '<br>') . '</span>';
            $sub_array['unit_price'] = SiteHelper::$Currency . " " . number_format($item->total_price);
            $sub_array['quantity'] = $item->quantity;
            $HomepageStatus = "";
            if ($item->homepage_status == 1) {
                $HomepageStatus = '<label class="switch">
                                  <input type="checkbox" name="product_homepage_status" id="producthomepagestatus_' . $item->id . '" checked onchange="UpdateProductHomepageStatus(this.id);">
                                    <span class="slider round"></span>
                                  </label>';
            } else {
                $HomepageStatus = '<label class="switch">
                                    <input type="checkbox" name="product_homepage_status" id="producthomepagestatus_' . $item->id . '" onchange="UpdateProductHomepageStatus(this.id);">
                                    <span class="slider round"></span>
                                  </label>';
            }
            $sub_array['homepage'] = $HomepageStatus;

            $Action = "<span>";
            $EditDetailsUrl = route('product.edit.details', array($item->id));
            $EditUrl = route('product.edit', array($item->id));
            $Id = $item->id;
            $OrderNo = $item->order_no;
            $Parameters = "this, '$Id', '$OrderNo'";
            $Action .= '<a href="javascript:void(0);" class="mr-2" onclick="ProductOrderUp(' . $Parameters . ');"><i class="fa fa-arrow-up"></i></a><a href="javascript:void(0);" class="mr-2" onclick="ProductOrderDown(' . $Parameters . ');"><i class="fa fa-arrow-down"></i></a><a href="' . $EditDetailsUrl . '"><i class="fas fa-clipboard-list mr-2 text-color-green"></i></a><a href="' . $EditUrl . '"><i class="fa fa-pen text-color-green"></i></a><a href="javascript:void(0);" class="ml-2" onclick="DuplicateProduct(\'' . $item->id . '\');"><i class="fa fa-clone text-color-green"></i></a><a href="javascript:void(0);" class="ml-2" onclick="DeleteProduct(\'' . $item->id . '\');"><i class="fa fa-trash text-color-red"></i></a>';
            $Action .= "<span>";
            $sub_array['action'] = $Action;
            $SrNo++;
            $data[] = $sub_array;
        }

        $json_data = array(
            "draw" => intval($request->post('draw')),
            "iTotalRecords" => $recordsTotal,
            "iTotalDisplayRecords" => $recordsFiltered,
            "aaData" => $data
        );

        echo json_encode($json_data);
    }

    function editDetails($ProductId)
    {
        $productDetails = ProductDetail::where('product_id', $ProductId)->first();
        $spec_summaries = !empty($productDetails['spec_summaries']) ? json_decode($productDetails['spec_summaries']) : null;
        $capacities = !empty($productDetails['capacities']) ? json_decode($productDetails['capacities']) : null;
        $dimensions = !empty($productDetails['dimensions']) ? json_decode($productDetails['dimensions']) : null;
        $general_features = !empty($productDetails['general_features']) ? json_decode($productDetails['general_features']) : null;
        return view('dashboard.products.edit-details', compact('ProductId','spec_summaries','capacities','dimensions','general_features'));
    }

    function updateDetails(Request $request)
    {
        $productDetails = ProductDetail::where('product_id', $request['product_id'])->first();
        if (empty($productDetails)) {
            $Affected = ProductDetail::create([
                'product_id' => $request['product_id'],
                'spec_summaries' => !empty($request['spec_summaries']) ? json_encode($request['spec_summaries']) : null,
                'capacities' => !empty($request['capacities']) ? json_encode($request['capacities']) : null,
                'dimensions' => !empty($request['dimensions']) ? json_encode($request['dimensions']) : null,
                'general_features' => !empty($request['general_features']) ? json_encode($request['general_features']) : null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        } else {
            $Affected = ProductDetail::where('product_id', $request['product_id'])->update([
                'spec_summaries' => !empty($request['spec_summaries']) ? json_encode($request['spec_summaries']) : null,
                'capacities' => !empty($request['capacities']) ? json_encode($request['capacities']) : null,
                'dimensions' => !empty($request['dimensions']) ? json_encode($request['dimensions']) : null,
                'general_features' => !empty($request['general_features']) ? json_encode($request['general_features']) : null,
                'updated_at' => Carbon::now()
            ]);
        }
        if ($Affected) {
            DB::commit();
            return redirect()->route('product')->with('success-message', 'Product details updated successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('product')->with('error-message', 'An unhandled error occurred.');
        }
    }

    function edit($ProductId)
    {
        $categories = DB::table('categories')
            ->where('deleted_at', null)
            ->orderBy('order_no', 'ASC')
            ->get();
        $colors = Color::all();
        $units = Unit::all();
        $brands = Brands::all();
        $Product = DB::table('products')
            ->where('id', $ProductId)
            ->where('deleted_at', null)
            ->get();
        $ProductGallery = DB::table('product_galleries')
            ->where('product_id', $ProductId)
            ->get();
        $ProductColors = DB::table('product_colors')
            ->where('product_id', $ProductId)
            ->get();
        $ProductSizes = DB::table('product_sizes')
            ->where('product_id', $ProductId)
            ->get();
        $ProductWeights = DB::table('product_weights')
            ->where('product_id', $ProductId)
            ->get();
        $subcategories = DB::table('subcategories')
            ->where('deleted_at', null)
            ->where('category', $Product[0]->category)
            ->orderBy('order_no', 'ASC')
            ->get();
        $SubSubcategorySql = "SELECT * FROM sub_subcategories WHERE ((FIND_IN_SET(:subCategoryId, subcategory) > 0) AND category = :categoryId) AND ISNULL(deleted_at) ORDER BY order_no ASC;";
        $sub_subcategories = DB::select(DB::raw($SubSubcategorySql), array($Product[0]->sub_category, $Product[0]->category));
        return view('dashboard.products.edit', compact('categories', 'subcategories', 'sub_subcategories', 'brands', 'colors', 'units', 'Product', 'ProductGallery', 'ProductSizes', 'ProductWeights', 'ProductColors'));
    }


    function update(Request $request)
    {
        /*echo '<pre>';
        echo print_r($request->all());
        echo '</pre>';
        exit();*/

        $ProductId = $request['product_id'];
        $ProductName = $request['product_name'];
        $ProductCode = $request['product_code'];
        $ProductCategory = $request['category'];
        $ProductSubCategory = $request['subcategory'];
        $ProductSubSubCategory = $request['sub-subcategory'];
        $ProductBrand = $request['brand'];
        $ProductClearanceSale = $request['product_clearance_sale'];
        $ProductRating = $request['product_rating'];
        $ProductReview = $request['product_review'];
        $ProductDescription = $request['product_description'];
        $ProductShortDescription = $request['product_short_description'];
        $ProductCompareDescription = $request['product_compare_description'];
        $ProductInstallmentCalculator = 0;
        if (isset($request['product_installment_calculator'])) {
            $ProductInstallmentCalculator = 1;
        }
        $ProductPrimaryImage = null;
        if ($request->has('primaryPicture')) {
            foreach ($request->file('primaryPicture') as $key => $photo) {
                $Name = 'ProductPrimaryImage_' . Carbon::now()->format('Ymd') . '-' . Carbon::now()->format('His') . '.' . $photo->extension();
                $path = $photo->storeAs('/public/products/', $Name);
                $ProductPrimaryImage = $Name;
                // unlink old primary image
                if ($request['old_primary_img'] != "") {
                    $path = public_path() . "/storage/products/" . $request['old_primary_img'];
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            }
        } else {
            if ($request['old_primary_img'] != "") {
                $ProductPrimaryImage = $request['old_primary_img'];
            }
        }

        $ProductSizePackagingImage = null;
        if ($request->has('sizePackagingPicture')) {
            foreach ($request->file('sizePackagingPicture') as $key => $photo) {
                $Name = 'ProductSizePackagingImage_' . Carbon::now()->format('Ymd') . ' at ' . Carbon::now()->format('His') . '.' . $photo->extension();
                $path = $photo->storeAs('/public/products/', $Name);
                $ProductSizePackagingImage = $Name;
                // unlink old primary image
                if ($request['old_size_packaging_img'] != "") {
                    $path = public_path() . "/storage/products/" . $request['old_size_packaging_img'];
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            }
        } else {
            if ($request['old_size_packaging_img'] != "") {
                $ProductSizePackagingImage = $request['old_size_packaging_img'];
            }
        }

        $ProductVideoLink = $request['product_video_link'];
        $ProductVideoFile = null;
        if ($request->has('product_video_file')) {
            $video = $request->file('product_video_file');
            $Name = 'ProductVideo_' . Carbon::now()->format('Ymd') . ' at ' . Carbon::now()->format('His') . '.' . $video->extension();
            $path = $video->storeAs('/public/products/', $Name);
            $ProductVideoFile = $Name;
            // unlink old video file
            if ($request['old_video_file'] != "") {
                $path = public_path() . "/storage/products/" . $request['old_video_file'];
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        } else {
            if ($request['old_video_file'] != "") {
                $ProductVideoFile = $request['old_video_file'];
            }
        }
        $ProductMetaTitle = $request['product_meta_title'];
        $ProductMetaDesc = $request['product_meta_desc'];
        $ProductMetaTags = $request['product_meta_tags'];
        $ProductMetaImage = null;
        if ($request->has('metaPicture')) {
            foreach ($request->file('metaPicture') as $key => $photo) {
                $Name = 'ProductMetaImage_' . Carbon::now()->format('Ymd') . ' at ' . Carbon::now()->format('His') . '.' . $photo->extension();
                $path = $photo->storeAs('/public/products/', $Name);
                $ProductMetaImage = $Name;
                // unlink old meta image
                if ($request['old_meta_image'] != "") {
                    $path = public_path() . "/storage/products/" . $request['old_meta_image'];
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            }
        } else {
            if ($request['old_meta_image'] != "") {
                $ProductMetaImage = $request['old_meta_image'];
            }
        }

        /*$ProductColorVariants = null;
        if (isset($request['product_color'])) {
            $ProductColorVariants = implode(",", $request['product_color']);
        }*/
        $ProductPurchasePrice = $request['product_purchase_price'];
        $ProductTax = $request['product_tax'] == '' ? 0 : $request['product_tax'];
        $ProductTaxPrice = ((floatval($ProductPurchasePrice) / 100) * floatval($ProductTax));
        $ProductDiscount = $request['product_discount'] == '' ? 0 : $request['product_discount'];
        $DiscountPrice = 0;
        $TotalPriceWithoutDiscount = 0;
        $TotalPrice = 0;
        /*Tax*/
        $TotalPriceWithoutDiscount = ceil(floatval($ProductPurchasePrice) + ((floatval($ProductPurchasePrice) / 100) * floatval($ProductTax)));
        /*Discount*/
        if ($ProductDiscount > 0) {
            $TotalPrice = ceil(floatval($TotalPriceWithoutDiscount) - ((floatval($TotalPriceWithoutDiscount) / 100) * floatval($ProductDiscount)));
        } else {
            $TotalPrice = $TotalPriceWithoutDiscount;
        }
        $DiscountPrice = ceil($TotalPriceWithoutDiscount - $TotalPrice);
        $ProductQuantity = $request['product_quantity'];
        $ProductFreeShipping = 1;
        $ProductShippingFlatRate = 0;
        if (isset($request['product_shipping_type'])) {
            $ProductFreeShipping = 0;
        } else {
            $ProductShippingFlatRate = $request['product_flat_rate_shipping'];
        }
        $ProductFast24HoursDelivery = $request['product_fast_delivery'];
        $ProductNormal2to3DaysDelivery = $request['product_normal_delivery'];
        $ProductZeroFreeInstallation = $request['product_free_installation'];
        $ProductInstallationPrice = 0;
        if ($ProductZeroFreeInstallation == 0) {
            $ProductInstallationPrice = $request['installation_price'];
        }
        $ProductPDFSpecification = null;
        if ($request->has('product_pdf_specification')) {
            $pdf = $request->file('product_pdf_specification');
            $Name = 'ProductPdf_' . Carbon::now()->format('Ymd') . '-' . Carbon::now()->format('His') . '.' . $pdf->extension();
            $path = $pdf->storeAs('/public/products/', $Name);
            $ProductPDFSpecification = $Name;
            // unlink old pdf file
            if ($request['old_pdf_specification'] != "") {
                $path = public_path() . "/storage/products/" . $request['old_pdf_specification'];
                unlink($path);
            }
        } else {
            if ($request['old_pdf_specification'] != "") {
                $ProductPDFSpecification = $request['old_pdf_specification'];
            }
        }

        DB::beginTransaction();
        $Affected = DB::table('products')
            ->where('id', '=', $ProductId)
            ->update([
                'name' => $ProductName,
                'code' => $ProductCode,
                'brand' => $ProductBrand,
                'category' => $ProductCategory,
                'sub_category' => $ProductSubCategory,
                'sub_subcategory' => $ProductSubSubCategory,
                'clearance_sale' => $ProductClearanceSale,
                'rating' => $ProductRating,
                'review' => $ProductReview,
                'installment_calculator' => $ProductInstallmentCalculator,
                'description' => $ProductDescription,
                'short_description' => $ProductShortDescription,
                'compare_description' => $ProductCompareDescription,
                'primary_img' => $ProductPrimaryImage,
                'size_packaging_img' => $ProductSizePackagingImage,
                'video_link' => $ProductVideoLink,
                'video_file' => $ProductVideoFile,
                'meta_title' => $ProductMetaTitle,
                'meta_desc' => $ProductMetaDesc,
                'meta_tags' => $ProductMetaTags,
                'meta_img' => $ProductMetaImage,
                /*'color_variants' => $ProductColorVariants,*/
                'unit_price' => $TotalPriceWithoutDiscount,
                'purchase_price' => $ProductPurchasePrice,
                'tax' => $ProductTax,
                'tax_price' => $ProductTaxPrice,
                'discount' => $ProductDiscount,
                'discount_price' => $DiscountPrice,
                'total_price_without_discount' => $TotalPriceWithoutDiscount,
                'total_price' => $TotalPrice,
                'quantity' => $ProductQuantity,
                'free_shipping' => $ProductFreeShipping,
                'shipping_flat_rate' => $ProductShippingFlatRate,
                'fast_24hour_delivery' => $ProductFast24HoursDelivery,
                'normal_2to3days_delivery' => $ProductNormal2to3DaysDelivery,
                'zero_free_installation' => $ProductZeroFreeInstallation,
                'installation_price' => $ProductInstallationPrice,
                'pdf_specification' => $ProductPDFSpecification,
                'slug' => $request['slug'],
                'updated_at' => Carbon::now()
            ]);

        // Unlink all previous entries
        DB::table('product_galleries')->where('product_id', $ProductId)->delete();
        $Removed_Gallery_Images = array();
        if ($request['removed_gallery_images'] != "") {
            $Removed_Gallery_Images = json_decode($request['removed_gallery_images']);
        }

        foreach ($Removed_Gallery_Images as $key => $value) {
            $path = public_path() . "/storage/products/" . $value;
            if (file_exists($path)) {
                unlink($path);
            }
        }

        // insert old images record into database
        if ($request->has('previous_photos')) {
            foreach ($request['previous_photos'] as $key => $value) {
                if (!in_array($value, $Removed_Gallery_Images)) {
                    ProductGallery::create([
                        'product_id' => $ProductId,
                        'gallery' => $value,
                        'created_at' => Carbon::now()
                    ]);
                }
            }
        }

        if ($request->has('galleryPictures')) {
            $Count = 1;
            foreach ($request->file('galleryPictures') as $key => $photo) {
                $Name = 'ProductGalleryImage_' . $Count . ' ' . Carbon::now()->format('Ymd') . '-' . Carbon::now()->format('His') . '.' . $photo->extension();
                $path = $photo->storeAs('/public/products/', $Name);
                ProductGallery::create([
                    'product_id' => $ProductId,
                    'gallery' => $Name,
                    'created_at' => Carbon::now()
                ]);
                $Count++;
            }
        }

        /** PRODUCT COLOR **/
        DB::table('product_colors')->where('product_id', $ProductId)->delete();
        /*Unlink Deleted Color Files*/
        if ($request->has('oldProductColorImages')) {
            if ($request['oldProductColorImages'] != '') {
                $DeletedColorFiles = json_decode($request['oldProductColorImages']);
                foreach ($DeletedColorFiles as $deletedColorFile) {
                    $path = public_path() . "/storage/products/" . $deletedColorFile;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            }
        }
        /*Inserting Old Color Entries*/
        if ($request->has('old_product_color')) {
            foreach ($request['old_product_color'] as $index => $OldProductColor) {
                ProductColors::create([
                    'product_id' => $ProductId,
                    'color_id' => $OldProductColor,
                    'color_image' => $request['old_product_image'][$index],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
        }
        /*Inserting New Color Entries*/
        $ProductColors = array();
        $ProductColorImages = array();
        if ($request->has('productColors')) {
            foreach ($request['productColors'] as $index => $productColor) {
                if (isset($request['productColors'][$index]['product_color_image'])) {
                    $CurrentFile = $request['productColors'][$index]['product_color_image'];
                    $Extension = $CurrentFile->extension();
                    $FileStoragePath = '/public/products/';
                    $Name = 'ProductColorImage_' . $index . ' ' . Carbon::now()->format('Ymd') . '-' . Carbon::now()->format('His') . '.' . $Extension;
                    $result = $CurrentFile->storeAs($FileStoragePath, $Name);
                    $ProductColors[] = $productColor['product_color'];
                    $ProductColorImages[] = $Name;
                }
            }
        }
        foreach ($ProductColorImages as $index => $productColorImage) {
            ProductColors::create([
                'product_id' => $ProductId,
                'color_id' => $ProductColors[$index],
                'color_image' => $productColorImage,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // Delete old record
        DB::table('product_sizes')->where('product_id', $ProductId)->delete();
        if (isset($request['sizes'])) {
            foreach ($request->post('sizes') as $index => $size) {
                if (isset($size['size_unit']) && isset($size['size_height']) && isset($size['size_width'])) {
                    if ($size['size_unit'] != "" && $size['size_height'] != "" && $size['size_width'] != "") {
                        ProductSize::create([
                            'product_id' => $ProductId,
                            'unit_id' => $size['size_unit'],
                            'height' => $size['size_height'],
                            'width' => $size['size_width'],
                            'depth' => $size['size_depth'],
                            'created_at' => Carbon::now()
                        ]);
                    }
                }
            }
        }

        DB::commit();
        return redirect()->route('product')->with('success-message', 'Product updated successfully.');
    }

    function delete(Request $request)
    {
        DB::beginTransaction();
        $Affected = DB::table('products')
            ->where('id', '=', $request->post('id'))
            ->update([
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now()
            ]);

        DB::table('product_galleries')->where('product_id', '=', $request->post('id'))->delete();
        DB::table('product_sizes')->where('product_id', '=', $request->post('id'))->delete();
        DB::table('product_weights')->where('product_id', '=', $request->post('id'))->delete();

        if ($Affected) {
            DB::commit();
            return redirect()->route('product')->with('success-message', 'Product deleted successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('product')->with('error-message', 'An unhandled error occurred.');
        }
    }

    function duplicate(Request $request)
    {
        $ProductDetails = DB::table('products')->where('id', $request['id'])->where('deleted_at', null)->get();
        $ProductGallery = DB::table('product_galleries')->where('product_id', '=', $request['id'])->get();
        $ProductSizes = DB::table('product_sizes')->where('product_id', '=', $request['id'])->get();

        DB::beginTransaction();
        $Affected = Product::create([
            'order_no' => $this->getLastOrderNo(),
            'name' => $ProductDetails[0]->name,
            'code' => $ProductDetails[0]->code,
            'brand' => $ProductDetails[0]->brand,
            'category' => $ProductDetails[0]->category,
            'sub_category' => $ProductDetails[0]->sub_category,
            'sub_subcategory' => $ProductDetails[0]->sub_subcategory,
            'clearance_sale' => $ProductDetails[0]->clearance_sale,
            'rating' => $ProductDetails[0]->rating,
            'review' => $ProductDetails[0]->review,
            'installment_calculator' => $ProductDetails[0]->installment_calculator,
            'description' => $ProductDetails[0]->description,
            'short_description' => $ProductDetails[0]->short_description,
            'compare_description' => $ProductDetails[0]->compare_description,
            'primary_img' => null,
            'size_packaging_img' => null,
            'video_link' => $ProductDetails[0]->video_link,
            'video_file' => null,
            'meta_title' => $ProductDetails[0]->meta_title,
            'meta_desc' => $ProductDetails[0]->meta_desc,
            'meta_tags' => $ProductDetails[0]->meta_tags,
            'meta_img' => null,
            'color_variants' => $ProductDetails[0]->color_variants,
            'unit_price' => $ProductDetails[0]->unit_price,
            'purchase_price' => $ProductDetails[0]->purchase_price,
            'tax' => $ProductDetails[0]->tax,
            'tax_price' => $ProductDetails[0]->tax_price,
            'discount' => $ProductDetails[0]->discount,
            'discount_price' => $ProductDetails[0]->discount_price,
            'total_price_without_discount' => $ProductDetails[0]->total_price_without_discount,
            'total_price' => $ProductDetails[0]->total_price,
            'quantity' => $ProductDetails[0]->quantity,
            'free_shipping' => $ProductDetails[0]->free_shipping,
            'shipping_flat_rate' => $ProductDetails[0]->shipping_flat_rate,
            'fast_24hour_delivery' => $ProductDetails[0]->fast_24hour_delivery,
            'normal_2to3days_delivery' => $ProductDetails[0]->normal_2to3days_delivery,
            'zero_free_installation' => $ProductDetails[0]->zero_free_installation,
            'installation_price' => $ProductDetails[0]->installation_price,
            'pdf_specification' => $ProductDetails[0]->pdf_specification,
            'slug' => $ProductDetails[0]->slug,
            'draft_status' => $ProductDetails[0]->draft_status,
            'homepage_status' => $ProductDetails[0]->homepage_status,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        foreach ($ProductSizes as $key => $value) {
            ProductSize::create([
                'product_id' => $Affected->id,
                'unit_id' => $value->unit_id,
                'height' => $value->height,
                'width' => $value->width,
                'depth' => $value->depth,
                'created_at' => Carbon::now()
            ]);
        }

        if ($Affected) {
            DB::commit();
            return redirect()->route('product')->with('success-message', 'Product duplicated successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('product')->with('error-message', 'An unhandled error occurred.');
        }
    }

    function orderUp(Request $request)
    {
        $PreviousRecord = DB::table('products')
            ->where('order_no', '<', $request->post('order_no'))
            ->where('deleted_at', '=', null)
            ->orderBy('order_no', 'DESC')
            ->limit(1)
            ->get();
        if (sizeof($PreviousRecord) > 0) {
            $PreviousOrderNo = $PreviousRecord[0]->order_no;
            DB::beginTransaction();
            $Affected1 = DB::table('products')
                ->where('id', '=', $request->post('id'))
                ->update([
                    'order_no' => $PreviousOrderNo,
                    'updated_at' => Carbon::now()
                ]);
            $Affected2 = DB::table('products')
                ->where('id', '=', $PreviousRecord[0]->id)
                ->update([
                    'order_no' => $request->post('order_no'),
                    'updated_at' => Carbon::now()
                ]);
            DB::commit();
            echo 'Success';
        } else {
            echo 'Success';
        }
        exit();
    }

    function orderDown(Request $request)
    {
        $NextRecord = DB::table('products')
            ->where('order_no', '>', $request->post('order_no'))
            ->orderBy('order_no', 'ASC')
            ->limit(1)
            ->get();
        if (sizeof($NextRecord) > 0) {
            $NextOrderNo = $NextRecord[0]->order_no;
            DB::beginTransaction();
            $Affected1 = DB::table('products')
                ->where('id', '=', $request->post('id'))
                ->update([
                    'order_no' => $NextOrderNo,
                    'updated_at' => Carbon::now()
                ]);
            $Affected2 = DB::table('products')
                ->where('id', '=', $NextRecord[0]->id)
                ->update([
                    'order_no' => $request->post('order_no'),
                    'updated_at' => Carbon::now()
                ]);
            DB::commit();
            echo 'Success';
        } else {
            echo 'Success';
        }
        exit();
    }

    function getLastOrderNo()
    {
        $Product = DB::table('products')
            ->where('deleted_at', '=', null)
            ->max('order_no');
        return $Product + 1;
    }

    function updateHomepageStatus(Request $request)
    {
        DB::beginTransaction();
        $Affected1 = DB::table('products')
            ->where('id', '=', $request->post('id'))
            ->update([
                'homepage_status' => $request->post('status'),
                'updated_at' => Carbon::now()
            ]);
        DB::commit();
        echo 'Success';
    }
}
