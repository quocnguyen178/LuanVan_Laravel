@extends('admin.layout.master')

@section('content')
<!-- Page Content -->

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Giảng Viên
                    <small>Danh sách</small>
                </h1>
                @if(session('thongbao'))
                <div class="alert alert-success" id="anthongbao">
                    {{session('thongbao')}}
                </div>
                @endif
                @if(session('thongbaokhongthe'))
                <div class="alert alert-success">
                    {{session('thongbaokhongthe')}}
                </div>
                @endif
            </div>
            <!-- /.col-lg-12 -->
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <td>Mã</td>
                        <td>Họ tên</td>
                        <td>Học hàm</td>
                        <td>Học vị</td>
                        <td>Loại</td>
                        <td>Email</td>
                        <td>SDT 1</td>
                        <td>SDT 2</td>
                        <td colspan="2">Quyền</td>
                        <td>Hành động</td>
                    </tr>
                </thead>
                <tbody>
                	@foreach($giangvien as $gv)
                    <tr class="odd gradeX" align="center">
                        <td>{{ $gv -> magv }}</td>
                        <td align="left">{{ $gv -> hotengv }}</td>
                        <td>{{ $gv -> hocham }}</td>
                        <td>{{ $gv -> hocvi }}</td>
                        <td>{{ $gv -> loaigv }}</td>
                        <td align="left">{{ $gv -> email }}</td>
                        <td>{{ $gv -> sdt1 }}</td>
                        <td>{{ $gv -> sdt2 }}</td>
                        @if(count($gv-> gv_quyen)==1)
                            @foreach($gv-> gv_quyen as $quyen)
                            <td>{{ $quyen-> quyen-> tenquyen }}</td>
                            <td></td>
                            @endforeach
                        @else
                            @foreach($gv-> gv_quyen as $quyen)
                            <td>{{ $quyen-> quyen-> tenquyen }}</td>
                            @endforeach
                        @endif
                        
                        <td class="center" align="center">
                            @if(Session::get('magv1') != $gv-> magv )
                                <a onclick="return confirm_tb()" href="{{route('giangvien.xoa', $gv-> magv)}}" style="margin-right: 10px;"><i class="fa fa-trash-o  fa-lg"></i>
                                </a>
                            @endif
                            <a href="{{route('giangvien.getsua', $gv-> magv)}}"><i class="fa fa-pencil fa-lg"></i>
                            </a>
                            
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
    $(document).ready(function(){
        $('#anthongbao').hide(3000);
    });
    function confirm_tb(){
        return confirm("Bạn có chắc chắn thực hiện hành động này");
    }
</script>
@endsection