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

use plugins\riPlugin\Plugin;
$local = Plugin::get('settings')->loadFile('riSsu', '', 'local.yaml');
//var_dump($local);
?>
<div class="span2 col-left">
    <ul class="nav nav-pills nav-stacked menu-contact">
        <li class="active"><a href="#"><?php rie('Custom Contract Forms')?></a></li>
        <li><a href="#"><?php rie('Saved Forms Submission')?></a></li>
        <li><a href="#"><?php rie('General Setting')?></a></li>
    </ul>
</div>
<div class="span10 col-right">
    <form class="form-horizontal ajax-form" method="POST" id="form-config" action="<?php echo riLink('ricore_admin_plugins_configs_settings', array(), 'NONSSL', false, 'ri.php')?>" >
    <input type="hidden" name="riname" value="<?php echo $riname;?>">
    <table class="table settings">
        <tr>
            <th colspan="2" style="border-top: none;"><?php rie('EDIT PLUGIN RISSU')?></th>
        </tr>
        <tr>
            <td class="td-left" style="vertical-align: top;">
                <div class="control-group">
                    <label class="control-label">Should we turn on ssu?</label>
                    <div class="controls">
                        <select class="input-mini" name="configs[status]">
                            <option value="1" <?php echo $local['status'] ? "selected='selected'" : ""; ?> >Yes</option>
                            <option value="0" <?php echo $local['status'] ? "" : "selected='selected'"; ?> >No</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Should we turn on alias?</label>
                    <div class="controls">
                        <select class="input-mini" name="configs[alias_status]">
                            <option value="1" <?php echo $local['alias_status'] ? "selected='selected'" : ""; ?>>Yes</option>
                            <option value="0" <?php echo $local['alias_status'] ? "" : "selected='selected'"; ?>>No</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Should the aliases be automatically generated to give links like categories-name/products-name</label>
                    <div class="controls">
                        <select class="input-mini" name="configs[auto_alias]">
                            <option value="1" <?php echo $local['auto_alias'] ? "selected='selected'" : ""; ?>>Yes</option>
                            <option value="0" <?php echo $local['auto_alias'] ? "" : "selected='selected'"; ?>>No</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Are we using multi language?</label>
                    <div class="controls">
                        <select class="input-mini" name="configs[multilang_status]">
                            <option value="1" <?php echo $local['multilang_status'] ? "selected='selected'" : ""; ?>>Yes</option>
                            <option value="0" <?php echo $local['multilang_status'] ? "" : "selected='selected'"; ?>>No</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Do we want to include the language identifier for the default language</label>
                    <div class="controls">
                        <select class="input-mini" name="configs[multilang_default_identifier]">
                            <option value="1" <?php echo $local['multilang_default_identifier'] ? "selected='selected'" : ""; ?>>Yes</option>
                            <option value="0" <?php echo $local['multilang_default_identifier'] ? "" : "selected='selected'"; ?>>No</option>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                    <span class="help-block">i.e Your site, even if using English as default, will always have links like this yoursite.com/en/....</span>
                </div>
                <div class="control-group">
                    <label class="control-label">
                        Do we want to append extension, for example .html, <br/>to the end of the links?
                    </label>
                    <div class="controls">
                        <input type="text" class="input-small" name="configs[extension]" placeholder="" value="<?php echo $local['extension']; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">
                        Trailing slash:
                    </label>
                    <div class="controls">
                        <select class="input-mini" name="configs[trailing_slash]">
                            <option value="1" <?php echo $local['trailing_slash'] ? "selected='selected'" : ""; ?>>Yes</option>
                            <option value="0" <?php echo $local['trailing_slash'] ? "" : "selected='selected'"; ?>>No</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">How do we want to separate categories in the links?</label>
                    <div class="controls">
                        <input type="text" class="input-small" name="configs[category_separator]" placeholder="" value="<?php echo $local['category_separator']; ?>">
                    </div>
                </div>
            </td>
            <td class="td-right" style="vertical-align: top;">
                <div class="control-group">
                    <label class="control-label">How many categories we want to include in a link?</label>
                    <div class="controls">
                        <input type="text" name="configs[category_maximum_level]" placeholder="" value="<?php echo $local['category_maximum_level']; ?>">
                    </div>
                    <div class="clearfix"></div>
                    <span class="help-block">For example your site may have 4 category levels but you want to display max 3 only, to shorten your links</span>
                </div>
                <div class="control-group">
                    <label class="control-label">What is the minimum length of a word:</label>
                    <div class="controls">
                        <input type="text" name="configs[minimum_word_length]" value="<?php echo $local['minimum_word_length']; ?>" placeholder="">
                    </div>
                    <div class="clearfix"></div>
                    <span class="help-block">If you set to 2 for example, then "this-is-a-name" will become "this-is-name"</span>
                </div>
                <div class="control-group">
                    <label class="control-label">Do you want to cut off the name on the links if it is too long? 0 means unlimited</label>
                    <div class="controls">
                        <label class="checkbox">
<!--                            <input type="checkbox"> Administrator &#124; User role-->
                            <input type="text" name="configs[max_name_length]" value="<?php echo $local['max_name_length']; ?>" placeholder="">
                        </label>
                    </div>
                    <div class="clearfix"></div>
                    <span class="help-block">
                        this is a sample product name: "lenovo x200" which has the product id of 199<br/>
                        after transforming, without auto alias, it may look like this: "lenovo-x200-p.199"
                    </span>
                </div>
                <div class="control-group">
                    <label class="control-label">Delimiters: id</label>
                    <div class="controls">
                        <input type="text" name="configs[delimiters][id]" value="<?php echo $local['delimiters']['id']; ?>" placeholder="">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Delimiters: name</label>
                    <div class="controls">
                        <input type="text" name="configs[delimiters][name]" value="<?php echo $local['delimiters']['name']; ?>" placeholder="">
                    </div>
                    <div class="clearfix"></div>
                    <span class="help-block">in the above case, "-" was chosen as the name delimiter while "." as the id delimiter</span>
                </div>
                <div class="btn-group">
                    <div class="btn btn-primary edit" ><i class="icon-plus-sign icon-white"></i> Save RiSsu</div>
                </div>
            </td>
        </tr>
    </table>
    </form>
</div>
<script>
    $(function(){
        $("div.edit").click( function(){
            $('.ajax-form').ajaxSubmit({
                success: function(response){

                }
            });
            return false;
        });
    });
</script>