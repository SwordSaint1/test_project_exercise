<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sample Website</title>
	<link rel="stylesheet" type="text/css" href="node_modules/css/bootstrap.css">
	   <!-- Sweet Alert -->
  	<link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
	<style>
   		.loader {
		  border: 16px solid #f3f3f3;
		  border-radius: 50%;
		  border-top: 16px solid #536A6D;
		  width: 50px;
		  height: 50px;
		  -webkit-animation: spin 2s linear infinite;
		  animation: spin 2s linear infinite;
		}

		@keyframes spin {
		  0% { transform: rotate(0deg); }
		  100% { transform: rotate(1080deg); }
		} 
  </style>
</head>
<body>
<div class="container-fluid">
	<!-- VIEW -->
	<div class="row">
		<div class="col-12">
			<h2 style="text-align: center;">Test Project Exercise</h2>
		</div>
		<div class="col-12">
				<div class="float-left">
					<a href="#" class="btn btn-info" onclick="save_data()">Save Data from API</a>
				</div>
				<div class="float-right">
					<a href="#" class="btn btn-info" onclick="fetch_data()">Search Data</a>
				</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-12">
			<table class="table">
				<thead style="text-align: center;">
					<th>#</th>
					<th>Iata Code</th>
					<th>Name</th>
					<th>Icao Name</th>
				</thead>
				<tbody id="records" style="text-align: center;"></tbody>
			</table>
		<div class="row">
                  <div class="col-6"></div>
                  <div class="col-6">   
                    <div class="spinner" id="spinner" style="display:none;">
                      <div class="loader float-sm-center"></div>    
                    </div>
                  </div>
                </div>
		</div>
	</div>
</div>

<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
<script type="text/javascript">
$(function(){
// fetch_data();
});

//CONTROLLER
const save_data =()=>{
	
	fetch("https://iata-and-icao-codes.p.rapidapi.com/airlines?api_key=e19036bdddmshec8b9d620c9b4b6p1dfc44jsn5e42aada67de", {
		  "method": "GET",
		  "headers": {
		    "X-RapidAPI-Key": "e19036bdddmshec8b9d620c9b4b6p1dfc44jsn5e42aada67de",
		    "X-RapidAPI-Host": "iata-and-icao-codes.p.rapidapi.com",
		    "RapidAPI-Project": "5cf1da516aca1a303720e78e"
		  }
		})
		.then(response => response.json())
		.then(data => {
		  // console.log(data);
		  // handle response data here
		  // console.log(data[0].iata_code);
		  // console.log(data.length);
		  for(x = 0; x <= data.length -1 ; x++){
		  	var iata_code = data[x].iata_code;
		  	var name = data[x].name;
		  	var icao_code = data[x].icao_code;
		  	$.ajax({
	        url: 'process/processor.php',
	        type: 'POST',
	        cache: false,
	        data:{
	            method: 'save_data',
	            iata_code:iata_code,
				name:name,
				icao_code:icao_code
	        },success:function(response) {
	           if (response == 'success') {
				    Swal.fire({
			            icon: 'success',
			            title: 'Successfully Recorded !!!',
			            text: 'Successfully',
			            showConfirmButton: false,
			            timer : 1000
			        });
			       
	           }else{
	           		Swal.fire({
			            icon: 'error',
			            title: 'Error !!!',
			            text: 'Error',
			            showConfirmButton: false,
			            timer : 1000
			        });
			      
	           }
	        }
    		});


		  }
		})
		.catch(err => {
		  console.log(err);
		});
}

const fetch_data =()=>{
		$('#spinner').css('display','block');
		$.ajax({
	        url: 'process/processor.php',
	        type: 'POST',
	        cache: false,
	        data:{
	            method: 'fetch_records',
	        },success:function(response) {
	           	document.getElementById('records').innerHTML = response;
	        	$('#spinner').fadeOut();
	        }
    		});
}

</script>
</body>
</html>