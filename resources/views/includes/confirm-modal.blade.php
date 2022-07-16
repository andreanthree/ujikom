<div class="modal fade" tabindex="-1" role="dialog" id="confirm-modal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="confirm-form" action="" method="" class="d-inline">
                @csrf
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <input type="hidden" id="lara-method" name="_method" value="">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="submit-btn btn-danger" class="btn btn-danger">
                        Ya
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
