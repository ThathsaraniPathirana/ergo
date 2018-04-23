@extends('layout')
  @section('content')
<!DOCTYPE html>
<html lang="en">
  <div class="content-wrapper" style="background-image: url(background1.jpg);">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/ssindex">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">My Profile</li>
      </ol>
      <div class="row">
        <div class="col-12"> 
          <h1>My Profile</h1>
          <p>Quick view of your profile</p>
          <hr>
          <div class="container">

            <div class="row">
              <div class="card" style="width: 25rem; text-align: ">
			  	<img class="card-img-top" src="{{ $Cdata -> profile_pic}}" alt="Card image cap">
			  	<div class="card-body">
			    	<h5 class="card-title">{{ $Cdata -> name }}</h5>
			    	<p class="card-text">{{ $Cdata -> email }}</p>
			  	</div>
			  	<ul class="list-group list-group-flush">
			    	<li class="list-group-item">
              <?php
    			    	$company= $Cdata->company ;
                echo $Cdata->role;
                echo " at ";
    			    	echo $company->name ;
    			    ?>  
            </li>
            <li class="list-group-item">
              <?php
              if($Cdata->status){
                echo "Currenly assigned";
              }else{
                echo "Currenly available";
              }
              ?>
            </li>
              <?php 
                $projects= $Cdata->projects;
                foreach($projects as $project )
                {
                  echo "<li class=\"list-group-item\">";
                  echo "currently work on";
                  echo $project->name;
                  echo "</li>";
                }
              ?>
			    	<li class="list-group-item">Vestibulum at eros</li>
			 	 </ul>
			  <div class="card-body">
			    <a href="#" class="card-link">Card link</a>
			    <a href="#" class="card-link">Another link</a>
			  </div>
			</div>
           </div>
         </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
   

</html>
  
@endsection