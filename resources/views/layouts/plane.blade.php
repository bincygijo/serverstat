<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
	<meta charset="utf-8"/>
	<title>Server  API statistics test - Laravel 5, Bootstrap, jQuery</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<meta content="" name="description"/>
	<meta content="" name="author"/>

	<link rel="stylesheet" href="{{ asset("public/assets/stylesheets/styles.css") }}" />
</head>
<body>
	@yield('body')
	<script src="{{ asset("public/assets/js/jquery.js") }}" type="text/javascript"></script>
	<script src="{{ asset("public//assets/js/bootstrap.js") }}" type="text/javascript"></script>

	<script>
	/* Custom functions */
	// Variable to hold request
	var request;
	$(function() {
		$("#pull-server-list").on('click', function(){
			if(confirm("Do you want to download and reload server list?\nClick 'OK' to continue.")){
					$("#server_listing").html('<div class="alert alert-info" role="alert">Reloading server list...</div>');
					// Abort any pending request
				    if (request) {
				        request.abort();
				    }
				    

				    // Fire off the request to /form.php
				    request = $.ajax({
				        url: "{{URL::to('reload-servers')}}",
				        type: "get"
				    });

				    // Callback handler that will be called on success
				    request.done(function (response, textStatus, jqXHR){
				        // Log a message to the console
				        console.log("Servers reloaded");
				        $("#server_listing").html('<div class="alert alert-success" role="alert">Fetched remote list, generating list...</div>');
				        $("#server_listing").load('{{URL::to("load-ajax-list")}}');

				    });

				    // Callback handler that will be called on failure
				    request.fail(function (jqXHR, textStatus, errorThrown){
				        // Log the error to the console
				        console.error(
				            "The following error occurred: "+
				            textStatus, errorThrown
				        );
				    });
			}
		});
		
		/* change server */
		$("#button-stat-form-submit").on("click", function(){
			var $server_id =  $("#select_server_list").val();
			location.href = "{{URL::to('view-stat')}}/" + $server_id;
		})

		/* get stat*/
		$("#pull-stat-remote").on('click', function(){
			var $server_id  = $(this).data("value");
			$("#server_statistics_row").html('<div class="alert alert-info " role="alert">Fetching remote list...</div>');
					// Abort any pending request
				    if (request) {
				        request.abort();
				    }
				    // Fire off the request to /form.php
				    request = $.ajax({
				        url: "{{URL::to('fetch-stat')}}",
				        type: "post",
				        data: {'server_id':$server_id,'_token': "{{csrf_token()}}"}
				    });

				    // Callback handler that will be called on success
				    request.done(function (response, textStatus, jqXHR){
				        // Log a message to the console
				        console.log("Servers reloaded");
				        $("#server_statistics_row").html('<div class="alert alert-success" role="alert">Fetched remote list, generating stat...</div>');
				        //$("#server_statistics_row").load('{{URL::to("load-ajax-stat")}}/' + $server_id);
				        location.reload();

				    });

				    // Callback handler that will be called on failure
				    request.fail(function (jqXHR, textStatus, errorThrown){
				        // Log the error to the console
				        console.error(
				            "The following error occurred: "+
				            textStatus, errorThrown
				        );
				    });
		});
		
	});
	</script>
</body>
</html>