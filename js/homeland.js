/**
 * Created by Khang Nguyen(nguyennhukhangvn@gmail.com) on 8/1/2017.
 */

$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	loadSearchDistrictByCityId();
	submitSearchForm();
	subscribleHandler();
	$(".toggleBtn").click(function() {
		changeIconMoreLess($(this));
	});
	$("#myBtn").click(function(){
		topFunction();
	});
	bindingChangeCaptchaEvent();
	contactFormHandler();
	callMeBackHandler();
	bindingAdd2Cart();
	bindingLoadCart();

});

function bindingLoadCart(){
	$('#myHeaderCart').hover(function(){
		loadCart();
	});
}

function loadCart(){
	$.ajax({
		type: "POST",
		url: urls.base_url + '/ShoppingCart_controller/reloadMiniCart',
	}).done(function (data) {
		$("ul.mycart").html(data);
		bindingRemoveItemCart();
	});
}

function bindingRemoveItemCart(){
	$(".remove-cart-item").click(function(){
		var rowid = $(this).attr('rowid');
		if(rowid != undefined){
			$.ajax({
				type: "POST",
				url: urls.base_url + '/ShoppingCart_controller/removeItemToCart',
				data: {rowid: rowid }
			}).done(function (data) {
				// $('#image-container-' + container).remove();
				$("#myHeaderCart").html(data);
				loadCart();
			});
		}
	});
}

function bindingAdd2Cart() {
	$(".buyableBtn").click(function () {
		var options = [];
		$('.property-item input[type=radio]:checked').each(function (index, elm) {
			var parentAtt = $(elm).attr('parent');
			options.push({'key': parentAtt, 'attr': $(elm).val()})
		});
		var qty = $('#quantity').val();
		if(qty == null || qty == undefined || qty < 1){
			qty = 1;
		}
		if (qty > 0) {
			$(".overlay").show();
			$.ajax({
				type: "POST",
				url: urls.base_url + '/ShoppingCart_controller/addItemToCart',
				data: {productId: $(this).attr('productId'), qty: qty, options: options}
			}).done(function (data) {
				// $('#image-container-' + container).remove();
				//update cart
				$("#myHeaderCart").html(data);
				//alert('them thanh cong');
				$(".overlay").hide();
			});
		} else {
			alert('qty > 0');
		}
	});
}

function bindingChangeCaptchaEvent(){
	$("#changeCaptcha").click(function (){
		$("#captchaImg").html("<img src='/img/load.gif'/>");
		$.ajax({
			type: "POST",
			url: urls.loadCaptchaUrl,
			dataType: 'json',
			success: function(res){
				$("#captchaImg").html(res[0].capchaImg);
			},
			error: function(xhr, err){
				console.log(err);
			}
		});
	});
}

function changeIconMoreLess($this){
	if($this.data('status') == 'open'){
		$this.html('Ít hơn');
		$this.data('status','close');
		$this.removeClass('toggleMore').addClass('toggleLess');
	}else{
		$this.html('Xem thêm');
		$this.data('status','open');
		$this.removeClass('toggleLess').addClass('toggleMore');
	}
}

function subscribleHandler(){
	$("#btnSubscrible").click(function(e){
		var email = $("#sbEmail").val();
		if(email != null && isValidEmail(email)){
			// ga('send', {
			// 	hitType: 'event',
			// 	eventCategory: 'Subscrible',
			// 	eventAction: 'Subscrible email',
			// 	eventLabel: 'Subscrible'
			// });

			jQuery.ajax({
				type: "POST",
				url: urls.addSubscribleUrl,
				dataType: 'json',
				data: {email: email},
				success: function(res){
					if(res == 'success'){
						$("#subcribleMes").html("<span class='subscrible-success'>Đăng ký theo dõi thành công.</span>");
					}else{
						$("#subcribleMes").html("<span class='subscrible-danger'>Email này đã tồn tại.</span>");
					}
				}
			});
		}else{
			$("#subcribleMes").html("<span class='subscrible-danger'>Email không đúng định dạng.</span>");
		}
	});
}

function isValidEmail(email){
	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}

