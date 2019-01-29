<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\GiangVien;
use App\GV_SV_LV;
use App\SinhVien;
use App\LuanVan;
use App\PhanLoai_LV;
use App\GV_SDT;
use App\User;
use App\Quyen;
use App\DiaLuanVan;

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/user', 'PageController@getIndex');

Route::get('gvtimkiem',['as'=>'giangvien.timkiem', 'uses'=> 'TimKiemController@getGVTimKiem']);
Route::get('timkiem',['as'=>'sinhvien.timkiem', 'uses'=> 'TimKiemController@getSVTimKiem']);

Route::post('doimatkhauadmin/{id}',[
	'as' => 'doimatkhauadmin',
	'uses' => 'UserController@doiMatKhauAdmin'
]);

Route::post('doimatkhaugiangvien/{id}',[
	'as' => 'doimatkhaugiangvien',
	'uses' => 'UserController@doiMatKhauGiangVien'
]);

Route::post('doimatkhausinhvien/{id}',[
	'as' => 'doimatkhausinhvien',
	'uses' => 'UserController@doiMatKhauSinhVien'
]);

Route::post('dangnhap',[
	'as' => 'dangnhap',
	'uses' => 'UserController@postDangnhapAdmin'
	]
);

Route::get('dangxuat',[
	'as' => 'dangxuat',
	'uses' => 'UserController@getDangXuatAdmin'
	]
);

Route::get('trangchu',
	[
		'as' => 'trangchu.get',
		'uses' => 'PageController@getIndex'
	]
);

Route::post('trangchu',
	[
		'as' => 'trangchu.post',
		'uses' => 'PageController@postIndex'
	]
);

