@extends('admin.layout.master')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Sinh Viên
                    <small>Danh sách</small>
                </h1>
                @if(session('thongbao'))
                <div class="alert alert-success" id="anthongbao">
                    {{session('thongbao')}}
                </div>
                @endif
            </div>
            <!-- /.col-lg-12 -->
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <td>MSSV</td>
                        <td>Họ tên sinh viên</td>
                        <td>Lớp</td>
                        <td>Số điện thoại</td>
                        <td>Email</td>
                        <td>Quyền</td>
                        <td>Hành động</td>
                    </tr>
                </thead>
                <tbody>
                	@foreach($sinhvien as $sv)
                    <tr class="odd gradeX" align="center">
                        <td>{{ $sv -> masv }}</td>
                        <td align="left">{{ $sv -> hotensv }}</td>
                        <td>{{ $sv -> lop }}</td>
                        <td>{{ $sv -> sdt }}</td>
                        <td align="left">{{ $sv -> email }}</td>
                        <td>{{ $sv -> quyen-> tenquyen }}</td>
                        <td class="center"><a onclick="return confirm_tb()" style="margin-right: 10px;" href="{{route('sinhvien.xoa', $sv-> masv)}}" ><i class="fa fa-trash-o  fa-lg"></i></a><a href="{{route('sinhvien.getsua', $sv-> masv)}}"><i class="fa fa-pencil fa-lg"></i> </a>
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection
@section('anthongbao')

<script>
    function confirm_tb(){
        return confirm("Bạn có chắc chắn thực hiện hành động này");
    }
    $(document).ready(function(){
        $('#anthongbao').hide(3000);
    });
</script>
@endsection