function loadSearchDistrictByCityId(){
	$("#cmCityId").change(function(){
		var cityId = $(this).val();
		jQuery.ajax({
			type: "POST",
			url: urls.loadDistrictByCityId,
			dataType: 'json',
			data: {cityId: cityId},
			success: function(res){
				document.getElementById("cmDistrictId").options.length = 1;
				for(key in res){
					$("#cmDistrictId").append("<option value='"+res[key].DistrictID+"'>"+res[key].DistrictName+"</option>");
				}
			}
		});
	});
}

function socialLogin(email, userID, fullName, callback){
	jQuery.ajax({
		type: "POST",
		url: urls.social_login_url,
		dataType: 'json',
		data: {username: email, password: userID, fullname: fullName},
		success: callback
	});
}

function submitSearchForm(){
	$("#btnSearch").click(function(){
		// ga('send', {
		// 	hitType: 'event',
		// 	eventCategory: 'Search',
		// 	eventAction: 'Tìm kiếm',
		// 	eventLabel: 'Tìm kiếm'
		// });
		$("form#search_form").submit();
	});
}

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
	if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
		$("#myBtn").show(1000);
	} else {
		$("#myBtn").hide(1000);
	}
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
	// ga('send', {
	// 	hitType: 'event',
	// 	eventCategory: 'Go to Top',
	// 	eventAction: 'Go to Top',
	// 	eventLabel: 'Go to Top'
	// });
	$('html,body').animate({ scrollTop: 0 }, 'slow');
}

function contactFormHandler(){
	$("#contactModalForm").click(function(){
		$.ajax({
			type:'POST',
			url: urls.base_url + 'ajax_controller/contactFormHandler',
			data: null,
			success:function(msg) {
				$("#modalFormDialog").html(msg);
				var $modal = $('#modalFormDialog');
				$modal.modal('show');
				bindingChangeCaptchaEvent();

			}
		});
	});
}

function callMeBackHandler(){
	$("#btnCallMe").click(function(){
		var postid = $(this).data('postid');
		$.ajax({
			type:'POST',
			url: urls.base_url + 'ajax_controller/submitCallMeBack',
			data: {'postid': postid},
			success:function(msg) {
				$("#modalFormDialog").html(msg);
				var $modal = $('#modalFormDialog');
				$modal.modal('show');
			}
		});
	});
}

function submitCallMeBackForm(){
	var dataString = $("#modalForm").serialize();
	$.ajax({
		type:'POST',
		url: urls.base_url + 'ajax_controller/submitCallMeBack',
		data: dataString,
		beforeSend: function () {
			$('.submitBtn').attr("disabled","disabled");
			$('.modal-body').css('opacity', '.5');
		},
		success:function(msg){
			$("#modalFormDialog").html(msg);
			$('.submitBtn').removeAttr("disabled");
			$('.modal-body').css('opacity', '');
		}
	});
}


function submitContactForm(){
		var dataString = $("#modalForm").serialize();
		$.ajax({
			type:'POST',
			url: urls.base_url + 'ajax_controller/contactFormHandler',
			data: dataString,
			beforeSend: function () {
				$('.submitBtn').attr("disabled","disabled");
				$('.modal-body').css('opacity', '.5');
			},
			success:function(msg){
				if(msg == "success"){
					$('#fullName').val('');
					$('#inputEmail').val('');
					$('#inputPhone').val('');
					$('#inputMessage').val('');
					$('#txtCaptcha').val('');
					$("#btnSendFeedBack").hide();
					$('.statusMsg').html('<span style="color:green;">Gửi thành công, chúng tôi sẻ phản hồi ngay khi có thể.</p>');
				}else{
					$('.statusMsg').html('<span style="color:red;">'+msg+'</span>');
				}
				$('.submitBtn').removeAttr("disabled");
				$('.modal-body').css('opacity', '');
			}
		});
}

function increaseValue(){
	var currentVal = parseInt($("#quantity").val());
	$("#quantity").val(currentVal + 1)
}

function decreaseValue(){
	var currentVal = parseInt($("#quantity").val());
	$("#quantity").val(currentVal < 2 ? 1 : currentVal - 1)
}

function cancelOrder(orderId){
	bootbox.confirm("Bạn có muốn hủy đơn hàng này không?", function(r) {
		if (r) {
			$("#crudaction").val('delete');
			$("#orderId").val(orderId);
			$("#frmOrder").submit();
		}
	});
}
