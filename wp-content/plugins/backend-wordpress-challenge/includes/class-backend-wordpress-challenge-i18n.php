<?php

/**
 * Defina a funcionalidade de internacionalização
 *
 * @link       https://rafael.business
 * @since      1.0.0
 *
 * @package    Backend_Wordpress_Challenge
 * @subpackage Backend_Wordpress_Challenge/includes
 */

/**
 * Carrega e define os arquivos de internacionalização para este plugin
 * para que esteja pronto para tradução.
 *
 * @since      1.0.0
 * @package    Backend_Wordpress_Challenge
 * @subpackage Backend_Wordpress_Challenge/includes
 * @author     Rafael dos Santos Pedro <contato@rafael.business>
 */
class Backend_Wordpress_Challenge_i18n {


	/**
	 * Carregue o domínio de texto do plugin para tradução.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'backend-wordpress-challenge',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
