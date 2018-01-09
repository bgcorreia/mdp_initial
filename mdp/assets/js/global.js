$('body').on('submit', '#form', function(e){
	e.preventDefault();
	var formData = new FormData($(this)[0]);
	$.ajax({
		url : "./upload.php",
		type: "POST",
		processData: false,
		contentType: false,
		data: formData,
		success: function(data){
			if (data.error) {
				console.info(data.error);
			} else if (data.classes) {
				$("#param").html("");
				$.each(data.classes, function() {
					$("#param").append("<option>"+this+"</option>");
				});
			}
		}
	});
});
$('input[type=file]').change(function(){
	var a = $(this),
		b = a.val(),
		c = b.substr(b.lastIndexOf('\\') + 1);
	a.next().next().html(c);
	$('#form').submit();
});
var page = {
	href: function(){
		$('a[href]:not([target])').click(function(e){
			e.preventDefault();
			a = $(this).attr('href');
			page.url(a);
			return false;
		});
	},
	url: function(link, prop){
		if(link == 'reload'){
			link = window.location.pathname;
		}
		$.ajax({
			type: 'GET',
			url: link,
			beforeSend: function(){
				if(prop == 'p'){
					$(document).scrollTop('0');
				}
			},
			success: function(data){
				if($(document).scrollTop() > 0){
					$(document).scrollTop('0');
				}
				if($(data).filter('#main')){
					var html = $(data).filter('#main').html();
					$('#main').html(html);
					page.href();
				} else {
					$(document).html(data);
				}
				if(!prop){
					history.pushState({state: 'new'}, '', link);
				}
			}
		});
	}
}
$(window).on('popstate', function(){
	page.url(window.location.href, 'p');
});
$(function(){
	page.href();
});
