@extends('admin.layout.master')
@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
        	
            <div class="col-lg-12">
                <h1 class="page-header">Hướng dẫn
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
                        <td>Sinh viên</td>
                        <td>Giảng viên</td>
                        <td>Mã luận văn</td>
                        <td>Ngày bắt đầu</td>
                        <td>Ngày kết thúc</td>
                        <td>Hướng dẫn</td>
                        <td>Hành động</td>
                    </tr>
                </thead>
                <tbody>
                	@foreach($huongdan as $hd)
                    <tr class="odd gradeX" align="center">
                        <td>{{ $hd-> masv }}</td>
                        <td align="left">{{ $hd-> sinhvien-> hotensv }}</td>
                        <td align="left">{{ $hd-> giangvien-> hotengv }}</td>
                        <td>{{ $hd-> malv }}</td>
                        <td>{{ date('d-m-Y', strtotime($hd-> ngaybd)) }}</td>
                        <td>{{ date('d-m-Y', strtotime($hd-> ngaykt)) }}</td>
                        <td>{{ $hd-> phantramhd }}%</td>
                        <td class="center"><a onclick="return confirm_tb()" style="margin-right: 10px;" href="{{route('gv_sv_lv.xoa', [ $hd-> masv, $hd-> magv, $hd->malv ])}}"><i class="fa fa-trash-o  fa-lg"></i></a><a href="{{route('gv_sv_lv.getsua',[ $hd-> masv, $hd-> magv, $hd->malv ])}}"><i class="fa fa-pencil fa-lg"></i></a></td>
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
    $(document).ready(function(){
        $('#anthongbao').hide(3000);
    });
</script>
@endsection
@section('xacnhan')
    <script>
        function confirm_tb(){
        return confirm("Bạn có chắc chắn thực hiện hành động này");
    }
    </script>
@endsection