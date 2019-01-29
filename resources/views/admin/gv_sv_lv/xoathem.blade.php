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
                <form action="{{route('gv_sv_lv.postxoathem1',[ $huongdan-> masv, $huongdan-> magv, $huongdan->malv ])}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group">
                        <label>Sinh viên</label>
                        <input class="form-control" readonly="" name="masv" value="{{$huongdan->sinhvien->masv}}-{{$huongdan->sinhvien->hotensv}}" />
                    </div>
                    <div class="form-group">
                        <label>Giảng viên</label>
                        <select class="form-control" name = "magv" {{-- id="loailv" --}}>
                            @foreach($giangvien as $gv)
                            <option value="{{ $gv -> magv }}">{{$gv-> magv}} - {{$gv-> hotengv}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Luận văn</label>
                        <input class="form-control" readonly="" name="malv" value="{{$huongdan->luanvan->malv}}-{{$huongdan->luanvan->tenlv}}" />
                    </div>
                     <div class="form-group">
                        <label>Tháng năm nộp của luận văn trên là </label>
                        <p >{{$thanglv}}-20{{$namlv}}</p>

                    </div>
                    
                    <div class="form-group">
                        <label>Ngày bắt đầu</label> <span> ( dd-mm-yyyy )</span>
                        <input class="form-control" onChange="bbb()" id="aaa"  name="ngaybd" value="{{$bd}}" placeholder="Nhập ngày bắt đầu" />
                        <span id="bd_error" class="error" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label>Ngày kết thúc</label> <span> ( dd-mm-yyyy )</span>
                        <input class="form-control"  name="ngaykt" value="{{$kt}}" placeholder="Nhập ngày kết thúc" />
                    </div>
                    <div class="form-group">
                        <label>Hướng dẫn</label> <span>(%)</span>
                        <input class="form-control" readonly="" onChange="ktpt()" id="pt1" name="phantramhd" value="{{$pt}}"/>
                        <span id="pt_error" class="error" style="color: red;"></span>
                    </div>
                    <button type="submit" id="them" class="btn btn-info" onclick=" return confirm_tb()">Thêm</button>
                    <!-- <a href="{{route('gv_sv_lv.getquaylai')}}">Quay lại</a> -->
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
        function bbb()
        {
            var a=$('#aaa').val();
            var namhd= a.substr(8,2);
            var namlv=$('#nam').val();
            alert(namlv);
            var thanglv=$('#thang').val();
            var thanghd= a.substr(3,2);
            if(Number(thanglv)-Number(thanghd)<=2)
                {
                    $('#bd_error').text('Ngày bắt đầu phải trước ngày hướng dẫn ít nhất 3 tháng');
                    $('#them').prop('disabled',true);
                }
            else{$('#bd_error').text('');$('#them').prop('disabled',false);}
            if(Number(namlv)-Number(namhd)!=0)
                {
                    $('#bd_error').text('Năm bắt đầu phải trùng với năm hướng dẫn');
                    $('#them').prop('disabled',true);
                }
            else{$('#bd_error').text('');$('#them').prop('disabled',false);}

            //alert('aa');
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