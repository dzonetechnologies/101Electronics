<div class="modal fade" id="deleteSubCategoryModal" tabindex="200" role="dialog" aria-labelledby="deleteSubCategoryModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteSubCategoryModalLabel">Confirm Delete</h5>
            </div>
            <form action="{{url(route('subcategories.delete'))}}" id="deleteSubCategoryForm" method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-12">
                            <p class="text-left">
                                Are you sure you wish to delete this subcategory <b id="deleteSubCategoryName"></b>?
                            </p>
                        </div>
                        {{--Hidden Field for Id--}}
                        <input type="hidden" name="id" id="deleteSubCategoryId" value="0"/>
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
