<ul class="folder-contents">
	<?php if ($files): ?>
		<?php foreach ($files as $file): ?>
			<?php $this->load->view('filebrowser/includes/_file_row', array('file' => $file)); ?>
		<?php endforeach; ?>
	<?php else: ?>
		Ce dossier est vide
	<?php endif; ?>
</ul>
