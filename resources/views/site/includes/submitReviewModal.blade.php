<div class="modal fade" id="submitReviewModal" tabindex="200" role="dialog" aria-labelledby="submitReviewModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{route('customer.reviews.store')}}" id="submitReviewForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Customer Review</h5>
                </div>
                <div class="modal-body">
                    <label><strong>Write Your Review</strong></label>
                    <textarea class="form-control" name="rating_text" id="rating_text" cols="20" rows="3" required></textarea>

                    <label><strong>Rate your experience</strong></label>
                        <p>
                            <i class="fa fa-star" id="review-star-1"
                               style="font-size: 1.2rem; cursor: pointer; color:black;"
                               onmouseenter="ChangeColor(1, 'enter');" onmouseleave="ChangeColor(1, 'leave');"
                               onclick="SetRating(1);"></i>
                            <i class="fa fa-star" id="review-star-2"
                               style="font-size: 1.2rem; cursor: pointer; color: black"
                               onmouseenter="ChangeColor(2, 'enter');" onmouseleave="ChangeColor(2, 'leave');"
                               onclick="SetRating(2);"></i>
                            <i class="fa fa-star" id="review-star-3"
                               style="font-size: 1.2rem; cursor: pointer; color: black;"
                               onmouseenter="ChangeColor(3, 'enter');" onmouseleave="ChangeColor(3, 'leave');"
                               onclick="SetRating(3);"></i>
                            <i class="fa fa-star" id="review-star-4"
                               style="font-size: 1.2rem; cursor: pointer; color: black;"
                               onmouseenter="ChangeColor(4, 'enter');" onmouseleave="ChangeColor(4, 'leave');"
                               onclick="SetRating(4);"></i>
                            <i class="fa fa-star" id="review-star-5"
                               style="font-size: 1.2rem; cursor: pointer; color: black;"
                               onmouseenter="ChangeColor(5, 'enter');" onmouseleave="ChangeColor(5, 'leave');"
                               onclick="SetRating(5);"></i>
                            <input type="hidden" id="review-star-rating" name="review-star-rating" value="" />
                            <input type="hidden" id="reviewProductId" name="reviewProductId" value="{{$Product[0]->id}}" />
                            <input type="hidden" id="reviewProductSlug" name="reviewProductSlug" value="{{$Product[0]->slug}}" />
                        </p>
                    <label><strong>Recommends this product?</strong></label><br>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">Yes</label>
                        <input class="form-check-input" type="radio" value="true" name="recommendation" checked />
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" for="inlineRadio2">No</label>
                        <input class="form-check-input" type="radio" value="false" name="recommendation"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="submit">Submit</button>
                    <button class="btn btn-outline-secondary" type="button" data-dismiss="modal" onclick="postReview()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>