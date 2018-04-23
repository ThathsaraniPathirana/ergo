<!DOCTYPE html>
<html lang="en">

@extends('layout')
  @section('content')
    <div class="content-wrapper" style="background-image: url(background1.jpg);">
      <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">My Dashboard</li>
        </ol>
        <h1 class="display-4">Welcome 
          <?php
    $value=session('Cdata');
    $user=$value->user;
    echo $user->name;
    //echo $user-> email;  
    ?>
        </h1>
  @endsection
</html>
