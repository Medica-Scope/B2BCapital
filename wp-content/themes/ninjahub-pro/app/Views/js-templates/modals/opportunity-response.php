<?php
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
            <div class="modal-content">
            <div class="modal-header">
                    <div class="circle">
                        <i class="bbc-check"></i>
                        </div>
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