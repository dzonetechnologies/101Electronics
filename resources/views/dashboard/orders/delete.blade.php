<div class="modal fade" id="deleteOrderModal" tabindex="200" role="dialog" aria-labelledby="deleteOrderModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteOrderModalLabel">Confirm Delete</h5>
            </div>
            <form action="{{route('orders.delete')}}" id="deleteOrderForm" method="post"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="deleteOrderId" value="0"/>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="mb-0">
                                Are you sure you wish to delete this order?
                            </p>
                        </div>
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