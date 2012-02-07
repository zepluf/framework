<?php 
$base_href = getBaseHref(true);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>RI Admin</title>
<link rel="stylesheet" type="text/css" href="<?php echo $base_href;?>includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="<?php echo $base_href;?>includes/cssjsmenuhover.css" media="all" id="hoverJS">
<link rel="stylesheet" type="text/css" href="<?php echo $base_href;?>../plugins/riResultList/content/css/pagination.css" media="all">
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
{header}
<!-- header_eof //-->
<!-- body //-->

<?php echo $view['holder']->get('main')?>

{footer}
{application_bottom}
</body>
</html>