<?php
/**
 * Acontece durante a ativação do plugin
 *
 * @link       https://rafael.business
 * @since      1.0.0
 *
 * @package    Backend_Wordpress_Challenge
 * @subpackage Backend_Wordpress_Challenge/includes
 */

/**
 * Esta classe define todo o código necessário para rodar durante a ativação do plugin.
 *
 * @since      1.0.0
 * @package    Backend_Wordpress_Challenge
 * @subpackage Backend_Wordpress_Challenge/includes
 * @author     Rafael dos Santos Pedro <contato@rafael.business>
 */
class Backend_Wordpress_Challenge_Activator {

	/**
	 * Cria a tabela necessária para armazenar os dados
	 * dos interessados em fazer os cursos.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		global $wpdb;

		$table_name = $wpdb->prefix . 'cursos_interessados';
		
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			curso_id mediumint(9) NOT NULL,
			data_insc datetime DEFAULT NOW() NOT NULL,
			nome tinytext NOT NULL,
			email varchar(55) DEFAULT '' NOT NULL,
			PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		add_option( 'bwc_db_version', '1.0' );

	}

}
