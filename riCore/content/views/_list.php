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

$riview->get('loader')->load(array('jquery.lib', 'bootstrap.lib', 'jquery.snippet.lib', 'jquery.form.lib', 'jquery.gritter.lib', 'riCore::jquery.tablesorter.js', 'riCore::style.css', 'riCore::modal.js', 'ritools.lib', 'riCore::plugins.css'))

?>

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
                url: '<?php echo riLink('ricore_admin_plugins_info');?>',
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
                            parent.find('a.activation.activate').addClass('act');
                            parent.find('a.activation.deactivate').removeClass('deact');
                        }
                        else{
                            parent.find('a.activate').show();
                            parent.find('a.deactivate').hide();
                            parent.find('a.activation.activate').removeClass('act');
                            parent.find('a.activation.deactivate').addClass('deact');
                        }
                    }

                    else if(response.installed != undefined){
                        if(response.installed){
                            parent.find('a.deactivate').hide();
                            parent.find('a.activate').show();
                            parent.find('a.activation.deactivate').addClass('deact');
                            parent.find('a.activation.activate').removeClass('act');
                            parent.find('a.install').hide();
                            parent.find('a.uninstall').show();
                        }
                        else{
                            parent.find('a.deactivate').hide();
                            parent.find('a.activate').hide();
                            parent.find('a.activation.deactivate').addClass('deact');
                            parent.find('a.install').show();
                            parent.find('a.uninstall').hide();
                        }
                    }
                    updateTab();
                    updateStatus($('#menu-plugins li.active').find('a').attr('data-dismiss'));
                    riTools.message(response.messages);
                }
            });
            e.preventDefault();
        });

    });
</script>
<?php $riview->get('loader')->endInline();?>
<div class="logo pull-left"></div>
<div class="menus pull-right">
    <ul class="nav nav-pills" id="tabPlugin">
        <li class="active">
            <a href="#plugins"><?php rie('Plugins')?></a>
        </li>
        <!--<li><a href="#install"><?php rie('Install')?></a></li>
        <li><a href="#feature"><?php rie('Featured')?></a></li>-->
        <li><a href="#about"><?php rie('About')?></a></li>
    </ul>
</div>
<div class="clearfix"></div>
<div class="row-fluid show-grid plugins">
    <div class="span12 title" id="table-name"><?php rie('Plugins')?></div>
    <div class="tab-content" style="width: 100%;">
        <div class="tab-pane active" id="plugins">
            <?php echo $riview->render('riCore::_tab_plugins.php', array('plugins' => $plugins, 'core' => $core));?>
        </div>
        <div class="tab-pane" id="settings">

        </div>
        <div class="tab-pane" id="install">
            <?php echo $riview->render('riCore::_tab_install.php');?>
        </div>
        <div class="tab-pane" id="feature">
            <div class="content">
                This tab will display featured plugins. Content coming soon...
            </div>
        </div>
        <div class="tab-pane" id="about">
            <div class="content">
                The Zencart Plugin Framework (ZePLUF) is a product of rubikin.com <br /><br />

                This framework is meant to be used with Zencart version 1.3.9h and above<br /><br />

                <h3 class="heading">Features</h3>

                <ol>
                    <li>Allows developers to package their plugin(s) in one single place (in most cases) instead of spreading the files all over the place.</li>
                    <li>Installing a Zencart plugin has never been easier, in many cases it's just a matter of uploading the new plugin folder. No more messing around with various Zencart folders.</li>
                    <li>Files/Classes are loaded on demand with PHP 5.3 lazy load feature.</li>
                    <li>Allows developers to save time while developing their modules by making use of the framework's useful features (such at the ability to inject content into any location)</li>
                    <li>Many of our modules also rely on ZePLUF to work, you won't be able to use our modules without ZePLUF</li>
                </ol>

                <h3 class="heading">Documentation</h3>

                Check our <a href="http://rubikin.com/wiki/zencart/plugin_framework/about">wiki</a>
            </div>
        </div>
    </div>
</div>
<a href="#" class="news"></a>

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
<script>
    $(function () {
        $('#tabPlugin a').click(function (e) {
            e.preventDefault();
            if($(this).attr('href') == '#plugins'){
                $('.tab-content').find('.tab-pane').removeClass('active');
                $('#plugins').addClass('active');
            }
            $(this).tab('show');
            $("#table-name").text($(this).text());
        });
    })
</script>