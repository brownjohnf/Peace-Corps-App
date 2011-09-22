<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" itemscope itemtype="http://schema.org/Organization">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta property="og:title" content="<?=$page_title?>"/>
    <meta property="og:site_name" content="Peace Corps Senegal"/>
    <meta property="fb:admins" content="172400188"/>
	<meta property="og:type" content="government" />
	<meta property="og:url" content="<?php echo current_url(); ?>" />
	<meta property="og:image" content="<?php echo base_url(); ?>img/pc_logo.png" />

	<!-- For google plusone button -->
	<meta itemprop="name" content="Title of your content">
	<meta itemprop="description" content="This would be a description of the content your users are sharing">
		
	<title><?=$page_title?></title>
	
	<!--[if IE]>
	<link rel="stylesheet" type="text/css" href="css/all-ie-only.css" />
	<![endif]-->
	
	<?php foreach ($stylesheets as $css): ?>
	<link href="<?php echo base_url().'css/'.$css; ?>" rel="stylesheet" type="text/css" />
	<?php endforeach; ?>
	
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
	
	<?php foreach ($scripts as $js): ?>
	<script type="text/javascript" src="<?php echo base_url().'js/'.$js; ?>"></script>
	<?php endforeach; ?>
		
	<link href="<?php echo base_url(); ?>img/favicon.ico" type="image/x-icon" rel="icon"/>
	<link href="<?php echo base_url(); ?>img/favicon.ico" type="image/x-icon" rel="shortcut icon"/>
</head>