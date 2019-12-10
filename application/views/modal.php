<!DOCTYPE html>  
 <html>  
      <head>  
           <title>Webslesson Tutorial | Make Login Form by Using Bootstrap Modal with PHP Ajax Jquery</title>  
		   <script src="<?php echo base_url() ?>aset/jquery.js"></script>
		   <script src="<?php echo base_url() ?>aset/js/bootstrap.min.js"></script>
			<link rel="stylesheet" href="<?php echo base_url() ?>aset/modal_login/css/reset.css"> <!-- CSS reset -->
			<link href	="<?php echo base_url()?>aset/css/bootstrap.min.css" rel="stylesheet">
			
			
      </head>  
      <body>  
       
                <div align="center">  
                     <button type="button" name="login" id="login" class="btn btn-success" data-toggle="modal" data-target="#loginModal">Login</button>  
                </div>  

           </div>  
           <br />  
      </body>  
 </html>  
 <div id="loginModal" class="modal fade" role="dialog">  
      <div class="modal-dialog">  
   <!-- Modal content-->  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Login</h4>  
                </div>  
                <div class="modal-body">  
                     <label>Username</label>  
                     <input type="text" name="username" id="username" class="form-control" />  
                     <br />  
                     <label>Password</label>  
                     <input type="password" name="password" id="password" class="form-control" />  
                     <br />  
                     <button type="button" name="login_button" id="login_button" class="btn btn-warning">Login</button>  
                </div>  
           </div>  
      </div>  
 </div>  
 <script>  
 $(document).ready(function(){  
 var url_admin = "<?php echo base_url('admin/crud') ?>";
      $('#login_button').click(function(){  
           var username = $('#username').val();  
           var password = $('#password').val();  
           if(username != '' && password != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url('auth/cek_login')?>",  
                     method:"POST",  
                     data: {username:username, password:password},  
                     success:function(data)  
                     {  
                         if(data == 'OK'){
							<?php 
							
							
							
							?>
						 }
                 
                     }  
                });  
           }  
           else  
           {  
                alert("Both Fields are required");  
           }  
      });  
      
      });   
 </script>  