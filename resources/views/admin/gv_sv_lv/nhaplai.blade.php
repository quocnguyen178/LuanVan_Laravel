@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Hướng dẫn
                    <small>Nhập tiếp</small>
                </h1>
                @if(isset($huongdan))
                <div class="alert alert-success">
                    Bạn phải nhập tiếp giảng viên hướng dẫn tiếp theo để đủ 100%
                </div>
                @endif
                @if(session('thongbao'))
                <div class="alert alert-success" id="anthongbao">
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
                <form action="{{route('gv_sv_lv.postnhaplai')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group">
                        <label>Sinh viên</label>
                        <input class="form-control" readonly="" name="masv" value="{{$sinhvien->masv}}-{{$sinhvien->hotensv}}" />
                    </div>
                    <div class="form-group">
                        <label>Giảng viên</label>
                        <select class="form-control" name = "magv" id="gv" >
                            <option selected="" value="">----</option>
                            @foreach($giangvien as $gv)
                            <option value="{{ $gv -> magv }}">{{$gv-> magv}} - {{$gv-> hotengv}}</option>
                            @endforeach
                        </select>
                         <span id="gv_error" class="error" style="color: red;"></span>
                         <span id="gv1_error" class="error" style="color: red;"></span>
                    </div>
                   
                    <div class="form-group">
                        <label>Luận văn</label>
                        <input class="form-control" readonly="" name="malv" value="{{$luanvan->malv}}-{{$luanvan->tenlv}}" />
                    </div>
                     <div class="form-group">
                        <label>Tháng năm nộp của luận văn trên là </label>
                        <p >{{$thanglv}}-20{{$namlv}}</p>

                    </div>
                       	<input class="form-control" type="hidden" id='pt'  name="pt1" value="{{$pt}}" />
                        <input class="form-control" type="hidden"  id='thang'  name="thang" value="{{$thanglv}}" />
                        <input class="form-control" type="hidden" id='nam'  name="nam" value="{{$namlv}}" />
                        <input class="form-control" type="hidden"  id='thang1'  name="thang" value="{{$bd1}}" />
                        <input class="form-control" type="hidden" id='nam1'  name="nam" value="{{$namlv}}" />
                       	<input class="form-control" type="hidden" id='magv'  name="magv1" value="{{$magv}}" />
                       	<input class="form-control" type="hidden" id='bd'  name="bd1" value="{{$bd}}" />
                       	<input class="form-control" type="hidden" id='kt'  name="kt1" value="{{$kt}}" />
                        
                    <div class="form-group">
                        <label>Ngày bắt đầu</label> <span> ( dd-mm-yyyy )</span>
                        <input class="form-control" onChange="ccc()" id="aaa"  name="ngaybd" value="{{$bd}}" placeholder="Nhập ngày bắt đầu" />
                        <span id="bd2_error" class="error" style="color: red;"></span>
                        <span id="bd3_error" class="error" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label>Ngày kết thúc</label> <span> ( dd-mm-yyyy )</span>
                        <input class="form-control" id='bbb' onChange="ccc()"  name="ngaykt" value="{{$kt}}" placeholder="Nhập ngày kết thúc" />
                        <span id="bd4_error" class="error" style="color: red;"></span>
                        <span id="bd5_error" class="error" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label>Hướng dẫn</label> <span>(%)</span>
                        <input class="form-control" onChange="ktpt()" id="pt1" name="phantramhd" value="" placeholder="Phần trăm hướng dẫn của giảng viên trước là {{$pt}}" />
                        <span id="pt_error" class="error" style="color: red;"></span>
                    </div>
                    <button type="submit" id="them" class="btn btn-info" onclick=" return confirm_tb()">Thêm</button>
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
        $(document).ready(function() {
            $('#gv').change(function(){
                var gv = $('#gv').val();
                //alert(gv);
                var gv1 = $('#magv').val();
                if(gv==gv1)
                {
                    $('#gv_error').text('Giảng viên hướng dẫn bị trùng');
                    $('#them').prop('disabled',true);
                }
                else{$('#gv_error').text('');$('#them').prop('disabled',false);}
                if(gv=="")
                {
                    $('#gv1_error').text('Chưa chọn giảng viên hướng dẫn');
                    $('#them').prop('disabled',true);
                }
                else{$('#gv1_error').text('');$('#them').prop('disabled',false);}
            });
            });
        function confirm_tb(){
        return confirm("Bạn có chắc chắn thực hiện hành động này");		
        }
        function ccc()
        {
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
        	var pt =$('#pt').val();
        	var pt1 = $('#pt1').val();
        	if(Number(pt)+Number(pt1)==100)
        		{$('#pt_error').text('');$('#them').prop('disabled',false);}
        	if(Number(pt)+Number(pt1)>100)
        		{$('#pt_error').text('Phần trăm hd không vượt quá 100%');$('#them').prop('disabled',true);}
			if(Number(pt)+Number(pt1)<100)
        		{$('#pt_error').text('Phần trăm hd không nhỏ hơn 100%');$('#them').prop('disabled',true);}
        }
    </script>
@endsection