<div class="my-2 mx-3">
    <div class="h4">User Profile</div>
    <hr class="my-sm-3 mb-0">
    <div class="form-group">
        <div class="row">
            <div class="col-sm-4 col-12 border-sm-bottom-0 border-bottom pb-sm-0 py-2 text-center">
                <img src="@if ($aRow->image){{ asset('public/uploads/'.$aRow->image)  }} @else {{ asset('public/images/profile.png')  }} @endif" class="img-fluid img-thumbnail w-sm-0 w-xs-50"  >

            </div>
            <div class="col-sm-8 col-12 border-sm-left">
                <div class="form-group">
                    <label class="font-weight-light m-0 border-bottom">Name</label>
                    <div class="ml-2 h5">{{$aRow->fname}}</div>
                </div>
                <div class="form-group">
                    <label class="font-weight-light m-0 border-bottom">Email</label>
                    <div class="ml-2 h5">{{$aRow->email}}</div>
                </div>
                <div class="form-group">
                    <label class="font-weight-light m-0 border-bottom">Mobile</label>
                    <div class="ml-2 h5">{{$aRow->mobile}}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-100 d-flex justify-content-center border-top pt-2">
        <button type="button" class="w-50 btn btn-afland btn-afland-white" data-dismiss="modal" aria-label="Close">
            Cancel
        </button>
    </div>
</div>

