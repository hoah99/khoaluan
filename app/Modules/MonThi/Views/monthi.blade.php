@extends('layouts.admin')

@section('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" />
    <style>
        #tbl_monthi{
            font-size: medium;
        }
    </style>
    
@section('nav_monthi','active')
@section('title','Môn thi')

@endsection
@section('content')
<div class="container-fluid">
    <h1>QUẢN LÝ MÔN THI</h1>
    <a class="btn btn-success" href="javascript:void(0)" id="createMonThi"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Thêm môn thi</a>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Danh sách môn thi</h4>
            <p class="card-category"> Here is a subtitle for this table</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table" id="tbl_monthi">
                <thead class=" text-primary">
                    <tr>
                        <td>No</td>
                        <td>Môn thi</td>
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
                  <form id="monthiForm" name="monthiForm" class="form-horizontal">
                    {{ csrf_field() }}
                     <input type="hidden" name="id" id="id">
                      <div class="form-group">
                          <label for="name" class="col-sm-12 control-label" style="font-size: medium;">Tên môn thi:</label>
                          <br>
                          <div class="col-sm-12">
                              <input type="text" class="form-control" id="tenmon" name="tenmon" placeholder="Nhập tên môn thi" value="" required="">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>


@if(Session::has('success'))
    <script>
        toastr.success("{!! Session::get('success') !!}");
    </script>
@endif
<script type="text/javascript">
    $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
          });
          var table = $('#tbl_monthi').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route('monthi.index') }}",
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  {data: 'tenmon', name: 'tenmon'},
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

          $('#createMonThi').click(function () {
              $('#saveBtn').val("create-monthi");
              $('#id').val('');
              $('#monthiForm').trigger("reset");
              $('#modelHeading').html("THÊM MÔN THI");
              $('#ajaxModel').modal('show');
          });

          

          $('body').on('click', '.editMonThi', function () {
            var id = $(this).data('id');
            $.get("{{ route('monthi.index') }}" +'/' + id +'/edit', function (data) {
                $('#modelHeading').html("SỬA MÔN THI");
                $('#saveBtn').val("edit-monthi");
                $('#ajaxModel').modal('show');
                $('#id').val(data.id);
                $('#tenmon').val(data.tenmon);
                
            })
         });
          $('#saveBtn').click(function (e) {
              e.preventDefault();
              $(this).html('Lưu');
          
              $.ajax({
                data: $('#monthiForm').serialize(),
                url: "{{ route('monthi.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
           
                    $('#monthiForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
               
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Lưu');
                }
            });

            
          });
          
          
          
          $('body').on('click', '.deleteMonThi', function (e) {
           
            if(!confirm("Bạn có chắc muốn xóa?")){
                return false;
            }
            e.preventDefault();
              var id = $(this).data("id");
            
              $.ajax({
                  type: "DELETE",
                  url: "{{ route('monthi.store') }}"+'/'+id,
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