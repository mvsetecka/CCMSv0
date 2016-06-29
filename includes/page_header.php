<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">

<head>
	<base href="<?php echo $this->get_settings('web_url')."/";?>" />
    <meta http-equiv="content-type" content="text/html; charset=windows-1250" />
    <meta http-equiv="content-language" content="cs" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="keywords" content="<?php echo $this->get_settings('meta_keywords') ?>" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="<?php echo $this->get_settings('meta_description') ?>" />
    <meta name="author" content="<?php echo $this->get_settings('meta_author') ?>" />
    <link rel="stylesheet" href="<?php echo $this->root."/CSS/".$this->get_settings('stylesheet_dir')."/stylesheet.css";?>" media="screen" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->root."/includes/lightboxplus/lightbox.css";?>" type="text/css" media="screen" />

    <link rel="shortcut icon" href='<?php echo $this->root."/".$this->get_settings('favicon') ?>' type="image/x-icon" />
    <link rel="icon" href='<?php echo $this->root."/".$this->get_settings('favicon') ?>' type="image/x-icon" />
    
    <title><?php echo $this->page_title; ?></title>
    
	<!--
<script src="<?php echo $this->root?>/includes/lightbox/prototype.js" type="text/javascript"></script>
	<script src="<?php echo $this->root?>/includes/lightbox/scriptaculous.js?load=effects,builder" type="text/javascript"></script>
	<script src="<?php echo $this->root?>/includes/lightbox/lightbox.js" type="text/javascript"></script>
-->
	<script type="text/javascript" charset="UTF-8" src="<?php echo $this->root?>/includes/lightboxplus/lightbox_plus.js"></script>

	
</head>
<body>