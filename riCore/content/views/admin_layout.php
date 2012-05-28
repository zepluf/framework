<?php 
$base_href = getBaseHref(true);
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $base_href;?>includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="<?php echo $base_href;?>includes/cssjsmenuhover.css" media="all" id="hoverJS">

<script language="javascript" src="<?php echo $base_href;?>includes/menu.js"></script>
<script language="javascript" src="<?php echo $base_href;?>includes/general.js"></script>

<script type="text/javascript">
  <!--
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  }
  // -->
</script>
<base href="<?php echo $base_href;?>">
</head>
<body onload="init()">
<!-- header //-->

<!-- header_eof //-->
<!-- body //-->

<?php echo $view['holder']->get('main')?>

</body>
</html>