@extends('layout.master')
@section('content')
@include('layout.navbar')
    <div class="col col-sm-6" style=" margin: 5px 0px 0px 350px; padding: 10px 0px;">
        <p style="margin-left: 70px; font-weight: bold; color: #0F197E;">Xem Sinh Viên Thực Hiện Luận Văn</p>
        <form enctype="multipart/form-data" action="{{ route('thongke.postsinhvien') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group col-sm-2" style="margin: 0px 0px 0px 120px">
                    <label>Khóa</label>
                        <select class="form-control" name = "khoa">
                            <option value="">----</option>
                            @foreach($arr as $khoa)
                            <option
                             value="{{ $khoa }}">{{$khoa}}</option>
                            @endforeach
                        </select>
                    </div>
                <div class="form-group col-sm-2 col-sm-offset-1"  style="margin: 25px 0px 0px 10px">
                <button type="submit" class="btn btn-info">Xem</button>
                </div>
        </form>
    </div>
    @if(session('data'))
    <?php $data = session('data'); ?>
    @if(!count($data))
        <div class="col-sm-12">
            <p style="color:red;font-size: 20px; text-align: center;">Không tìm thấy kết quả</p>
        </div>
        @else
            @if(isset($data))
                <table class="table table-striped table-bordered table-hover">
                <thead style="background: #1A91EA; color: white;">
                    <tr align="center">
                        <td>STT</td>
                        <td>MSSV</td>
                        <td>Họ tên sinh viên</td>
                        <td>Tên luận văn</td>
                        <td>Loại luận văn</td>
                        <td>Tháng năm nộp</td>
                        <td>Chi tiết</td>
                        <td>GVHD</td>
                        @if( (Session::has('login3') && Session::get('login3')==true) )
                            <td>Tải về</td>
                        @endif
                        @if( (Session::has('login2') && Session::get('login2')==true) )
                            <td colspan="3">Tải về</td>
                        @endif
                    </tr>
                </thead>
                <?php $i=1; ?>
                @foreach($data as $lv)
                    <tr align="center" id="timkiem">
                        <td>{{$i}}</td>
                        <td>{{$lv-> masv}}</td>
                        <td align="left">{{$lv-> hotensv}}</td>
                        <td align="left">{{$lv-> tenlv}}</td>
                        <td>{{$lv-> tenloailv}}</td>
                        <td>{{date('m-Y', strtotime($lv -> thangnam))}}</td>
                        <td><a href="" data-toggle="modal" data-target="#{{$lv-> malv}}">Xem chi tiết</a></td>
                        <td align="left">{{$lv-> hotengv}}</td>
                        {{-- Pop-up --}}
                        <div class="modal fade" id="{{$lv-> malv}}" role="dialog">
                            <div class="modal-dialog modal-md">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Chi tiết: {{ $lv -> tenlv }}</h4>
                                </div>
                                <div class="modal-body">
                                  <ul>
                                        <li><span style="font-weight: bold;">Mã luận văn:</span> {{$lv-> malv}}</li>
                                        <li><span style="font-weight: bold;">Màu bìa:</span> {{ $lv -> maubia }}</li>
                                        <li><span style="font-weight: bold;">Nội dung tóm tắt:</span> {{ $lv -> noidungtomtat }}</li>
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                        </div>
                        @if( (Session::has('login3') && Session::get('login3')==true) )
                            <td><a href="url/pdf/{{$lv-> filepdf}}">PDF</a></td>
                        @endif
                        @if( (Session::has('login2') && Session::get('login2')==true) )
                            <td><a href="url/pdf/{{$lv-> filepdf}}">PDF</a></td>
                            <td><a href="url/doc/{{$lv-> fileword}}">WORD</a></td>
                            <td><a href="url/src/{{$lv-> filesrc}}">SOURCE</a></td>
                        @endif
                    </tr>
                <?php $i++; ?>
                @endforeach
            </table>
            @endif
        @endif
	@endif
@endsection