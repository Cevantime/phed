<?php $this->load->helper('form'); ?>

<?php echo form_open(current_url()); ?>
	<input type="hidden" name="disconnect" value="1"/>
	<input type="submit" name="disconnect" value="<?php echo translate('Se déconnecter'); ?>">
</form>

