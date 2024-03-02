<div class="modal fade" id="deliveryOptionsModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="font-weight: 600;">Delivery Options</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="toggleDeliveryOptions();">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="guideModel">
          @foreach($GeneralPages as $page)
            @if($page->id == 4)
              {!! $page->desc !!}
            @endif
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
