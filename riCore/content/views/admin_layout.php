<?php 
$base_href = getBaseHref(true);
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<?php if($_GET['action'] == 'link_aliases') { ?>

<link rel="stylesheet" type="text/css" media="screen" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../plugins/riSsu/content/resources/jqGrid/css/ui.jqgrid.css" />
<style type="text/css">
input.FormElement[type="text"] {
width:350px;
}
</style>
<script src="../plugins/riSsu/content/resources/jqGrid/jquery.js" type="text/javascript"></script>
<script src="../plugins/riSsu/content/resources/jqGrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="../plugins/riSsu/content/resources/jqGrid/jquery.jqGrid.js" type="text/javascript"></script>


<script type="text/javascript">
var $list;
jQuery(document).ready(function(){ 
 
jQuery("#list").jqGrid({ 
	url:'ssu_link_alias.php', 
	datatype: "json", 
	jsonReader : {

  root: "rows",
  page: "page",
  total: "total",
  records: "records",
  repeatitems: true,
  cell: "cell",
  id: "id",
  userdata: "userdata",
  subgrid: {root:"rows", 
    repeatitems: true, 
    cell:"cell"
  }},
  colNames:['id','Url', 'Alias', /*'Language',*/ 'Status', 'Permanent'],
  colModel :[ 
    {name:'id', index:'id', width:50}, 
    {name:'link_url', index:'link_url', editable:true, width:420}, 
    {name:'link_alias', index:'link_alias', editable:true, width:420, align:'left'}, 
    //{name:'languages_id', index:'languages_id', edittype:'select', editoptions:{value:"<?php echo $languages_string;?>"} },
    {name:'status', index:'status', editable:true, edittype:"checkbox", editoptions: {value:'1:0'}, width:80, align:'left'},
    {name:'permanent_link', index:'permanent_link', editable:true, edittype:"checkbox", editoptions: {value:'1:0'}, width:80, align:'left'}
    ],
	rowNum:25,
  rowList:[25,50,100],
	imgpath: 'includes/templates/template_default/css/themes/steel/images', 
	pager: jQuery('#pager'), 
	sortname: 'id', 
	viewrecords: true, 
	multiselect: true,
	sortorder: "desc", 
	caption: 'Your link aliases', 
	editurl: 'ssu_link_alias.php?action=edit', 
	height:450 }).navGrid('#pager', {}, //options 
											{height:280,width:420,reloadAfterSubmit:true}, // edit options 
											{height:280,width:420,reloadAfterSubmit:true}, // add options 
											{reloadAfterSubmit:true}, // del options 
											{sopt: ['eq','cn'] } // search options 
											); 
}); 
</script>
<?php } ?>
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
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
if (typeof _editor_url == "string") HTMLArea.replaceAll();
 }
 // -->
</script>
</head>
<body onload="init()">
<!-- header //-->

<!-- header_eof //-->
<!-- body //-->

<?php echo $view['holder']->get('main')?>



</body>
</html>