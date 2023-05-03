<?php
	/**
	 * @Filename: class-b2b_admin.php
	 * @Description:
	 * @User: NINJA MASTER - Mustafa Shaaban
	 * @Date: 1/4/2023
	 */


    namespace B2B\APP\MODELS\ADMIN;

    use B2B\APP\CLASSES\B2b_Init;
    use B2B\APP\HELPERS\B2b_Hooks;
    use B2B\B2b;

    /**
	 * Description...
	 *
	 * @class B2b_Admin
	 * @version 1.0
	 * @since 1.0.0
	 * @package B2B
	 * @author APPENZA - Mustafa Shaaban
	 */
	class B2b_Admin {

        /**
         * @var \B2B\APP\HELPERS\B2b_Hooks
         */
		private B2b_Hooks $hooks;


        /**
         * @param \B2B\APP\HELPERS\B2b_Hooks $hooks
         */
		public function __construct( B2b_Hooks $hooks )
		{
			$this->hooks = $hooks;
			$this->actions();
			$this->filters();
			B2b_Init::get_instance()->run( 'admin' );
		}

		public function actions(): void
        {
			$this->hooks->add_action( 'admin_enqueue_scripts', $this, 'enqueue_styles' );
			$this->hooks->add_action( 'admin_enqueue_scripts', $this, 'enqueue_scripts' );
			$this->hooks->run();
		}

		public function filters()
		{

		}

		public function enqueue_styles(): void
        {
//			$this->hooks->add_style( B2b::_DOMAIN_NAME.'-admin-style-main', B2b_Hooks::PATHS['admin']['css'] . '/style' );
		}

		public function enqueue_scripts(): void
        {
//			$this->hooks->add_script( B2b::_DOMAIN_NAME.'-admin-script-main', B2b_Hooks::PATHS['admin']['js'] . '/main', [ 'jquery' ] );
//			$this->hooks->add_localization(B2b::_DOMAIN_NAME.'-admin-script-main', 'b2bGlobals', array(
//				'domain_key'  => B2b::_DOMAIN_NAME,
//				'ajaxUrl' => admin_url('admin-ajax.php'),
//			));
			$this->hooks->run();

		}

	}
