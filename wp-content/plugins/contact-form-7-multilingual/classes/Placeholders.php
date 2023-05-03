<?php

namespace WPML\CF7;

use WPML\FP\Lens;
use WPML\FP\Obj;
use WPML\FP\Str;
use WPML\LIB\WP\Hooks;

use function WPML\FP\compose;
use function WPML\FP\spreadArgs;

class Placeholders implements \IWPML_Backend_Action, \IWPML_Frontend_Action {

	/**
	 * @return void
	 */
	public function add_hooks() {
		Hooks::onFilter( 'icl_job_elements', 10, 2 )
			->then( spreadArgs( [ $this, 'fixTagForTranslation' ] ) );
	}

	/**
	 * @param array $elements
	 * @param mixed $postId
	 *
	 * @return array
	 */
	public function fixTagForTranslation( $elements, $postId ) {
		if ( Constants::POST_TYPE !== get_post_type( $postId ) ) {
			return $elements;
		}

		$fieldTypes = wp_list_pluck( $elements, 'field_type' );
		$index      = array_search( 'field-_form-0', $fieldTypes, true );
		if ( false !== $index ) {
			// $lensOnDecodedFieldData :: callable -> callable
			$lensOnDecodedFieldData = compose( Obj::lensPath( [ $index, 'field_data' ] ), Lens::isoBase64Decoded() );

			// $addEqualSignOnPlaceholder :: string -> string
			$addEqualSignOnPlaceholder = Str::replace( 'placeholder "', 'placeholder="' );

			return Obj::over( $lensOnDecodedFieldData, $addEqualSignOnPlaceholder, $elements );
		}

		return $elements;
	}

}
