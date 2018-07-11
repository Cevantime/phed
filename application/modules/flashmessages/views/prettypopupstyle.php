<style>
	#popup-flash-messages {
		background: rgba(0,0,0,0.8);
		font-size: 0.9em;
		color: black;
	}
	
	#popup-flash-messages .popup {
		position: relative;
	}
	
	#popup-flash-messages .close-popup {
		position: relative;
		background: gray none repeat scroll 0% 0%;
		color: black;
		padding: 3px 7px;
		border-radius: 2px;
		box-shadow: 0px 0px 3px black;
		position: relative;
		bottom: 33px;
	}
	
	#popup-flash-messages ul {
		list-style: none;
		margin: 0;
		padding: 0;
	}
	
	#popup-flash-messages .list-flash-messages {
		padding: 10px 10px 40px 10px;
		border-radius: 3px;
		box-shadow: 0 0 4px black;
		background-color: white;
	}
	
	#popup-flash-messages p{
		margin: 10px 0;
	}
	
	#popup-flash-messages .list-flash-messages.error {
		background-color: #E13300;
	}
	
	#popup-flash-messages .list-flash-messages.success {
		background-color: #093;
	}
	
	#popup-flash-messages .list-flash-messages.warning {
		background-color: #eb9316;
	}
	
	
</style>
<?php $this->load->view('flashmessages/includes/list-flash-messages'); ?>

<script type="text/javascript" data-module="modules/flashmessages/popup-flashmessages"></script>
