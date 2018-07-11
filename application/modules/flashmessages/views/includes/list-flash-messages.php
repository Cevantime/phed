<?php if(isset($flashMessages) && $flashMessages): ?>
	<?php foreach($flashMessages as $type => $messages): ?>
	<?php if($messages): ?>
	<ul class="list-flash-messages <?php echo $type ?>">
		<?php foreach ($messages as $message) :?>
		<li>
			<?php echo $message['content'] ?>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>
