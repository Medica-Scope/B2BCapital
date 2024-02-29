<?php
use NH\APP\HELPERS\Nh_Hooks;
/**
 * @Filename: opportunity-response.php
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 7/14/2023
 */
?>

<script type="text/template" id="ninja_modal_opp_request_success">
    <div class="modal fade" id="opportunitySuccess" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="opportunitySuccessLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content pt-0">
            <div class="modal-header">
                <span class="icon-wrapper">
                    <dotlottie-player
                        src="<?= Nh_Hooks::PATHS['public']['vendors']; ?>/css/lottiefiles/verifyed-verified-sign.json"
                        background="transparent" speed="1" style="width: 160px; height: 160px" direction="1" mode="normal" loop
                        autoplay>
                    </dotlottie-player>
                    
                </span>
            </div>
                <div class="modal-body">
                    <p><%= msg %></p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-dismiss="modal"> <%= button_text %></button>
                </div>
            </div>
        </div>
    </div>

</script>