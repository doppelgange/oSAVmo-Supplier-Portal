$(function () {
  $('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover({
		trigger: 'hover',
		container: 'body',
        placement : 'auto'
	});
  
  $('a.submit').click(function(){
  	$(this).parents('form').submit();
  });
})