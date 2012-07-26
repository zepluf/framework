<?php
namespace plugins\riCart;

use plugins\riPlugin\Plugin;

class Cart extends ZCCart{

	/**
	   * Method to add an item to the cart
	   *
	   * This method is usually called as the result of a user action.
	   * As the method name applies it adds an item to the uses current cart
	   * and if the customer is logged in, also adds to the database sored
	   * cart.
	   *
	   * @param integer the product ID of the item to be added
	   * @param decimal the quantity of the item to be added
	   * @param array any attributes that are attache to the product
	   * @param boolean whether to add the product to the notify list
	   * @return void
	   * @global object access to the db object
	   * @todo ICW - documentation stub
	   */
	  function add_cart($products_id, $qty = '1', $attributes = '', $notify = true) {
	    global $db;
	    $this->notify('NOTIFIER_CART_ADD_CART_START', array('products_id' => $products_id));
	    $products_id = zen_get_uprid($products_id, $attributes);
	    if ($notify == true) {
	      $_SESSION['new_products_id_in_cart'] = $products_id;
	    }

	$qty = $this->adjust_quantity($qty, $products_id, 'shopping_cart');

	    if ($this->in_cart($products_id)) {
	      $this->update_quantity($products_id, $qty, $attributes);
	    } else {
	      $this->contents[] = array($products_id);
	      $this->contents[$products_id] = array('qty' => (float)$qty);
	      // insert into database
	      if (isset($_SESSION['customer_id'])) {
	        $sql = "insert into " . TABLE_CUSTOMERS_BASKET . "
	                              (customers_id, products_id, customers_basket_quantity,
	                              customers_basket_date_added)
	                              values ('" . (int)$_SESSION['customer_id'] . "', '" . zen_db_input($products_id) . "', '" .
	        $qty . "', '" . date('Ymd') . "')";

	        $db->Execute($sql);
	      }

	      if (is_array($attributes)) {
	        reset($attributes);
	        while (list($option, $value) = each($attributes)) {
	          //CLR 020606 check if input was from text box.  If so, store additional attribute information
	          //CLR 020708 check if text input is blank, if so do not add to attribute lists
	          //CLR 030228 add htmlspecialchars processing.  This handles quotes and other special chars in the user input.
	          $attr_value = NULL;
	          $blank_value = FALSE;
	          if (strstr($option, TEXT_PREFIX)) {
	            if (trim($value) == NULL) {
	              $blank_value = TRUE;
	            } else {
	              $option = substr($option, strlen(TEXT_PREFIX));
	              $attr_value = stripslashes($value);
	              $value = PRODUCTS_OPTIONS_VALUES_TEXT_ID;
	              $this->contents[$products_id]['attributes_values'][$option] = $attr_value;
	            }
	          }

	          if (!$blank_value) {
	            if (is_array($value) ) {
	              reset($value);
	              while (list($opt, $val) = each($value)) {
	                $this->contents[$products_id]['attributes'][$option.'_chk'.$val] = $val;
	              }
	            } else {
	              $this->contents[$products_id]['attributes'][$option] = $value;
	            }
	            // insert into database
	            //CLR 020606 update db insert to include attribute value_text. This is needed for text attributes.
	            //CLR 030228 add zen_db_input() processing
	            if (isset($_SESSION['customer_id'])) {

	              //              if (zen_session_is_registered('customer_id')) zen_db_query("insert into " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " (customers_id, products_id, products_options_id, products_options_value_id, products_options_value_text) values ('" . (int)$customer_id . "', '" . zen_db_input($products_id) . "', '" . (int)$option . "', '" . (int)$value . "', '" . zen_db_input($attr_value) . "')");
	              if (is_array($value) ) {
	                reset($value);
	                while (list($opt, $val) = each($value)) {
	                  $products_options_sort_order= zen_get_attributes_options_sort_order(zen_get_prid($products_id), $option, $opt);
	                  $sql = "insert into " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
	                                        (customers_id, products_id, products_options_id, products_options_value_id, products_options_sort_order)
	                                        values ('" . (int)$_SESSION['customer_id'] . "', '" . zen_db_input($products_id) . "', '" .
	                                        (int)$option.'_chk'. (int)$val . "', '" . (int)$val . "',  '" . $products_options_sort_order . "')";

	                                        $db->Execute($sql);
	                }
	              } else {
	                if ($attr_value) {
	                  $attr_value = zen_db_input($attr_value);
	                }
	                $products_options_sort_order= zen_get_attributes_options_sort_order(zen_get_prid($products_id), $option, $value);
	                $sql = "insert into " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
	                                      (customers_id, products_id, products_options_id, products_options_value_id, products_options_value_text, products_options_sort_order)
	                                      values ('" . (int)$_SESSION['customer_id'] . "', '" . zen_db_input($products_id) . "', '" .
	                                      (int)$option . "', '" . (int)$value . "', '" . $attr_value . "', '" . $products_options_sort_order . "')";

	                                      $db->Execute($sql);
	              }
	            }
	          }
	        }
	      }
	    }
	    $this->cleanup();

	    // assign a temporary unique ID to the order contents to prevent hack attempts during the checkout procedure
	    $this->cartID = $this->generate_cart_id();
	    $this->notify('NOTIFIER_CART_ADD_CART_END');
	  }
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