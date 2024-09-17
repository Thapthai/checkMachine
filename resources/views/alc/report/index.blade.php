 @extends('layouts.app')

 @push('styles')
     <style>
         @media print {

             @page {
                 size: A3;
             }

             .d-print-none {
                 display: none;
             }

             .page-break {
                 page-break-after: always;
             }

         }

         .center {
             border-collapse: collapse;
             max-width: 100%;
             margin-bottom: 1rem;
             width: 100%;
         }

         .center td,
         .center th {
             text-align: center;
             border: 1px solid #000;
             padding: 0px;
         }
     </style>
 @endpush

 @section('content')
     <div class="container">

         <table class="table">
             <tr>
                 <td>
                     <h4><strong>รายงาน แอลกอฮอล์ และ คลอรีน ของแผนก {{ $department->name }}</strong></h4>
                 </td>

             </tr>

         </table>


         @if ($message = Session::get('success'))
             <div class="alert alert-success">
                 <p>{{ $message }}</p>
             </div>
         @endif
         @if ($message = Session::get('error'))
             <div class="alert alert-warning">
                 <p>{{ $message }}</p>
             </div>
         @endif

         <div class="row">
             <div class="pull-right mb-2">
                 <a href="{{ url('/') }}" class="btn btn-primary d-print-none">หน้าแรก</a>
             </div>

         </div>
         <hr>

         <form action="{{ route('alc_report', $department->id) }}" method="POST" enctype="multipart/form-data">
             @csrf

             <div class="row my-3 d-print-none">
                 <div class="col">
                     <label>ตั้งแต่</label>
                     <input type="date" name="since_date" class="form-control rounded  d-print-none"
                         @if (!empty($since_date)) value="{{ $since_date }}" @endif required />
                 </div>
                 <div class="col">
                     <label>ถึง</label>
                     <input type="date" name="to_date" class="form-control rounded  d-print-none"
                         @if (!empty($to_date)) value="{{ $to_date }}" @endif required />
                 </div>
                 <div class="col col-2">
                     <label></label>
                     <button type="submit" class="btn btn-success rounded w-100  d-print-none">เลือก</button>
                 </div>
             </div>


         </form>


         @if (count($alc_usages) > 0)
             <form action="{{ route('alc_report_excel') }}">
                 @csrf
                 <input type="hidden" name="department_name" value="{{ $department->name }}">
                 <input type="hidden" value="{{ $since_date }}" name="start_date">
                 <input type="hidden" value="{{ $to_date }}" name="end_date">
                 <input type="hidden" value="{{ $department->id }}" name="department_id">

                 <a onclick=" window.print()" class="btn btn-success d-print-none">กดพิมพ์ หรือ save เป็น
                     PDF</a>
                 <button type="submit" class="btn btn-danger d-print-none">Excel</button>
                 <a href="{{ route('sendEmail_alcReport', [$department->id, $since_date, $to_date]) }}"
                     class="btn btn-primary d-print-none">กดส่ง Email</a>
             </form>

             <br>

             <h5>วัน {{ date('d F Y', strtotime($since_date)) }} ถึง {{ date('d F Y', strtotime($to_date)) }} </h5>
     </div>

     <div class="container-fluid">

         <h4><strong>รายงาน การบันทึก</strong></h4>

         <table class="table center">
             <thead>
                 <tr>
                     <th>ไลน์</th>
                     <th>ส่วนงาน</th>
                     <th>จำนวนที่กำหนด</th>
                     <th>จำนวนที่เบิก</th>
                     <th>จำนวนที่ใช้งาน</th>
                     <th>จำนวนที่เสียหาย</th>

                 </tr>
             </thead>
             <tbody>

                 @foreach ($alc_usages->groupBy('shift_date') as $shift_date => $alc_usages)
                     <tr>
                         <th colspan="6">
                             <h5>วันที่ {{ date('d F Y', strtotime($shift_date)) }}</h5>
                         </th>
                     </tr>

                     @foreach ($alc_usages->groupBy('on_shift') as $on_shift => $alc_usages)
                         <tr>
                             <th colspan="6" style="text-align: center">
                                 <h5>กะ : {{ $on_shift }}</h5>
                             </th>
                         </tr>

                         @foreach ($alc_usages as $alc_usage)
                             @if ($alc_usage->alc_checkings->count() > 0)
                                 @foreach ($alc_usage->alc_checkings as $alc_checking)
                                     <tr>
                                         <td>{{ $alc_usage->alc_standard->name }}</td>
                                         <td>{{ $alc_usage->alc_standard->line->name }}</td>
                                         <td>{{ $alc_usage->alc_standard->quantity }}</td>

                                         <td>{{ $alc_usage->used_quantity }}</td>
                                         <td style="width: 200px">{{ $alc_checking->quantity_alc_usage }} ขวด
                                             <div class="d-flex p-1">
                                                 <table class="table">
                                                     <tr>
                                                         <th>หมายเลขขวด</th>
                                                         <th>ชนิด</th>
                                                     </tr>

                                                     @foreach ($alc_checking->alc_normals as $alc_normal)
                                                         <tr>
                                                             <td>
                                                                 {{ $alc_normal->alc_usage_bottle->alc_bottle->bottle_no ?? '-' }}
                                                             </td>
                                                             <td>
                                                                 {{ $alc_normal->alc_usage_bottle->alc_bottle->type ?? '-' }}

                                                             </td>
                                                         </tr>
                                                     @endforeach

                                                 </table>
                                             </div>
                                         </td>
                                         @if (count($alc_checking->alc_brokeds) > 0)
                                             <td>{{ $alc_checking->quantity_alc_broked }} ขวด
                                                 <div class="d-flex p-1">

                                                     <table class="center">

                                                         <tr>
                                                             <th>หมายเลขขวด</th>
                                                             <th>ชนิด</th>
                                                             <th>รูป</th>
                                                             <th>รายละเอียด</th>
                                                         </tr>

                                                         @foreach ($alc_checking->alc_brokeds as $alc_broked)
                                                             <tr>
                                                                 <td>
                                                                     {{ $alc_broked->alc_usage_bottle->alc_bottle->bottle_no ?? '-' }}
                                                                 </td>
                                                                 <td>
                                                                     {{ $alc_broked->alc_usage_bottle->alc_bottle->type ?? '-' }}

                                                                 </td>
                                                                 <td>
                                                                     @foreach ($alc_broked->alc_broked_pictures as $alc_broked_picture)
                                                                         <img src="{{ asset('storage/' . $alc_broked_picture->path) }}"
                                                                             alt="รูปภาพ" width="100px" class="m-2">
                                                                     @endforeach
                                                                 </td>
                                                                 <td> {{ $alc_broked->detail }}</td>
                                                             </tr>
                                                         @endforeach

                                                     </table>
                                                 </div>
                                             </td>
                                     </tr>
                                 @else
                                     <td>
                                         <div class="  alert-success">
                                             ไม่มีขวดที่เสียหาย
                                         </div>
                                     </td>
                                 @endif
                             @endforeach
                         @endif
                     @endforeach
                 @endforeach
                 @endforeach

         </table>
     @else
         <div class="alert alert-danger">
             <p>NO DATA</p>
         </div>
         @endif
     </div>

     @include('alc.script')
 @endsection
