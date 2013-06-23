<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html debug="true">
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <script src="./template/skin/js/jquery.js"></script>
  <script src="./template/skin/js/bootstrap.js"></script>
  <link href="./template/skin/css/bootstrap.css" rel="stylesheet">

  <style>
      body {
        padding-top: 10px; /* 60px to make the container go all the way to the bottom of the topbar */
      }

<!--	.sidebar-nav-fixed {
	     position:fixed;
	     top:60px;
	     width:290;
	 }	

	 @media (max-width: 767px) {
	     .sidebar-nav-fixed {
	         width:auto;
	     }
	 }

	 @media (max-width: 979px) {
	     .sidebar-nav-fixed {
	         position:static;
	        width: auto;
	     }
	 } -->
  </style>

  <title>{$sitetitle} - {$pagetitle}</title>
  </head>
  <body>

  <div class="container">


{include file='menu.tpl'}
