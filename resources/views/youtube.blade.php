<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	
	<title>Laravel</title>

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Raleway:100,600"
		rel="stylesheet" type="text/css">
	
	<!-- Styles -->
	<style>
	html, body {
		background-color: #fff;
		color: #636b6f;
		font-family: 'Raleway', sans-serif;
		font-weight: 100;
		height: 100vh;
		margin: 0;
	}
	
	.full-height {
		height: 100vh;
	}
	
	.flex-center {
		align-items: center;
		display: flex;
		justify-content: center;
	}
	
	.position-ref {
		position: relative;
	}
	
	.top-right {
		position: absolute;
		right: 10px;
		top: 18px;
	}
	
	.content {
		text-align: center;
	}
	
	.title {
		font-size: 84px;
	}
	
	.links>a {
		color: #636b6f;
		padding: 0 25px;
		font-size: 12px;
		font-weight: 600;
		letter-spacing: .1rem;
		text-decoration: none;
		text-transform: uppercase;
	}
	
	.m-b-md {
		margin-bottom: 30px;
	}
	</style>

    
	<!-- Responsavel pelo JQuery -->
	<script>
		window.jQuery || document.write('<script type="text/javascript" src="//www.andy666.com.br/js/jquery.min.js">\x3C/script>');
	</script>
        
    
    <script type="text/javascript">
    $(document).ready(function() {

		// Execute a function when the user releases a key on the keyboard
		$( "#TextSearch" ).keyup(function() {
		
		    // Number 13 is the "Enter" key on the keyboard
		    if (event.keyCode === 13) {
				
			    // change mouse cursor
		    	$("body").css("cursor", "wait");  
		    	
				
		        var postForm = { //Fetch form data
	        		_token			: "{{ csrf_token() }}",
	                'TextSearch'	: $( "#TextSearch" ).val() //Store name fields value
	            };
	            
		        $.ajax({
		            url     : './search',
		            method  : 'post',
		            data    : postForm,
		            headers:
		            {
		                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		            },
		            success : function($response){
						
					    // change mouse cursor
		            	$("body").css("cursor", "auto"); 
						
					    // Make the logo visible
				    	$("#divYouTube").removeClass('flex-center');
		            	
			            $response = JSON.parse( $response );
			            
						console.log( $response );
						
			            //alert( response );
			            
			            if($response['error'] == ''){
				            $('#divReturn').show();

				            $('#divReturn').html( '' );
							
				            $.each($response['video'], function($index, $value) {
					            
								console.log( $value );
								
					            $('#divReturn').html( $('#divReturn').html() + '<br><br><b>' + $value['title'] + '</b><br>https://www.youtube.com/watch?v=' + $value['videoId'] );
					            
						    });
				            
			            } else {
				            alert( $response['error'] );
			            }
			            
		            },
		            error: function (xhr, ajaxOptions, thrownError) {
		            	$("body").css("cursor", "auto"); 
		            	
		                alert(xhr.status);
		                alert(thrownError);
	              	}
		        });
		
		    }
		
		});
    });
	</script>
    
</head>

<body>
	<div id="divYouTube" class="flex-center position-ref full-height">

		<div class="content">
			<div class="title m-b-md">
				YouTube
			</div>
				
			<div class="links">
				<input type="text" id="TextSearch">
			</div>
			
			<div class="links" id="divReturn" style="display: none;">
				return
			</div>	

		</div>
	</div>
</body>

</html>
