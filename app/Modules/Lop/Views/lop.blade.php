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

@section('nav_lop','active')
@section('title','Lớp')


@section('content')
<div class="container-fluid">
    <h1>QUẢN LÝ LỚP</h1>
    <a class="btn btn-success" href="javascript:void(0)" id="createLop"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Thêm lớp</a>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Danh sách lớp</h4>
            <p class="card-category"> Here is a subtitle for this table</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table" id="tbl_lop">
                <thead class=" text-primary">
                    <tr>
                        <td>No</td>
                        <td>Mã lớp</td>
                        <td>Tên lớp</td>
                        <td>Bộ môn</td>
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
        use App\Modules\BoMon\Models\BoMon;

        $BoMon = BoMon::all();
    @endphp

    <div class="modal fade" id="ajaxModel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="modelHeading"></h4>
              </div>
              <div class="modal-body">
                  <form id="lopForm" name="lopForm" class="form-horizontal">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name" class="col-sm-12 control-label" style="font-size: medium;">Mã lớp:</label>
                        <br>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="malop" name="malop" placeholder="Nhập mã lớp" value="" required="">
                        </div>
                    </div>
                      <div class="form-group">
                          <label for="name" class="col-sm-12 control-label" style="font-size: medium;">Tên lớp:</label>
                          <br>
                          <div class="col-sm-12">
                              <input type="text" class="form-control" id="tenlop" name="tenlop" placeholder="Nhập tên lớp" value="" required="">
                          </div>
                      </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-12 control-label" style="font-size: medium;">Bộ môn:</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="idbomon" name="idbomon" required="">
                              <option value="" disabled selected>--Chọn bộ môn--</option>
                              @foreach ($BoMon as $key=>$bomon)
                                  <option value="{{$bomon->id}}">{{$bomon->tenbomon}}</option>
                              @endforeach
                            </select>
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
          var table = $('#tbl_lop').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route('lop.index') }}",
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  {data: 'malop', name: 'malop'},
                  {data: 'tenlop', name: 'tenlop'},
                  {data: 'tenbomon', name: 'tenbomon'},
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

          $('#createLop').click(function () {
              $('#saveBtn').val("create-lop");
              $('#id').val('');
              $('#lopForm').trigger("reset");
              $('#modelHeading').html("THÊM LỚP");
              $('#ajaxModel').modal('show');
          });

          

          $('body').on('click', '.editLop', function () {
            var id = $(this).data('id');
            $.get("{{ route('lop.index') }}" +'/' + id +'/edit', function (data) {
                $('#modelHeading').html("SỬA LỚP");
                $('#saveBtn').val("edit-lop");
                $('#ajaxModel').modal('show');
                $('#id').val(data.id);
                $('#malop').val(data.malop);
                $('#tenlop').val(data.tenlop);
                $('#idbomon').val(data.idbomon);   
            })
         });
          $('#saveBtn').click(function (e) {
              e.preventDefault();
              $(this).html('Lưu');
          
              $.ajax({
                data: $('#lopForm').serialize(),
                url: "{{ route('lop.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
           
                    $('#lopForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
               
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Lưu');
                }
            });

            
          });
          
          
          
          $('body').on('click', '.deleteLop', function (e) {
           
            if(!confirm("Bạn có chắc muốn xóa?")){
                return false;
            }
            e.preventDefault();
              var id = $(this).data("id");
            
              $.ajax({
                  type: "DELETE",
                  url: "{{ route('lop.store') }}"+'/'+id,
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