$(document).on('click', '.delete-class', function(e){
  var id = $(this).attr('data-id');
  $.confirm({
    title: 'Delete Class',
    content: 'Are you really want to delete the class permanently and remove all students in it ?',
    icon: 'fa fa-trash',
    theme: 'supervan',
    closeIcon: true,
    animation: 'scale',
    type: 'orange',
    buttons: {
      Delete: function () {
        $.ajax({
          type: "POST",
          url: base_url+'classes/delete',
          data:{id:id},
          dataType:'json',
          success: function(data)
          {
            if(data.status){
              location.reload();
            }
          }
        });
      },
      Cancel: function () {}
    }
  });
});

function update(id) {
	var name = $("#class_name"+id).val();
	$.ajax({
		type: "POST",
		url: base_url+'classes/update',
		data:{id:id,name:name},
		dataType:'json',
		success: function(res)
		{
			if(res.status){
				location.reload();
			}
		}
	});
}


$(document).on('click', '.delete-connected-class', function(e){
  var id = $(this).attr('data-id');
  var index = $(this).attr('data-index');
  $.confirm({
    title: 'Delete Connected Class',
    content: 'Do you really want to remove the partner class?',
    icon: 'fa fa-trash',
    theme: 'supervan',
    closeIcon: true,
    animation: 'scale',
    type: 'orange',
    buttons: {
      Delete: function () {
        $.ajax({
          type: "POST",
          url: base_url+'classes/delete_connected_class',
          data:{id:id,index:index},
          dataType:'json',
          success: function(data)
          {
            if(data.status){
              location.reload();
            }
          }
        });
      },
      Cancel: function () {}
    }
  });
});


function delete_shortcut(id,index) {

  $.ajax({
    type: "POST",
    url: base_url+'classes/delete_shortcuts',
    data:{id:id,index:index},
    dataType:'json',
    success: function(data)
    {
      if(data.status){
        location.reload();
      }
    }
  });
}