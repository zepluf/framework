<?php use_helper('I18N'); ?>

<div id="sf_admin_container">
  <h1>daYamlEditor</h1>

  <div id="sf_admin_content">
    <div class="sf_admin_form">

      <?php if ($sf_user->hasFlash('notice')): ?>
        <div class="notice"><?php echo __($sf_user->getFlash('notice'), array(), 'sf_admin') ?></div>
      <?php endif; ?>

      <?php if ($sf_user->hasFlash('error')): ?>
        <div class="error"><?php echo __($sf_user->getFlash('error'), array(), 'sf_admin') ?></div>
      <?php endif; ?>

      <form action="" method="post">
        <fieldset id="sf_fieldset_none">
          <?php echo $form ?>
        </fieldset>
        <ul class="sf_admin_actions">
          <li class="sf_admin_action_save">
            <input type="submit" value="<?php echo __('Save', array(), 'sf_admin'); ?>" />
          </li>
        </ul>
      </form>

    </div>
  </div>
</div>