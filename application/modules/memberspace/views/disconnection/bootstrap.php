<?php $this->load->helper('form'); ?>

<?php echo form_open(current_url()); ?>

	<div class="form-group">
		<input type="hidden" name="disconnect" value="1"/>
		<button type="submit" class="btn btn-ar btn-primary pull-right">Se déconnecter</button>
		<div class="clearfix"></div>
	</div>
</form>