/**
 * Created by Khang Nguyen on 10/9/2017.
 * nguyennhukhangvn@gmail.com
 */

$(document).ready(function(){
	activeLeftMenu();
	$('[data-toggle="tooltip"]').tooltip();
	//Date picker
	$('.datepicker').datepicker({
		format: 'dd/mm/yyyy',
		autoclose: true
	});
	$("input[name='checkAll']").change(function(){
		if($(this).is(':checked')){
			$("input[name='checkList[]']").prop( "checked", true );
		} else {
			$("input[name='checkList[]']").prop( "checked", false );
		}

	});
});

function activeLeftMenu(){
	// 1. Định nghĩa URL của trang Dashboard chính (Thay đổi phù hợp với dự án của bạn)
	var dashboardUrl = window.location.origin + '/dashboard.html';
	var currentUrl = window.location.href;
	// 2. Xử lý logic Active khi Tải Trang (Page Load)
	if (currentUrl === dashboardUrl || currentUrl === window.location.origin + '/') {
		// Nếu quay lại Dashboard -> Xóa bộ nhớ tạm để tránh lệch trạng thái
		localStorage.removeItem('activeMenuHref');

		// Active trực tiếp menu Dashboard (Giả định thẻ a của Dashboard có href trùng url)
		$('ul.sidebar-menu > li > a[href="' + dashboardUrl + '"]').parent('li').addClass('active');
	} else {
		// Nếu ở các trang khác -> Kiểm tra bộ nhớ tạm
		var savedHref = localStorage.getItem('activeMenuHref');

		if (savedHref) {
			// Nếu có bộ nhớ tạm -> Active menu cha đã lưu trước đó
			$('ul.sidebar-menu > li > a[href="' + savedHref + '"]').parent('li').addClass('active');
		} else {
			// Dự phòng: Nếu mất bộ nhớ tạm, chạy lại tính năng quét URL trùng khớp cũ
			$('ul.menu > li > a').each(function() {
				if (this.href === currentUrl) {
					$(this).parent('li').addClass('active');
					localStorage.setItem('activeMenuHref', this.href); // Lưu lại luôn
				}
			});
		}
	}

	// 3. Xử lý logic khi Người Dùng Click vào Menu Chính
	$('ul.sidebar-menu > li > a').click(function() {
		// Lưu thuộc tính href của menu chính vừa click vào localStorage
		var menuHref = $(this).attr('href');
		localStorage.setItem('activeMenuHref', menuHref);
	});
}

var getNamedParameter = function (key) {
	if (key == undefined) return false;

	var url = window.location.href;
	//console.log(url);
	var path_arr = url.split('?');
	if (path_arr.length === 1) {
		return null;
	}
	path_arr = path_arr[1].split('&');
	path_arr = remove_value(path_arr, "");
	var value = undefined;
	for (var i = 0; i < path_arr.length; i++) {
		var keyValue = path_arr[i].split('=');
		if (keyValue[0] == key) {
			value = keyValue[1];
			break;
		}
	}

	return value;
};


var remove_value = function (value, remove) {
	if (value.indexOf(remove) > -1) {
		value.splice(value.indexOf(remove), 1);
		remove_value(value, remove);
	}
	return value;
};


var admin_paging = function(baseUrl){
	var sendRequest = function(){
		var searchKey = $('#searchKey').val()||"";
		window.location.href = baseUrl + '?query='+searchKey+ '&orderField='+curOrderField+'&orderDirection='+curOrderDirection;
	}

	var curOrderField, curOrderDirection;
	$('[data-action="sort"]').on('click', function(e){
		curOrderField = $(this).data('title');
		curOrderDirection = $(this).data('direction');
		sendRequest();
	});


	$('#searchKey').val(decodeURIComponent(getNamedParameter('query')||""));

	var curOrderField = getNamedParameter('orderField')||"";
	var curOrderDirection = getNamedParameter('orderDirection')||"";
	var currentSort = $('[data-action="sort"][data-title="'+getNamedParameter('orderField')+'"]');
	if(curOrderDirection=="ASC"){
		currentSort.attr('data-direction', "DESC").find('i.glyphicon').removeClass('glyphicon-triangle-bottom').addClass('glyphicon-triangle-top active');
	}else{
		currentSort.attr('data-direction', "ASC").find('i.glyphicon').removeClass('glyphicon-triangle-top').addClass('glyphicon-triangle-bottom active');
	}
}
