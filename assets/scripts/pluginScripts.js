// Set array to count modal product quantity
var countQty = [];
var countQty2 = [];
var countItemQty = [];
$(".content").niceScroll();
$(".modal-body").niceScroll();

/** Get File Location **/
function pluginURL(){
	var plugin_url = pluginScript.pluginsUrl;
	return plugin_url;
}

function returnStampsValue(totalItemQty){
	var fixedItemWeight = 0.5;
    var totalItemWeight = totalItemQty * fixedItemWeight;

    var from_firstname = $("input[name=from_firstname]").val();
	var from_lastName = $("input[name=from_lastName]").val();	
	var from_address = $("input[name=from_address]").val();	
	var from_city = $("input[name=from_city]").val();
	var from_state = $("input[name=from_state]").val();
	var from_postcode = $("input[name=from_postcode]").val();
	var from_phone_number = $("input[name=from_phone_number]").val();
	var from_email = $("input[name=from_email]").val();

	var data = {
		from_firstname : from_firstname,
		from_lastName : from_lastName,
		from_address : from_address,
		from_city : from_city,
		from_state : from_state,
		from_postcode : from_postcode,
		from_phone_number : from_phone_number,
		from_email : from_email,
		totalItemQty : totalItemQty,
		totalItemWeight : totalItemWeight
	};

	$.ajax({
		url: pluginURL() + 'templates/submit/stampsSubmit.template.php',
	    method: 'POST',	    
	    data: data,
	    dataType:"JSON",
	    success: function(response) {
	       	$('input[name=ServiceType]').val(response.PackageType);
	       	$('input[name=ServiceDescription]').val(response.ServiceDescription);
	       	$(".serviceType").html(response.ServiceDescription + "/" + response.PackageType);

	       	var maxAmount = parseFloat(response.MaxAmount);
	       	$('input[name=returnedRate]').val(response.MaxAmount);
	       	$(".returnedRate").html("$" + maxAmount.toFixed(2));

	       	$('input[name=totalItemQty]').val(totalItemQty);

			$('input[name=totalItemWeight]').val(response.WeightOz);
			$(".totalItemWeight").html(totalItemQty + " Items * " + "0.5oz/stick = " + response.WeightOz + "oz");

			$('input[name=DeliverDays]').val(response.DeliverDays);
			$(".DeliverDays").html(response.DeliverDays);

			$('input[name=ShipDate]').val(response.ShipDate);
			$(".ShipDate").html(response.ShipDate);
	    },
	     error: function(xhr, status, error){	     	
	         var errorMessage = xhr.status + ': ' + xhr.statusText
	         alert('Error - ' + errorMessage);
	     }
	});

}

