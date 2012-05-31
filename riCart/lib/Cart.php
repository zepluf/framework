<?php
namespace plugins\riCart;

use plugins\riPlugin\Plugin;

class Cart extends ZCCart{
    /**
     * 
     * Since zen add_cart does not add new quantity to the current one we have to tweak it a bit
     * @param unknown_type $products_id
     * @param unknown_type $new_qty
     * @param unknown_type $attributes
     * @param unknown_type $notify
     */
    public function addCart($products_id, $new_qty = '1', $real_ids = '', $notify = true){
        // verify qty to add
        //          $real_ids = $_POST['id'];
        //die('I see Add to Cart: ' . $_POST['products_id'] . 'real id ' . zen_get_uprid($_POST['products_id'], $real_ids) . ' add qty: ' . $add_max . ' - cart qty: ' . $cart_qty . ' - newqty: ' . $new_qty);
        $add_max = zen_get_products_quantity_order_max($products_id);
        $cart_qty = $this->in_cart_mixed($products_id);
        //$messageStack->add_session('header', 'actionAddProduct Products_id: ' . $_POST['products_id'] . ' qty: ' . $cart_qty . ' <br>', 'caution');        

        //echo 'I SEE actionAddProduct: ' . $_POST['products_id'] . '<br>';
        $new_qty = $this->adjust_quantity($new_qty, $products_id, 'shopping_cart');

        $adjust_max = false;
        if (($add_max == 1 and $cart_qty == 1)) {
            // do not add
            $new_qty = 0;
            $adjust_max = true;
        } else {
            // adjust quantity if needed
            if (($new_qty + $cart_qty > $add_max) and $add_max != 0) {
                $adjust_max = true;
                $new_qty = $add_max - $cart_qty;
            }
        }
        
        if ($adjust_max == 'true') {
            Plugin::get('riLog.Logs')->add(array('message' => ERROR_MAXIMUM_QTY.$products_id, 'type' => 'caution'));            
        }
        
        $this->add_cart($products_id, $this->get_quantity(zen_get_uprid($products_id, $real_ids))+$new_qty, $real_ids, $notify);
    }
    
  /**
   * Method to remove an item from the cart
   *
   * @param mixed product ID of item to remove
   * @return void
   * @global object access to the db object
   */
  function remove($products_id) {
    global $db;
    $this->notify('NOTIFIER_CART_REMOVE_START', array('products_id' => $products_id));
    //die($products_id);
    //CLR 030228 add call zen_get_uprid to correctly format product ids containing quotes
    //      $products_id = zen_get_uprid($products_id, $attributes);
    unset($this->contents[$products_id]);
    // remove from database
    if ($_SESSION['customer_id']) {

      //        zen_db_query("delete from " . TABLE_CUSTOMERS_BASKET . " where customers_id = '" . (int)$customer_id . "' and products_id = '" . zen_db_input($products_id) . "'");

      $sql = "delete from " . TABLE_CUSTOMERS_BASKET . "
                where customers_id = '" . (int)$_SESSION['customer_id'] . "'
                and products_id = '" . zen_db_input($products_id) . "'";

      $db->Execute($sql);

      //        zen_db_query("delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where customers_id = '" . (int)$customer_id . "' and products_id = '" . zen_db_input($products_id) . "'");

      $sql = "delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
                where customers_id = '" . (int)$_SESSION['customer_id'] . "'
                and products_id = '" . zen_db_input($products_id) . "'";

      $db->Execute($sql);

    }

    // assign a temporary unique ID to the order contents to prevent hack attempts during the checkout procedure
    $this->cartID = $this->generate_cart_id();
    $this->notify('NOTIFIER_CART_REMOVE_END');
  }
}