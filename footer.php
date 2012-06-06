		<footer>
			Pase Usted es una Asociación Civil independiente y sin fines de lucro.  Diseño: Salón 
		</footer>
	</div>

	<script src="<?php bloginfo('template_url');?>/js/jquery-1.7.min.js"></script>
	<script src="<?php bloginfo('template_url');?>/js/slides.min.jquery.js"></script>
	<script src="<?php bloginfo('template_url');?>/js/jquery.bxSlider.js"></script>

	<!--  slider  -->
		<script>
			$(function(){
				var startSlide = 1;
				if (window.location.hash) {	startSlide = window.location.hash.replace('#',''); }
				$('#slides').slides({
					preload: false,
					generatePagination: false,
					play: 5000,
					pause: 2500,
					hoverPause: false,
					start: startSlide,
				});
			});
		</script>
	<!--  end slider -->

	<!-- carrucel -->
		<script type="text/javascript">
			$(function(){
			  $('#carrucel').bxSlider({
			    displaySlideQty: 6,
			    moveSlideQty: 1
			  });
			});
		</script>
	<!-- fin carrucel -->
		<script type="text/javascript">
			/* funcion destacar categorias en hover */
				$(".categorias p, .categorias a, .categorias div").hover(
					function(){
						var categoria_id = $(this).parent().attr("id");
						$("#" + categoria_id).children(".icon").addClass("black_icon");
					}, 
					function(){
						var categoria_id = $(this).parent().attr("id");
						$("#" + categoria_id).children(".icon").removeClass("black_icon");
					}
				);
				
			/* funcion menu fijo durante el scroll */
				$(window).scroll(function(){
					scroll_top = $(this).scrollTop();
					if(scroll_top >= 43){
						$("nav").removeClass("normal_nav");
						$("nav").addClass("scroll_nav");
					}else{
						$("nav").removeClass("scroll_nav");
						$("nav").addClass("normal_nav");
					}
				})

				function validar_email(valor){
			        var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
			        if(filter.test(valor)) return true;
			        else return false;
			    }
			    
			    $(".subscribir").submit(function(e) {
			    	e.preventDefault();
			    	var email = $("#in-email").val();

			        if(email == '') alert("Campo vacio"); 
			        else if( !validar_email(email) ) alert("e-mail no valido");
					else{
			    		var url =  "http://paseusted2012.salonendesarrollo.com/pu/email_unico-2" ;
				        $.post( url, {email:email}, function(data) {
							if (data == "true") 
			    				message = "Gracias por subscribirte";
			    			else 
			    				message = "Este correo ya esta subscrito";
			    			
			    			alert(data);
					    });
					}
			    });
		</script>
</body>
</html>