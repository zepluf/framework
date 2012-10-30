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

if(empty($info)):
    rie('This plugin does not have the plugin.xml file');
else:?>
	<table class="table">
		<tr>
			<td>
				<?php rie('Name')?>
			</td>
			<td>
				<?php echo $info->name?>
			</td>
			<td>
				<?php rie('License')?>
			</td>
			<td>
				<a href="<?php echo $info->license->attributes()->uri;?>" target="_blank"><?php echo $info->license?></a>
			</td>
		</tr>
		<tr>
			<td>
				<?php rie('Version')?>
			</td>
			<td>
				<?php echo $info->release?>
			</td>
			<td>
				<?php rie('Date')?>
			</td>
			<td>
				<?php echo $info->released?>
			</td>
		</tr>		
	</table>
	<h2><?php rie('Dependencies')?></h2>
	<?php foreach ($info->dependencies->required as $required):?>
		<?php foreach ($required as $key => $rq):?>
			<strong><?php echo $key?>:</strong> <?php echo $rq->min?><br />	
		<?php endforeach;?>	
	<?php endforeach;?>
	
	<?php
    if(!empty($info->dependencies->plugins->plugin))
        foreach ($info->dependencies->plugins->plugin as $plugin):?>
		
		<strong><?php echo $plugin->codename?></strong> <?php rie('min version')?> <?php echo $plugin->min?><br />
		
	<?php endforeach;?>
	<h2><?php rie('Authors')?></h2>
	<?php foreach($info->authors->author as $author):?>
	<table class="table">
		<tr>
			<td>
				<?php rie('Name')?>
			</td>
			<td>
				<?php echo $author->name;?>
			</td>
			<td>
				<?php rie('Email')?>
			</td>
			<td>
				<?php echo $author->email?>
			</td>
		</tr>
	</table>
	<?php endforeach;?>
	
	<h2><?php rie('Summary')?></h2>
	<?php echo nl2br($info->summary)?>
	
	<h2><?php rie('Notes')?></h2>
	<?php echo ($info->notes)?>
	
	<h2><?php rie('Changelog')?></h2>
	<?php foreach($info->changelog->release as $release):?>
		<div class="releases">
    		<strong><?php echo $release->version->release?></strong>
    		(<?php echo $release->released?>) 
    		<a target="_blank" href="<?php echo $release->license->attributes()->uri?>">(<?php echo $release->license;?></a>)
    		<br />
    		<?php echo nl2br($release->notes)?>
		</div>
	<?php endforeach;?>
<?php endif;?>  