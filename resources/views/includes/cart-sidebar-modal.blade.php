<div class="sidebar-modal">
    <div class="modal modal_outer right_modal fade" id="cart_modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body has-cool-scrollbar get_quote_view_modal_body">
                    <button type="button" class="close ml-2" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <cart :with-card-class={{json_encode(false)}}></cart>
                </div>
            </div>
        </div>
    </div>
</div>
