<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('dashboard.layouts.partials.head')
</head>
<body class="sidebar-dark">
<div class="main-wrapper">
    @include('dashboard.layouts.partials.sidebar')
    <div class="page-wrapper">
        @include('dashboard.layouts.partials.navbar')
        @yield('content')
        @include('dashboard.layouts.partials.footer')
    </div>
</div>
@include('dashboard.layouts.partials.footer-scripts')
@yield('sample-scripts')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Initialize CKEditor
    ClassicEditor.defaultConfig = {
        toolbar: {
            items: [
                'heading',
                '|',
                'bold',
                'italic',
                '|',
                'bulletedList',
                'numberedList',
                '|',
                'insertTable',
                '|',
                'undo',
                'redo'
            ]
        },
        image: {
            toolbar: []
        },
        table: {
            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
        },
        language: 'en'
    };
    if ($("#product_short_description").length > 0) {
        ClassicEditor.create(document.querySelector('#product_short_description'), {
            link: {
                addTargetToExternalLinks: true
            },
        }).then(editor => {

        }).catch(error => {

        });
    }
    if ($("#product_compare_description").length > 0) {
        ClassicEditor.create(document.querySelector('#product_compare_description'), {
            link: {
                addTargetToExternalLinks: true
            },
        }).then(editor => {

        }).catch(error => {

        });
    }
    if ($("#product_description").length > 0) {
        ClassicEditor.create(document.querySelector('#product_description'), {
            link: {
                addTargetToExternalLinks: true
            },
        }).then(editor => {

        }).catch(error => {

        });
    }
    if ($("#welcome_text").length > 0) {
        ClassicEditor.create(document.querySelector('#welcome_text'), {
            link: {
                addTargetToExternalLinks: true
            },
        }).then(editor => {

        }).catch(error => {

        });
    }
    if ($("#vision_text").length > 0) {
        ClassicEditor.create(document.querySelector('#vision_text'), {
            link: {
                addTargetToExternalLinks: true
            },
        }).then(editor => {

        }).catch(error => {

        });
    }
    if ($("#mission_text").length > 0) {
        ClassicEditor.create(document.querySelector('#mission_text'), {
            link: {
                addTargetToExternalLinks: true
            },
        }).then(editor => {

        }).catch(error => {

        });
    }
    if ($("#values_text").length > 0) {
        ClassicEditor.create(document.querySelector('#values_text'), {
            link: {
                addTargetToExternalLinks: true
            },
        }).then(editor => {

        }).catch(error => {

        });
    }
    if ($("#wayOfwork_text").length > 0) {
        ClassicEditor.create(document.querySelector('#wayOfwork_text'), {
            link: {
                addTargetToExternalLinks: true
            },
        }).then(editor => {

        }).catch(error => {

        });
    }
    if ($("#pricing_promise").length > 0) {
        ClassicEditor.create(document.querySelector('#pricing_promise'), {
            link: {
                addTargetToExternalLinks: true
            },
        }).then(editor => {

        }).catch(error => {

        });
    }
    if ($("#technical_experts").length > 0) {
        ClassicEditor.create(document.querySelector('#technical_experts'), {
            link: {
                addTargetToExternalLinks: true
            },
        }).then(editor => {

        }).catch(error => {

        });
    }
    if ($("#client_support").length > 0) {
        ClassicEditor.create(document.querySelector('#client_support'), {
            link: {
                addTargetToExternalLinks: true
            },
        }).then(editor => {

        }).catch(error => {

        });
    }
    if ($("#order_notification").length > 0) {
        ClassicEditor.create(document.querySelector('#order_notification'), {
            link: {
                addTargetToExternalLinks: true
            },
        }).then(editor => {

        }).catch(error => {

        });
    }
    if ($("#offer_description").length > 0) {
        ClassicEditor.create(document.querySelector('#offer_description'), {
            link: {
                addTargetToExternalLinks: true
            },
        }).then(editor => {

        }).catch(error => {

        });
    }
    if ($("#careRepair_description").length > 0) {
        ClassicEditor.create(document.querySelector('#careRepair_description'), {
            link: {
                addTargetToExternalLinks: true
            },
        }).then(editor => {

        }).catch(error => {

        });
    }
    if ($("#pricing_description").length > 0) {
        ClassicEditor.create(document.querySelector('#pricing_description'), {
            link: {
                addTargetToExternalLinks: true
            },
        }).then(editor => {

        }).catch(error => {

        });
    }
    if ($("#delivery_collection").length > 0) {
        ClassicEditor.create(document.querySelector('#delivery_collection'), {
            link: {
                addTargetToExternalLinks: true
            },
        }).then(editor => {

        }).catch(error => {

        });
    }
    if ($("#parts_design").length > 0) {
        ClassicEditor.create(document.querySelector('#parts_design'), {
            link: {
                addTargetToExternalLinks: true
            },
        }).then(editor => {

        }).catch(error => {

        });
    }
</script>
@include('dashboard.includes.scripts')
</body>
</html>
