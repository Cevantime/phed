
<style type="text/css">
	.admin-message {

		background: gray none repeat scroll 0 0;

		border-radius: 0 0 4px 4px;

		color: white;

		padding: 10px;

		position: absolute;

		top: -40px;

		right: 200px;

		opacity: 0;

		z-index: 10000;

		transition: all 0.5s 0s linear;

	}

	.admin-message.displayed {

		top: 0;

		opacity: 1;

	}

	.admin-message.error {

		background-color: #B82222

	}

	.admin-message.warning {

		background-color: #C7B123

	}

	.admin-message.success {

		background-color: #26A21B

	}

	.admin-message button {
		float: right;
		border: none;
		background: transparent;
	}

	.admin-message .admin-message-content {
		margin: 0;
	}

</style>
<div style="display: none">

	<?php if (isset($flashMessages) && $flashMessages): ?>
		<?php $nbFlashMessage = count($flashMessages); ?>
		<?php for ($i = $nbFlashMessage - 1; $i >= 0; $i--): ?>
			<?php $flashMessage = $flashMessages[$i]; ?>
			<div class="admin-message <?php echo $flashMessage['type']; ?>">
				<button class="bt-close">&Cross;</button>

				<p class="admin-message-content">
					<?php echo $flashMessage['content']; ?>
				</p>
			</div>        
		<?php endfor; ?>
	<?php endif; ?>
</div>

<script type="text/javascript" data-module="modules/flashmessages/slidedown-flashmessages"></script>