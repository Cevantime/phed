<?php

$config = array(
	'memberspace/user' => array(
		'update-forbidden' => translate('Vous ne pouvez pas modifier cet utilisateur'),
		'insert-forbidden' => translate('Vous ne pouvez pas ajouter cet utilisateur'),
		'update-success' => translate("L'utilisateur a bien été mis à jour"),
		'insert-success' => translate("L'utilisateur a bien été ajouté"),
		'delete-forbidden' => translate('Vous n\'avez pas le droit de supprimer cet utilisateur'),
		'delete-success' => translate('L\'utilisateur a bien été supprimé')
	),
	
	'bo/admin' => array(
		'update-forbidden' => translate('Vous ne pouvez pas modifier cet administrateur'),
		'insert-forbidden' => translate('Vous ne pouvez pas ajouter cet administrateur'),
		'update-success' => translate("L'administrateur a bien été modifié"),
		'insert-success' => translate("L'administrateur a bien été ajouté"),
		'delete-forbidden' => translate('Vous n\'avez pas le droit de supprimer cet administrateur'),
		'delete-success' => translate('L\'administrateur a bien été supprimé')
	)
);
