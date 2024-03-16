<div class="modal fade" id="deletePromotionModal" tabindex="200" role="dialog" aria-labelledby="deletePromotionModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePromotionModalLabel">Confirm Delete</h5>
            </div>
            <form action="{{url(route('promotions.delete'))}}" id="deletePromotionForm" method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-12">
                            <p class="text-left">
                                Are you sure you wish to delete this Promotion <b id="deletePromotionName"></b>?
                            </p>
                        </div>
                        {{--Hidden Field for Id--}}
                        <input type="hidden" name="id" id="deletePromotionId" value="0"/>
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
