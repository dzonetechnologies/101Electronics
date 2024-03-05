<script type="application/javascript">
    let nf = new Intl.NumberFormat('en', { //en-AE
        /*style: 'currency',
        currency: 'AED',*/
        minimumFractionDigits: parseInt('2'),
        maximumFractionDigits: parseInt('2')
    });

    $(document).ready(function () {
        if ($("#product-details-page").length > 0) {
            if ($("#unitmmDepthWidth").length > 0) {
                $("#unitmmDepthWidth").show();
            }
            if ($("#unitmmHeight").length > 0) {
                $("#unitmmHeight").show();
            }
            $('[data-toggle="tooltip"]').tooltip();
        }

        let CompareCheckBox = $(".compareCheckBox");
        if (CompareCheckBox.length > 0) {
            CompareCheckBox.each(function (i, obj) {
                $(obj).prop('checked', false);
            });
        }

        $("#review-form").submit(function (event) {
            let Rating = $("#review-star-rating").val();
            if (Rating === '') {
                alert('Please rate product!');
                event.preventDefault();
            }
        });

        UpdateProductQuantityInCart();
        MakeOrdersTable();

        let NiceSelect_Select2 = $(".niceSelect-select2");
        if(NiceSelect_Select2.length > 0) {
            NiceSelect_Select2.niceSelect('destroy').select2();
        }
    });

    $(window).bind("pageshow", function () {
        $(".compareCheckBox").prop("checked", false);
    });

    function ShowSearchSuggestionsM() {
        let Object = $("#search-bar-input-m");
        if (Object.val() !== '') {
            $.ajax({
                type: "post",
                url: "{{ route('searchproductm') }}",
                data: {search: Object.val()}
            }).done(function (data) {
                data = JSON.parse(data);
                console.log(data)
                $("#search-results-m").empty().append(data);
                $(".suggestions-m").show();
            });
        } else {
            $(".suggestions-m").hide();
        }
    }

    function ShowSearchSuggestions() {
        let Object = $("#search-bar-input");
        if (Object.val() !== '') {
            $.ajax({
                type: "post",
                url: "{{ route('searchproduct') }}",
                data: {search: Object.val()}
            }).done(function (data) {
                data = JSON.parse(data);
                $("#search-results").empty().append(data);
                $(".suggestions").show();
            });
        } else {
            $(".suggestions").hide();
        }
    }

    function HideSearchSuggestions() {
        //
    }

    function OpenFacebookPage() {
        window.open('{{\App\Helpers\SiteHelper::settings()['Facebook']}}', '_blank');
    }

    function OpenInstagramPage() {
        window.open('{{\App\Helpers\SiteHelper::settings()['Instagram']}}', '_blank');
    }

    function OpenLinkedInPage() {
        window.open('{{\App\Helpers\SiteHelper::settings()['LinkedIn']}}', '_blank');
    }

    /*Care & Repair*/
    function ChangeTab(TabId, TabContentId) {
        $("#tab1").removeClass('card-header-tabs-active');
        $("#tab2").removeClass('card-header-tabs-active');
        $("#tab3").removeClass('card-header-tabs-active');
        $("#tab4").removeClass('card-header-tabs-active');
        $("#tab1Content").hide();
        $("#tab2Content").hide();
        $("#tab3Content").hide();
        $("#tab4Content").hide();
        $("#" + TabId).addClass('card-header-tabs-active');
        $("#" + TabContentId).fadeIn();
    }

    function CareRepairTableLoad(e) {
        let Type = $(e).data('type');
        $.ajax({
            type: "post",
            url: "{{ route('CareRepairTableLoadRoute') }}",
            data: { Type : Type }
        }).done(function (data) {
            data = window.atob(JSON.parse(data));
            if(data !== '') {
                $("#serviceRateListDiv1").hide();
                $("#serviceRateListDiv2").show().html(data);
            } else {
                $("#serviceRateListDiv1").show();
                $("#serviceRateListDiv2").hide().html('');
            }
        });
    }

    /*Product Details*/
    function ChangeGalleryImage(e, id) {
        let Image = $(e).attr('src');
        $("#product-image-container").show().attr('src', Image).ezPlus();
        $("#product-image-container-mob").show().attr('src', Image).ezPlus({
            zoomWindowWidth: 170,
            zoomWindowHeight: 300
        });
        $("#product-video-container").hide().attr('src', '');
        $("#product-video-iframe").ezPlus().hide().attr('src', '');
        $("#colorImageDisplay").attr('src', '').hide();
    }

    function DisplayIframe(id) {
        let VideoLink = id.split('||')[1];
        $("#product-image-container").hide().attr('src', '').ezPlus();
        $("#product-image-container-mob").hide().attr('src', '');
        $("#product-video-container").hide().attr('src', '');
        $("#product-video-iframe").show().attr('src', VideoLink);
    }

    function DisplayVideoTag(id) {
        let VideoFile = id.split('||')[1];
        $("#product-image-container").hide().attr('src', '');
        $("#product-image-container-mob").hide().attr('src', '');
        $("#product-video-container").show().attr('src', VideoFile);
        $("#product-video-iframe").hide().attr('src', '');
    }

    function CheckNumberInputForQty(e, event, value) {
        // Allow only backspace and delete
        if (event.keyCode === 8) {
            // let it happen, don't do anything
        } else {
            // Ensure that it is a number and stop the keypress
            if (event.keyCode < 48 || event.keyCode > 57) {
                event.preventDefault();
            }
        }
    }

    function CheckQuantityInput() {
        let e = $("#quantity");
        if (e.val() === '') {
            e.val(1);
        }
    }

    function ReduceQty(Element, Value) {
        let Qty = $(Element).val();
        if (Qty !== '') {
            if (parseFloat(Qty) > 1) {
                $(Element).val(parseFloat(Qty) - Value);
                CalculatePrice();
            }
        }
    }

    function IncreaseQty(Element, Value) {
        let Qty = $(Element).val();
        if (Qty !== '') {
            $(Element).val(parseFloat(Qty) + Value);
            CalculatePrice();
        }
    }

    function CalculatePrice() {
        CheckQuantityInput();
        let Currency = $("#hiddenCurrency").val();
        let NonDiscountedPrice = $("#hiddenTotalPriceWithoutDiscounted").val();
        let DiscountedPrice = $("#hiddenTotalPrice").val();
        let Discount = parseFloat($("#hiddenDiscount").val());
        let Qty = $("#quantity").val();
        if (Qty !== '') {
            if (Discount !== 0) {
                $("#productPriceDisplay").text(Currency + ' ' + nf.format(parseFloat(DiscountedPrice) * parseFloat(Qty)));
                $("#productOrgPriceDisplay").text(Currency + ' ' + nf.format(parseFloat(NonDiscountedPrice) * parseFloat(Qty)));
                $("#hiddenTotalQuantity").val(Qty);
            } else {
                $("#productPriceDisplay").text(Currency + ' ' + nf.format(parseFloat(DiscountedPrice) * parseFloat(Qty)));
                $("#hiddenTotalQuantity").val(Qty);
            }
        }
    }

    function ChangeProductSizeUnits(e, value) {
        if ($("#unitmmDepthWidth").length > 0 && $("#unitmmHeight").length > 0) {
            if (value) {
                $("#unitmmDepthWidth").hide();
                $("#unitmmHeight").hide();
                $("#unitinchesDepthWidth").show();
                $("#unitinchesHeight").show();
            } else {
                $("#unitmmDepthWidth").show();
                $("#unitmmHeight").show();
                $("#unitinchesDepthWidth").hide();
                $("#unitinchesHeight").hide();
            }
        }
    }

    function SelectSubCategory(id, e) {
        $(".subCatBtn").each(function (i, obj) {
            $(obj).removeClass('activeSubCategoryBlock').addClass('subCategoryBlock');
        });
        $(e).addClass('activeSubCategoryBlock');
        $("#hiddenSelectedSubCat").val(id);
        /*$("#SubCatDisplayText").text($(e).text());*/
    }

    function LoadSubSubCategory () {
        let SubCategory = $("input[name='subCatFilter']:checked").val();
        if (SubCategory !== '0') {
            $.ajax({
                type: "post",
                url: "{{ route('CompareRoute.subSubCategories') }}",
                data: {id: SubCategory}
            }).done(function (data) {
                data = JSON.parse(data);
                $("#TotalSubSubCategoryCount").val(data.length);
                let rows = '';
                for (let i = 0; i < data.length; i++) {
                    rows += '' +
                        '<div class="row align-items-center line-height-1-3 mb-2">' +
                        '   <div class="col-8"><div class="fs-13">' + data[i].title + '</div></div>' +
                        '   <div class="col-4 text-end">' +
                        '       <label class="switch-sm" for="subSubCatFilter' + i + '">' +
                        '           <input type="checkbox" class="checkboxForSubSubCategory" name="subSubCatFilter[]"' +
                        '               id="subSubCatFilter' + i + '" value="' + data[i].id + '"' +
                        '               onchange="document.getElementById(\'checkboxSubSubCat\').checked = false; AllSubSubCategoryChecker();ApplyRunTimeFilters();"' +
                        '               checked>' +
                        '               <span class="slider-sm round"></span>' +
                        '       </label>' +
                        '   </div>' +
                        '</div>';
                }
                $("#subSubCategoryDiv").html(rows);
                $("#checkboxSubSubCat").prop('checked', true);
            });
        } else {
            $("#checkboxSubSubCat").prop('checked', true);
            $("#subSubCategoryDiv").html('');
        }
    }

    function CheckForAllSubSubCategory(value) {
        if (value) {
            $(".checkboxForSubSubCategory").each(function (i, obj) {
                $(obj).prop('checked', true);
            });
        } else {
            $(".checkboxForSubSubCategory").each(function (i, obj) {
                $(obj).prop('checked', false);
            });
        }
    }

    function AllSubSubCategoryChecker() {
        let Total = parseInt($("#TotalSubSubCategoryCount").val());
        let Count = 0;
        $(".checkboxForSubSubCategory").each(function (i, obj) {
            if ($(obj).prop('checked')) {
                Count++;
            }
        });
        if (Count === Total) {
            $("#checkboxSubSubCat").prop('checked', true).trigger('change');
        }
    }

    function CheckForAllBrands(value) {
        if (value) {
            $(".checkboxForBrands").each(function (i, obj) {
                $(obj).prop('checked', true);
            });
        } else {
            $(".checkboxForBrands").each(function (i, obj) {
                $(obj).prop('checked', false);
            });
        }
    }

    function AllBrandsChecker() {
        let TotalBrands = parseInt($("#TotalBrandsCount").val());
        let Count = 0;
        $(".checkboxForBrands").each(function (i, obj) {
            if ($(obj).prop('checked')) {
                Count++;
            }
        });
        if (Count === TotalBrands) {
            $("#checkboxBrands").prop('checked', true).trigger('change');
        }
    }

    function ApplyFilters() {
        let SubCategory = $("input[name='subCatFilter']:checked").val();
        let StartPrice = $("#startRange").val();
        let EndPrice = $("#endRange").val();
        let SubSubCategories = [];
        let Brands = [];
        $("input[name='CheckboxBrands[]']:checked").each(function () {
            Brands.push($(this).val());
        });
        $("input[name='subSubCatFilter[]']:checked").each(function () {
            SubSubCategories.push($(this).val());
        });
        if (Brands.length === 0) {
            alert('Please select at least one brand!');
        } else if (StartPrice === '' || EndPrice === '') {
            alert('Please input a price range!');
        } else if (SubSubCategories.length === 0) {
            alert('Please select at least one sub subcategory!');
        } else {
            let UrlSlug = $("#UrlSlug").val();
            let Url = '';
            let BrandUrl = '';
            let SubSubCategoryUrl = '';
            if (parseInt(Brands[0]) === 0) {
                BrandUrl = '&brands=';
            } else {
                BrandUrl = '&brands=' + btoa(JSON.stringify(Brands));
            }
            if (parseInt(SubSubCategories[0]) === 0) {
                SubSubCategoryUrl = '&subSub=';
            } else {
                SubSubCategoryUrl = '&subSub=' + btoa(JSON.stringify(SubSubCategories));
            }
            Url = '{{url('/compare')}}' + '/' + UrlSlug + '?sub=' + SubCategory + SubSubCategoryUrl + '&range=' + StartPrice + '_' + EndPrice + BrandUrl;
            window.open(Url, '_self');
        }
    }

    function ApplySubCategoryRunTimeFilters() {
        let SubCategory = $("input[name='subCatFilter']:checked").val();
        let StartPrice = $("#startRange").val();
        let EndPrice = $("#endRange").val();
        let SubSubCategories = [];
        let Brands = [];
        let FilterType = "subcategory";
        $("input[name='CheckboxBrands[]']:checked").each(function () {
            Brands.push($(this).val());
        });
        if (Brands.length === 0) {
            alert('Please select at least one brand!');
        } else if (StartPrice === '' || EndPrice === '') {
            alert('Please input a price range!');
        } else {
            {{-- Apply Ajax --}}
            $.ajax({
                type: "post",
                url: "{{ route('CompareRunTimeRoute') }}",
                data: {
                    SubCategory: SubCategory,
                    SubSubCategories: JSON.stringify(SubSubCategories),
                    Brands: JSON.stringify(Brands),
                    StartPrice: StartPrice,
                    EndPrice: EndPrice,
                    FilterType: FilterType,
                    slug: $("#UrlSlug").val(),
                }
            }).done(function (data) {
                let s = data;
                s = s.replace(/\\n/g, "\\n")
                    .replace(/\\'/g, "\\'")
                    .replace(/\\"/g, '\\"')
                    .replace(/\\&/g, "\\&")
                    .replace(/\\r/g, "\\r")
                    .replace(/\\t/g, "\\t")
                    .replace(/\\b/g, "\\b")
                    .replace(/\\f/g, "\\f");
                s = s.replace(/[\u0000-\u0019]+/g, "");
                let Record = JSON.parse(s);
                $("#RecordSections").html('').html(Record);
                sliderInit();
            });
        }
    }

    function ApplyRunTimeFilters() {
        let SubCategory = $("input[name='subCatFilter']:checked").val();
        let StartPrice = $("#startRange").val();
        let EndPrice = $("#endRange").val();
        let SubSubCategories = [];
        let Brands = [];
        let FilterType = "others";
        $("input[name='CheckboxBrands[]']:checked").each(function () {
            Brands.push($(this).val());
        });
        $("input[name='subSubCatFilter[]']:checked").each(function () {
            SubSubCategories.push($(this).val());
        });
        if (Brands.length === 0) {
            alert('Please select at least one brand!');
        } else if (StartPrice === '' || EndPrice === '') {
            alert('Please input a price range!');
        } else if (SubSubCategories.length === 0) {
            alert('Please select at least one sub subcategory!');
        } else {
            {{-- Apply Ajax --}}
            $.ajax({
                type: "post",
                url: "{{ route('CompareRunTimeRoute') }}",
                data: {
                    SubCategory: SubCategory,
                    SubSubCategories: JSON.stringify(SubSubCategories),
                    Brands: JSON.stringify(Brands),
                    StartPrice: StartPrice,
                    EndPrice: EndPrice,
                    FilterType: FilterType,
                    slug: $("#UrlSlug").val(),
                }
            }).done(function (data) {
                let s = data;
                s = s.replace(/\\n/g, "\\n")
                    .replace(/\\'/g, "\\'")
                    .replace(/\\"/g, '\\"')
                    .replace(/\\&/g, "\\&")
                    .replace(/\\r/g, "\\r")
                    .replace(/\\t/g, "\\t")
                    .replace(/\\b/g, "\\b")
                    .replace(/\\f/g, "\\f");
                s = s.replace(/[\u0000-\u0019]+/g, "");
                let Record = JSON.parse(s);
                $("#RecordSections").html('').html(Record);
                sliderInit();
            });
        }
    }

    // Product Details
    function toggleDeliveryOptions() {
        $("#deliveryOptionsModal").modal('toggle');
    }

    function toggleReturnCancellations() {
        $("#returnCancellationsModal").modal('toggle');
    }

    /*Cart Functions*/
    function AddToCartProductDetails(e, Checkout = false) {
        $(e).attr('disabled', true);
        let Product = $("#hiddenProductId").val();
        let Qty = $("#quantity").val();
        $.ajax({
            type: "post",
            url: "{{ route('add.to.cart') }}",
            data: {Product: Product, Quantity: Qty}
        }).done(function (data) {
            $(e).attr('disabled', false);
            if (Checkout) {
                window.location.href = '{{route('CheckoutRoute')}}';
            } else {
                ShowToast(data);
                ShowCartCount();
                LoadCartModalHtml();
                LoadCartPageHtml();
                LoadCheckoutPageHtml();
            }
        });
    }

    function AddToCart(e, Product, Count) {
        $(e).hide();
        $("#addToCartDiv_" + Count).show();
        $.ajax({
            type: "post",
            url: "{{ route('add.to.cart') }}",
            data: {Product: Product}
        }).done(function (data) {
            ShowToast(data);
            ShowCartCount();
            LoadCartModalHtml();
            LoadCartPageHtml();
            LoadCheckoutPageHtml();
            $(e).show();
            $("#addToCartDiv_" + Count).hide();
        });
    }

    function RemoveFromCart(Id) {
        if (confirm("Sure you want to remove from cart?")) {
            $.ajax({
                type: "post",
                url: "{{ route('remove.from.cart') }}",
                data: {Product: Id}
            }).done(function (data) {
                ShowToast(data);
                ShowCartCount();
                LoadCartModalHtml();
                LoadCartPageHtml();
                LoadCheckoutPageHtml();
            });
        }
    }

    function ShowCartCount() {
        $.ajax({
            type: "post",
            url: "{{ route('CartCount') }}",
            data: {}
        }).done(function (data) {
            if (parseInt(data) !== 0) {
                $("#headerCartCount").html('<sup>' + data + '</sup>');
                $("#headerCartCountM").html('<sup>' + data + '</sup>');
            } else {
                $("#headerCartCount").html('');
                $("#headerCartCountM").html('');
            }
        });
    }

    function LoadCartModalHtml() {
        $.ajax({
            type: "post",
            url: "{{ route('cart.modal.html') }}",
            data: {}
        }).done(function (data) {
            $("#cartSideModal").html(atob(JSON.parse(data)));
        });
    }

    function LoadCartPageHtml() {
        let cartPageHtml = $("#cartPageHtml");
        if (cartPageHtml.length > 0) {
            $.ajax({
                type: "post",
                url: "{{ route('cart.page.html') }}",
                data: {}
            }).done(function (data) {
                cartPageHtml.html(atob(JSON.parse(data)));
                UpdateProductQuantityInCart();
            });
        }
    }

    function LoadCheckoutPageHtml() {
        let checkoutPageHtml = $("#checkoutPageHtml");
        if (checkoutPageHtml.length > 0) {
            $.ajax({
                type: "post",
                url: "{{ route('checkout.page.html') }}",
                data: {}
            }).done(function (data) {
                checkoutPageHtml.html(atob(JSON.parse(data)));
            });
        }
    }

    function UpdateProductQuantityInCart() {
        $(".qtybutton").on("click", function () {
            let $button = $(this);
            let ProductId = $button.attr('id').split('_')[1];
            let oldValue = $button.parent().find("input").val();
            let newVal = 0;
            if ($button.text() == "+") {
                newVal = parseFloat(oldValue) + 1;
            } else {
                if (oldValue > 0) {
                    newVal = parseFloat(oldValue) - 1;
                } else {
                    newVal = 0;
                }
            }
            $button.parent().find("input").val(newVal);
            $.ajax({
                type: "post",
                url: "{{ route('cart.quantity.update') }}",
                data: {Product: ProductId, Quantity: newVal}
            }).done(function (data) {
                ShowToast(data);
                LoadCartModalHtml();
                LoadCartPageHtml();
                LoadCheckoutPageHtml();
            });
        });
    }

    /*Cart Functions*/

    /*Discount Code*/
    function ApplyDiscountCode(e) {
        let Code = $("#discountCodeInput");
        let OrderTotal = $("#orderTotal").val();
        if (Code.val() !== '') {
            $(e).attr('disabled', true);
            Code.attr('disabled', true);
            $.ajax({
                type: "post",
                url: "{{ route('apply.discount.code') }}",
                data: {Code: Code.val(), OrderTotal: OrderTotal}
            }).done(function (data) {
                data = JSON.parse(data);
                let ChangeInAmount = parseFloat(data.amountChange);
                if (ChangeInAmount !== 0) {
                    let NewAmount = parseFloat(OrderTotal) - ChangeInAmount;
                    $("#voucherAmount").val(ChangeInAmount);
                    $("#orderTotal").val(NewAmount);
                    $("#orderTotalDisplay").text(data.currency + ' ' + nf.format(NewAmount));
                    $("#discountAmountTr").show();
                    $("#discountAmountTr td:nth-child(2)").html('<b class="text-danger">- ' + ' ' + data.currency + ' ' + nf.format(ChangeInAmount) + '</b>');
                    /*Code.val('');*/
                    ShowToast(data.message, 'success', 4000);
                } else {
                    $(e).attr('disabled', false);
                    Code.attr('disabled', false).val('');
                    ShowToast(data.message, 'danger', 4000);
                }
            });
        }
    }

    /*Discount Code*/

    /*Checkout*/
    // duplicating values with checkbox in checkout
    function CopyBillingAddress() {
        $(document).on("change", "#checkboxCopyAddress", function () {
            if ($('#checkboxCopyAddress').is(':checked')) {
                var billingaddress = $("#ltn__billing_address").val();
                $("#ltn__shipping_address").val(billingaddress);
                var billingcity = $("#ltn__billing_city").val();
                $("#ltn__shipping_city").val(billingcity);
                var billingstate = $("#ltn__billing_state").val();
                $("#ltn__shipping_state").val(billingstate);
                var billingzipcode = $("#ltn__billing_zipcode").val();
                $("#ltn__shipping_zipcode").val(billingzipcode);
            } else {
                $('#ltn__shipping_address').val('');
                $("#ltn__shipping_city").val('');
                $("#ltn__shipping_state").val('');
                $("#ltn__shipping_zipcode").val('');
            }
        });
    }

    function ChangePaymentGateway(Value) {
        $("#paymentGateWay").val(Value);
    }

    /**
     * @return {boolean}
     */
    function ValidateAllRequiredFields() {
        let FirstName = $("#ltn__first_name");
        let LastName = $("#ltn__last_name");
        let Email = $("#ltn__email");
        let Phone = $("#ltn__phone");
        let Company = $("#ltn__company");
        let CompanyAddress = $("#ltn__company_address");

        /*Billing Address*/
        let BAddress = $("#ltn__billing_address");
        let BCity = $("#ltn__billing_city");
        let BState = $("#ltn__billing_state");
        let BZipcode = $("#ltn__billing_zipcode");
        /*Shipping Address*/
        let SAddress = $("#ltn__shipping_address");
        let SCity = $("#ltn__shipping_city");
        let SState = $("#ltn__shipping_state");
        let SZipcode = $("#ltn__shipping_zipcode");

        let Notes = $("#ltn__message");
        let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if (jQuery.trim(FirstName.val()) === '') {
            FirstName.focus();
            return false;
        }

        if (jQuery.trim(LastName.val()) === '') {
            LastName.focus();
            return false;
        }

        if (!regex.test(Email.val())) {
            Email.focus();
            return false;
        }

        if (jQuery.trim(Phone.val()) === '') {
            Phone.focus();
            return false;
        }

        if (jQuery.trim(BAddress.val()) === '') {
            BAddress.focus();
            return false;
        }

        if (jQuery.trim(BCity.val()) === '') {
            BCity.focus();
            return false;
        }

        if (jQuery.trim(BState.val()) === '') {
            BState.focus();
            return false;
        }

        if (jQuery.trim(BZipcode.val()) === '') {
            BZipcode.focus();
            return false;
        }

        if (jQuery.trim(SAddress.val()) === '') {
            SAddress.focus();
            return false;
        }

        if (jQuery.trim(SCity.val()) === '') {
            SCity.focus();
            return false;
        }

        if (jQuery.trim(SState.val()) === '') {
            SState.focus();
            return false;
        }

        if (jQuery.trim(SZipcode.val()) === '') {
            SZipcode.focus();
            return false;
        }
        return true;
    }

    function CheckoutCheck(e) {
        let Code = $("#discountCodeInput");
        let CreateAccount = $("#createAccount").prop('checked');
        let Email = $("#ltn__email").val();
        $.ajax({
            type: "post",
            url: "{{ route('checkout.check') }}",
            data: {Code: Code.val(), CreateAccount: CreateAccount, Email: Email}
        }).done(function (data) {
            data = JSON.parse(data);
            if (!data.Status) {
                ShowToast(data.Message, 'danger', 3000);
                $(e).html('Place Order').removeClass('d-flex').removeClass('align-items-center').attr('disabled', false);
            } else {
                /*All good here (Stock + Calculations with Discount Code)*/
                $("#orderSubTotal").val(data.CartSubTotal);
                $("#orderShipping").val(data.Shipping);
                $("#orderInstallation").val(data.Installation);
                $("#voucherAmount").val(data.VoucherAmount);
                $("#orderTotal").val(data.OrderTotal);
                /*Save Order*/
                SaveOrder(e);
            }
        });
    }

    function SaveOrder(e) {
        let FirstName = $("#ltn__first_name").val();
        let LastName = $("#ltn__last_name").val();
        let Email = $("#ltn__email").val();
        let Phone = $("#ltn__phone").val();
        let Company = $("#ltn__company").val();
        let CompanyAddress = $("#ltn__company_address").val();

        /*Billing Address*/
        let BAddress = $("#ltn__billing_address").val();
        let BCity = $("#ltn__billing_city").val();
        let BState = $("#ltn__billing_state").val();
        let BZipcode = $("#ltn__billing_zipcode").val();
        /*Shipping Address*/
        let SAddress = $("#ltn__shipping_address").val();
        let SCity = $("#ltn__shipping_city").val();
        let SState = $("#ltn__shipping_state").val();
        let SZipcode = $("#ltn__shipping_zipcode").val();

        let Notes = $("#ltn__message").val();
        let PaymentGateWay = $("#paymentGateWay").val();
        let CreateAccount = $("#createAccount").prop('checked');
        let Code = $("#discountCodeInput").val();
        let OrderSubTotal = $("#orderSubTotal").val();
        let OrderGSTTotal = $("#orderGSTTotal").val();
        let OrderDiscountTotal = $("#orderDiscountTotal").val();
        let OrderShipping = $("#orderShipping").val();
        let OrderInstallation = $("#orderInstallation").val();
        let VoucherAmount = $("#voucherAmount").val();
        let OrderTotal = $("#orderTotal").val();

        $.ajax({
            type: "post",
            url: "{{ route('checkout.order') }}",
            data: {
                FirstName: FirstName,
                LastName: LastName,
                Email: Email,
                Phone: Phone,
                Company: Company,
                CompanyAddress: CompanyAddress,
                BAddress: BAddress,
                BCity: BCity,
                BState: BState,
                BZipcode: BZipcode,
                SAddress: SAddress,
                SCity: SCity,
                SState: SState,
                SZipcode: SZipcode,
                Notes: Notes,
                PaymentGateWay: PaymentGateWay,
                CreateAccount: CreateAccount,
                Code: Code,
                OrderSubTotal: OrderSubTotal,
                OrderGSTTotal: OrderGSTTotal,
                OrderDiscountTotal: OrderDiscountTotal,
                OrderB2BDiscount: $("#b2bDiscount").val(),
                OrderShipping: OrderShipping,
                OrderInstallation: OrderInstallation,
                VoucherAmount: VoucherAmount,
                OrderTotal: OrderTotal
            }
        }).done(function (data) {
            data = JSON.parse(data);
            let InvoiceNo = data.OrderId;
            if (!data.Status) {
                /*window.location.href = '{{url('checkout/order/complete')}}' + '/?status=' + btoa('failed') + '&order_no=' + btoa(InvoiceNo);*/
                ShowToast(data.Message, 'danger', 3000);
            } else {
                window.location.href = '{{url('checkout/order/complete')}}' + '/?status=' + btoa('success') + '&order_no=' + btoa(InvoiceNo);
                /*ShowToast("Order Placed Successfully", 'success', 3000);*/
            }
            $(e).html('Place Order').removeClass('d-flex').removeClass('align-items-center').attr('disabled', false);
        });
    }

    function PlaceOrder(e) {
        grecaptcha.ready(function () {
            grecaptcha.execute('6LcUceMfAAAAACPs5b7QopMRLfY2CeRZI37yIf94', {action: "submit"}).then(function (token) {
                if (token) {
                    /*document.getElementById('order_token').value=token;
                    $("#order_form").submit();*/
                    $(e).html('<div class="spinner-border" role="status">' +
                        '       <span class="sr-only">Loading...</span>' +
                        '      </div>&nbsp;&nbsp;Place Order').addClass('d-flex').addClass('align-items-center').attr('disabled', true);
                    if (ValidateAllRequiredFields()) {
                        /*Fields Validated*/
                        /*Check for Stock and Calculations*/
                        CheckoutCheck(e);
                    } else {
                        /*Fields not Validated*/
                        $(e).html('Place Order').removeClass('d-flex').removeClass('align-items-center').attr('disabled', false);
                        window.scrollTo(100, 100);
                        ShowToast('Required Fields are missing', 'danger', 3000);
                    }
                }
            })
        });
    }

    /*Checkout*/

    /*Wishlist Functions*/
    function AddToWishlist(Text, ProductId, e) {
        @if(\Illuminate\Support\Facades\Auth::check())
        // Add To List
        if (ProductId !== '') {
            $.ajax({
                type: "post",
                url: "{{ route('AddToWishList') }}",
                data: {ProductId: ProductId}
            }).done(function (data) {
                if (data === 'Added') {
                    $(e).addClass('bg-custom-primary').addClass('text-white').text('Wishlisted');
                    ShowToast('Product Added in the list');
                } else {
                    $(e).removeClass('bg-custom-primary').removeClass('text-white').text('Wishlist');
                    ShowToast('Product Removed from the list');
                }
                ShowWishlistCount();
            });
        } else {
            window.location.href = '{{url('account')}}' + '?list=1';
        }
        @else
        // Please login first
        $("#addToWishlistText").text(Text);
        $("#addToWishListModal").modal('toggle');
        @endif
    }

    function AddToWishlistProductDetails(Text, ProductId, e) {
        @if(\Illuminate\Support\Facades\Auth::check())
        // Add To List
        if (ProductId !== '') {
            $.ajax({
                type: "post",
                url: "{{ route('AddToWishList') }}",
                data: {ProductId: ProductId}
            }).done(function (data) {
                if (data === 'Added') {
                    $(e).html('<i class="fas fa-heart text-custom-primary pdfGuideSetting"></i> Wishlisted');
                    ShowToast('Product Added in the list');
                } else {
                    $(e).html('<i class="far fa-heart text-custom-primary pdfGuideSetting"></i> Wishlist');
                    ShowToast('Product Removed from the list');
                }
                ShowWishlistCount();
            });
        } else {
            window.location.href = '{{url('account')}}' + '?list=1';
        }
        @else
        // Please login first
        $("#addToWishlistText").text(Text);
        $("#addToWishListModal").modal('toggle');
        @endif
    }

    function ShowWishlistCount() {
        $.ajax({
            type: "post",
            url: "{{ route('WishListCount') }}",
            data: {}
        }).done(function (data) {
            if (parseInt(data) !== 0) {
                $("#headerWishListCount").html('<sup>' + data + '</sup>');
                $("#headerWishListCountM").html('<sup>' + data + '</sup>');
            } else {
                $("#headerWishListCount").html('');
                $("#headerWishListCountM").html('');
            }
        });
    }

    function CloseModal(id) {
        $("#" + id).modal('toggle');
    }

    function ShowToast(Text, Type = 'default', Timeout = 2000) {
        let x = $("#snackbar");
        if (Type === 'default') {
            x.css('background-color', '#333');
        } else if (Type === 'success') {
            x.css('background-color', '#198754');
        } else if (Type === 'danger') {
            x.css('background-color', '#C71738');
        }
        x.text(Text).fadeIn();
        setTimeout(function () {
            x.fadeOut();
        }, Timeout);
        /*x.text(Text).addClass("show").slideDown();
        setTimeout(function(){ x.text('').removeClass("show").slideUp(); }, Timeout);*/
    }

    /*Wishlist Functions*/

    /*Track Order*/
    function SearchOrderForTracking() {
        let InvoiceNo = $("#trackOrder").val();
        if (jQuery.trim(InvoiceNo) !== '') {
            let trackOrderPage = $("#trackOrderPage");
            if (trackOrderPage.length > 0) {
                $.ajax({
                    type: "post",
                    url: "{{ route('track.order.invoiceNo') }}",
                    data: {InvoiceNo: InvoiceNo}
                }).done(function (data) {
                    trackOrderPage.hide().html(atob(JSON.parse(data))).slideDown();
                });
            }
        }
    }

    /*Track Order*/

    /*Account Page*/
    function EditAddress(Type) {
        if (Type === 'Billing') {
            $("#addressModalTitle").text('Edit Billing Address');
            $("#ltn__address").val($("#billing_address").val());
            $("#ltn__city").val($("#billing_city").val());
            $("#ltn__state").val($("#billing_state").val());
            $("#ltn__zipcode").val($("#billing_zipcode").val());
            $("#address_type").val('billing');
        } else {
            $("#addressModalTitle").text('Edit Shipping Address');
            $("#ltn__address").val($("#shipping_address").val());
            $("#ltn__city").val($("#shipping_city").val());
            $("#ltn__state").val($("#shipping_state").val());
            $("#ltn__zipcode").val($("#shipping_zipcode").val());
            $("#address_type").val('shipping');
        }
        $("#editAddressModal").modal('toggle');
    }

    function MakeOrdersTable() {
        let Table = $("#accountOrdersTable");
        let CustomerId = $("#customer_id").val();
        if (Table.length > 0) {
            Table.DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "ajax": {
                    "url": "{{ route('home.account.orders.all')  }}",
                    "type": "POST",
                    "data": {CustomerId: CustomerId}
                },
                'columns': [
                    {data: 'id'},
                    {data: 'invoice_no'},
                    {data: 'created_at'},
                    {data: 'order_total'},
                    {data: 'order_notes'},
                    {data: 'order_status'},
                    {data: 'action', orderable: false}
                ],
                'order': [0, 'asc']
            });
        }
    }

    $(function () {
        $('#WAButton').floatingWhatsApp({
            phone: '923251011019', //WhatsApp Business phone number
            headerTitle: 'Chat with us on WhatsApp!', //Popup Title
            popupMessage: 'Hello, how can we help you?', //Popup Message
            showPopup: true, //Enables popup display
            buttonImage: '<img src="{{asset('public/storage/logo/whatsapp.png')}}" alt="Whatsapp" />', //Button Image
            //headerColor: 'crimson', //Custom header color
            //backgroundColor: 'crimson', //Custom background button color
            position: "right" //Position: left | right

        });
    });

    //ElevateZoom-Plugin
    $("#product-image-container").ezPlus();
    $("#product-image-container-mob").ezPlus({
        zoomWindowWidth: 170,
        zoomWindowHeight: 300
    });

    /*Customer Reviews*/

    //Review modal window
    function postReview() {
        $("#submitReviewModal").modal('toggle');
    }

    function ChangeColor(count, event) {
        let Rating = $("#review-star-rating").val();
        if (Rating === '') {
            if (event === 'enter') {
                for (let i = 1; i <= count; i++) {
                    $("#review-star-" + i).css('color', '#ffb33e');
                }
            } else {
                for (let i = 1; i <= count; i++) {
                    $("#review-star-" + i).css('color', 'black');
                }
            }
        }
    }

    function SetRating(Rating) {
        $("#review-star-rating").val(Rating);
        /*Reset Rating*/
        for (let i = 1; i <= 5; i++) {
            $("#review-star-" + i).css('color', 'black');
        }
        /*New Rating*/
        for (let i = 1; i <= Rating; i++) {
            $("#review-star-" + i).css('color', '#ffb33e');
        }
    }

    function DeleteReview(id) {
        let Confirm = window.confirm('Sure you want to remove this review?');
        if (Confirm) {
            $.ajax({
                type: "post",
                url: "{{ route('customer.reviews.delete') }}",
                data: {Id: id}
            }).done(function (data) {
                window.location.reload();
            });
        }
    }
    /*Customer Reviews*/

    //loadSubCategory

    function loadProductSubCategory(product)
    {
        $.ajax({
            type: 'post',
            url: '{{route('product.subcategory.load')}}',
            data: {Product: product}
        }).done(function (data) {
            data = JSON.parse(data);
            $("#product_sub_category").niceSelect('destroy').html(data).select2();
        });
    }

    function loadSubCategoryProduct(product_sub_category)
    {
        let productType = $('#product').val();
        $.ajax({
            type: 'post',
            url: '{{route('subcategory.product.load')}}',
            data: {
                ProductType: productType,
                category_id: product_sub_category,
                category_title: $("#product_sub_category option:selected").text()
            }
        }).done(function (data) {
            data = JSON.parse(data);
            $("#model_no").niceSelect('destroy').html(data).select2();
        });
    }

    //Quiz Calculation
    function quizCalculation(){
        let total_right_answers = 0;
        let totalQuestions = $('#total_questions').val();
        let rightAnswer = 0;
        let userAnswer = 0;
        for (let i=0; i < totalQuestions; i++){
            rightAnswer = $('#answer_' + i).val();
            userAnswer = $('input[name="choice_' + i + '"]:checked').val();
            if (rightAnswer === userAnswer){
                 total_right_answers += 1;
            }
        }
        if (total_right_answers == totalQuestions){
            $('#quiz_div').hide();
            $('#submit_btn').hide();
            $('#message').show();
            $.ajax({
                type: 'post',
                url: '{{route('discount.code')}}',
            }).done(function (data) {
                data = JSON.parse(data);
                $("#discount_code").text(data[0].discount_code);
            });


        }else {
            $('#quiz_div').hide();
            $('#submit_btn').hide();
            $('#message_lose').show();
        }
    }

    function ShowProductColorImage(Url) {
        $("#colorImageDisplay").attr('src', Url).show().ezPlus();
        $("#product-image-container").hide();
        $("#product-image-container-mob").hide();
        $("#product-video-container").hide();
        $("#product-video-iframe").hide();
    }
</script>
