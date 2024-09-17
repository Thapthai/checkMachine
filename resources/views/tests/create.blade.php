 <!-- Create Parts-->
 <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
 aria-labelledby="staticBackdropLabel" aria-hidden="true">
 <div class="modal-dialog">
     <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title" id="staticBackdropLabel"><strong>เพิ่มชิ้นส่วนของเครื่องจักร</strong></h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
             <form action="{{ route('parts.store', [$department_id, $machine_id]) }}" method="POST"
                 enctype="multipart/form-data">
                 @csrf
                 <div class="col-xs-12 col-sm-12 col-md-12">
                     <div class="form-group">
                         <strong>ลำดับการตรวจ :</strong>
                         <input type="number" name="sequence" class="form-control" required>
                     </div>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-12">
                     <div class="form-group">
                         <strong>Part Name:</strong>
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
                         <strong>รายละเอียด :</strong>
                         <input type="text" name="detail" class="form-control">
                     </div>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-12">
                     <div class="form-group">
                         <strong>pic 1:</strong>
                         <input type="file" name="pic1" class="form-control" placeholder="image">
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