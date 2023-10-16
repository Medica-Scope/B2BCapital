<?php
/**
 * @Filename: opportunity-response.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 7/14/2023
 */
?>

<script type="text/template" id="ninja_modal_opp_request_success">
<div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="staticBackdropLabel"><%= msg %></h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p><%= msg %></p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary"> <%= button_text %> </button>
			</div>
		</div>
	</div>
</div>
</script>
