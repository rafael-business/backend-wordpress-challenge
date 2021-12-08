<?php
/**
 * Formulário de interesse.
 */

$bwc_data_limite = esc_attr( get_post_meta( get_the_ID(), 'bwc_data_limite', true ) );
$insc_abertas = strtotime( $bwc_data_limite ) > time() ? true : false;

$link_insc = esc_attr( get_post_meta( get_the_ID(), 'bwc_link_insc', true ) );

$html = $insc_abertas ? '
    <h3>Tenho Interesse</h3>
    <form id="confirmar_interesse" class="insc" method="POST" action="'. get_rest_url( null, 'cursos-fuerza/insert-interessado' ) .'">
        <div class="column">
            <label for="nome">Nome</label>
            <input id="nome" name="nome" type="text">
        </div>
        <div class="column">
            <label for="email">E-mail</label>
            <input id="email" name="email" type="email">
        </div>
        <div class="column">
            <input type="hidden" id="curso_id" name="curso_id" value="'. get_the_ID() .'">
            <input id="confirmar" type="submit" value="Confirmar Interesse">
            <div id="loading"><img src="'. plugin_dir_url( __FILE__ ) .'../img/loading.gif"></div>
        </div>
    </form>
    <div id="msg_status"></div>
' : '
    <a class="button confira" href="'. $link_insc .'">Inscrições encerradas. Confira a página do curso.</a>
';

return $html;
