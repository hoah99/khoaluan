@extends('layouts.admin')

@section('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style>
        #tbl_monthi{
            font-size: medium;
        }
    </style>

@endsection

@section('nav_dethi','active')
@section('title','Đề thi')


@section('content')
<div class="container-fluid">
    <h1>QUẢN LÝ ĐỀ THI</h1>
    <a class="btn btn-success" href="javascript:void(0)" id="createDeThi"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Thêm đề thi</a>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Danh sách đề thi</h4>
            <p class="card-category"> Here is a subtitle for this table</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table" id="tbl_dethi">
                <thead class=" text-primary">
                    <tr>
                        <td>No</td>
                        <td>Tiêu đề</td>
                        <td>Số câu hỏi</td>
                        <td>Thời gian (phút)</td>
                        <td>Môn thi</td>
                        <td>Lớp</td>
                        <td>Giảng viên</td>
                        <td width="500px">Hành động</td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    @php
        use App\Modules\MonThi\Models\MonThi;
        use App\Modules\GiangVien\Models\GiangVien;
        use App\Modules\Lop\Models\Lop;
        use App\Modules\CauHoi\Models\CauHoi;

        $MonThi = MonThi::all();
        $GiangVien = GiangVien::all();
        $Lop = Lop::all();
        
    @endphp

    <div class="modal fade" id="ajaxModel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="modelHeading"></h4>
              </div>
              <div class="modal-body">
                  <form id="cauhoiForm" name="cauhoiForm" class="form-horizontal">
                    {{ csrf_field() }}
                     <input type="hidden" name="id" id="id">

                     <div class="form-group">
                        <label for="name" class="col-sm-12 control-label" style="font-size: medium;">Tiêu đề:</label>
                        <br>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="tieude" name="tieude" placeholder="Nhập tiêu đề" value="" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-12 control-label" style="font-size: medium;">Mật khẩu:</label>
                        <br>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="matkhau" name="matkhau" placeholder="Nhập mật khẩu" value="" required="">
                        </div>
                    </div>

                     <div class="form-group">
                        <label for="name" class="col-sm-12 control-label" style="font-size: medium;">Môn thi:</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="idmonthi" name="idmonthi" onchange="getsocauhoi(this.value)" required="">
                              <option value="" disabled selected>--Chọn môn thi--</option>
                              @foreach($MonThi as $key => $monthi)
                              <option value="{{$monthi->id}}">{{$monthi->tenmon}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    @php
                        $CauHoi = CauHoi::where('idmonthi','=','29');
                    @endphp

                    <div id="dschuong" name="dschuong"></div>
                        
                      <div class="form-group">
                          <label for="name" class="col-sm-12 control-label" style="font-size: medium;">Tổng số câu hỏi: {{ $CauHoi->count() }}</label>
                          <br>
                          <div class="col-sm-12">
                            <input type="number" class="form-control" id="socauhoi" name="socauhoi" required="">
                          </div>
                      </div>

                      <div class="form-group">
                        <label for="name" class="col-sm-12 control-label" style="font-size: medium;">Thời gian (phút):</label>
                        <br>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="thoigian" name="thoigian" placeholder="Nhập thời gian" value="" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-12 control-label" style="font-size: medium;">Lớp:</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="idlop" name="idlop" required="">
                              <option value="" disabled selected>--Chọn lớp--</option>
                              @foreach($Lop as $key => $lop)
                              <option value="{{$lop->id}}">{{$lop->malop}} - {{$lop->tenlop}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-12 control-label" style="font-size: medium;">Giảng viên:</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="idgiangvien" name="idgiangvien" required="">
                              <option value="" disabled selected>--Chọn giảng viên--</option>
                              @foreach($GiangVien as $key => $giangvien)
                              <option value="{{$giangvien->id}}">{{$giangvien->hoten}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-12 control-label" style="font-size: medium;">Ghi chú:</label>
                        <br>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="ghichu" name="ghichu" placeholder="Nhập ghi chú" value="" required="">
                        </div>
                    </div>
                    
                      <div class="col-sm-offset-2 col-sm-10">
                       <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Lưu
                       </button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>


</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>  

@if (Session::has('themthanhcong'))
    <script>
      toastr.success("{{ Session::get('themthanhcong ') }}");
    </script>
@endif
<script type="text/javascript">
    $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
          });
          var table = $('#tbl_dethi').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route('dethi.index') }}",
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  {data: 'tieude', name: 'tieude'},
                  {data: 'socauhoi', name: 'socauhoi'},
                  {data: 'thoigian', name: 'thoigian'},
                  {data: 'tenmon', name: 'tenmon'},
                  {data: 'tenlop', name: 'tenlop'},
                  {data: 'hoten', name: 'hoten'},
                  {data: 'action', name: 'action', orderable: false, searchable: false},
              ],
              language: {
                "processing": "Đang tải...",
                "lengthMenu": "Hiển thị _MENU_",
                "zeroRecords": "Không tìm thấy",
                "info": "Hiển thị trang _PAGE_/_PAGES_",
                "infoEmpty": "Không có dữ liệu",
                "emptyTable": "Không có dữ liệu",
                "infoFiltered": "(tìm kiếm trong tất cả _MAX_ mục)",
                "sSearch": "Tìm kiếm",
                "paginate": {
                    "first": "Đầu",
                    "last": "Cuối",
                    "next": "Sau",
                    "previous": "Trước"
                }
        }
          });

          $('#createDeThi').click(function () {
              $('#saveBtn').val("create-dethi");
              $('#id').val('');
              $('#dethiForm').trigger("reset");
              $('#modelHeading').html("THÊM ĐỀ THI");
              $('#ajaxModel').modal('show');
          });

          

          $('body').on('click', '.editCauHoi', function () {
            var id = $(this).data('id');
            $.get("{{ route('cauhoi.index') }}" +'/' + id +'/edit', function (data) {
                $('#modelHeading').html("SỬA CÂU HỎI");
                $('#saveBtn').val("edit-cauhoi");
                $('#ajaxModel').modal('show');
                $('#id').val(data.id);
                $('#noidung').val(data.noidung);
                $('#phuongana').val(data.phuongana);
                $('#phuonganb').val(data.phuonganb);
                $('#phuonganc').val(data.phuonganc);
                $('#phuongand').val(data.phuongand);
                $('#dapan').val(data.dapan);
                $('#chuong').val(data.chuong);
                $('#dokho').val(data.dokho);
                $('#idmonthi').val(data.idmonthi);    
            })
         });
          $('#saveBtn').click(function (e) {
              e.preventDefault();
              $(this).html('Lưu');
          
              $.ajax({
                data: $('#dethiForm').serialize(),
                url: "{{ route('dethi.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
           
                    $('#dethiForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
               
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Lưu');
                }
            });

            
          });
          
          
          
          $('body').on('click', '.deleteCauHoi', function (e) {
           
            if(!confirm("Bạn có chắc muốn xóa?")){
                return false;
            }
            e.preventDefault();
              var id = $(this).data("id");
            
              $.ajax({
                  type: "DELETE",
                  url: "{{ route('cauhoi.store') }}"+'/'+id,
                  success: function (data) {
                      table.draw();
                  },
                  error: function (data) {
                      console.log('Error:', data);
                  }
              });
          });
    

     });
     

    //  $('select').select();
    // function get_units(id) {
    //     var list = $('#dschuong');
    //     list.empty();
    //     var url = "{{ route('dethi.laydschuong') }}"+'/'+ id;
    //     var success = function (result) {
    //         if (result.length <= 0) {
    //             var item = '<div class="input-field"><input type="text" disabled value="Môn này hiện chưa có câu hỏi nào"></div>';
    //             list.append(item);
    //         } else {
    //             for (i = 0; i < result.length; i++) {
    //                 var item = '<div class="input-field"><label for="unit-' + result[i].Unit + '">Nhập số câu hỏi chương ' + result[i].Unit + ' (có ' + result[i].Total + ' câu) <span class="failed">(*)</span></label><input type="number" max="' + result[i].Total + '" class="unit_input" onchange="set_sum(' + result[i].Total + ')"  name="unit-' + result[i].Unit + '" id="unit-' + result[i].Unit + '" required></div>';
    //                 list.append(item);
    //             }
    //         }
    //     };
    //     $.get(url, success);
    // }
    // function set_sum(total) {
    //     var sum = 0;
    //     $('.unit_input').each(function () {
    //         if (parseInt(this.value) > parseInt(this.getAttribute("max")))
    //             alert("Nhập quá số câu hỏi đang có, vui lòng kiểm tra lại");
    //         else if (this.value != "")
    //             sum += parseInt(this.value);
    //     });
    //     $('#total_question').val(sum);
    // }

    

</script>
@endsection