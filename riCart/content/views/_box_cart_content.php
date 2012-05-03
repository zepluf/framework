<?php 

// quick hack to get $currencies
global $currencies, $db;

$content_block = '<div style="width: 250px" id="shoppingcart" class="rightBoxContainer">';
$content_block .= '<h3 id="shoppingcartHeading" class="rightBoxHeading"><a href="'.zen_href_link(FILENAME_SHOPPING_CART).'">Shopping Cart&nbsp;&nbsp;</a></h3>';
$content_block .= '<div class="sideBoxContent" id="shoppingcartContent">';

if ($_SESSION['cart']->count_contents() > 0) {

    $content_block .= '<div class="cartSavingText">' . shippingSavingText() . '</div>';
    $content_block .= '<div style="text-align:right"><a style="color: #0070B8;font-weight: bold;text-decoration: none;" href="'.  zen_href_link(FILENAME_SHOPPING_CART) .'">Edit My Cart</a></div>';
    // $content_block .= '<br class="clearBoth" />';

    if ($_SESSION['cart']->count_contents() > 0) {
        $total = $currencies->format($_SESSION['cart']->show_total());

        $face_total = $currencies->format($_SESSION['cart']->face_total);

        $content_block .= '<div class="cartBoxTotal"><strong>Total Face Value: </strong>' . $face_total . '</div>';

        $content_block .= '<div class="cartBoxTotal"><strong>Total Cost: </strong>' . $total . '</div>';

        $content_block .= '<br class="clearBoth" />';

    }

    $content_block .= '<div class="back"><a href="' . zen_href_link(FILENAME_XCHECKOUT, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_CHECKOUT, BUTTON_CHECKOUT_ALT) . '</a></div>';



    if (defined('MODULE_PAYMENT_PAYPALWPP_STATUS') && MODULE_PAYMENT_PAYPALWPP_STATUS == 'True') {

        ob_start();

        include(DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/tpl_ec_button.php');

        $content_block .= ob_get_clean();

    }

}

if ($_SESSION['cart']->count_contents() > 0) {

    $content_block .= '<br class="clearBoth" /><div id="cartBoxListWrapper">' . "\n" . '<ul>' . "\n";



    $products = $_SESSION['cart']->get_products();

    $n = sizeof($products);

    for ($i=$n-1; $i>=0; $i--) {

        $content_block .= '<li>';



        if (($_SESSION['new_products_id_in_cart']) && ($_SESSION['new_products_id_in_cart'] == $products[$i]['id'])) {

            $content_block .= '<span class="cartNewItem">';

        } else {

            $content_block .= '<span class="cartOldItem">';

        }



        $content_block .= $products[$i]['quantity'] . BOX_SHOPPING_CART_DIVIDER . '</span><a href="' . zen_href_link('index', zen_get_path(zen_get_products_category_id($products[$i]['id']))) . '">';



        if (($_SESSION['new_products_id_in_cart']) && ($_SESSION['new_products_id_in_cart'] == $products[$i]['id'])) {

            $content_block .= '<span class="cartNewItem">';

        } else {

            $content_block .= '<span class="cartOldItem">';

        }



        $content_block .= zen_image(DIR_WS_IMAGES . $products[$i]['image'], $products[$i]['name'], IMAGE_SHOPPING_CART_WIDTH, IMAGE_SHOPPING_CART_HEIGHT) . '<br>' . $products[$i]['name'] . '</span></a></li>' . "\n";



        if (($_SESSION['new_products_id_in_cart']) && ($_SESSION['new_products_id_in_cart'] == $products[$i]['id'])) {

            $_SESSION['new_products_id_in_cart'] = '';

        }

    }

    // BOF Edit My Cart
    $content_block .= '</ul>' . "\n";

    $content_block .= '</div>';
    // EOF Edit My Cart
} else {

    $content_block .= '<div id="cartBoxEmpty">' . BOX_SHOPPING_CART_EMPTY . '</div>';

}



/*  if ($_SESSION['cart']->count_contents() > 0) {

$content_block .= '<hr />';

$content_block .= '<div class="cartBoxTotal">' . $currencies->format($_SESSION['cart']->show_total()) . '</div>';

}*/





if (isset($_SESSION['customer_id'])) {

    $gv_query = "select amount

                 from " . TABLE_COUPON_GV_CUSTOMER . "

                 where customer_id = '" . $_SESSION['customer_id'] . "'";

    $gv_result = $db->Execute($gv_query);



    if ($gv_result->RecordCount() && $gv_result->fields['amount'] > 0 ) {

        $content_block .= '<div id="cartBoxGVButton"><a href="' . zen_href_link(FILENAME_GV_SEND, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_SEND_A_GIFT_CERT , BUTTON_SEND_A_GIFT_CERT_ALT) . '</a></div>';

        $content_block .= '<div id="cartBoxVoucherBalance">' . VOUCHER_BALANCE . $currencies->format($gv_result->fields['amount']) . '</div>';

    }

}

$content_block .= '<br class="clearBoth" />';
$content_block .= '</div></div>';

echo $content_block;