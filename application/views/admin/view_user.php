
<div class="container">
    	
        
<h2 id="_default"><i class="icon-accessibility on-left"></i>View user</h2>

<div class="grid fluid">   
	<div class="row"> 
			<?php echo $this->table->generate();   
            ?>
            </div>
</div>
  
 </div>

  


<script>

$( document ).ready(function() {	
	 oTable = $('#dataTables-1').dataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": '<?php echo base_url('admin/datatable'); ?>',
                
                "sPaginationType": "full_numbers",
           
         
        "fnInitComplete": function() {
                //oTable.fnAdjustColumnSizing();
         },
                'fnServerData': function(sSource, aoData, fnCallback)
            {
              $.ajax
              ({
                'dataType': 'json',
                'type'    : 'POST',
                'url'     : sSource,
                'data'    : aoData,
                'success' : fnCallback
              });
            }
	} );
				   
 				
		



					
$(document).on('click','.editInfo', function(){
	var $bla = $(this).parents('td').prev();
	
	var lname = $bla.prev();
	var fname = lname.prev();
	var email = fname.prev();
	
	var id = $(this).siblings('input').val()
    $.Dialog({
        overlay: true,
        shadow: true,
        flat: true,
	     	draggable: true,
        icon: '<img src="<?php echo base_url('assets/images/Windows-8-Logo.png')?>">',
        title: 'Flat window',
        content: '',
		    width: 500,
        padding: 10,
        onShow: function(_dialog){
            var content = '<form action="<?php echo base_url('admin/editUserInfo'); ?>" method="POST" id="editform">' +
                '<label>id</label>' +
                '<div class="input-control text"><input type="text" name="id" value="'+id+'" readOnly="true">'+
               ' <button class="btn-clear"></button></div> ' +
			     '<label>Email</label>' +
                '<div class="input-control text"><input type="email"  value= "'+email.text()+'"name="email" readOnly="true">'+
               ' <button class="btn-clear"></button></div> ' +
			     '<label>First Name</label>' +
                '<div class="input-control text"><input type="text" value = "'+fname.text()+'" name="fname"  required>'+
               ' <button class="btn-clear"></button></div> ' +
			      '<label>Last Name</label>' +
                '<div class="input-control text"><input type="text" name="lname" value = "'+lname.text()+'"  required>'+
               ' <button class="btn-clear"></button></div> ' +
			   
			  
                '<div class="form-actions">' +
                '<button class="button primary" onclick = "return confirm("are you sure?")">EDIT</button> '+
                '<button class="button" type="button" onclick="$.Dialog.close()">Cancel</button> '+
                '</div>'+
                '</form>';
 
            $.Dialog.title("User login");
            $.Dialog.content(content);
            $.Metro.initInputs();
        }
    });
   
	
     $('#editform').validate({
        rules: {
          fname: {
            minlength: 2,
            required: true,
            lettersonly: true
          },
          lname: {
             minlength: 2,
             required: true,
             lettersonly: true
          }
        },
            highlight: function(element) {
                $(element).closest('.input-control').removeClass('success-state').addClass('error-state');
            },
            success: function(element) {
                element
                    .closest('.input-control').removeClass('error-state').addClass('success-state');
            }
      });

});					
		
		
	
					

$(document).on('click','.deleteUser', function(){
	var id = $(this).siblings('input').val()
    $.Dialog({
        overlay: true,
        shadow: true,
        flat: true,
		    draggable: true,
        icon: '<img src="images/excel2013icon.png">',
        title: 'Delete User',
		    width: 300,
        content: '',
        padding: 10,
        onShow: function(_dialog){
            var content = '<div>Are you sure you want to delete user? </div></br>' +
						  '<div class="grid fluid">'+
   						  '<div class="row">'+
                		  '<div class="span8 offset2"> <button class="btn-close" onclick="$.Dialog.close()"><i class="icon-folder-2 on-left"></i>Cancel</button> '+
    					  '<button class="confirmDelete" value="'+id+'" onclick="$.Dialog.close();confirmDeleteFunc(this.value); "><i class="icon-floppy on-left"></i>Save</button>'+
        				  '</div>'+
   						  '</div>'+
						'</div> ';
						
 
            $.Dialog.title("Delete User ");
            $.Dialog.content(content);
            $.Metro.initInputs();
        }
    });
	

});	

$(document).on('submit','#editform', function(e){
    var postData = $(this).serializeArray();
	var formURL = $(this).attr("action");
	var r = confirm('are you sure?');
	
	if( r == true){
     $.ajax({
        url : formURL,
        type: "POST",
        data : postData,
        success:function(msg) 
        {
          if(msg == "success"){
			var not = $.Notify({
				 	style: {background: 'green', color: 'white'},
    				caption: "Update",
       				content: "Update of User is successful!!!",
      			  	timeout: 10000 // 10 seconds
			});
			 oTable.fnDraw();
		  }else if(msg == "error"){
			 	var not = $.Notify({
				 	style: {background: 'red', color: 'white'},
    				caption: "Update",
       				content: "Update of User has Failed!!!",
      			  	timeout: 10000 // 10 seconds
			});
		  } 
		   
		  
        }
	 
    });
	}else{}

  	
    e.preventDefault(); //STOP default action
    e.unbind(); //unbind. to stop multiple form submit.
});


			
});//ready end
					
function  confirmDeleteFunc(id){
$.ajax({
		type: "POST",
		url: "<?php echo base_url('admin/deleteUser/')?>/"+id,
			
	}).done(function(msg){
		if(msg=="success"){
			 var not = $.Notify({
				 	style: {background: 'green', color: 'white'},
    				caption: "Delete",
       				content: "Deletion of User is successful!!!",
      			  	timeout: 10000 // 10 seconds
   			 });
		 oTable.fnDraw();
		}
				//alert(msg);
	});

}

					

</script>
