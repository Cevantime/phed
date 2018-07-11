<?php switch($file->type): ?>
<?php case 'image/png': ?>
<?php case 'image/jpeg' : ?>
<?php case 'image/gif' : ?>
	<img src="<?php echo base_url($file->file); ?>"/>
	<?php break; ?>
<?php case 'application/zip' : ?>
<?php case 'application/rar' : ?>
	<i class="fa fa-file-archive-o"></i>
	<?php break; ?>
<?php case 'application/pdf' : ?>
	<?php $this->load->helper('images/pdfthumb'); ?>
	<!-- <img src="<?php // echo base_url(pdfthumb($file->file)); ?>"/> -->
	<i class="fa fa-file-pdf-o"></i>
	<?php break; ?>
<?php default : ?>
	<i class="fa fa-file"></i>
<?php endswitch; ?>
<p>
	<?php echo $file->name; ?>
</p>