<?php if ($file->is_folder): ?>
	<li class="file file-folder" data-file="<?php echo $file->id; ?>" id="folder-<?php echo $file->id; ?>">
		<div class="file-row">
			<span class="file-icon"><i class="fa fa-folder"></i></span>
			<label class="folder-name"><?php echo $file->name; ?></label> 
			<div class="file-actions">
				<a title="Aller dans le dossier" href="#" class="action" data-action="browse" data-file="<?php echo $file->fullpath; ?>"><i class="fa fa-eye"></i></a>
				<?php if(user_can('delete', 'file', $file)) : ?>
				<a title="Supprimer le dossier" href="#" class="action" data-action="delete" data-file="<?php echo $file->id; ?>"><i class="fa fa-trash"></i></a>
				<?php endif; ?>
				<?php if(user_can('add', 'file')) : ?>
				<a title ="Ajouter un dossier" href="#" class="action" data-action="add-folder" data-file="<?php echo $file->id; ?>"><i class="fa fa-folder"></i></a>
				<a title="Ajouter un fichier" href="#" class="action" data-action="add-file" data-file="<?php echo $file->id; ?>"><i class="fa fa-file"></i></a>
				<?php endif; ?>
				<?php if(user_can('update', 'file', $file)) : ?>
				<a title="Renommer un fichier" href="#" class="action" data-action="rename" data-file="<?php echo $file->id; ?>"><i class="fa fa-edit"></i></a>
				<?php endif; ?>
			</div>

		</div>
	</li>
<?php else: ?>
	<li class="file file-file" data-type="<?php echo $file->type; ?>" data-source="<?php echo $file->file; ?>" data-infos="<?php echo htmlentities(json_encode($file), ENT_QUOTES, 'UTF-8'); ?>" data-file="<?php echo $file->id; ?>" id="file-<?php echo $file->id; ?>">
		<div class="file-row">
			<span class="file-icon"><?php $this->load->view('filebrowser/includes/_file_icon', array('file'=>$file)) ?></span>
			<label class="file-name"><?php echo $file->name; ?></label>
			<div class="file-actions">
				<?php if(user_can('delete', 'file', $file)) : ?>
				<a title="Supprimer le fichier" href="#" class="action" data-action="delete" data-file="<?php echo $file->id; ?>"><i class="fa fa-trash"></i></a>
				<?php endif; ?>
				<?php if(user_can('update', 'file', $file)) : ?>
				<a title="Renommer un fichier" href="#" class="action" data-action="rename" data-file="<?php echo $file->id; ?>"><i class="fa fa-edit"></i></a>
				<?php endif; ?>
			</div>
		</div>
	</li>
<?php endif; ?>


