<div class="modal fade" id="delete-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center mb-4 mt-0 mt-md-n2">
                    <h3 class="secondary-font">آیا اطمینان دارید؟</h3>
                </div>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-danger me-sm-3 me-1">حذف</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                aria-label="Close">
                            انصراف
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
