<div class="modal fade" id="updateStatusModal" tabindex="200" role="dialog"
     aria-labelledby="updateStatusModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">Update Order Status</h5>
            </div>
            <form action="#" method="post"
                  enctype="multipart/form-data">
                <input type="hidden" name="OrderId" id="hiddenOrderId" value="">

                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="orderStatus">Status</label>
                            <select name="Status" id="orderStatus" class="form-control" required>
                                <option value="">Select</option>
                                <option value="0">Pending</option>
                                <option value="1">In Progress</option>
                                <option value="2">Delivered</option>
                                <option value="3">Completed</option>
                                <option value="4">Cancelled</option></a> 
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" onclick="ConfirmUpdateOrderStatus(this);">
                        <i class="fa fa-check"></i>
                        Update
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