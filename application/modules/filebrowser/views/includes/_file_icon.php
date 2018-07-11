<?php switch($file->type): ?>
<?php case 'image/png': ?>
<?php case 'image/jpeg' : ?>
<?php case 'image/gif' : ?>
	<img src="<?php echo imageresize($file->file, 20, 20); ?>" title="<?php echo $file->name; ?>"/>
	<?php break; ?>
<?php case 'application/zip' : ?>
<?php case 'application/rar' : ?>
	<i class="fa fa-file-archive-o"></i>
	<?php break; ?>
<?php case 'application/pdf' : ?>
	<i class="fa fa-file-pdf-o"></i>
	<?php break; ?>
<?php default : ?>
	<i class="fa fa-file"></i>
<?php endswitch; ?>