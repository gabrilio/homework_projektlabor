<?php 
  include('../functions.php');
  
  

	if (!isAdmin()) {
		$_SESSION['msg'] = "You must log in first";
		header('location: ../login.php');
	}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Admin_Home</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
  <link rel="stylesheet" href="../homework.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
	
	
		
	
</head>
<body>
	
	<div class="content">
		<!-- notification message -->
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
				<br>
			</div><br>
		<?php endif ?>

		<!-- logged in user information -->
		<div class="profile_info">
			<img src="../images/admin_profile.png"  >

			<div>
				<?php  if (isset($_SESSION['user'])) : ?>
					<h2><strong><?php echo $_SESSION['user']['username']; ?></strong></h2>
				<div class="no-print">
					<small>
						<i  style="color: #888 ;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
						<br><br>
						<a href="home.php?logout='1'" class="btn btn btn-danger">Kijelentkezés</a>
						&nbsp; <a href="create_user.php" class="btn btn-warning bt-xs"> + Felhasználók hozzáadása</a>
					</small>
					<br><br>

				<?php endif ?>
			</div>
			<br></div>
		</div>



	</div>
	<script src="../homework.js"></script>
<div class="container">
	<div class="no-print" > 
    Alapművelet típusa: <select id=typeOfEquations>
      <option value=1>Összeadás</option>
      <option value=2>Kivonás</option>
      <option value=3>Szorzás</option>
      <option value=4>Osztás</option>
      <option value=5 selected>Vegyes feladatok</option>
    </select><br/>
    Számjegyek száma:<select id=numberOfDigits>
      <option value=1>1 számjegy</option>
      <option value=2 >2 számjegy</option>
     <option value=3 selected>3 számjegy</option>
      <option value=4>4 számjegy</option>
      <option value=5>5 számjegy</option>
      <option value=6>6 számjegy</option> 
    </select><br/>  
   Feladatok száma: <select id=numberOfEquations>
      <option value=5>5 feladat</option>
      <option value=10 selected>10 feladat</option>
      <option value=15>15 feladat</option>
      <option value=20>20 feladat</option>
      </select></br><br><br>
    
    <input type="button" class="btn btn btn-success "value="Feladatlap létrehozása" onclick="JavaScript: generateEquations();">
    <input type="button" class="btn btn-warning bt-xs " value="Feladatlap nyomtatása" onclick="JavaScrit:window.print();">
    
   
    
		</div>
    <div id=title></div>
    <div id=worksheet>
 
    </div> 
</div>
    <div class="no-print"> 
   
 
 
 
 
  <br /><br />  
  <div class="container" style="width:900px;">  
   <h3 align="center">Házi feladat feltöltése</h3>  
   <br />
   <div align="right">
    <button type="button" name="add" id="add" class="btn btn-success">Feltöltés</button>
   </div>
   <br />
   <div id="image_data">

   </div>
  </div>  
 


<div id="imageModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Kép hozzáadása</h4>
   </div>
   <div class="modal-body">
    <form id="image_form" method="post" enctype="multipart/form-data">
     <p><label>Kép kiválasztása</label>
     <input type="file" name="image" id="image" /></p><br />
     <input type="hidden" name="action" id="action" value="insert" />
     <input type="hidden" name="image_id" id="image_id" />
     <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-info" />
      
    </form>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Bezár</button>
   </div>
  </div>
 </div>
</div>
 </div>
<script>  
$(document).ready(function(){
 
 fetch_data();

 function fetch_data()
 {
  var action = "fetch";
  $.ajax({
   url:"../action.php",
   method:"POST",
   data:{action:action},
   success:function(data)
   {
    $('#image_data').html(data);
   }
  })
 }
 $('#add').click(function(){
  $('#imageModal').modal('show');
  $('#image_form')[0].reset();
  $('.modal-title').text("Kép hozzáadása");
  $('#image_id').val('');
  $('#action').val('insert');
  $('#insert').val("Feltöltés");
 });
 $('#image_form').submit(function(event){
  event.preventDefault();
  var image_name = $('#image').val();
  if(image_name == '')
  {
   alert("Válassz képet!");
   return false;
  }
  else
  {
   var extension = $('#image').val().split('.').pop().toLowerCase();
   if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
   {
    alert("Érvénytelen formátum");
    $('#image').val('');
    return false;
   }
   else
   {
    $.ajax({
     url:"../action.php",
     method:"POST",
     data:new FormData(this),
     contentType:false,
     processData:false,
     success:function(data)
     {
      alert(data);
      fetch_data();
      $('#image_form')[0].reset();
      $('#imageModal').modal('hide');
     }
    });
   }
  }
 });
 $(document).on('click', '.update', function(){
  $('#image_id').val($(this).attr("id"));
  $('#action').val("update");
  $('.modal-title').text("Kép csere");
  $('#insert').val("Csere");
  $('#imageModal').modal("show");
 });
 $(document).on('click', '.delete', function(){
  var image_id = $(this).attr("id");
  var action = "delete";
  if(confirm("Biztos hogy törölni szeretnéd?"))
  {
   $.ajax({
    url:"../action.php",
    method:"POST",
    data:{image_id:image_id, action:action},
    success:function(data)
    {
     alert(data);
     fetch_data();
    }
   })
  }
  else
  {
   return false;
  }
 });
});  
</script>	
</body>
</html>
