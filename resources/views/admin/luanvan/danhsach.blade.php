@extends('admin.layout.master')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
        	
            <div class="col-lg-12">
                <h1 class="page-header">Luận Văn
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
                        <td>Mã luận văn</td>
                        <td>Tên luận văn</td>
                        <td>Loại luận văn</td>
                        <td>Tháng năm nộp luận văn</td>
                        <td>Nội dung tóm tắt</td>
                        <td>Màu bìa</td>
                        <td>Hành động</td>
                    </tr>
                </thead>
                <tbody>
                	@foreach($luanvan as $lv)
                    <tr class="odd gradeX" align="center">
                        <td>{{ $lv -> malv }}</td>
                        <td align="left">{{ $lv -> tenlv }}</td>
                        <td>{{ $lv -> phanloai_lv-> tenloailv }}</td>
                        <td>{{  date('m-Y', strtotime($lv -> thangnam)) }}</td>
                        <td><a href="" data-toggle="modal" data-target="#{{$lv-> malv}}">Xem chi tiết</a></td>
                        <td align="left">{{ $lv -> maubia }}</td>
                        {{-- Pop-up --}}
                        <div class="modal fade" id="{{$lv-> malv}}" role="dialog">
                            <div class="modal-dialog modal-md">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Nội dung tóm tắt: {{ $lv -> tenlv }}</h4>
                                </div>
                                <div class="modal-body">
                                  <p>{{ $lv -> noidungtomtat }}</p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                        </div>
                        <td class="center"><a onclick="return confirm_tb()" style="margin-right: 10px;" href="{{route('luanvan.xoa', $lv-> malv)}}"><i class="fa fa-trash-o  fa-lg"></i></a><a href="{{route('luanvan.getsua', $lv-> malv)}}"><i class="fa fa-pencil fa-lg"></i></a></td>
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