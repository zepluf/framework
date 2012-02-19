<?php 
echo $riview->render('riCard::_admin_sell__filter');
?>
<table>
<tr style="vertical-align:top">
<td class="column odd">
<?php echo $riview->render('riCard::_admin_sell__list', array('result_list' => $result_list));?>
</td>
<td class="column">
<?php 
if(isset($order) && $order !== false) {
echo $riview->render('riCard::_admin_sell_view');
?>
<hr />

<?php 
echo $riview->render('riCard::_admin_sell_new');
}
?>
</td>
</tr>
</table>