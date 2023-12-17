<?php
use NH\APP\MODELS\FRONT\MODULES\Nh_Search;

// use function NH\TrimString;

/**
 * Filename: search-ajax.php
 * Description:
 * User: Ahmed Gamal
 * Date: 8/10/2023
 */

//    global $args;

$posts = $args['data']['posts'];
$count = $args['data']['count'];
$key = $args['data']['key'];

?>

<div class="search-result">
	<p>
		<?= sprintf( __( 'Search results for: `%s`', 'ninja' ), $key ); ?>
	</p>
	<div class="search-data">
		<?php
		if ( ! empty( $posts ) ) {
			?>
			<div class="search-success" data-page="2" data-last="<?= $count > 10 ? 'false' : 'true' ?>">
				<ul>
					<?php
					foreach ( $posts as $post ) {
						if ( $post['type'] == 'post' ) {
							?>
							<li>
								<a class="result-row" href="<?= $post['permalink'] ?>">
									<h4 class="result-head">
										<?= $post['title'] ?>
									</h4>
								</a>
							</li>
							<?php
						} elseif ( $post['type'] == 'term' ) {
							?>
							<li>
								<a class="result-row" href="<?= home_url( $post['slug'] ) ?>">
									<h4 class="result-head">
										<?= $post['title'] ?>
									</h4>
								</a>
							</li>
							<?php
						}
					}
					?>
				</ul>
			</div>
		</div>
		<?php
		} else {
			?>
		<div class="search-empty">
			<div class="result">
				<p><i class="fas fal fa-info-circle"></i>
					<?= __( 'Sorry! No results found, please try another way.', 'ninja' ) ?>
				</p>
			</div>
		</div>
		<?php
		}
		?>
</div>