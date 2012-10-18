<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 9/30/12
 * Time: 4:31 PM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF
 */

$riview->get('loader')->load(array('jquery.lib', 'jquery.ui.lib', 'bootstrap.lib', 'jquery.snippet.lib', 'jquery.gritter.lib', 'riCore::style.css', 'riCore::modal.js', 'ritools.lib', 'riCore::plugins.css'))
?>

<?php $riview->get('loader')->startInline('js');?>
<script type="text/javascript">
    //update row of table by status
    function updateStatus(stt){
        var tb = $('#pluginGrid tbody');
        if(stt == 'all'){
            tb.find('tr').show();
        }else if(stt == 'act'){
            tb.find('tr').hide();
            tb.find('.act').closest('tr').show();
        }else if(stt == 'deact'){
            tb.find('tr').hide();
            tb.find('.deact').closest('tr').show();
        }else if(stt == 'update'){
            tb.find('tr').hide();
            tb.find('.update').closest('tr').show();
        }
    }
    //update tab menus by status
    function updateTab(){
        $('#menu-plugins a').each(function(){
            var curr = $(this);
            var stt = curr.attr('data-dismiss');
            var num = 0;
            if(stt == 'act') num = $('.act').length;
            if(stt == 'deact') num = $('.deact').length;
            if(stt == 'update') num = $('.update').length;
            curr.parent().find('span').text(num);
        });
    }
    $(function () {
        $('.show-setting').on('click', function(e){
            e.preventDefault();
            $('.tab-content').find('.tab-pane').removeClass('active');
            $('#settings').addClass('active');
            $("#table-name").text('<?php rie('Custom forms'); ?>');
            var riname = $(this).attr('data-parent');
            $.ajax({
                type: "POST",
                url: "<?php echo riLink('ricore_admin_plugins_show_settings', array(), 'NONSSL', false, 'ri.php'); ?>",
                data: {name: riname},
                dataType: 'json',
                success: function(data){
                    if(data.view){
                        $('#settings').html(data.view);
                    }else{
                        $('#settings').html("<br /><p style='padding: 10px;'>This plugin can not edit settings.</p>");
                    }
                }
            });
        });
//        $('.table tbody tr:odd').addClass('odd');

        var grid = $('#pluginGrid');

        // handle search fields key up event
        $('#search-term').keyup(function(e) {
            var text = $(this).val(); // grab search term

            if(text.length > 1) {
                grid.find('tr:has(td)').hide(); // hide data rows, leave header row showing

                // iterate through all grid rows
                grid.find('tr').each(function(i) {
                    // check to see if search term matches Name column
                    if($(this).find('td:first-child').text().toUpperCase().match(text.toUpperCase()))
                        $(this).show(); // show matching row
                });
            }
            else
                grid.find('tr').show(); // if no matching name is found, show all rows
        });

        $('#menu-plugins a').on('click', function(e){
            e.preventDefault();
            var curr = $(this);
            var parent = $(this).closest('li');
            var lis = $('#menu-plugins li');
            var stt = curr.attr('data-dismiss');
            lis.removeClass('active');
            updateStatus(stt);
            parent.addClass('active');
        });

        $('a.delete').on('click', function(e){
            e.preventDefault();
            var parent = $(this).closest('tr');
            var riname = $(this).attr('data-parent');
            $.ajax({
                type: "POST",
                url: "<?php echo riLink('ricore_admin_plugins_delete', array(), 'NONSSL', false, 'ri.php'); ?>",
                data: {name: riname},
                dataType: 'json',
                success: function(data){
                    if(data.status){
                        parent.remove();
                    }else{
                        alert('Delete this plugin unsuccessfull!');
                    }
                }
            });
        });

        updateTab();

        $('#search-btn').click(function(e){
            e.preventDefault();
        });
    });
