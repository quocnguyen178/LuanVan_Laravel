@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Hướng dẫn
                    <small>Sửa</small>
                </h1>
                @if(session('thongbao'))
                <div class="alert alert-success">
                    {{session('thongbao')}}
                </div>
                @endif
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
                @if(!$errors-> has('matkhaucu') || !$errors-> has('matkhaumoi') || !$errors-> has('nhaplaimatkhau'))
                    @if(count($errors) >0)
                        <div class="alert alert-danger">
                            Thông tin bạn nhập không đúng, bạn cần chỉnh sửa như sau:
                            <ul>
                            @foreach($errors->all() as $err)
                                <li>{{$err}}</li>
                            @endforeach
                            </ul>
                        </div>
                    @endif
                @endif
                <form action="{{route('gv_sv_lv.postsuatiep', [ $huongdan-> masv, $huongdan-> magv, $huongdan->malv ])}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input class="form-control" type="hidden"  id='thang'  name="thang" value="{{$thangnop}}" />
                        <input class="form-control" type="hidden" id='nam'  name="nam" value="{{$namnop}}" />
                    <div class="form-group">
                        <label>Sinh viên</label>
                        <input class="form-control" readonly="" name="masv" value="{{$huongdan->masv}} - {{$huongdan->sinhvien->hotensv}}" />
                       
                    </div>
                    <div class="form-group">
                        <label>Giang viên</label>
                        <input class="form-control" readonly="" name="magv" value="{{$huongdan->magv}} - {{$huongdan->giangvien->hotengv}}" />
                    </div>
                    <div class="form-group">
                        <label>Luận văn</label>
                       <input class="form-control" readonly="" id="malv" name="malv" value="{{$huongdan->malv}} - {{$huongdan->luanvan->tenlv}}" />
                    </div>
                    <div class="form-group">
                        <label>Tháng năm nộp của luận văn trên là</label>
                        <p id="thangnop">{{$tnop}}</p>
                    </div>
                    <div class="form-group">
                        <label>Ngày bắt đầu</label><span> ( dd-mm-yyyy )</span>
                        <input class="form-control" onChange="ccc()" id="aaa" name="ngaybd" value="{{date('d-m-Y', strtotime($huongdan-> ngaybd))}}" placeholder="Nhập ngày bắt đầu" />
                        <span id="bd2_error" class="error" style="color: red;"></span>
                        <span id="bd3_error" class="error" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label>Ngày kết thúc</label><span> ( dd-mm-yyyy )</span>
                        <input class="form-control" name="ngaykt" id="bbb" onChange="ccc()" value="{{date('d-m-Y', strtotime($huongdan-> ngaykt))}}" placeholder="Nhập ngày kết thúc" />
                        <span id="bd4_error" class="error" style="color: red;"></span>
                        <span id="bd5_error" class="error" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label>Hướng dẫn</label> <span>(%)</span>
                        <input class="form-control" name="phantramhd" onChange="ktpt()" id="pt1" value="{{$huongdan-> phantramhd}}" placeholder="Nhập phần trăm hướng dẫn" /><span id="pt_error" class="error" style="color: red;"></span>
                    </div>
                    <button type="submit" id="them" class="btn btn-info" onclick="return confirm_tb()">Sửa</button>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection
@section('xacnhan')
    <script>
        function confirm_tb(){
        return confirm("Bạn có chắc chắn thực hiện hành động này");
    }
    function ccc(){
        var a=$('#aaa').val();
        var b=$('#bbb').val();
        var namhd= a.substr(8,2);
        var namlv=$('#nam').val();
        var thanglv=$('#thang').val();
        var thanghd= a.substr(3,2);
        var namkt=b.substr(8,2);
        var thangkt=b.substr(3,2);
            if(Number(thanglv)==7 || Number(thanglv)==8){
                if(Number(thanglv)-Number(thanghd)>3 || Number(thanglv)-Number(thanghd)<0)
                {
                    $('#bd2_error').text('Tháng hướng dẫn phải trước tháng nộp ít nhất 3 tháng');
                    $('#them').prop('disabled',true);
                }
                else{$('#bd2_error').text('');$('#them').prop('disabled',false);}
                if(Number(namlv)-Number(namhd)!=0 )
                {
                    $('#bd3_error').text('Năm bắt đầu phải trùng với năm hướng dẫn');
                    $('#them').prop('disabled',true);
                }
                else{$('#bd3_error').text('');$('#them').prop('disabled',false);}
            }
            if(namlv-namkt==0)
                 {
                    $('#bd5_error').text('');$('#them').prop('disabled',false);
                    
                }
            else{$('#bd5_error').text('Năm kết thúc hướng dẫn phải trùng với năm nộp luận văn');
                    $('#them').prop('disabled',true);}
            if(thanglv-thangkt!=0)
                 {
                    $('#bd4_error').text('Tháng kết thúc hướng dẫn phải trùng với tháng nộp luận văn');
                    $('#them').prop('disabled',true);
                }
            else{$('#bd4_error').text('');$('#them').prop('disabled',false);}
    }
    
    function ktpt(){
            var pt1 = $('#pt1').val();
            if(Number(pt1)==100)
                {$('#pt_error').text('Sinh viên làm luận văn này đã có 2 người hướng dẫn không thể hướng dẫn 100% được');$('#them').prop('disabled',true);}
            if(Number(pt1)>100)
                {$('#pt_error').text('Phần trăm hd không vượt quá 100%');$('#them').prop('disabled',true);}
            if(Number(pt1)<100)
                {$('#pt_error').text('');$('#them').prop('disabled',false);}
        }
        $(document).ready(function() {
            $('#malv').change(function(){
                var malv = $('#malv').val();
                $.get("admin/ajax/huongdan/"+malv, function(data){
                    $('#thangnop').html(data);
            });
            });
        });
    </script>
@endsection
