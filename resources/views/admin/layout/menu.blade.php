<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            {{-- <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                <!-- /input-group -->
            </li> --}}
            {{-- <li>
                <a href="#"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li> --}}
            <li>
                <a href="{{ route('giangvien.danhsach') }}"><i class="fa fa-briefcase fa-lg"></i> Giảng Viên<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('giangvien.danhsach') }}">Danh sách giảng viên</a>
                    </li>
                    <li>
                        <a href="{{ route('giangvien.getthem') }}">Thêm giảng viên</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="{{route('sinhvien.danhsach')}}"><i class="fa fas fa-graduation-cap fa-lg"></i>Sinh Viên<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{route('sinhvien.danhsach')}}">Danh sách sinh viên</a>
                    </li>
                    <li>
                        <a href="{{route('sinhvien.getthem')}}">Thêm sinh viên</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="{{ route('luanvan.danhsach') }}"><i class="fa fa-book fa-lg"></i> Luận Văn<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('luanvan.danhsach') }}">Danh sách luận văn</a>
                    </li>
                    <li>
                        <a href="{{ route('luanvan.getthem') }}">Thêm luận văn</a>
                    </li>
                    
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="{{ route('dialuanvan.danhsach') }}"><i class="fa fas fa-link fa-lg"></i> Đĩa luận văn<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('dialuanvan.danhsach') }}">Danh sách đĩa luận văn</a>
                    </li>
                    <li>
                        <a href="{{ route('dialuanvan.getthem') }}">Thêm đĩa luận văn</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="{{ route('phanloailv.danhsach') }}"><i class="fa fas fa-certificate fa-lg"></i> Loại luận văn<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('phanloailv.danhsach') }}">Danh sách loại luận văn</a>
                    </li>
                    <li>
                        <a href="{{ route('phanloailv.getthem') }}">Thêm loại luận văn</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="{{ route('gv_sv_lv.danhsach') }}"><i class="fa far fa-calendar fa-lg"></i> Hướng dẫn<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('gv_sv_lv.danhsach') }}">Danh sách hướng dẫn</a>
                    </li>
                    <li>
                        <a href="{{ route('gv_sv_lv.getthem') }}">Nhập phần trăm hướng dẫn</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="{{route('sv_bv_lv.danhsach')}}"><i class="fa fas fa-clipboard fa-lg"></i> Điểm luận văn<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{route('sv_bv_lv.danhsach')}}">Danh sách điểm</a>
                    </li>
                    <li>
                        <a href="{{route('sv_bv_lv.getthem')}}">Nhập điểm</a>
                    </li>
                    <li>
                        <a href="{{route('upload.getdiemexcel')}}">Upload điểm excel</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            
            {{-- <li>
                <a href="#"><i class="fa fa-users fa-lg"></i> User<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{route('user.danhsach')}}">Danh sách User</a>
                    </li>
                    <li>
                        <a href="{{route('user.getthem')}}">Thêm User</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li> --}}
            <li>
                <a href="{{route('quyen.danhsach')}}"><i class="fa far fa-star fa-lg"></i> Quyền<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{route('quyen.danhsach')}}">Danh sách quyền</a>
                    </li>
                    <li>
                        <a href="{{route('quyen.getthem')}}">Thêm quyền</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="{{route('diem.getexportdiemexcel')}}"><i class="fa fas fa-download fa-lg"></i> Download file <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{route('diem.getexportdiemexcel')}}">File điểm</a>
                    </li>
                    <li>
                        <a href="upload\mauexcel.xlsx">Mẫu file excel</a>
                    </li>
                    <!-- <li>
                        <a href="{{ route('luanvan.getexportluanvanexcel') }}">File luận văn</a>
                    </li> -->
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="{{route('upload.getexcel')}}"><i class="fa fa-upload fa-lg"></i> Upload file <span class="fa arrow"></span></a>
                <!-- /.nav-second-level -->
            </li>
            
            <li>
                <a href="{{route('thongke.getloailvall')}}"><i class="fa fas fa-signal fa-lg"></i> Thống Kê<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{route('thongke.getloailvall')}}">Loại luận văn</a>
                    </li>
                    <li>
                        <a href="{{route('thongke.getdiemsvall')}}">Điểm sinh viên</a>
                    </li>
                    <li>
                        <a href="{{route('thongke.getmaubialvall')}}">Màu luận văn</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>