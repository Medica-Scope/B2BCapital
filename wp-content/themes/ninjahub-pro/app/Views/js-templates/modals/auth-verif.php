<?php
/**
 * @Filename: auth-verif.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 7/14/2023
 */
?>

<script type="text/template" id="ninja_modal_auth_verif">
	<div class="modal" id="authVerifySuccess" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
		 aria-labelledby="authVerifySuccessLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header justify-content-center">
					<h1 class="modal-title fs-5" id="authVerifySuccessLabel">Account Authentication</h1>
				</div>
				<div class="modal-body justify-content-center">
					<p><%= msg %></p>
				</div>
				<!-- <div class="modal-footer justify-content-center">
					<a href="<%= redirect_url %>" class="btn btn-success btn-"> <%= redirect_text %> </a>
				</div> -->
			</div>
		</div>
	</div>
</script>
