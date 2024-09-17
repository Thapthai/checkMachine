<!-- Create -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"><strong>เพิ่มชิ้นส่วนของเครื่องจักร</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form
                    action="{{ route('machines.store', [$department->id, $onshift, $selected, $line->id, $shiftDate]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>ชื่่อเครื่องจักร :</strong>
                            <input type="text" name="name" class="form-control">

                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>สถานะ :</strong>
                            <input type="text" name="status" class="form-control">

                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>ลำดับการตรวจ :</strong>
                            <input type="number" name="sequence" class="form-control">

                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>ข้อมูล :</strong>
                            <input type="text" name="detail" class="form-control">

                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <strong>pic 1:</strong>
                                <input type="file" name="pic1" class="form-control" placeholder="image">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <strong>pic 2 :</strong>
                                <input type="file" name="pic2" class="form-control" placeholder="image">

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <strong>pic 3 :</strong>
                                <input type="file" name="pic3" class="form-control" placeholder="image">

                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <strong>pic 4 :</strong>
                                <input type="file" name="pic4" class="form-control" placeholder="image">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <strong>pic 5 :</strong>
                                <input type="file" name="pic5" class="form-control" placeholder="image">

                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <strong>pic 6 :</strong>
                                <input type="file" name="pic6" class="form-control" placeholder="image">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <strong>pic 7 :</strong>
                                <input type="file" name="pic7" class="form-control" placeholder="image">

                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <strong>pic 8 :</strong>
                                <input type="file" name="pic8" class="form-control" placeholder="image">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <strong>pic 9 :</strong>
                                <input type="file" name="pic9" class="form-control" placeholder="image">

                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <strong>pic 10 :</strong>
                                <input type="file" name="pic10" class="form-control" placeholder="image">

                            </div>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="subnit" class="btn btn-primary">เพิ่ม</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
