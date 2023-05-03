<?php
    /**
     * @Filename: class-b2b_ajax_response.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     */

    namespace B2B\APP\HELPERS;

    /**
     * Description...
     *
     * @class B2bAjax__Response
     * @version 1.0
     * @since 1.0.0
     * @package b2b
     * @author Mustafa Shaaban
     */
	class B2b_Ajax_Response
	{

		public function __construct(bool $status, string $msg, array $data = [])
		{
			$this->response($status, $msg, $data);
		}

        /**
         * Description...
         *
         * @param bool   $status
         * @param string $msg
         * @param array  $data
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         */
		protected function response(bool $status, string $msg, array $data = []): void
        {
			$response = [
				'success' => $status,
				'msg'    => $msg,
			];

			if (!empty($data)) {
				$response['data'] = $data;
			}

			wp_send_json($response);
		}

	}
