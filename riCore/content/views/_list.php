<?php $riview->get('loader')->load(array('jquery.lib', 'jquery.snippet.lib', 'jquery.gritter.lib', 'riCore::style.css', 'riCore::modal.js', 'ritools.lib'))?>

<?php $riview->get('loader')->startInline('js');?>
<script type="text/javascript">
    $(function () {
        $('#myModal').modal({
            backdrop: true,
            keyboard: true,
            show: false
        });

        $('.modal-link').bind('click', function (e) {
            $.ajax({
                url: '<?php echo riLink('admin_plugins_info');?>',
                data: {plugin: $(this).data('plugin')},
                success: function(response){
                    $('#myModal .modal-body').html(response);
                    $('#myModal').modal('show');
                    $("pre.code").each(function(){
                        $(this).snippet($(this).data('language'));
                    });
                }
            });
            e.preventDefault();
        });

        $('.ajax-link').click(function(e){
            $.ajax({
                url: $(this).data('href'),
                dataType: 'json',
                success: function(response){
                    riTools.message(response.messages);
                }
            });
            e.preventDefault();
        });

        $('a.toggle-plugin').click(function(e){
            var $this = $(this);
            $.ajax({
                url: $(this).attr('href'),
                dataType: 'json',
                success: function(response){
                    var parent = $this.closest('tr');

                    if(response.activated != undefined){
                        parent.find('a.install').hide();
                        parent.find('a.uninstall').show();
                        if(response.activated){
                            parent.find('a.activate').hide();
                            parent.find('a.deactivate').show();
                        }
                        else{
                            parent.find('a.activate').show();
                            parent.find('a.deactivate').hide();
                        }
                    }

                    else if(response.installed != undefined){
                        if(response.installed){
                            parent.find('a.deactivate').hide();
                            parent.find('a.activate').show();
                            parent.find('a.install').hide();
                            parent.find('a.uninstall').show();
                        }
                        else{
                            parent.find('a.deactivate').hide();
                            parent.find('a.activate').hide();
                            parent.find('a.install').show();
                            parent.find('a.uninstall').hide();
                        }
                    }

                    riTools.message(response.messages);
                }
            });
            e.preventDefault();
        })

    });
</script>
<?php $riview->get('loader')->endInline();?>

<button class="ajax-link" data-href="<?php echo riLink('admin_plugins_load_theme_settings');?>">Load theme settings</button>

<table class="table">
    <tr>
        <th><?php rie('Plugin Code Name')?></th>
        <th><?php rie('Version')?></th>
        <th><?php rie('Install')?></th>
        <th><?php rie('Status')?></th>
        <th><?php rie('Action')?></th>
    </tr>
    <?php foreach ($plugins as $plugin):?>
    <?php
    $installed = \plugins\riPlugin\Plugin::isInstalled($plugin['code_name']);
    $activated = \plugins\riPlugin\Plugin::isActivated($plugin['code_name']);
    $info = \plugins\riPlugin\Plugin::info($plugin['code_name']);
    ?>
    <tr>
        <td><?php echo $plugin['code_name']?></td>
        <td><?php echo $info->release?></td>
        <td>
            <a class="toggle-plugin installation install" <?php echo $installed ? 'style="display:none"' : '' ?> href="<?php echo riLink('admin_plugins_install', array('plugin' => $plugin['code_name']))?>">
                <?php rie('install')?>
            </a>

            <a class="toggle-plugin installation uninstall" <?php echo !$installed ? 'style="display:none"' : '' ?> href="<?php echo riLink('admin_plugins_uninstall', array('plugin' => $plugin['code_name']))?>">
                <?php rie('un-install')?>
            </a>
        </td>
        <td>
            <a class="toggle-plugin activation activate" <?php echo !$installed || $activated ? 'style="display:none"' : '' ?> href="<?php echo riLink('admin_plugins_activate', array('plugin' => $plugin['code_name']))?>">
                <?php rie('activate')?>
            </a>

            <a class="toggle-plugin activation deactivate" <?php echo !$installed || !$activated ? 'style="display:none"' : '' ?> href="<?php echo riLink('admin_plugins_deactivate', array('plugin' => $plugin['code_name']))?>">
                <?php rie('de-activate')?>
            </a>

        </td>
        <td><a class="modal-link" href="#" data-plugin="<?php echo $plugin['code_name']?>"><?php rie('view')?></a></td>
    </tr>
    <?php endforeach;?>
</table>
<div class="modal" id="myModal" style="display: none">
    <div class="modal-header">
        <button class="close" data-dismiss="modal">x</button>
        <h3><?php rie('Plugin Info')?></h3>
    </div>
    <div class="modal-body">

    </div>
    <div class="modal-footer">
        <button class="close btn" data-dismiss="modal"><?php rie('Close')?></button>
    </div>
</div>