$(function() {	
    /** Start Front End Form Submission **/
	    // Hide Loader
		$("#loader").hide();
		// Submit Front End Form
	    $('#form-recycle').on('submit', function(event) { 
	        event.preventDefault();
	        $("#loader").show();
	        var data = $( "#form-recycle" ).serialize();
	        jQuery.ajax({
	        	dataType: "json",
	        	type : "POST",
	        	data : data,
	        	url : pluginURL() + "templates/submit/pageSubmit.template.php",
	        	success: success,
	        	error: printError
	        });

	    });

	    // Success Message
	    var success = function( resp ){
	    	alert("Form is Submitted Successfully");
	    };
	    // Error Message > This is the function being called whenever the form submission is succesful
	    var printError = function( req, status, err ) {
	    	$("#loader").hide();
	    	$.confirm({
			    title: 'Bidi Recycle Submitted Succeffully!',
			    content: 'Thank You For Using Bidi Recycle!\nPlease wait for further Information regarding the Recycle Request',
			    buttons: {
			        Ok: function () {
			            location.reload();
			        }
			    }
			});
		};
    /** End Front End Form Submission **/

    /** Start Admin End Form Submission **/    	
    	$('#adminSubmitButton').prop('disabled', true);
    	// Hide Loader
		$("#adminLoader").hide();
		$("#transaction_status").change(function(){
	        var selectedCountry = $(this).children("option:selected").val();
	        
	        if(selectedCountry = 'wc-recycled'){
	        	// Submit Front End Form
	        	$('#adminSubmitButton').prop('disabled', false);
			    $('#form-admin-recycle').on('submit', function(event) { 
			        event.preventDefault();
			        $("#adminLoader").show();
			        var data = $( "#form-admin-recycle" ).serialize();
			        jQuery.ajax({
			        	dataType: "json",
			        	type : "POST",
			        	data : data,
			        	url : pluginURL() + "templates/submit/adminSubmit.template.php",
			        	success: successAdmin,
			        	error: printErrorAdmin
			        });

			    });
			    // Success Message
			    var successAdmin = function( resp ){
			    	alert("Form is Submitted Successfully");
			    };
			    // Error Message > This is the function being called whenever the form submission is succesful
			    var printErrorAdmin = function( req, status, err ) {
			    	$("#adminLoader").hide();
			    	$.confirm({
					    title: 'Item Recycled Successfully!',
					    content: 'You have changed the current status of this recycled item.\nThank You!',
					    buttons: {
					        Ok: function () {
					            location.reload();
					        }
					    }
					});
				};
	        }

	    });
    /** Start Admin End Form Submission **/

    /** Start Admin Searching **/
		var searchValue = $('#recycle-search-input').val();	
		if( !searchValue ){
			var txt = $(this).val();
			$('result').html('');
			$.ajax({
				url : pluginURL() + "templates/submit/search.template.php",
				method: "POST",
				data: {data: txt},
				dataType: "html",
				success: function(data){
					$('#the-recycle-list').html(data);
				}
			});

		}

		$('#recycle-search-input').keyup(function(){
			$('#the-list2').hide();
			var txt = $(this).val();
			$.ajax({
				url : pluginURL() + "templates/submit/search.template.php",
				method: "POST",
				data: {data: txt},
				dataType: "html",
				success: function(data){
					$('#the-recycle-list').html(data);
				}
			});		
		});

	/** End Admin Searching **/

	/** Start Pagination **/
		
		$('#previousRecyclePagination').click(function(event) {
			var buttonVal = $(this).attr("value");
			var span = $('.pagination #currentPage #CurrentPageNumber').text();
			
			if(buttonVal != span){
				
				var currentPage = parseInt(span) - 1;
				$.ajax({
					url : pluginURL() + "templates/submit/pagination.template.php",
					method: "POST",
					data: {data: currentPage},
					dataType: "html",
					success: function(data){
						$('#the-recycle-list').html(data);
						$(".pagination #currentPage #CurrentPageNumber").text(currentPage);
					}
				});
			}else{
				
				event.preventDefault()
			}
			
		});

		$('#nextRecyclePagination').click(function(event) {
			var buttonVal = $(this).attr("value");
			var span = $('.pagination #currentPage #CurrentPageNumber').text();

			if(span <= buttonVal){
				var currentPage = parseInt(span) + 1;
				$.ajax({
					url : pluginURL() + "templates/submit/pagination.template.php",
					method: "POST",
					data: {data: currentPage},
					dataType: "html",
					success: function(data){
						$('#the-recycle-list').html(data);
						$(".pagination #currentPage #CurrentPageNumber").text(currentPage);
						$(this).val(currentPage);
					}
				});
				
			}else if(span == buttonVal){
				var currentPage = parseInt(span) + 1;
				$.ajax({
					url : pluginURL() + "templates/submit/pagination.template.php",
					method: "POST",
					data: {data: currentPage},
					dataType: "html",
					success: function(data){
						$('#the-recycle-list').html(data);
						$(".pagination #currentPage #CurrentPageNumber").text(currentPage);
						$(this).val(currentPage);
					}
				});
				
			}else if(span >= buttonVal){
				
				event.preventDefault()
			}
			
		});
	/** End Pagination **/

	/** Start Date Sorting **/
		// By Date
		$('.dateSorting').click(function(event) { 
		    event.preventDefault();
		    var txt = $(this).data("id");
		    $.ajax({
		        url : pluginURL() + "templates/submit/sorting.template.php",
				method: "POST",
				data: {dateSorting: txt},
				dataType: "html",
				success: function(data){
					$('#the-recycle-list').html(data);
				}
		    });
		    return false; // for good measure
		});

		// By Status		
		$('.statusSorting').click(function(event) { 
		    event.preventDefault();
		    var txt = $(this).data("id");
		    alert(txt);
		    $.ajax({
		        url : pluginURL() + "templates/submit/sorting.template.php",
				method: "POST",
				data: {statusSorting: txt},
				dataType: "html",
				success: function(data){
					$('#the-recycle-list').html(data);
				}
		    });
		    return false; // for good measure
		});
	/** End Sorting **/
});