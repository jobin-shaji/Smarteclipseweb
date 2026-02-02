<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal add content-->

        <div class="modal-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Add Product</h6>
                            <form method="POST" id="productform" action="{{ url('addproducts') }}">@csrf


                                <label>Name</label>
                                <input style="margin-top: 2%" id="name" type="text" class="form-control add-new"
                                    name="name" placeholder="Product Name" required>
                                <br>
                                <label>Description</label>
                                <input type="text" class="form-control" name="description" id="description"
                                    placeholder="Description">

                                <br> <label>Price</label><input type="text" class="form-control" name="price"
                                    id="price" placeholder="Price" required>

                                <br> <input type="checkbox" name="tax_type" value="1" class="btn-check"
                                    id="btncheck2" autocomplete="off" >
                                <label>Tax Inclusive</label>

                                <br> <label>Gst (%)</label><input type="text" class="form-control" id="gst"
                                    name="gst" placeholder="GST" required>

                                <br> <input type="checkbox" name="status" value="1" class="btn-check"
                                    id="btncheck1" autocomplete="off" checked>
                                <label>active</label>




                                <br>
                                <button type="submit" style="width:100%; margin-top: 1%;"
                                    class="btn btn-primary">Add</button>
                                <br> <button data-dismiss="modal" style="width:100%;margin-top: 1%;"
                                    class="btn btn-light">Cancel</button>

                                <input type="hidden" value="" name="edit" id="edit">
                            </form>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
