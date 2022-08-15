<div class="modal fade" id="deleteRequestModal" tabindex="200" role="dialog" aria-labelledby="deleteRequestModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{route('returnRequest.delete')}}" id="deleteRequestModalForm">
                @csrf
                <input type="hidden" name="id" id="deleteRequestId"/>
                <div class="modal-header">
                    <h5 class="modal-title" id="requestModalLabel">
                        Delete Request
                    </h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="submit">Yes</button>
                    <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>
