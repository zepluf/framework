<?php
/**
 * sfWidgetFormSchemaFormatterDaYamlEditor try to display a form like Doctrine Admin generator do
 *
 * @author dalexandre
 * @since 8 janv. 2010
 */
class sfWidgetFormSchemaFormatterDaYamlEditor extends sfWidgetFormSchemaFormatter
{
    protected
    $rowFormat                 = '<div class="sf_admin_form_row sf_admin_text">
      %error%
   <div>%label%
    <div class="content">%field%</div>
    %help%
    %hidden_fields%
   </div>
</div>',
    $helpFormat                = '<div class="help">%help%</div>';
}