<div class="modal fade" id="quoterequestModal" tabindex="200" role="dialog" aria-labelledby="quoterequestModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{route('quoteRequest.action')}}" id="quoterequestModalForm">
                @csrf
                <input type="hidden" name="id" id="quoterequestId"/>
                <input type="hidden" name="quote_request_status" id="quote_request_status">
                <div class="modal-header">
                    <h5 class="modal-title" id="quoterequestModalLabel">
                        Update Status
                    </h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Submit</button>
                    <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Back</button>
                </div>
            </form>
        </div>
    </div>
</div>