</script>
<?php $riview->get('loader')->endInline();?>
<div class="show-plugin">
    <div class="span2 col-left">
        <button class="ajax-link btn" data-href="<?php echo riLink('ricore_admin_plugins_load_theme_settings');?>">Load theme settings</button>
        <form class="form-search">
            <div class="input-append">
                <input type="text" class="span2 search-query" id="search-term" placeholder="Search install Plugins">
                <a href="#" class="btn" id="search-btn"></a>
            </div>
        </form>
        <ul class="nav nav-pills nav-stacked" id='menu-plugins'>
            <li class="active"><a href="#" data-dismiss="all">All</a> (<?php echo count($plugins);?>)</li>
            <li><a href="#" data-dismiss="act">Active</a> (<span>0</span>)</li>
            <li><a href="#" data-dismiss="deact">Inactive</a> (<span>0</span>)</li>
            <li><a href="#" data-dismiss="update">Update Available</a> (<span>0</span>)</li>
        </ul>
    </div>
    <div class="span10 col-right">
        <table class="table tablesorter" id='pluginGrid'>
            <thead>
            <tr>
                <th class="sorted"><?php rie('Plugin Code Name')?></th>
                <th><?php rie('Version')?></th>
                <th class="sorted"><?php rie('Install')?></th>
                <th class="sorted desc"><?php rie('Status')?></th>
                <th><?php rie('Action')?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($plugins as $plugin):?>
                <?php
                $installed = \plugins\riPlugin\Plugin::isInstalled($plugin['code_name']);
                $activated = \plugins\riPlugin\Plugin::isActivated($plugin['code_name']);
                $info = \plugins\riPlugin\Plugin::info($plugin['code_name']);
                ?>
            <tr class="<?php echo in_array($plugin['code_name'], $core) ? 'core' : 'noncore';?>">
                <td><?php echo $plugin['code_name']?></td>
                <td><?php echo $info->release?></td>
                <td>
                    <a class="toggle-plugin installation install" <?php echo $installed ? 'style="display:none"' : '' ?> href="<?php echo riLink('ricore_admin_plugins_install', array('plugin' => $plugin['code_name']))?>">
                        <?php rie('install')?>
                    </a>

                    <a class="toggle-plugin installation uninstall" <?php echo !$installed ? 'style="display:none"' : '' ?> href="<?php echo riLink('ricore_admin_plugins_uninstall', array('plugin' => $plugin['code_name']))?>">
                        <?php rie('un-install')?>
                    </a>
                </td>
                <td>
                    <a class="toggle-plugin activation activate <?php echo $activated ? 'act' : '' ?>" <?php echo !$installed || $activated ? 'style="display:none"' : '' ?> href="<?php echo riLink('ricore_admin_plugins_activate', array('plugin' => $plugin['code_name']))?>">
                        <?php rie('activate')?>
                    </a>

                    <a class="toggle-plugin activation deactivate <?php echo !$activated ? 'deact' : '' ?>" <?php echo !$installed || !$activated ? 'style="display:none"' : '' ?> href="<?php echo riLink('ricore_admin_plugins_deactivate', array('plugin' => $plugin['code_name']))?>">
                        <?php rie('de-activate')?>
                    </a>

                </td>
                <td>
                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-cog"></i> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a class="modal-link" href="#" data-plugin="<?php echo $plugin['code_name']?>"><i class="icon-file"></i> <?php rie('View info')?></a></li>
                            <li><a href="#" class="show-setting deactivate" <?php echo $installed && $activated ? '':'style="display:none"'; ?> data-parent="<?php echo $plugin['code_name'];?>"><i class="icon-cog"></i> <?php rie('Settings')?></a></li>
                            <li><a class="toggle-plugin deactivate" <?php echo $installed && $activated ? '':'style="display:none"'; ?> href="<?php echo riLink('ricore_admin_plugins_reset', array('plugin' => $plugin['code_name']))?>"><i class="icon-refresh"></i> <?php rie('Reload Settings')?></a></li>
                            <li><a href="#" class="delete" data-parent="<?php echo $plugin['code_name'];?>"><i class="icon-remove"></i> <?php rie('Delete')?></a></li>
                        </ul>
                    </div>
                </td>
            </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <div class="info-plugin" style="display: none;">
            <div class="alert">
                There is a new version of Google Analytics for WordPress available. <a href="#">View version 1.3.0 details</a> or <a href="#"> update now.</a>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $("#pluginGrid").tablesorter({headers: { 1:{sorter: false}, 2:{sorter: false}, 3:{sorter: false}, 4:{sorter: false}}});
    })
</script>