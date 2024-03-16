<script type="text/javascript">
    $(document).ready(function () {
        SideBarLinksSettings();
        MakeBrandsTable();
        MakeCategoriesTable();
        MakeSubCategoriesTable();
        MakeSubSubCategoriesTable();
        MakeInstantCalculatorTable();
        MakeColorTable();
        MakeUnitTable();
        MakeProductTable();
        MakeSliderTable();
        MakeDiscountVoucherTable();
        MakeOrdersTable();
        MakereturnRequestTable();
        MakequoteRequestTable();
        MakePromotionsTable();

        /*Select2 Initialization*/
        let Select2 = $(".select2");
        if(Select2.length > 0){
            Select2.select2();
        }

        $("#logo").on("change", function (e) {
            let fileName = document.getElementById("logo").value;
            let idxDot = fileName.lastIndexOf(".") + 1;
            let extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
            if (extFile === "jpeg" || extFile === "png" || extFile === "jpg" || extFile === "webp" || extFile === "JPEG" || extFile === "PNG" || extFile === "JPG" || extFile === "WEBP") {
                $("#previewImg").attr('src', URL.createObjectURL(e.target.files[0]));
            } else {
                $("#logo").val('');
            }
        });
        //Mobile
        $("#logo_mob").on("change", function (e) {
            let fileName = document.getElementById("logo_mob").value;
            let idxDot = fileName.lastIndexOf(".") + 1;
            let extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
            if (extFile === "jpeg" || extFile === "png" || extFile === "jpg" || extFile === "webp" || extFile === "JPEG" || extFile === "PNG" || extFile === "JPG" || extFile === "WEBP") {
                $("#previewImgmobile").attr('src', URL.createObjectURL(e.target.files[0]));
            } else {
                $("#logo_mob").val('');
            }
        });

        setTimeout(function () {
            $(".alert").each(function (i, obj) {
                $(obj).slideUp();
            });
        }, 2500);
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function SideBarLinksSettings() {
        /*Remove Active from all links*/
        $("li.nav-item").removeClass('active');
        $("li#productsLink > div.collapse > ul > li > a.nav-link").removeClass('active');
        /*Add Active on specific page*/
        // Brands Link
        if ($("#product-brands").length > 0) {
            $("li#productsLink").addClass('active');
            $("li#productsLink > div.collapse > ul > li > a#product-brands-link").addClass('active');
        }
        // Category Link
        if ($("#product-categories").length > 0) {
            $("li#productsLink").addClass('active');
            $("li#productsLink > div.collapse > ul > li > a#product-categories-link").addClass('active');
        }
        // SubCategory Link
        if ($("#product-subcategories").length > 0) {
            $("li#productsLink").addClass('active');
            $("li#productsLink > div.collapse > ul > li > a#product-subcategories-link").addClass('active');
        }
        // Sub Sub Category Link
        if ($("#product-sub-subcategories").length > 0) {
            $("li#productsLink").addClass('active');
            $("li#productsLink > div.collapse > ul > li > a#product-sub-subcategories-link").addClass('active');
        }
    }

    function MakeBrandsTable() {
        let Table = $("#brandsTable");
        if (Table.length > 0) {
            Table.DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "ajax": {
                    "url": "{{ route('brands.load')  }}",
                    "type": "POST"
                },
                'columns': [
                    { data: 'order_no', bVisible: false },
                    { data: 'id' },
                    { data: 'title' },
                    { data: 'b2b' },
                    { data: 'type' },
                    { data: 'logo', orderable: false },
                    { data: 'action', orderable: false },
                ],
                'order': [0, 'asc']
            });
        }
    }

    function BrandOrderUp(e, Id, OrderNo) {
        $(e).css({pointerEvents: "none"});
        $.ajax({
            type: "post",
            url: "{{ route('brands.order.up') }}",
            data: { id : Id, order_no : OrderNo }
        }).done(function (data) {
            $('#brandsTable').DataTable().ajax.reload();
        });
    }

    function BrandOrderDown(e, Id, OrderNo) {
        $(e).css({pointerEvents: "none"});
        $.ajax({
            type: "post",
            url: "{{ route('brands.order.down') }}",
            data: { id : Id, order_no : OrderNo }
        }).done(function (data) {
            $('#brandsTable').DataTable().ajax.reload();
        });
    }

    function DeleteBrand(id, title) {
        title = atob(title);
        $("#deleteBrandId").val(id);
        $("#deleteBrandName").text(title);
        $("#deleteBrandModal").modal('toggle');
    }

    function MakeCategoriesTable() {
        let Table = $("#categoriesTable");
        if (Table.length > 0) {
            Table.DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "ajax": {
                    "url": "{{ route('categories.load')  }}",
                    "type": "POST"
                },
                'columns': [
                    { data: 'order_no', bVisible: false },
                    { data: 'id' },
                    { data: 'title' },
                    { data: 'meta_title' },
                    { data: 'homepage_selling_tagline' },
                    { data: 'brandpage_selling_tagline' },
                    { data: 'categorypage_selling_tagline' },
                    { data: 'logo', orderable: false },
                    { data: 'brand', orderable: false },
                    { data: 'action', orderable: false },
                ],
                'order': [0, 'asc']
            });
        }
    }

    function CategoryOrderUp(e, Id, OrderNo) {
        $(e).css({pointerEvents: "none"});
        $.ajax({
            type: "post",
            url: "{{ route('categories.order.up') }}",
            data: { id : Id, order_no : OrderNo }
        }).done(function (data) {
            $('#categoriesTable').DataTable().ajax.reload();
        });
    }

    function CategoryOrderDown(e, Id, OrderNo) {
        $(e).css({pointerEvents: "none"});
        $.ajax({
            type: "post",
            url: "{{ route('categories.order.down') }}",
            data: { id : Id, order_no : OrderNo }
        }).done(function (data) {
            $('#categoriesTable').DataTable().ajax.reload();
        });
    }

    function DeleteCategory(id, title) {
        title = atob(title);
        $("#deleteCategoryId").val(id);
        $("#deleteCategoryName").text(title);
        $("#deleteCategoryModal").modal('toggle');
    }

    function LoadCategoryBrand(categoryId) {
        $.ajax({
            type: "post",
            url: "{{ url('category/brand') }}",
            data: { categoryId : categoryId}
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
            // remove non-printable and other non-valid JSON chars
            s = s.replace(/[\u0000-\u0019]+/g, "");
            let Brands = JSON.parse(s);
            $("#_brandBlock").css('display', 'grid');
            $("#brand").html('').html(Brands);
        });
    }

    function LoadMultipleSubCategoryBrand() {
        var subCategories = $("#subcategory").val();
        if (subCategories === '') {
          $("#_brandBlock").css('display', 'grid');
          $("#brand").html('');
        } else {
            $.ajax({
                type: "post",
                url: "{{ url('subcategory/multiple/brand') }}",
                data: { subCategories : JSON.stringify(subCategories)}
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
                // remove non-printable and other non-valid JSON chars
                s = s.replace(/[\u0000-\u0019]+/g, "");
                let Brands = JSON.parse(s);
                $("#_brandBlock").css('display', 'grid');
                $("#brand").html('').html(Brands);
            });
        }
    }


    function LoadSubCategoryBrand(subCategoryId) {
        $.ajax({
            type: "post",
            url: "{{ url('subcategory/brand') }}",
            data: { subCategoryId : subCategoryId}
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
            // remove non-printable and other non-valid JSON chars
            s = s.replace(/[\u0000-\u0019]+/g, "");
            let Brands = JSON.parse(s);
            $("#_brandBlock").css('display', 'grid');
            $("#brand").html('').html(Brands);
        });
    }

    function LoadSubSubCategoryBrand(subSubCategoryId) {
        $.ajax({
            type: "post",
            url: "{{ url('sub-subcategory/brand') }}",
            data: { subSubCategoryId : subSubCategoryId}
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
            // remove non-printable and other non-valid JSON chars
            s = s.replace(/[\u0000-\u0019]+/g, "");
            let Brands = JSON.parse(s);
            $("#brand").html('').html(Brands);
        });
    }

    function MakeSubCategoriesTable() {
        let Table = $("#subcategoriesTable");
        if (Table.length > 0) {
            Table.DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "ajax": {
                    "url": "{{ route('subcategories.load')  }}",
                    "type": "POST"
                },
                'columns': [
                    { data: 'order_no', bVisible: false },
                    { data: 'id' },
                    { data: 'title' },
                    { data: 'meta_title' },
                    { data: 'category' },
                    { data: 'brand' },
                    { data: 'action', orderable: false },
                ],
                'order': [0, 'asc']
            });
        }
    }

    function SubCategoryOrderUp(e, Id, OrderNo) {
        $(e).css({pointerEvents: "none"});
        $.ajax({
            type: "post",
            url: "{{ route('subcategories.order.up') }}",
            data: { id : Id, order_no : OrderNo }
        }).done(function (data) {
            $('#subcategoriesTable').DataTable().ajax.reload();
        });
    }

    function SubCategoryOrderDown(e, Id, OrderNo) {
        $(e).css({pointerEvents: "none"});
        $.ajax({
            type: "post",
            url: "{{ route('subcategories.order.down') }}",
            data: { id : Id, order_no : OrderNo }
        }).done(function (data) {
            $('#subcategoriesTable').DataTable().ajax.reload();
        });
    }

    function DeleteSubCategory(id, title) {
        title = atob(title);
        $("#deleteSubCategoryId").val(id);
        $("#deleteSubCategoryName").text(title);
        $("#deleteSubCategoryModal").modal('toggle');
    }

    function MakeSubSubCategoriesTable() {
        let Table = $("#sub_subcategoriesTable");
        if (Table.length > 0) {
            Table.DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "ajax": {
                    "url": "{{ route('sub_subcategories.load')  }}",
                    "type": "POST"
                },
                'columns': [
                    { data: 'order_no', bVisible: false },
                    { data: 'id' },
                    { data: 'title' },
                    { data: 'meta_title' },
                    { data: 'category' },
                    { data: 'subcategory' },
                    { data: 'brand' },
                    { data: 'action', orderable: false },
                ],
                'order': [0, 'asc']
            });
        }
    }

    function SubSubCategoryOrderUp(e, Id, OrderNo) {
        $(e).css({pointerEvents: "none"});
        $.ajax({
            type: "post",
            url: "{{ route('sub_subcategories.order.up') }}",
            data: { id : Id, order_no : OrderNo }
        }).done(function (data) {
            $('#sub_subcategoriesTable').DataTable().ajax.reload();
        });
    }

    function SubSubCategoryOrderDown(e, Id, OrderNo) {
        $(e).css({pointerEvents: "none"});
        $.ajax({
            type: "post",
            url: "{{ route('sub_subcategories.order.down') }}",
            data: { id : Id, order_no : OrderNo }
        }).done(function (data) {
            $('#sub_subcategoriesTable').DataTable().ajax.reload();
        });
    }

    function DeleteSubSubCategory(id, title) {
        title = atob(title);
        $("#deleteSubSubCategoryId").val(id);
        $("#deleteSubSubCategoryName").text(title);
        $("#deleteSubSubCategoryModal").modal('toggle');
    }

    function GetSubcategoriesFromCategories(Category) {
        if(Category !== ''){
            $.ajax({
                type: "post",
                url: "{{ route('category.subcategories') }}",
                data: { Category : Category }
            }).done(function (data) {
                data = JSON.parse(data);
                let Rows = '<option value="" disabled>Select</option>';
                for (let i = 0; i < data.length; i++) {
                    Rows += '<option value="' + data[i].id + '">' + data[i].title + '</option>';
                }
                $("#subcategory").html(Rows);
            });
        }
    }

    function GetSubSubcategoriesFromSubCategory(SubCategory) {
        if(SubCategory !== ''){
            let Category = $("#category option:selected").val();
            $.ajax({
                type: "post",
                url: "{{ route('subcategory.sub-subcategories') }}",
                data: { Category : Category, SubCategory : SubCategory }
            }).done(function (data) {
                data = JSON.parse(data);
                let Rows = '<option value="" selected>Select</option>';
                for (let i = 0; i < data.length; i++) {
                    Rows += '<option value="' + data[i].id + '">' + data[i].title + '</option>';
                }
                $("#sub-subcategory").html(Rows);
            });
        }
    }

    function GetProductSubcategoriesFromCategories(Category) {
        if(Category !== ''){
            $.ajax({
                type: "post",
                url: "{{ route('category.subcategories') }}",
                data: { Category : Category }
            }).done(function (data) {
                data = JSON.parse(data);
                let Rows = '<option value="">Select</option>';
                for (let i = 0; i < data.length; i++) {
                    Rows += '<option value="' + data[i].id + '">' + data[i].title + '</option>';
                }
                $("#subcategory").html(Rows);
            });
        }
    }

    function GetProductSubSubcategoriesFromSubCategory(SubCategory) {
        if(SubCategory !== ''){
            let Category = $("#category option:selected").val();
            $.ajax({
                type: "post",
                url: "{{ route('subcategory.sub-subcategories') }}",
                data: { Category : Category, SubCategory : SubCategory }
            }).done(function (data) {
                data = JSON.parse(data);
                let Rows = '<option value="">Select</option>';
                for (let i = 0; i < data.length; i++) {
                    Rows += '<option value="' + data[i].id + '">' + data[i].title + '</option>';
                }
                $("#sub-subcategory").html(Rows);
            });
        }
    }

    // Instant Calculator - Start
    function MakeInstantCalculatorTable() {
        let Table = $("#instantCalculatorTable");
        if (Table.length > 0) {
            Table.DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "ajax": {
                    "url": "{{ route('instantcalculator.load')  }}",
                    "type": "POST"
                },
                'columns': [
                    { data: 'id' },
                    { data: 'month' }
                ],
                'order': [0, 'asc']
            });
        }
    }

    // Attributes - Color - Start
    function MakeColorTable() {
        let Table = $("#colorTable");
        if (Table.length > 0) {
            Table.DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "ajax": {
                    "url": "{{ route('color.load')  }}",
                    "type": "POST"
                },
                'columns': [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'code' }
                ],
                'order': [0, 'asc']
            });
        }
    }

    // Attributes - Unit - Start
    function MakeUnitTable() {
        let Table = $("#unitTable");
        if (Table.length > 0) {
            Table.DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "ajax": {
                    "url": "{{ route('unit.load')  }}",
                    "type": "POST"
                },
                'columns': [
                    { data: 'id' },
                    { data: 'name' }
                ],
                'order': [0, 'asc']
            });
        }
    }

    // Product - Start
    function CalculateSalePrice() {
        var result = parseFloat(parseInt($("#product_purchase_price").val()) * parseInt($("#product_tax").val()) / 100);
        var a = parseInt($("#product_purchase_price").val());
        var total = a+result;
        $('#product_unit_price').val(Math.ceil(total || '')); //shows value in "#rate"
    }

    function CalculateAfterDiscountPrice() {
        var result = parseFloat(parseInt($("#product_unit_price").val()) * parseInt($("#product_discount").val()) / 100);
        var a = parseInt($("#product_unit_price").val());
        var total = a-result;
        $('#product_price_after_discount').val(Math.ceil(total || '')); //shows value in "#rate"
    }

    function checkDiscountType(discountType)
    {
        if (discountType === 'fixed') {
          $("#_fixedDiscountBlock").show();
          $("#_percentageDiscountBlock").hide();
        } else {
          $("#_percentageDiscountBlock").show();
          $("#_fixedDiscountBlock").hide();
        }
    }

    $("#product_shipping_type").change(function() {
      if(this.checked) {
        $("#_shippingFlatRateBlock").hide();
      } else {
        $("#_shippingFlatRateBlock").show();
      }
    });

    function checkInstallation(){
      var installation = $("#product_free_installation option:selected").val();
      if (installation === '0') {
          $("#_installationPriceBlock").show();
      } else {
          $("#_installationPriceBlock").hide();
      }
    }

    function MakeProductTable() {
        let Table = $("#productsTable");
        if (Table.length > 0) {
            Table.DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "ajax": {
                    "url": "{{ route('product.load')  }}",
                    "type": "POST"
                },
                'columns': [
                    { data: 'order_no', bVisible: false },
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'code' },
                    { data: 'brand' },
                    { data: 'category' },
                    { data: 'subcategory' },
                    { data: 'sub-subcategory' },
                    { data: 'unit_price' },
                    { data: 'quantity' },
                    { data: 'homepage' },
                    { data: 'action' },
                ],
                'order': [0, 'asc']
            });
        }
    }

    function DeleteProduct(id) {
        $("#deleteProductId").val(id);
        $("#deleteProductModal").modal('toggle');
    }

    function DuplicateProduct(id) {
        $("#duplicateProductId").val(id);
        $("#duplicateProductModal").modal('toggle');
    }

    function ProductOrderUp(e, Id, OrderNo) {
        $(e).css({pointerEvents: "none"});
        $.ajax({
            type: "post",
            url: "{{ route('product.order.up') }}",
            data: { id : Id, order_no : OrderNo }
        }).done(function (data) {
            $('#productsTable').DataTable().ajax.reload();
        });
    }

    function ProductOrderDown(e, Id, OrderNo) {
        $(e).css({pointerEvents: "none"});
        $.ajax({
            type: "post",
            url: "{{ route('product.order.down') }}",
            data: { id : Id, order_no : OrderNo }
        }).done(function (data) {
            $('#productsTable').DataTable().ajax.reload();
        });
    }

    function UpdateProductHomepageStatus(id){
        let ProductId = id.split("_")[1];
        let Status = 0;
        if ($('#'+id).is(":checked")) {
            Status = 1;
        } else {
            Status = 0
        }

        $.ajax({
            type: "post",
            url: "{{ route('product.homepagestatus.update') }}",
            data: { id : ProductId, status : Status }
        }).done(function (data) {
            //$('#productsTable').DataTable().ajax.reload();
        });
    }

    // Slug Duplication Checking - Start
    function CheckForDuplicateTitle(value, tableName) {
        $.ajax({
            type: "post",
            url: "{{route('brand.title-duplicate-check')}}",
            data: { tableName : tableName, Value : value }
        }).done(function (data) {
            if(data === 'Success'){
                $("#titleError").hide();
                value = value.replaceAll(' ', '-');
                value = value.toLowerCase();
                value = value.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '');
                console.log("Slug: " + value);
                $("#slug").val(value);
                $("#saveProducts").attr('disabled', false);
            } else {
                $("#titleError").show();
                if (tableName === 'products') {
                    $("#titleError").html('Product name already exists.');
                } else {
                    $("#titleError").html('Title already exists.');
                }
                $("#saveProducts").attr('disabled', true);
            }
        });
    }

    function EditCheckForDuplicateTitle(value, tableName) {
        $.ajax({
            type: "post",
            url: "{{route('brand.title-duplicate-check')}}",
            data: { Id : $("#id").val(), tableName : tableName, Value : value }
        }).done(function (data) {
            if(data === 'Success'){
                $("#titleError").hide();
                value = value.replaceAll(' ', '-');
                value = value.toLowerCase();
                value = value.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '');
                $("#slug").val(value);
                $("#saveProducts").attr('disabled', false);
            } else {
                $("#titleError").show().html('Title already exists.');
                $("#saveProducts").attr('disabled', true);
            }
        });
    }

    // General Settings - Slider - Start
    function checkSliderPage(value){
      if (value === 'home') {
          $("#BrandsBlock").hide();
          $("#brand").prop('required',false);
      } else if(value === 'b2b'){
          $("#BrandsBlock").hide();
          $("#brand").prop('required',false);
      } else if (value === 'brands') {
          $("#BrandsBlock").show();
          $("#BrandsBlock").css('display', 'block');
          $("#brand").prop('required',true);
          $("#brand").select2();
      }
    }

    function checkSliderType(value){
      if (value === 'image') {
          $("#SliderImageBlock").show();
          $("#SliderVideoBlock").hide();
          $("#logo").prop('required',true);
          $("#slider_video").prop('required',false);
      } else if (value === 'video') {
          $("#SliderVideoBlock").show();
          $("#SliderImageBlock").hide();
          $("#logo").prop('required',false);
          $("#slider_video").prop('required',true);
      }
    }

    function MakeSliderTable() {
        let Table = $("#slidersTable");
        if (Table.length > 0) {
            Table.DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "ajax": {
                    "url": "{{ route('slider.load')  }}",
                    "type": "POST"
                },
                'columns': [
                    { data: 'order_no', bVisible: false },
                    { data: 'id' },
                    { data: 'slider' },
                    { data: 'page' },
                    { data: 'screen' },
                    { data: 'brand' },
                    { data: 'action' },
                ],
                'order': [0, 'asc']
            });
        }
    }

    function DeleteSlider(id) {
        $("#deleteSliderId").val(id);
        $("#deleteSliderModal").modal('toggle');
    }

    function SliderOrderUp(e, Id, OrderNo) {
        $(e).css({pointerEvents: "none"});
        $.ajax({
            type: "post",
            url: "{{ route('slider.order.up') }}",
            data: { id : Id, order_no : OrderNo }
        }).done(function (data) {
            $('#slidersTable').DataTable().ajax.reload();
        });
    }

    function SliderOrderDown(e, Id, OrderNo) {
        $(e).css({pointerEvents: "none"});
        $.ajax({
            type: "post",
            url: "{{ route('slider.order.down') }}",
            data: { id : Id, order_no : OrderNo }
        }).done(function (data) {
            $('#slidersTable').DataTable().ajax.reload();
        });
    }
    // General Settings - Slider - End

    // Discount Voucher - Start
    function MakeDiscountVoucherTable() {
        let Table = $("#discountVoucherTable");
        if (Table.length > 0) {
            Table.DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "ajax": {
                    "url": "{{ route('discountvouchers.load')  }}",
                    "type": "POST"
                },
                'columns': [
                    { data: 'order_no', bVisible: false },
                    { data: 'id' },
                    { data: 'title' },
                    { data: 'discount_code' },
                    { data: 'voucher_price' },
                    { data: 'min_shopping_price' },
                    { data: 'limit' },
                    { data: 'status' },
                    { data: 'action' },
                ],
                'order': [0, 'asc']
            });
        }
    }

    function UpdateVoucherStatus(id){
        let VoucherId = id.split("_")[1];
        let Status = 0;
        if ($('#'+id).is(":checked")) {
            Status = 1;
        } else {
            Status = 0
        }

        $.ajax({
            type: "post",
            url: "{{ route('discountvouchers.status.update') }}",
            data: { id : VoucherId, status : Status }
        }).done(function (data) {
            $('#discountVoucherTable').DataTable().ajax.reload();
        });
    }

    function VoucherOrderUp(e, Id, OrderNo) {
        $(e).css({pointerEvents: "none"});
        $.ajax({
            type: "post",
            url: "{{ route('discountvouchers.order.up') }}",
            data: { id : Id, order_no : OrderNo }
        }).done(function (data) {
            $('#discountVoucherTable').DataTable().ajax.reload();
        });
    }

    function VoucherOrderDown(e, Id, OrderNo) {
        $(e).css({pointerEvents: "none"});
        $.ajax({
            type: "post",
            url: "{{ route('discountvouchers.order.down') }}",
            data: { id : Id, order_no : OrderNo }
        }).done(function (data) {
            $('#discountVoucherTable').DataTable().ajax.reload();
        });
    }

    function DeleteVoucher(id) {
        $("#deleteVoucherId").val(id);
        $("#deleteDiscountVoucherModal").modal('toggle');
    }
    // Discount Voucher - End

    /*Orders*/
    function MakeOrdersTable() {
        let Table = $("#ordersTable");
        if (Table.length > 0) {
            Table.DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "ajax": {
                    "url": "{{ route('orders.load')  }}",
                    "type": "POST"
                },
                'columns': [
                    { data: 'id' },
                    { data: 'invoice_no' },
                    { data: 'first_name' },
                    { data: 'created_at' },
                    { data: 'order_total' },
                    { data: 'order_notes' },
                    { data: 'order_status' },
                    { data: 'action', orderable: false }
                ],
                'order': [0, 'desc']
            });
        }
    }

    function UpdateOrderStatus(id) {
        let OrderId = id.split('_')[1];
        $("#hiddenOrderId").val(OrderId);
        $("#updateStatusModal").modal('toggle');
    }

    function ConfirmUpdateOrderStatus(e) {
        let Table = $("#ordersTable");
        let OrderId = $("#hiddenOrderId").val();
        let Status = $("#orderStatus option:selected").val();
        $(e).attr('disabled', true);
        $.ajax({
            type: "post",
            url: "{{ route('orders.update.status') }}",
            data: { OrderId : OrderId, Status : Status }
        }).done(function (data) {
            if (Table.length > 0) {
                $('#ordersTable').DataTable().ajax.reload();
                $(e).attr('disabled', false);
                $("#orderStatus").val("").trigger('change');
                $("#updateStatusModal").modal('toggle');
            } else {
                location.reload();
            }
        });
    }

    function DeleteOrder(Id) {
        let Values = Id.split('_');
        $("#deleteOrderId").val(Values[1]);
        $("#deleteOrderModal").modal('toggle');
    }
    /*Orders*/
    /*Form-Validation*/
    $(document).ready(function(){
        $("#saveProducts").on("click", function(event) {
            $(".alert").show();
            let validate = 1;
            let p_name = $('#product_name').val();
            let p_code = $('#product_code').val();
            let p_category = $('#category').val();
            let p_subcategory = $('#subcategory').val();
            let p_sub_subcategory = $('#sub-subcategory').val();
            let p_brand = $('#brand').val();
            let p_clearance_sale = $('#product_clearance_sale').val();
            let p_purchase_price = $('#product_purchase_price').val();
            let p_quantity = $('#product_quantity').val();
            let p_fast_delivery = $('#product_fast_delivery').val();
            let p_normal_delivery = $('#product_normal_delivery').val();
            let p_free_installation = $('#product_free_installation').val();
            if (p_name == ""){
                $("#alertDiv").show();
                $("#formValidationAlert").html('').html("Product name is missing!");
                validate = 0;
            } else if(p_code == ""){
                $("#alertDiv").show();
                $("#formValidationAlert").html('').html("Product code is missing!");
                validate = 0;
            } else if(p_category == ""){
                $("#alertDiv").show();
                $("#formValidationAlert").html('').html("Product Category is missing!");
                validate = 0;
            } else if(p_subcategory == ""){
                $("#alertDiv").show();
                $("#formValidationAlert").html('').html("Product subcategory is missing!");
                validate = 0;
            } else if(p_sub_subcategory == ""){
                $("#alertDiv").show();
                $("#formValidationAlert").html('').html("Product sub-subcategory is missing!");
                validate = 0;
            } else if(p_brand == ""){
                $("#alertDiv").show();
                $("#formValidationAlert").html('').html("Product brand is missing!");
                validate = 0;
            } else if(p_clearance_sale == ""){
                $("#alertDiv").show();
                $("#formValidationAlert").html('').html("Clearance sale is missing!");
                validate = 0;
            } else if(p_purchase_price == "") {
                $("#alertDiv").show();
                $("#formValidationAlert").html('').html("Product purchase price is missing!");
                validate = 0;
            } else if(p_quantity == ""){
                $("#alertDiv").show();
                $("#formValidationAlert").html('').html("Product quantity  is missing!");
                validate = 0;
            } else if(p_fast_delivery == ""){
                $("#alertDiv").show();
                $("#formValidationAlert").html('').html("Fast delivery field  is missing!");
                validate = 0;
            } else if(p_normal_delivery == ""){
                $("#alertDiv").show();
                $("#formValidationAlert").html('').html("Product normal delivery  is missing!");
                validate = 0;
            } else if(p_free_installation == ""){
                $("#alertDiv").show();
                $("#formValidationAlert").html('').html("Product free installation  is missing!");
                validate = 0;
            }
            if (validate == 0){
                return false;
            } else {
                $('#addProductForm').submit();
            }
        });
    });

    // Return Request-Start
    function MakereturnRequestTable() {
        let Table = $("#returnRequestTable");
        if (Table.length > 0) {
            Table.DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "ajax": {
                    "url": "{{ route('returnRequest.load')  }}",
                    "type": "POST"
                },
                'columns': [
                    { data: 'id'},
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'phone' },
                    { data: 'order_no' },
                    { data: 'serial_no' },
                    { data: 'status' },
                    { data: 'action' },
                ],
                'order': [0, 'asc']
            });
        }
    }

    function returnRequest(e,status) {
        let id = e.split('||')[1];
        $("#requestId").val(id);
        $("#request_status").val(status);
        $("#requestModal").modal('toggle');
    }

    function DeleteRequest(id) {
        $("#deleteRequestId").val(id);
        $("#deleteRequestModal").modal('toggle');
    }

    // Sale Report - Start
    function FilterSaleReport() {
        let StartDate = $("#report_start_date").val();
        let EndDate = $("#report_end_date").val();
        let OrderStatus = $("#report_order_status option:selected").val();
        let Product = $("#report_product option:selected").val();

        $("#startDateFilter").val(StartDate);
        $("#endDateFilter").val(EndDate);
        $("#orderStatusFilter").val(OrderStatus);
        $("#productFilter").val(Product);

        $.ajax({
            type: "post",
            url: "{{ route('sale-report.filter') }}",
            data: {
                StartDate : StartDate,
                EndDate : EndDate,
                Status : OrderStatus,
                Product : Product
            }
        }).done(function (data) {
            data = JSON.parse(data);
            $("#total_orders").html('').html(data.total_orders);
            $("#total_sale").html('').html(data.total_sale);
            $("#total_gst").html('').html(data.total_gst);
            $("#total_discount").html('').html(data.total_discount);
            $("#total_products_qty").html('').html(data.total_products_qty);
        });
    }

    function FilterSaleReportExcel() {
        /*let StartDate = $("#startDateFilter").val();
        let EndDate = $("#endDateFilter").val();
        let OrderStatus = $("#orderStatusFilter").val();
        let Product = $("#productFilter").val();*/
        let StartDate = $("#report_start_date").val();
        let EndDate = $("#report_end_date").val();
        let OrderStatus = $("#report_order_status option:selected").val();
        let Product = $("#report_product option:selected").val();

        if(StartDate === '') {
            StartDate = '-';
        }
        if(EndDate === '') {
            EndDate = '-';
        }
        if(OrderStatus === '') {
            OrderStatus = '-';
        }
        if(Product === '') {
            Product = '-';
        }

        window.open('{{url('sale-report/export/excel')}}' + '/' + window.btoa(StartDate) + '/' + window.btoa(EndDate) + '/' + window.btoa(OrderStatus) + '/' + window.btoa(Product), '_blank');
    }
    // Sale Report - End

    function FilterBackButton() {
        $("#filterPage").show();
        $("#beforeTablePage").removeClass("col-md-1");
        $("#filterPage").removeClass("col-md-1");
        $("#filterPage").addClass("col-md-2");
    }

    function FilterCloseButton() {
        $("#filterPage").hide();
        $("#beforeTablePage").addClass("col-md-1");
        $("#filterPage").removeClass("col-md-2");
        $("#filterPage").addClass("col-md-1");
    }

    //changepassword
    $('form#changePasswordForm').submit(function (e) {
       let NewPassword = $('#newPassword').val();
       let ConfirmPassword = $('#confirmPassword').val();
       if (NewPassword === ConfirmPassword){
            $('#changePasswordError').hide();
       }else {
           $('#changePasswordError').show();
            e.preventDefault(e);
       }
    });

    //Quote-Request
    function MakequoteRequestTable() {
        let Table = $("#quoteRequestTable");
        if (Table.length > 0) {
            Table.DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "ajax": {
                    "url": "{{ route('quoteRequest.load')  }}",
                    "type": "POST"
                },
                'columns': [
                    { data: 'id'},
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'phone' },
                    { data: 'city' },
                    { data: 'status' },
                    { data: 'action' },
                ],
                'order': [0, 'asc']
            });
        }
    }
    //Delete Quote request
    function DeleteQuoteRequest(id) {
        $("#deleteQuoteRequestId").val(id);
        $("#deleteQuoteRequestModal").modal('toggle');
    }
    //Quote-status
    function returnQuoteRequest(e,status) {
        let id = e.split('||')[1];
        $("#quoterequestId").val(id);
        $("#quote_request_status").val(status);
        $("#quoterequestModal").modal('toggle');
    }

    function DeleteProductColor(e) {
        let RowId = $(e).attr('id').split('_')[1];
        let OldFile = $("#old_product_image_" + RowId).val();
        let RemovedProductColorImages = $("#oldProductColorImages").val();
        if(RemovedProductColorImages !== '') {
            RemovedProductColorImages = JSON.parse(RemovedProductColorImages);
        } else {
            RemovedProductColorImages = [];
        }
        RemovedProductColorImages.push(OldFile);
        $("#oldProductColorImages").val(JSON.stringify(RemovedProductColorImages));
        $("#productColorRow_" + RowId).remove();
    }

    // Promotions

    function MakePromotionsTable() {
        let Table = $("#promotionsTable");
        if (Table.length > 0) {
            Table.DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "ajax": {
                    "url": "{{ route('promotions.load')  }}",
                    "type": "POST"
                },
                'columns': [
                    { data: 'id' },
                    { data: 'type' },
                    { data: 'title' },
                    { data: 'logo', orderable: false },
                    { data: 'action', orderable: false },
                ],
                'order': [0, 'asc']
            });
        }
    }
    function DeletePromotion(id, title) {
        title = atob(title);
        $("#deletePromotionId").val(id);
        $("#deletePromotionName").text(title);
        $("#deletePromotionModal").modal('toggle');
    }


</script>
