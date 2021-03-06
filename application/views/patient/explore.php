<?php echo link_tag('assets/css/l&g.css');echo link_tag('assets/css/dimmer.min.css');?>
<script src="<?php echo base_url('assets/js/dimmer.min.js')?>"></script>
<style type="text/css">
#alphabetical  .active a{
	 font-weight: bold;
	}
</style>
<?php echo $notif; ?>
<div class="container">
    <div class="grid fluid">
        <div class="row">	
            <div class="span3">
            </br></br>
                <nav class="sidebar light">
                    <ul>
                    	<li class="stick bg-red"><a href="<?php echo base_url('patient/doctors') ?>"><i class="icon-cog"></i>Doctors</a></li>
                   		<li class="stick bg-yellow"><a href="<?php echo base_url('patient/clinics') ?>"><i class="icon-cog"></i>Clinic</a></li>
                    </ul>
                </nav>
            </div><!-- end of span3 -->
            <div class="span9">
                <div class="lg"> 
                    <header>                 
                    	<h1>Doctors</h1>   
                        <strong>
					<ul style="list-style:none;" id="alphabetical" class="inline">
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/A'); ?>">A</a></li>
                        <li class=""><a  href="<?php echo base_url('patient/doctors/sort_by/B'); ?>">B</a></li>
                        <li><a href="<?php echo base_url('patient/doctors/sort_by/C'); ?>">C</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/D'); ?>">D</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/E'); ?>">E</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/F'); ?>">F</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/G'); ?>">G</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/H'); ?>">H</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/I'); ?>">I</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/J'); ?>">J</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/K'); ?>">K</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/L'); ?>">L</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/M'); ?>">M</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/N'); ?>">N</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/O'); ?>">O</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/P'); ?>">P</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/Q'); ?>">Q</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/R'); ?>">R</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/S'); ?>">S</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/T'); ?>">T</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/U'); ?>">U</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/V'); ?>">V</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/W'); ?>">W</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/X'); ?>">X</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/Y'); ?>">Y</a></li>
                        <li><a  href="<?php echo base_url('patient/doctors/sort_by/Z'); ?>">Z</a></li>
					</ul>
            		</strong>    
                    </header>
                    <ul id="products" class="grid clearfix">          
        

                    <?php if($results){ foreach($results as $data) { 	?>                    
                        <li class="clearfix dims">
                            <div class="ui dimmer">
                                <div class="content">
                                    <div class="center">
                                    	<div class="viewProfile ui primary button">View Profile</div>
                                    	<input  type="hidden" id="id" value="<?php echo $data->id; ?>"/>
                                        <input  type="hidden" id="fname" value="<?php echo $data->fname; ?>"/>
                                        <input  type="hidden" id="lname" value="<?php echo $data->lname;?>"/>
                                        <input  type="hidden" id="avatar" value="<?php echo $data->avatar; ?>"/>
                                        <input  type="hidden" id="specialization" value="<?php echo $data->specialist; ?>"/>
                                        <input  type="hidden" id="contact_num" value="<?php echo $data->contact_num; ?>"/>                        
                                        <input  type="hidden" id="room_num" value="<?php echo $data->room_num; ?>"/>                        
                                    </div>
                                </div>
                            </div>                      
                            <section class="left">
                            	<div class="thumb"> <?php echo img($data->avatar);?> </div>
                            	<h3> <?php echo  $data->fname ?></h3>                      
                            </section>
                            <section class="right">
                            	<span class="price"><?php echo $data->specialist ?> </span> 
                            </section>
                        </li>                    
                    <?php }}else{ echo "No Doctor(s) here";} ?>              
                    </ul>
                    <footer>   
                    	<br />                 
                    	<div class="pagination small">
                   		<?php echo $links; ?>
                   		</div>
                    </footer>
                </div> 
            </div><!-- end of span9 -->
        </div>
    </div><!-- end of grid -->
	<div id="modal_cont"></div>  
    
 
</div> <!-- end of container -->
<script type="text/javascript">
$( document ).ready(function() {	



			   
	$('.dims')
		.dimmer({
			on: 'hover',
			duration    : {
			show : 0,
			hide : 10
		}
	});	//  end of .dims		
	
	$(document).on('click','.viewProfile', function(){
		var $bla = $(this).parents('td').prev();	
		var lname = $(this).siblings('#lname').val();
		var fname = $(this).siblings('#fname').val();
		var id = $(this).siblings('#id').val();
		var specialization = $(this).siblings('#specialization').val();
		var Cnum = $(this).siblings('#contact_num').val();
		var Rnum = $(this).siblings('#room_num').val();
		var avatar = $(this).siblings('#avatar').val();
		var currentdate = new Date(); 
var date = currentdate.getFullYear() + "-" 
                + (currentdate.getMonth()+1) + "-"
				+ currentdate.getDate();
	
                
		var id = $(this).siblings('#id').val();	
		var cont= 		'<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'+
						'<div class="modal-dialog">'+
							'<div class="modal-content">'+
								'<div class="modal-header">'+
									'<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+
									'<h4 class="modal-title" id="myModalLabel">Doctor </h4>'+
								'</div>'+
								'<div class="modal-body">'+
									'<div class="thumb" style="margin: 0 auto;"><img  class="scale" src = "<?php echo base_url()?>'+avatar+'" ></div><br/>'+
										'<dl class="horizontal" style="margin: 0 auto;">'+
											'<dt class="text-info">Name:</dt>'+
												'<dd class="readable-text">'+ lname+'  '+fname+'</dd>'+
											'<dt class="text-info">Specialization:</dt>'+
												'<dd class="readable-text">'+specialization+'</dd>'+
											'<dt class="text-info">Contact num:</dt>'+
												'<dd class="readable-text">'+Cnum+'</dd>'+
											'<dt class="text-info">Room num:</dt>'+
												'<dd class="readable-text">'+Rnum+'</dd>'+
										'</dl>'+			
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>' +
						'</div>';

		$( "#modal_cont" ).html(cont);

		$('#myModal').modal('show');	
		 $("#datepicker").datepicker();

	});	//end of viewProfile
	
	$(document).on('click','.makeAppointment', function(){
	  $(".appointmentForm").show();
	});

	$(document).on('click','.closemdl', function(){
	  $(".appointmentForm").hide();
	});
	
	<?php if($this->uri->segment(3) == "sort_by"){ ?>
		var ul = document.getElementById("alphabetical");
		var items = ul.getElementsByTagName("li");
		for (var i = 0; i < items.length; ++i) {
		  // do something with items[i], which is a <li> element
		     if( $(items[i]).children('a').html() == '<?php echo $this->uri->segment(4) ?>')
			 		$(items[i]).addClass('active');
		}

   					//echo  $this->uri->segment(4);

		
	<?php	} ?>
				
   

});//ready end
</script>
     
