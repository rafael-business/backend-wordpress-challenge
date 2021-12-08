<?php
/**
 *
 * @link              https://rafael.business
 * @since             1.0.0
 * @package           Backend_Wordpress_Challenge
 *
 * @wordpress-plugin
 * Plugin Name:       Backend Wordpress Challenge
 * Plugin URI:        https://github.com/rafael-business/backend-wordpress-challenge
 * Description:       Desafio WordPress para programadores back-end interessados em trabalhar na Fuerza.
 * Version:           1.0.0
 * Author:            Rafael dos Santos Pedro
 * Author URI:        https://rafael.business
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       backend-wordpress-challenge
 * Domain Path:       /languages
 */

// Se este arquivo for chamado diretamente, aborte.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Versão atual do plugin.
 */
define( 'BACKEND_WORDPRESS_CHALLENGE_VERSION', '1.0.0' );

/**
 * O código executado durante a ativação do plugin.
 * Esta ação está documentada em includes/class-backend-wordpress-challenge-activator.php
 */
function activate_backend_wordpress_challenge() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-backend-wordpress-challenge-activator.php';
	Backend_Wordpress_Challenge_Activator::activate();
}

register_activation_hook( __FILE__, 'activate_backend_wordpress_challenge' );

/**
 * A classe do plugin principal que é usada para definir a internacionalização,
 * hooks específicos do admin e hooks do site (público).
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-backend-wordpress-challenge.php';

/**
 * Começa a execução do plugin.
 *
 * Uma vez que tudo dentro do plugin é registrado por meio de hooks,
 * iniciar o plugin a partir deste ponto no arquivo
 * não afeta o ciclo de vida da página.
 *
 * @since    1.0.0
 */
function run_backend_wordpress_challenge() {

	$plugin = new Backend_Wordpress_Challenge();
	$plugin->run();

}
run_backend_wordpress_challenge();
