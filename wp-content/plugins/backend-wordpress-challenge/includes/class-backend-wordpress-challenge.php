<?php

/**
 * O arquivo que define a classe do plugin principal
 *
 * Uma classe que inclui atributos e funções usados em ambos os
 * lados, o site em si e a área administrativa.
 *
 * @link       https://rafael.business
 * @since      1.0.0
 *
 * @package    Backend_Wordpress_Challenge
 * @subpackage Backend_Wordpress_Challenge/includes
 */

/**
 * A classe do plugin principal.
 *
 * Usada para definir internacionalização, hooks específicos do admin e
 * do site (público).
 *
 * Também mantém o identificador único deste plugin, bem como a atual
 * versão do plugin.
 *
 * @since      1.0.0
 * @package    Backend_Wordpress_Challenge
 * @subpackage Backend_Wordpress_Challenge/includes
 * @author     Rafael dos Santos Pedro <contato@rafael.business>
 */
class Backend_Wordpress_Challenge {

	/**
	 * O loader responsável por manter e registrar todos os hooks do plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Backend_Wordpress_Challenge_Loader    $loader    Mantém e registra todos os hooks para o plugin.
	 */
	protected $loader;

	/**
	 * O identificador único deste plugin (nome do plugin).
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    A string usada para identificar exclusivamente este plugin.
	 */
	protected $plugin_name;

	/**
	 * A versão atual do plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    A versão atual do plugin.
	 */
	protected $version;

	/**
	 * Define a funcionalidade principal do plugin.
	 *
	 * Define o nome e a versão do plugin, que pode ser usada em todo o plugin.
	 * Carrega as dependências, define a localidade e também os hooks para a área administrativa e
	 * para o site (público).
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'BACKEND_WORDPRESS_CHALLENGE_VERSION' ) ) {
			$this->version = BACKEND_WORDPRESS_CHALLENGE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'backend-wordpress-challenge';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Carregua as dependências necessárias para este plugin.
	 *
	 * Inclui os seguintes arquivos que compõem o plugin:
	 *
	 * - Backend_Wordpress_Challenge_Loader. Orquestra os hooks do plugin.
	 * - Backend_Wordpress_Challenge_i18n. Define a funcionalidade de internacionalização.
	 * - Backend_Wordpress_Challenge_Admin. Define todos os hooks para a área administrativa.
	 * - Backend_Wordpress_Challenge_Public. Define todos os hooks para o lado público do site.
	 *
	 * Cria uma instância do loader que será usada para registrar os hooks
	 * com WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-backend-wordpress-challenge-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-backend-wordpress-challenge-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-backend-wordpress-challenge-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-backend-wordpress-challenge-public.php';

		$this->loader = new Backend_Wordpress_Challenge_Loader();

	}

	/**
	 * Define a localidade para este plugin para internacionalização.
	 *
	 * Usa a classe Backend_Wordpress_Challenge_i18n para definir o domínio e registrar o hook
	 * com WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Backend_Wordpress_Challenge_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Registra todos os hooks relacionados às funcionalidades da área de admin
	 * do plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Backend_Wordpress_Challenge_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'init', 					$plugin_admin, 'bwc_register_cursos_fuerza_post_type', 0 );
		$this->loader->add_action( 'add_meta_boxes', 		$plugin_admin, 'bwc_register_cursos_fuerza_meta_boxes' );
		$this->loader->add_action( 'save_post', 			$plugin_admin, 'bwc_save_cursos_fuerza_custom_fields' );
		$this->loader->add_filter( 'manage_cursos_fuerza_posts_columns', $plugin_admin, 'bwc_cursos_fuerza_columns' );
		$this->loader->add_action( 'manage_cursos_fuerza_posts_custom_column' , $plugin_admin, 'bwc_cursos_fuerza_column', 5, 2 );

	}

	/**
	 * Registra todos os hooks relacionados às funcionalidades do site (público)
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Backend_Wordpress_Challenge_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_filter( 'the_content', 		 $plugin_public, 'bwc_content_filter' );
		$this->loader->add_action( 'rest_api_init', 	 $plugin_public, 'bwc_register_rest_routes_cursos_fuerza' );

	}

	/**
	 * Executa o loader para executar todos os hooks com WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * O nome do plugin usado para identificá-lo exclusivamente dentro do contexto do
	 * WordPress e para definir a funcionalidade de internacionalização.
	 *
	 * @since     1.0.0
	 * @return    string    O nome do plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Referência à classe que orquestra os hooks do plugin.
	 *
	 * @since     1.0.0
	 * @return    Backend_Wordpress_Challenge_Loader    Orquestra os hooks do plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Recupera o número da versão do plugin.
	 *
	 * @since     1.0.0
	 * @return    string    O número da versão do plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
