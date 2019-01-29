@extends('admin.layout.master')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
        	
            <div class="col-lg-12">
                <h1 class="page-header">Đĩa Luận Văn
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
                        <td>Mã đĩa</td>
                        <td>File PDF</td>
                        <td>File WORD</td>
                        <td>File SOURCE</td>
                        <td>Tên luận văn</td>
                        <td>Hành động</td>
                    </tr>
                </thead>
                <tbody>
                	@foreach($dialuanvan as $dlv)
                    <tr class="odd gradeX" align="center">
                        <td>{{ $dlv -> madia }}</td>
                        <td align="left">{{ $dlv -> filepdf }}</td>
                        <td align="left">{{ $dlv -> fileword }}</td>
                        <td align="left">{{ $dlv -> filesrc }}</td>
                        <td align="left">{{ $dlv -> luanvan-> tenlv }}</td>
                        <td class="center" align="center"><a onclick="return confirm_tb()" style="margin-right: 10px;" href="{{route('dialuanvan.xoa', $dlv-> madia)}}"><i class="fa fa-trash-o  fa-lg"></i></a><a href="{{route('dialuanvan.getsua', $dlv-> madia)}}"><i class="fa fa-pencil fa-lg"></i></a></td>
                        
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