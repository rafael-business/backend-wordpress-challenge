<?php

/**
 * Registre todas as ações e filtros para o plugin
 *
 * @link       https://rafael.business
 * @since      1.0.0
 *
 * @package    Backend_Wordpress_Challenge
 * @subpackage Backend_Wordpress_Challenge/includes
 */

/**
 * Mantém uma lista de todos os hooks que estão registrados, em todo
 * o plugin, e os registra com a API do WordPress. Chama a
 * função de execução para executar a lista de ações e filtros.
 *
 * @package    Backend_Wordpress_Challenge
 * @subpackage Backend_Wordpress_Challenge/includes
 * @author     Rafael dos Santos Pedro <contato@rafael.business>
 */
class Backend_Wordpress_Challenge_Loader {

	/**
	 * O conjunto de ações registradas com WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $actions    As ações registradas com WordPress para disparar quando o plugin é carregado.
	 */
	protected $actions;

	/**
	 * O conjunto de filtros registrados com WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $filters    Os filtros registrados com WordPress para disparar quando o plugin é carregado.
	 */
	protected $filters;

	/**
	 * Inicializa as coleções usadas para manter as ações e filtros.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->actions = array();
		$this->filters = array();

	}

	/**
	 * Adiciona uma nova ação à coleção a ser registrada no WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             O nome da ação do WordPress que está sendo registrada.
	 * @param    object               $component        Uma referência à instância do objeto no qual a ação é definida.
	 * @param    string               $callback         O nome da definição da função no $componente.
	 * @param    int                  $priority         Opcional. A prioridade na qual a função deve ser disparada. O padrão é 10.
	 * @param    int                  $accepted_args    Opcional. O número de argumentos que devem ser passados para o retorno de $callback. O padrão é 1.
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Adiciona um novo filtro à coleção para ser registrado no WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             O nome do filtro do WordPress que está sendo registrado.
	 * @param    object               $component        Uma referência à instância do objeto no qual o filtro é definido.
	 * @param    string               $callback         O nome da definição da função no $componente.
	 * @param    int                  $priority         Opcional. A prioridade na qual a função deve ser disparada. O padrão é 10.
	 * @param    int                  $accepted_args    Opcional. O número de argumentos que devem ser passados para o retorno de $callback. O padrão é 1.
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Uma função de utilidade que é usada para registrar as ações e hooks em uma única
	 * coleção.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    array                $hooks            A coleção de hooks que está sendo registrada (ou seja, ações ou filtros).
	 * @param    string               $hook             O nome do filtro do WordPress que está sendo registrado.
	 * @param    object               $component        Uma referência à instância do objeto no qual o filtro é definido.
	 * @param    string               $callback         O nome da definição da função no $component.
	 * @param    int                  $priority         A prioridade na qual a função deve ser disparada.
	 * @param    int                  $accepted_args    O número de argumentos que devem ser passados para o $callback.
	 * @return   array                                  A coleção de ações e filtros registrados com WordPress.
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;

	}

	/**
	 * Registra os filtros e ações com o WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

	}

}
