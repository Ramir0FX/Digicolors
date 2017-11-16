$(document).ready(function(){
	//inicio
	$('#content').load('paginas/index.html');
	
	//clicks en el menu
	$('ul#nav li a').click(function() {
		var page = $(this).attr('href');
		$('#content').load('paginas/' + page + '.html');
		return false;
	});
});