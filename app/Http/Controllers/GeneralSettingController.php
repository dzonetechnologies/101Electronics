<?php

namespace App\Http\Controllers;

use App\Models\CareRepair;
use App\Models\DeliveryPartsDesign;
use App\Models\Faqs;
use App\Models\GeneralSetting;
use App\Models\Offer;
use App\Models\Pricing;
use App\Models\RateList;
use Carbon\Carbon;
use App\Models\SizePackagingImage;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        $GeneralSettings = DB::table('general_settings')->get();
        return view('dashboard.settings.index', compact('GeneralSettings'));
    }

    function update(Request $request)
    {
        $FileName = $request->post('oldLogo');
        if ($request->has('logo_image')) {
            $Path = public_path('storage/logo') . '/' . $FileName;
            if (file_exists($Path)) {
                unlink($Path);
            }
            unlink($Path);
            $FileName = "";
            $FileName = 'Logo-' . Carbon::now()->format('Ymd-His') . '.' . $request->file('logo_image')->extension();
            $request->file('logo_image')->storeAs('public/logo', $FileName);
        }

        $SecurePayment = array();
        $Oldfile = $request->post('oldsecurePayment');
        if ($request->has('securePayment')) {
            $data = explode(',', $Oldfile);
            foreach ($data as $key => $picture) {
                $Path = public_path('storage/payment-methods/') . '/' . $picture;
                if (file_exists($Path)) {
                    unlink($Path);
                }
            }
            foreach ($request->file('securePayment') as $key => $photo) {
                $Name = 'PaymentMethod' . Carbon::now()->format('Ymd') . '-' . Carbon::now()->format('His') . '.' . $photo->extension();
                $path = $photo->storeAs('/public/payment-methods/', $Name);
                array_push($SecurePayment, $Name);
            }
        }
        if (count($SecurePayment) > 0) {
            $SecurePayment = implode(",", $SecurePayment);
        } else {
            $SecurePayment = null;
        }

        /*B2B*/
        $OldB2BFile = $request->post('b2b');
        $B2bFileName = $OldB2BFile;
        if ($request->has('b2bFile')) {
            if ($OldB2BFile != '') {
                $Path = public_path('storage/b2b/') . '/' . $OldB2BFile;
                if (file_exists($Path)) {
                    unlink($Path);
                }
            }
            $B2bFile = $request->file('b2bFile');
            $B2bFileName = 'B2B-' . Carbon::now()->format('Ymd') . '-' . Carbon::now()->format('His') . '.' . $B2bFile->extension();
            $Result = $B2bFile->storeAs('/public/b2b/', $B2bFileName);
        }

        DB::beginTransaction();
        $Affected = DB::table('general_settings')
            ->update([
                'logo' => $FileName,
                'facebook_pixel' => $request['facebook_pixel'],
                'google_analytics' => $request['google_analytics'],
                'announcement' => $request['announcement'],
                'homepage_selling_tagline' => $request['homepage_selling_tagline'],
                'brandpage_selling_tagline' => $request['brandpage_selling_tagline'],
                'categorypage_selling_tagline' => $request['categorypage_selling_tagline'],
                'shipping_quantity' => $request['shipping_quantity'],
                'shipping_cost' => $request['shipping_cost'],
                'secure_payment' => $SecurePayment,
                'b2b' => $B2bFileName,
                'b2b_discount' => $request['b2b_discount'],
                'promotion' => $request['promotion'],
                'pay_latter' => $request['pay_latter'],
                'updated_at' => Carbon::now()
            ]);
        if ($Affected) {
            DB::commit();
            return redirect()->route('settings')->with('success-message', 'Settings updated successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('settings')->with('error-message', 'An unhandled error occurred.');
        }
    }

    /* Pages - Start */
    function pages()
    {
        return view('dashboard.settings.pages.pages');
    }

    function editPage($PageId)
    {
        $PageDetails = DB::table('general_pages')->where('id', $PageId)->get();
        return view('dashboard.settings.pages.edit', compact('PageId', 'PageDetails'));
    }

    function updatePage(Request $request)
    {
        $PageId = $request->post('page_id');
        DB::beginTransaction();
        $Affected = DB::table('general_pages')
            ->where('id', $PageId)
            ->update([
                'meta_title' => $request['meta_title'],
                'meta_description' => $request['meta_description'],
                'page_link' => $request['page_link'],
                'desc' => $request['page_description'],
                'updated_at' => Carbon::now()
            ]);

        if ($Affected) {
            DB::commit();
            return redirect()->route('settings.pages.edit', [$PageId])->with('success-message', 'Page updated successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('settings.pages.edit', [$PageId])->with('error-message', 'An unhandled error occurred.');
        }
    }
    /* Pages - End */

    /* Page Banners - Start */
    function banners()
    {
        return view('dashboard.settings.banners.banners');
    }

    function editPageBanner($PageId)
    {
        $PageDetails = DB::table('general_pages')->where('id', $PageId)->get();
        return view('dashboard.settings.banners.edit', compact('PageId', 'PageDetails'));
    }

    function updatePageBanner(Request $request)
    {
        $PageId = $request->post('page_id');
        $FileName = $request->post('oldPageBannerImage');
        $FileNameMobile = $request->post('oldPageBannerImageMobile');
        if ($request->has('banner')) {
            if ($FileName != "") {
                $Path = public_path('storage/page-banners') . '/' . $FileName;

                if (file_exists($Path)) {

                    unlink($Path);
                }

            }
            $FileName = "";
            $FileName = 'PageBanner-' . Carbon::now()->format('Ymd-His') . '.' . $request->file('banner')->extension();
            $request->file('banner')->storeAs('public/page-banners', $FileName);
        }
        if ($request->has('banner_mobile')) {
            if ($FileNameMobile != "") {
                $Path = public_path('storage/page-banners') . '/' . $FileNameMobile;
                if (file_exists($Path)) {
                    unlink($Path);
                }

            }
            $FileNameMobile = "";
            $FileNameMobile = 'PageBannerMobile-' . Carbon::now()->format('Ymd-His') . '.' . $request->file('banner_mobile')->extension();
            $request->file('banner_mobile')->storeAs('public/page-banners', $FileNameMobile);
        }

        DB::beginTransaction();
        $Affected = DB::table('general_pages')
            ->where('id', $PageId)
            ->update([
                'banner_img' => $FileName,
                'banner_img_mobile' => $FileNameMobile,
                'updated_at' => Carbon::now()
            ]);

        if ($Affected) {
            DB::commit();
            return redirect()->route('settings.banners.edit', [$PageId])->with('success-message', 'Banner updated successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('settings.banners.edit', [$PageId])->with('error-message', 'An unhandled error occurred.');
        }
    }

    /* Page Banners - End */


    function sizePackaging()
    {
        $Categories = DB::table('categories')->get();
        $SizePackagingImages = DB::table('size_packaging_images')->get();

        $Status = 0;
        foreach ($Categories as $key => $category) {
            foreach ($SizePackagingImages as $index => $packaging) {
                if ($category->id == $packaging->category) {
                    $Status = 1;
                }
            }

            if ($Status == 0) {
                // Insert record
                SizePackagingImage::create([
                    'category' => $category->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        return view('dashboard.settings.size-packaging.index', compact('Categories'));
    }

    function editSizePackagingImage($CategoryId)
    {
        $SizePackagingDetails = DB::table('size_packaging_images')->where('category', $CategoryId)->get();
        return view('dashboard.settings.size-packaging.edit', compact('CategoryId', 'SizePackagingDetails'));
    }

    function updateSizePackagingImage(Request $request)
    {
        $CategoryId = $request['category_id'];
        $FileName = $request->post('oldSizePackagingImage');
        if ($request->has('size_packaging_image')) {
            if ($FileName != "") {

                $Path = public_path('storage/size-packaging') . '/' . $FileName;

                if (file_exists($Path)) {

                    unlink($Path);

                }

            }
            $FileName = "";
            $FileName = 'SizePackaging-' . Carbon::now()->format('Ymd-His') . '.' . $request->file('size_packaging_image')->extension();
            $request->file('size_packaging_image')->storeAs('public/size-packaging', $FileName);
        }
        DB::beginTransaction();
        $Affected = DB::table('size_packaging_images')
            ->where('category', $CategoryId)
            ->update([
                'image' => $FileName,
                'updated_at' => Carbon::now()
            ]);

        if ($Affected) {
            DB::commit();
            return redirect()->route('settings.size-packaging.edit', [$CategoryId])->with('success-message', 'Settings updated successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('settings.size-packaging.edit', [$CategoryId])->with('error-message', 'An unhandled error occurred.');
        }
    }

    //About us
    public function AboutUs()
    {
        $AboutUsDetails = DB::table('about_us')
            ->get();
        return view('dashboard.settings.aboutUs.index', compact('AboutUsDetails'));
    }

    public function AboutUpdate(Request $request)
    {
        $Affected = "";
        DB::beginTransaction();
        $Affected = DB::table('about_us')
            ->update([
                'welcome_text' => $request['welcome_text'],
                'vision' => $request['vision_text'],
                'mission' => $request['mission_text'],
                'values' => $request['values_text'],
                'way_of_work' => $request['wayOfwork_text'],
                'pricing_promise' => $request['pricing_promise'],
                'technical_experts' => $request['technical_experts'],
                'client_support' => $request['client_support'],
                'order_notification' => $request['order_notification'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        if ($Affected) {
            DB::commit();
            return redirect()->route('settings.AboutUs')->with('success-message', 'Details updated successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('settings.AboutUs')->with('error-message', 'An unhandled error occurred.');
        }
    }

    //Care & Repair FAQS
    public function Faq()
    {
        $FaqDetails = DB::table('faqs')
            ->get();
        return view('dashboard.care-repair.faq', compact('FaqDetails'));
    }

    public function updateFaq(Request $request)
    {
        DB::table('faqs')
            ->delete();
        $Affected = "";
        DB::beginTransaction();
        if ($request->has('faq')) {
            foreach ($request->post('faq') as $index => $request) {
                $Affected = Faqs::create([
                    'question' => $request['question'],
                    'answer' => $request['answer'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
        if ($Affected) {
            DB::commit();
            return redirect()->route('CareRepair.faq')->with('success-message', 'Faqs updated successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('CareRepair.faq')->with('error-message', 'An unhandled error occurred.');
        }

    }

    //Care & Repair Offers
    public function offers()
    {
        $OfferDetail = DB::table('offers')->get();
        return view('dashboard.care-repair.offer', compact('OfferDetail'));
    }

    public function updateOffer(Request $request)
    {
        DB::beginTransaction();
        $Affected = DB::table('offers')
            ->update([
                'description' => $request['offer_description'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        if ($Affected) {
            DB::commit();
            return redirect()->route('CareRepair.offers')->with('success-message', 'Offer updated successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('CareRepair.offers')->with('error-message', 'An unhandled error occurred.');
        }
    }

    //Care & Repair Index
    public function careRepair()
    {
        $CareRepairDetail = DB::table('care_repairs')->get();
        return view('dashboard.care-repair.careRepair', compact('CareRepairDetail'));
    }

    public function updateCareRepair(Request $request)
    {
        DB::beginTransaction();
        $Affected = DB::table('care_repairs')
            ->update([
                'description' => $request['careRepair_description'],
                'get_care_repair' => $request['get_care'],
                'inspection' => $request['inspection'],
                'day_fix' => $request['day_fix'],
                'visit_charges' => $request['visit_charges'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        if ($Affected) {
            DB::commit();
            return redirect()->route('CareRepair.index')->with('success-message', 'Details updated successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('CareRepair.index')->with('error-message', 'An unhandled error occurred.');
        }
    }

    //Care & Repair Pricing
    public function pricing()
    {
        $PricingDetails = DB::table('pricings')->get();
        return view('dashboard.care-repair.pricing', compact('PricingDetails'));
    }

    public function pricingUpdate(Request $request)
    {
        DB::beginTransaction();
        $Affected = DB::table('pricings')
            ->update([
                'description' => $request['pricing_description'],
            ]);
        if ($Affected) {
            DB::commit();
            return redirect()->route('CareRepair.pricing')->with('success-message', 'Description updated successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('CareRepair.pricing')->with('error-message', 'An unhandled error occurred.');
        }
    }

    public function serviceCharges()
    {
        $ServiceDetails = DB::table('delivery_service_charges')->get();
        $RateListDetails = DB::table('rate_lists')->get();
        $DeliveryParts = DB::table('delivery_parts_designs')->get();
        return view('dashboard.care-repair.serviceCharges', compact('ServiceDetails', 'RateListDetails','DeliveryParts'));
    }

    public function serviceChargesUpdate(Request $request)
    {

        foreach ($request->post('parts_design') as $index => $parts) {
            DB::table('delivery_parts_designs')
                ->where('id', '=', $parts['id'])
                ->delete();
                $Affected1 =  DeliveryPartsDesign::create([
                'title' => $parts['parts_design'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        DB::beginTransaction();
        $Affected = DB::table('delivery_service_charges')
            ->update([
                'delivery_collection' => $request['delivery_collection'],
                'warranty_pkr' => $request['warranty_pkr'],
                'warranty_usd' => $request['warranty_usd'],
                'nonwarranty_pkr' => $request['nonwarranty_pkr'],
                'nonwarranty_usd' => $request['nonwarranty_usd'],
                'pickup_pkr' => $request['pickup_pkr'],
                'pickup_usd' => $request['pickup_usd'],
                'checkup_pkr' => $request['checkup_pkr'],
                'checkup_usd' => $request['checkup_usd'],
                'installation_problem' => $request['installation_problem'],
                'display_problem' => $request['display_problem'],
                'hardware_problem' => $request['hardware_problem'],
                'product_breakdown' => $request['product_breakdown'],
                'error_occur' => $request['error_occur'],
                'not_working' => $request['not_working'],
                'parts_design' => $request['parts_design'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        if ($Affected && $Affected1) {
            DB::commit();
            return redirect()->route('CareRepair.serviceCharges')->with('success-message', 'Description updated successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('CareRepair.serviceCharges')->with('error-message', 'An unhandled error occurred.');
        }
    }

    public function rateListUpdate(Request $request)
    {
        /* Delete Old Event Jobs */

        foreach ($request->post('rate_list') as $index => $jobdetail) {
            DB::table('rate_lists')
                ->where('id', '=', $jobdetail['id'])
                ->delete();
            $Affected1 = RateList::create([
                'description' => $jobdetail['description'],
                'tv' => $jobdetail['tv'],
                'ac' => $jobdetail['ac'],
                'wm' => $jobdetail['wm'],
                'rff' => $jobdetail['rff'],
                'dw' => $jobdetail['dw'],
                'others' => $jobdetail['others'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        if ($Affected1) {
            DB::commit();
            return redirect()->route('CareRepair.serviceCharges')->with('success', 'Rate List updated successfully');
        } else {
            DB::rollback();
            return redirect()->route('CareRepair.serviceCharges')->with('error', 'Error! An unhandled exception occurred');
        }


    }
    //Care & Repair-End
}
