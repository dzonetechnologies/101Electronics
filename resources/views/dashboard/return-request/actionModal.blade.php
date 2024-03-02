<div class="modal fade" id="requestModal" tabindex="200" role="dialog" aria-labelledby="requestModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{route('request.action')}}" id="requestModalForm">
                @csrf
                <input type="hidden" name="id" id="requestId"/>
                <input type="hidden" name="request_status" id="request_status">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestModalLabel">
                    </h5>
                </div>
                <div class="modal-body">
                    <p>Reason</p>
                    <textarea class="form-control" name="admin_reason" id="admin_reason" cols="60" rows="5"></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Submit</button>
                    <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Back</button>
                </div>
            </form>
        </div>
    </div>
</div>
