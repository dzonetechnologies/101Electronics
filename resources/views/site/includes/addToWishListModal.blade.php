<div class="modal fade" id="addToWishListModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: 600;">Add to Wishlist</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="CloseModal('addToWishListModal');">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 fs-large" id="addToWishlistText"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" style="width: 130px;" onclick="CloseModal('addToWishListModal');">Close</button>
                    <button type="button" class="theme-btn-2 btn btn-effect-2" style="width: 130px;" onclick="window.location.href='{{url('login')}}';">Go to Login</button>
                </div>
            </div>
        </div>
    </div>
</div>