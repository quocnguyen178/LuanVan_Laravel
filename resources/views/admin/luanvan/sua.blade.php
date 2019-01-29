@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Luận Văn 
                    <small>Sửa</small>
                </h1>
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
                <form action="{{route('luanvan.postsua', $luanvan-> malv)}}" method="POST">
                	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
                	<div class="form-group">
                        <label>Mã luận văn</label>
                        <input class="form-control" name="malv" readonly="" value="{{$luanvan-> malv}}" placeholder="Nhập mã loại luận văn" />
                    </div>
                    <div class="form-group">
                        <label>Tên luận văn</label>
                        <input class="form-control" name="tenlv" value="{{$luanvan-> tenlv}}" placeholder="Nhập tên loại luận văn" />
                    </div>
                    <div class="form-group">
                        <label>Loại luận văn</label>
                        <select class="form-control" name = "maloailv" id="loailv">
                            @foreach($loailv as $llv)
                            <option 
                                @if($llv-> maloailv == $luanvan-> maloailv)
                                    {{"selected"}}
                                @endif
                            value="{{ $llv -> maloailv }}">{{$llv-> tenloailv}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tháng năm nộp luận văn </label> (mm-YYYY)
                        <input class="form-control" name="thangnam" id="thangnam" onChange="ktthangnam()" value="{{date('m-Y', strtotime($luanvan-> thangnam))}}" placeholder="Nhập tháng năm nộp luận văn" />
                        <span id="thang_error" class="error" style="color: red;"></span>
                        <span id="nam_error" class="error" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label>Màu bìa</label>
                        <input class="form-control" name="maubia" value="{{$luanvan-> maubia}}" placeholder="Nhập màu bìa" />
                    </div>
                    <div class="form-group">
                        <label>Nội dung tóm tắt</label>
                        <textarea id="demo" name="noidungtt" class="form-control ckeditor" rows="3">
                            {{$luanvan-> noidungtomtat}}
                        </textarea>
                    </div>
                    <button type="submit" class="btn btn-info" onclick="return confirm_tb()">Sửa</button>
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
        function ktthangnam()
        {
            var a=(new Date()).getFullYear();
            var t=$('#thangnam').val();
            var thang=t.substr(0,2);
            var nam=t.substr(3,4);
            if(Number(nam)-Number(a)!=0)
                {
                    $('#nam_error').text('Năm nộp phải là năm hiện tại');
                    $('#them').prop('disabled',true);
                }
                else{$('#nam_error').text('');$('#them').prop('disabled',false);}
            if(Number(thang)==1 || Number(thang)==2 || Number(thang)==7 || Number(thang)==8 )
                {
                    $('#thang_error').text('');$('#them').prop('disabled',false);
                    
                }
                else{$('#thang_error').text('Tháng nộp phải là 1 2 7 8');
                    $('#them').prop('disabled',true);}
        }
        function confirm_tb(){
        return confirm("Bạn có chắc chắn thực hiện hành động này");
    }
    </script>
@endsection