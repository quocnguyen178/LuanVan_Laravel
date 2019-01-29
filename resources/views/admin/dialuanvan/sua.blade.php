@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Đĩa Luận Văn
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
                <form action="{{route('dialuanvan.postsua',$dialuanvan-> madia)}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group">
                        <label>Mã đĩa luận văn</label>
                        <input class="form-control" name="madia" readonly="" value="{{$dialuanvan-> madia}}" placeholder="Nhập mã loại luận văn" />
                    </div>
                    <div class="form-group">
                        <label>Luận văn</label>
                        <select class="form-control" name = "malv" id="loailv">
                            @foreach($luanvan as $lv)
                            <option
                                @if($lv-> malv == $dialuanvan-> malv)
                                    {{"selected"}}
                                @endif
                             value="{{ $lv -> malv }}">{{$lv-> malv}} - {{$lv-> tenlv}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>URL WORD</label>
                        <input type="file" class="form-control" name="fileword"   />{{$dialuanvan-> fileword}}
                    </div>
                    <div class="form-group">
                        <label>URL PDF</label>
                        <input type="file" class="form-control" name="filepdf" />{{$dialuanvan-> filepdf}}
                    </div>
                    <div class="form-group">
                        <label>URL SOURCE</label>
                        <input type="file" class="form-control" name="filesrc"  />{{$dialuanvan-> filesrc}}
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
        function confirm_tb(){
        return confirm("Bạn có chắc chắn thực hiện hành động này");
    }
    </script>
@endsection