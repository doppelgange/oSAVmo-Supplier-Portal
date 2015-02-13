$(function () {
  $('[data-toggle="tooltip"]').tooltip({
		container: 'body'
  });
	$('[data-toggle="popover"]').popover({
		trigger: 'hover',
		container: 'body',
        placement : 'auto'
	});
  
  $('a.submit').click(function(){
  	$(this).parents('form').submit();
  });

//Edit Sales Document Page, Fulfill Item
  $('.btn-partial-fulfill').click(function(){
    //Set fulfill item id
    var itemID = $(this).data("itemid");
    $("input[name='itemID']").val(itemID);

    //Set fulfill item amount default value
    var itemOutstandingAmount = $(this).data("itemoutstandingamount");
    $("input[name='fulfillAmount']").val(itemOutstandingAmount);

    //Set the dorpdown list of panel
    var optionString='<option selected value="'+itemOutstandingAmount+'">'+itemOutstandingAmount+'</option>';
    for(var i=itemOutstandingAmount-1; i >0; i--){
      optionString+='<option value="'+i+'">'+i+'</option> ';
    }
    $('#fulfillOptionAmount').data("itemid",$(this).data("itemid"));
    $('#fulfillOptionAmount').html(optionString);

    //Show modal
    $('#fulfillOption').modal();
  })

  $('#fulfillOptionAmount').change(function () {
    $("input[name='fulfillAmount']").val($(this).val());
  });

//Fully Fulfill Action
  $('.btn-fully-fulfill-action').click(function(){
    var itemID = $(this).data("itemid");
    $("input[name='itemID']").val(itemID);

    var itemOutstandingAmount = $(this).data("itemoutstandingamount");
    $("input[name='fulfillAmount']").val(itemOutstandingAmount);
    $(this).parents('form').submit();
  });
//Partila Fulfill Action
  $('.btn-partial-fulfill-action').click(function(){
    $(this).parents('form').submit();
    $('#fulfillOption').modal('hide');
  });

//fully fulfill all items
  $('.btn-fully-fulfill-all-action').click(function(){
    $("input[name='itemID']").val('*');
    $(this).parents('form').submit();
  });




})