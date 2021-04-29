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

@section('nav_giangvien','active')
@section('title','Giảng viên')


@section('content')
<div class="container-fluid">
    <h1>QUẢN LÝ GIẢNG VIÊN</h1>
    <a class="btn btn-success" href="javascript:void(0)" id="createGiangVien"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Thêm giảng viên</a>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Danh sách giảng viên</h4>
            <p class="card-category"> Here is a subtitle for this table</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table" id="tbl_giangvien">
                <thead class=" text-primary">
                    <tr>
                        <td>No</td>
                        <td>Họ tên</td>
                        <td>Email</td>
                        <td>SDT</td>
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

    <div class="modal fade" id="ajaxModel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="modelHeading"></h4>
              </div>
              <div class="modal-body">
                  <form id="giangvienForm" name="giangvienForm" class="form-horizontal">
                    {{ csrf_field() }}
                     <input type="hidden" name="id" id="id">
                      <div class="form-group">
                          <label for="name" class="col-sm-12 control-label" style="font-size: medium;">Họ tên:</label>
                          <br>
                          <div class="col-sm-12">
                              <input type="text" class="form-control" id="hoten" name="hoten" placeholder="Nhập họ tên" value="" required="">
                          </div>
                      </div>

                      <div class="form-group">
                        <label for="name" class="col-sm-12 control-label" style="font-size: medium;">Tài khoản:</label>
                        <br>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="taikhoan" name="taikhoan" placeholder="Nhập tài khoản" value="" required="">
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
                        <label for="name" class="col-sm-12 control-label" style="font-size: medium;">Email:</label>
                        <br>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Nhập email" value="" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-12 control-label" style="font-size: medium;">Số điện thoại:</label>
                        <br>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="sdt" name="sdt" placeholder="Nhập số điện thoại" value="" required="">
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
          var table = $('#tbl_giangvien').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route('giangvien.index') }}",
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  {data: 'hoten', name: 'hoten'},
                  {data: 'email', name: 'email'},
                  {data: 'sdt', name: 'sdt'},
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

          $('#createGiangVien').click(function () {
              $('#saveBtn').val("create-giangvien");
              $('#id').val('');
              $('#giangvienForm').trigger("reset");
              $('#modelHeading').html("THÊM GIẢNG VIÊN");
              $('#ajaxModel').modal('show');
          });

          

          $('body').on('click', '.editGiangVien', function () {
            var id = $(this).data('id');
            $.get("{{ route('giangvien.index') }}" +'/' + id +'/edit', function (data) {
                $('#modelHeading').html("SỬA GIẢNG VIÊN");
                $('#saveBtn').val("edit-giangvien");
                $('#ajaxModel').modal('show');
                $('#id').val(data.id);
                $('#hoten').val(data.hoten);
                $('#taikhoan').val(data.taikhoan);
                $('#matkhau').val(data.matkhau);
                $('#email').val(data.email);
                $('#sdt').val(data.sdt);  
            })
         });
          $('#saveBtn').click(function (e) {
              e.preventDefault();
              $(this).html('Lưu');
          
              $.ajax({
                data: $('#giangvienForm').serialize(),
                url: "{{ route('giangvien.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
           
                    $('#giangvienForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
               
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Lưu');
                }
            });

            
          });
          
          
          
          $('body').on('click', '.deleteGiangVien', function (e) {
           
            if(!confirm("Bạn có chắc muốn xóa?")){
                return false;
            }
            e.preventDefault();
              var id = $(this).data("id");
            
              $.ajax({
                  type: "DELETE",
                  url: "{{ route('giangvien.store') }}"+'/'+id,
                  success: function (data) {
                      table.draw();
                  },
                  error: function (data) {
                      console.log('Error:', data);
                  }
              });
          });
    

     });

</script>
@endsection