Route::group(['prefix' => 'thongke'],function()
{
	Route::get('luanvan',
		[
			'as' => 'thongke.getluanvan',
			'uses' => 'ThongKeController@getLuanVan'
		]
	);
	Route::post('luanvan',
		[
			'as' => 'thongke.postluanvan',
			'uses' => 'ThongKeController@postLuanVan'
		]
	);
	Route::get('luanvan',
		[
			'as' => 'thongke.getallluanvan',
			'uses' => 'PageController@getallLuanVan'
		]
	);
	Route::post('luanvan',
		[
			'as' => 'thongke.postallluanvan',
			'uses' => 'PageController@postallLuanVan'
		]
	);
	Route::get('loailuanvan',
		[
			'as' => 'thongke.getloailuanvan',
			'uses' => 'ThongKeController@getLoaiLuanVan'
		]
	);
	Route::post('loailuanvan',
		[
			'as' => 'thongke.postloailuanvan',
			'uses' => 'ThongKeController@postLoaiLuanVan'
		]
	);
	Route::get('sinhvien',
		[
			'as' => 'thongke.getsinhvien',
			'uses' => 'ThongKeController@getSinhVien'
		]
	);
	Route::get('giangvien',
		[
			'as' => 'thongke.getgiangvien',
			'uses' => 'ThongKeController@getGiangVien'
		]
	);
	Route::post('giangvien',
		[
			'as' => 'thongke.postgiangvien',
			'uses' => 'ThongKeController@postGiangVien'
		]
	);
	Route::post('sinhvien',
		[
			'as' => 'thongke.postsinhvien',
			'uses' => 'ThongKeController@postSinhVien'
		]
	);
	Route::get('diem',
		[
			'as' => 'thongke.getdiem',
			'uses' => 'ThongKeController@getDiem'
		]
	);
	Route::post('diem',
		[
			'as' => 'thongke.postdiem',
			'uses' => 'ThongKeController@postDiem'
		]
	);
});
//,'middleware' => 'adminLogin'
Route::group(['prefix' => 'admin','middleware' => 'adminLogin'], function(){
	Route::group(['prefix' => 'sinhvien'], function(){
		Route::get('danhsach',
			[
				'as' => 'sinhvien.danhsach',
				'uses' => 'SinhVienController@getDanhSach'
			]
		);
		Route::get('them',
			[
				'as' => 'sinhvien.getthem',
				'uses' => 'SinhVienController@getThem'
			]
		);
		Route::post('them',
			[
				'as' => 'sinhvien.postthem',
				'uses' => 'SinhVienController@postThem'
			]
		);
		Route::get('sua/{id}',
			[
				'as' => 'sinhvien.getsua',
				'uses' => 'SinhVienController@getSua'
			]
		);
		Route::post('sua/{id}',
			[
				'as' => 'sinhvien.postsua',
				'uses' => 'SinhVienController@postSua'
			]
		);
		Route::get('xoa/{id}',
			[
				'as' => 'sinhvien.xoa',
				'uses' => 'SinhVienController@getXoa'
			]
		);
	});

	Route::group(['prefix' => 'giangvien'], function(){
		Route::get('danhsach',
			[
				'as' => 'giangvien.danhsach',
				'uses' => 'GiangVienController@getDanhSach'
			]
		);
		Route::get('them',
			[
				'as' => 'giangvien.getthem',
				'uses' => 'GiangVienController@getThem'
			]
		);
		Route::post('them',
			[
				'as' => 'giangvien.postthem',
				'uses' => 'GiangVienController@postThem'
			]
		);
		Route::get('sua/{id}',
			[
				'as' => 'giangvien.getsua',
				'uses' => 'GiangVienController@getSua'
			]
		);
		Route::post('sua/{id}',
			[
				'as' => 'giangvien.postsua',
				'uses' => 'GiangVienController@postSua'
			]
		);
		Route::get('xoa/{id}',
			[
				'as' => 'giangvien.xoa',
				'uses' => 'GiangVienController@getXoa'
			]
		);
	});

	Route::group(['prefix' => 'phanloailv'], function(){
		Route::get('danhsach',
			[
				'as' => 'phanloailv.danhsach',
				'uses' => 'PhanLoai_LVController@getDanhSach'
			]
		);
		Route::get('them',
			[
				'as' => 'phanloailv.getthem',
				'uses' => 'PhanLoai_LVController@getThem'
			]
		);
		Route::post('them',
			[
				'as' => 'phanloailv.postthem',
				'uses' => 'PhanLoai_LVController@postThem'
			]
		);
		Route::get('sua/{id}',
			[
				'as' => 'phanloailv.getsua',
				'uses' => 'PhanLoai_LVController@getSua'
			]
		);
		Route::post('sua/{id}',
			[
				'as' => 'phanloailv.postsua',
				'uses' => 'PhanLoai_LVController@postSua'
			]
		);
		Route::get('xoa/{id}',
			[
				'as' => 'phanloailv.xoa',
				'uses' => 'PhanLoai_LVController@getXoa'
			]
		);
	});

	Route::group(['prefix' => 'luanvan'], function(){
		Route::get('danhsach',
			[
				'as' => 'luanvan.danhsach',
				'uses' => 'LuanVanController@getDanhSach'
			]
		);
		Route::get('them',
			[
				'as' => 'luanvan.getthem',
				'uses' => 'LuanVanController@getThem'
			]
		);
		Route::post('them',
			[
				'as' => 'luanvan.postthem',
				'uses' => 'LuanVanController@postThem'
			]
		);
		Route::get('sua/{id}',
			[
				'as' => 'luanvan.getsua',
				'uses' => 'LuanVanController@getSua'
			]
		);
		Route::post('sua/{id}',
			[
				'as' => 'luanvan.postsua',
				'uses' => 'LuanVanController@postSua'
			]
		);
		Route::get('xoa/{id}',
			[
				'as' => 'luanvan.xoa',
				'uses' => 'LuanVanController@getXoa'
			]
		);
		
	});

	Route::group(['prefix' => 'dialuanvan'], function(){
		Route::get('danhsach',
			[
				'as' => 'dialuanvan.danhsach',
				'uses' => 'DiaLuanVanController@getDanhSach'
			]
		);
		Route::get('them',
			[
				'as' => 'dialuanvan.getthem',
				'uses' => 'DiaLuanVanController@getThem'
			]
		);
		Route::post('them',
			[
				'as' => 'dialuanvan.postthem',
				'uses' => 'DiaLuanVanController@postThem'
			]
		);
		Route::get('sua/{id}',
			[
				'as' => 'dialuanvan.getsua',
				'uses' => 'DiaLuanVanController@getSua'
			]
		);
		Route::post('sua/{id}',
			[
				'as' => 'dialuanvan.postsua',
				'uses' => 'DiaLuanVanController@postSua'
			]
		);
		Route::get('xoa/{id}',
			[
				'as' => 'dialuanvan.xoa',
				'uses' => 'DiaLuanVanController@getXoa'
			]
		);
	});

	Route::group(['prefix' => 'user'], function(){
		Route::get('danhsach',
			[
				'as' => 'user.danhsach',
				'uses' => 'UserController@getDanhSach'
			]
		);
		Route::get('them',
			[
				'as' => 'user.getthem',
				'uses' => 'UserController@getThem'
			]
		);
		Route::post('them',
			[
				'as' => 'user.postthem',
				'uses' => 'UserController@postThem'
			]
		);
		Route::get('sua/{id}',
			[
				'as' => 'user.getsua',
				'uses' => 'UserController@getSua'
			]
		);
		Route::post('sua/{id}',
			[
				'as' => 'user.postsua',
				'uses' => 'UserController@postSua'
			]
		);
		Route::get('xoa/{id}',
			[
				'as' => 'user.xoa',
				'uses' => 'UserController@getXoa'
			]
		);
	});

	Route::group(['prefix' => 'quyen'], function(){
		Route::get('danhsach',
			[
				'as' => 'quyen.danhsach',
				'uses' => 'QuyenController@getDanhSach'
			]
		);
		Route::get('them',
			[
				'as' => 'quyen.getthem',
				'uses' => 'QuyenController@getThem'
			]
		);
		Route::post('them',
			[
				'as' => 'quyen.postthem',
				'uses' => 'QuyenController@postThem'
			]
		);
		Route::get('sua/{id}',
			[
				'as' => 'quyen.getsua',
				'uses' => 'QuyenController@getSua'
			]
		);
		Route::post('sua/{id}',
			[
				'as' => 'quyen.postsua',
				'uses' => 'QuyenController@postSua'
			]
		);
		Route::get('xoa/{id}',
			[
				'as' => 'quyen.xoa',
				'uses' => 'QuyenController@getXoa'
			]
		);
	});

	Route::group(['prefix' => 'diem'], function(){
		Route::get('danhsach',
			[
				'as' => 'sv_bv_lv.danhsach',
				'uses' => 'SV_BV_LVController@getDanhSach'
			]
		);
		Route::get('them',
			[
				'as' => 'sv_bv_lv.getthem',
				'uses' => 'SV_BV_LVController@getThem'
			]
		);
		Route::post('them',
			[
				'as' => 'sv_bv_lv.postthem',
				'uses' => 'SV_BV_LVController@postThem'
			]
		);
		Route::get('sua/{id}/{idlv}',
			[
				'as' => 'sv_bv_lv.getsua',
				'uses' => 'SV_BV_LVController@getSua'
			]
		);
		Route::post('sua/{id}/{idlv}',
			[
				'as' => 'sv_bv_lv.postsua',
				'uses' => 'SV_BV_LVController@postSua'
			]
		);
		Route::get('xoa/{id}/{idlv}',
			[
				'as' => 'sv_bv_lv.xoa',
				'uses' => 'SV_BV_LVController@getXoa'
			]
		);
	});

	Route::group(['prefix' => 'ajax'], function(){
		Route::get('diem/{masv}/{malv}','AjaxController@getGiangVien');
		Route::get('luanvan/{masv}','AjaxController@getLuanVan');
		Route::get('huongdan/{malv}','AjaxController@getthangnop');
	});

	Route::group(['prefix' => 'huongdan'], function(){
		Route::get('danhsach',
			[
				'as' => 'gv_sv_lv.danhsach',
				'uses' => 'GV_SV_LVController@getDanhSach'
			]
		);
		Route::get('them',
			[
				'as' => 'gv_sv_lv.getthem',
				'uses' => 'GV_SV_LVController@getThem'
			]
		);
		Route::get('quaylai',
			[
				'as' => 'gv_sv_lv.getquaylai',
				'uses' => 'GV_SV_LVController@getquaylai'
			]
		);
		Route::get('themhd',
			[
				'as' => 'gv_sv_lv.getthemhd',
				'uses' => 'GV_SV_LVController@getThemhd'
			]
		);
		Route::get('xoathem/{id}/{idgv}/{idlv}',
			[
				'as' => 'gv_sv_lv.getxoathem',
				'uses' => 'GV_SV_LVController@getxoa1'
			]
		);
		Route::post('xoathem/{id}/{idgv}/{idlv}',
			[
				'as' => 'gv_sv_lv.postxoathem',
				'uses' => 'GV_SV_LVController@getxoa2'
			]
		);
		Route::post('xoathem/{id}/{idgv}/{idlv}',
			[
				'as' => 'gv_sv_lv.postxoathem1',
				'uses' => 'GV_SV_LVController@getxoa3'
			]
		);
		Route::post('them',
			[
				'as' => 'gv_sv_lv.postthem',
				'uses' => 'GV_SV_LVController@postThem'
			]
		);
		Route::get('sua/{id}/{idgv}/{idlv}',
			[
				'as' => 'gv_sv_lv.getsua',
				'uses' => 'GV_SV_LVController@getSua'
			]
		);
		Route::post('sua/{id}/{idgv}/{idlv}',
			[
				'as' => 'gv_sv_lv.postsua',
				'uses' => 'GV_SV_LVController@postSua1'
			]
		);
		Route::post('suaa/{id}/{idgv}/{idlv}',
			[
				'as' => 'gv_sv_lv.postsuaa',
				'uses' => 'GV_SV_LVController@postSua'
			]
		);
		Route::post('suatieptheo/{id}/{idgv}/{idlv}',
			[
				'as' => 'gv_sv_lv.postsuatiep',
				'uses' => 'GV_SV_LVController@postsuatiep'
			]
		);
		Route::get('themtiep',
			[
				'as' => 'gv_sv_lv.getnhaplai',
				'uses' => 'GV_SV_LVController@getnhaplai'
			]
		);
		Route::post('themtiep',
			[
				'as' => 'gv_sv_lv.postnhaplai',
				'uses' => 'GV_SV_LVController@postnhaplai'
			]
		);
		Route::post('suathem',
			[
				'as' => 'gv_sv_lv.postsuathemhd',
				'uses' => 'GV_SV_LVController@postsuaThemhd'
			]
		);
		Route::post ('xoatiep/{id}/{idgv}/{idlv}',
			[
				'as' => 'gv_sv_lv.xoatiep',
				'uses' => 'GV_SV_LVController@getXoatiep'
			]
		);
		Route::get('xoa/{id}/{idgv}/{idlv}',
			[
				'as' => 'gv_sv_lv.xoa',
				'uses' => 'GV_SV_LVController@getXoa'
			]
		);
	});

	Route::group(['prefix' => 'upload'], function(){
		Route::get('excel',
			[
				'as' => 'upload.getexcel',
				'uses' => 'ExcelController@getExcel'
			]
		);
		Route::post('excel',
			[
				'as' => 'upload.postexcel',
				'uses' => 'ExcelController@postExcel'
			]
		);
		Route::post('excelhuongdan',
			[
				'as' => 'upload.postexcelhuongdan',
				'uses' => 'ExcelController@postExcelHuongDan'
			]
		);
		Route::post('exceldia',
			[
				'as' => 'upload.postexceldia',
				'uses' => 'ExcelController@postExcelDia'
			]
		);

		Route::get('diemexcel',
			[
				'as' => 'upload.getdiemexcel',
				'uses' => 'ExcelController@getDiemExcel'
			]
		);
		Route::post('diemexcel',
			[
				'as' => 'upload.postdiemexcel',
				'uses' => 'ExcelController@postDiemExcel'
			]
		);
	});

	Route::group(['prefix' => 'export'], function(){
		Route::get('diem',
			[
				'as' => 'diem.getexportdiemexcel',
				'uses' => 'ExcelController@getExportDiemExcel'
			]
		);
		Route::post('diem',
			[
				'as' => 'diem.postexportdiemexcel',
				'uses' => 'ExcelController@postExportDiemExcel'
			]
		);
		Route::get('luanvan',
			[
				'as' => 'luanvan.getexportluanvanexcel',
				'uses' => 'ExcelController@getExportLuanVanExcel'
			]
		);
		Route::post('luanvan',
			[
				'as' => 'luanvan.postexportluanvanexcel',
				'uses' => 'ExcelController@postExportLuanVanExcel'
			]
		);

	});

	Route::group(['prefix' => 'thongke'], function(){
		Route::get('loailv',
			[
				'as' => 'thongke.getloailvall',
				'uses' => 'ThongKeController@getLoailvAll'
			]
		);
		Route::post('loailv',
			[
				'as' => 'thongke.postloailvall',
				'uses' => 'ThongKeController@postLoailvAll'
			]
		);

		Route::get('diemsv',
			[
				'as' => 'thongke.getdiemsvall',
				'uses' => 'ThongKeController@getDiemsvAll'
			]
		);
		Route::post('diemsv',
			[
				'as' => 'thongke.postdiemsvall',
				'uses' => 'ThongKeController@postDiemsvAll'
			]
		);

		Route::get('maubialv',
			[
				'as' => 'thongke.getmaubialvall',
				'uses' => 'ThongKeController@getMauBialvAll'
			]
		);
		Route::post('maubialv',
			[
				'as' => 'thongke.postmaubialvall',
				'uses' => 'ThongKeController@postMauBialvAll'
			]
		);
		
	});

});