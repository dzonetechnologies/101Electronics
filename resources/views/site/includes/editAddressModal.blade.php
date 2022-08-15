<div class="modal fade" id="editAddressModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addressModalTitle" style="font-weight: 600;"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="CloseModal('editAddressModal');">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('home.account.address.update')}}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <input type="hidden" name="address_type" id="address_type" value="">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <h6>Address</h6>
                            <div class="input-item">
                                <input type="text"
                                       maxlength="200"
                                       name="address"
                                       id="ltn__address"
                                       autocomplete="off"
                                       placeholder="Address" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <h6>Town / City</h6>
                            <div class="input-item">
                                <input type="text" name="city" id="ltn__city" placeholder="City" autocomplete="off"
                                       maxlength="100" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <h6>State / Province</h6>
                            <div class="input-item">
                                <input type="text" placeholder="State" id="ltn__state" name="state" autocomplete="off"
                                       maxlength="100" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <h6>Zip / PostCode</h6>
                            <div class="input-item">
                                <input type="text" placeholder="Zip" id="ltn__zipcode" name="zipcode" autocomplete="off"
                                       maxlength="100" required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" style="width: 130px;"
                                onclick="CloseModal('editAddressModal');">Close
                        </button>
                        <button type="submit" class="theme-btn-2 btn btn-effect-2" style="width: 130px;">
                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>