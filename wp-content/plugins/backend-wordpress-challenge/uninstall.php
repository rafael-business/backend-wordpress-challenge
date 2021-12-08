<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * Esta classe define todo o código necessário para rodar durante a desinstalação do plugin.
 *
 * @since      1.0.0
 * @package    Backend_Wordpress_Challenge
 * @author     Rafael dos Santos Pedro <contato@rafael.business>
 */
class Backend_Wordpress_Challenge_Uninstall {

	/**
	 * Exclui a tabela e os dados dos interessados nos cursos.
	 *
	 * @since    1.0.0
	 */
	public static function uninstall() {

		global $wpdb;

		$table_name = $wpdb->prefix . 'cursos_interessados';

		$sql = "DROP TABLE IF EXISTS $table_name";
		$wpdb->query( $sql );

		delete_option( 'bwc_db_version' );

	}

}
