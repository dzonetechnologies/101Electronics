<div class="modal fade" id="deleteDiscountVoucherModal" tabindex="200" role="dialog" aria-labelledby="deleteDiscountVoucherModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDiscountVoucherModalLabel">Confirm Delete</h5>
            </div>
            <form action="{{url(route('discountvouchers.delete'))}}" id="deleteVoucherForm" method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-12">
                            <p class="text-left">
                                Are you sure?
                            </p>
                        </div>
                        {{--Hidden Field for Id--}}
                        <input type="hidden" name="id" id="deleteVoucherId" value="0"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="submit">
                        <i class="fa fa-trash"></i>
                        Delete
                    </button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
