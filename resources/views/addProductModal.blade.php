<div id="addProductModal" class="modal inmodal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Product</h4>
            </div>
            <form method="post" id="addProductForm">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input required value="" id="name" name="name" class="form-control">
                    </div>
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="addProductClose" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="addProduct" data-dismiss="modal">Create</button>
                </div>
            </form>
        </div>

    </div>
</div>