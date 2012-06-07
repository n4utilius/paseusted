			
				function validar_email(valor){
			        var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
			        if(filter.test(valor)) return true;
			        else return false;
			    }
			    
			    $(".subscribir").submit(function(e) {
			    	e.preventDefault();
			    	var email = $("#in-email").val();

			        if(email == '') 
			        	alert("Campo vacio"); 
			        else if( !validar_email(email) ) 
			        	alert("e-mail no valido");
					else{
						$.ajax({  
						  	type: 'POST',  
						  	url: 'http://paseusted2012.salonendesarrollo.com/pu/wp-admin/admin-ajax.php',  
						  	data: {  
						  		action: 'insert_email',  
						  		email: email,
						  	},  
						  	success: function(data, textStatus, XMLHttpRequest){  
							  	if (data == "true") 
						    		message = "Gracias por subscribirte";
						    	else 
						    		message = "Este correo ya esta subscrito";	
					    		var div_menssage = "<div id='r-email'>" + message + "</div>"
					    		$('form.subscribir').append(div_menssage);
						  	} 
				  		}); 
					/*	
			    		var url =  "http://paseusted2012.salonendesarrollo.com/pu/wp-admin/admin-ajax.php" ;
				        $.post( url, {email:email}, function(data) {
							if (data == "true") 
			    				message = "Gracias por subscribirte";
			    			else 
			    				message = "Este correo ya esta subscrito";
			    			
			    			alert(data);
					    });
					*/
					}
			    });