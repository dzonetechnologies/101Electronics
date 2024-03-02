<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            101 Electronics
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="{{url('/dashboard')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{url('/')}}" class="nav-link" target="_blank">
                    <i class="link-icon fas fa-eye"></i>
                    <span class="link-title">Visit Site</span>
                </a>
            </li>
            <li class="nav-item nav-category">Manager</li>
            <li class="nav-item" id="productsLink">
                <a class="nav-link" data-toggle="collapse" href="#_productsLink" role="button" aria-expanded="false"
                   aria-controls="emails">
                    <i class="link-icon fa fa-shopping-cart"></i>
                    <span class="link-title">Products</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="_productsLink">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('brands')}}" id="product-brands-link" class="nav-link">Brands</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('categories')}}" id="product-categories-link" class="nav-link">Categories</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('subcategories')}}" id="product-subcategories-link" class="nav-link">Subcategories</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('sub_subcategories')}}" id="product-sub-subcategories-link" class="nav-link">Sub Subcategories</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('product')}}" id="product-products-link" class="nav-link">In House Products</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item" id="attributeLink">
                <a class="nav-link" data-toggle="collapse" href="#_attributeLink" role="button" aria-expanded="false"
                   aria-controls="emails">
                    <i class="link-icon fa fa-check"></i>
                    <span class="link-title">Attributes</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="_attributeLink">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('color')}}" id="product-colors-link" class="nav-link">Colors</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('unit')}}" id="product-units-link" class="nav-link">Units</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item" id="instantCalculator">
                <a class="nav-link" href="{{route('instantcalculator')}}" role="button" aria-expanded="false" aria-controls="instant_calculator">
                    <i class="link-icon fa fa-calculator"></i>
                    <span class="link-title">Instant Calculator</span>
                </a>
            </li>
            <li class="nav-item" id="discountVoucher">
                <a class="nav-link" href="{{route('discountvouchers')}}" role="button" aria-expanded="false" aria-controls="discount_voucher">
                    <i class="link-icon fa fa-percent"></i>
                    <span class="link-title">Discount Voucher</span>
                </a>
            </li>
            <li class="nav-item" id="attributeLink">
                <a class="nav-link" data-toggle="collapse" href="#_generalSettingLink" role="button" aria-expanded="false"
                   aria-controls="emails">
                    <i class="link-icon fas fa-cog"></i>
                    <span class="link-title">General Settings</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="_generalSettingLink">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('settings')}}" id="settings-link" class="nav-link">Settings</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('sliders')}}" id="sliders-link" class="nav-link">Sliders</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('settings.pages')}}" id="pages-link" class="nav-link">Page Content</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('settings.banners')}}" id="banners-link" class="nav-link">Page Banner</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('settings.SizePackagingRoute')}}" id="size-packaging-link" class="nav-link">Size and Packaging</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('settings.AboutUs')}}" id="about-us" class="nav-link">About Us</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item" id="attributeLink">
                <a class="nav-link" data-toggle="collapse" href="#_careRepairLink" role="button" aria-expanded="false"
                   aria-controls="emails">
                    <i class="link-icon fa fa-info"></i>
                    <span class="link-title">Care & Repair</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="_careRepairLink">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('CareRepair.index')}}" id="careRepair" class="nav-link">Care & Repair</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('CareRepair.faq')}}" id="faqs" class="nav-link">Faq's</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('CareRepair.offers')}}" id="offers" class="nav-link">Offers</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('CareRepair.pricing')}}" id="pricing" class="nav-link">Pricing</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('CareRepair.serviceCharges')}}" id="pricing" class="nav-link">Service Charges</a>
                        </li>

                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('orders')}}" role="button" aria-expanded="false" aria-controls="orders">
                    <i class="link-icon fas fa-dollar-sign"></i>
                    <span class="link-title">Orders</span>
                </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="{{route('return-request')}}" role="button" aria-expanded="false" aria-controls="AdminReturnRequest">
                <i class="link-icon  fa fa-comments"></i>
                <span class="link-title">Return Requests</span>
            </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('quote-request')}}" role="button" aria-expanded="false" aria-controls="AdminQuoteRequest">
                    <i class="link-icon fa fa-paper-plane" aria-hidden="true"></i>
                    <span class="link-title">Quote Request</span>
                </a>
            </li>
             <li class="nav-item">
                <a class="nav-link" href="{{route('discountQuestion.add')}}" role="button" aria-expanded="false" aria-controls="AdminQuoteRequest">
                    <i class="link-icon fa fa-question-circle" aria-hidden="true"></i>
                    <span class="link-title">Discount Questions</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('sale-report')}}" role="button" aria-expanded="false" aria-controls="AdminSaleReport">
                    <i class="link-icon fa fa-file"></i>
                    <span class="link-title">Sale Report</span>
                </a>
            </li>
        </ul>
    </div>
</nav>