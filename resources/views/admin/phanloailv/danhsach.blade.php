@extends('admin.layout.master')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
        	
            <div class="col-lg-12">
                <h1 class="page-header">Loại Luận Văn
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
                        <td>Mã loại</td>
                        <td>Tên loại luận văn</td>
                        <td>Hành động</td>
                    </tr>
                </thead>
                <tbody>
                	@foreach($loailv as $llv)
                    <tr class="odd gradeX" align="center">
                        <td>{{ $llv -> maloailv }}</td>
                        <td>{{ $llv -> tenloailv }}</td>
                        <td class="center"><a onclick="return confirm_tb()" style="margin-right: 10px;" href="{{route('phanloailv.xoa', $llv-> maloailv)}}"><i class="fa fa-trash-o  fa-lg"></i></a><a href="{{route('phanloailv.getsua', $llv-> maloailv)}}"><i class="fa fa-pencil fa-lg"></i></a></td>
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