<?php
/**
 * @package Devops_challenge_Junior
 * @version 1.1
 */
/*
Plugin Name: Devops challenge Júnior
Plugin URI: https://apiki.com/
Description: Sabe de nada, inocente! Ordinária!!
Author: Apiki WordPress
Version: 1.1
*/

$global_lyrics = <<<TXT
	Pau que nasce torto nunca se endireita
	Menina que requebra a mãe pega na cabeça
	Pau que nasce torto nunca se endireita
	Menina que requebra a mãe pega na cabeça
	Domingo ela não vai (vai, vai)
	Domingo ela não vai não (vai, vai, vai)
	Olha, domingo ela não vai (vai, vai)
	Domingo ela não vai não (vai, vai, vai)
	O pau que nasce torto nunca se endireita
	Menina que requebra a mãe pega na cabeça
	Pau que nasce torto nunca se endireita
	Menina que requebra a mãe pega na cabeça
	Segure o tchan
	Amare o tchan
	Segure o tchan tchan tchan tchan
	Depois de nove meses você vê o resultado
	Esse é o Gera Samba arrebentando no pedaço
	Joga ela no meio, mete em cima, mete embaixo
	TXT;


function devops_challenge() {
	$chosen = apiki_segura_o_tchan();
	$lang = 'lang="en"';

	if ($chosen) {
		if ( 'en_' !== substr( get_user_locale(), 0, 3 ) ) {
			$lang = 'lang="' . substr( get_user_locale(), 0, 2 ) . '"';
		}
		
		printf(
			'<div id="devops">%s %s, by Apiki WordPress: %s</div>',
			__( 'O texto é:', 'devops-challenge-languages' ),
			__( $chosen, 'devops-challenge-languages' ),
			$lang
		);
	}
	else {
		error_log( 'Nenhuma frase encontrada!' );
	}
}
add_action( 'init', 'devops_challenge' );


function devops_challenge_languages() {
	load_textdomain(
		'devops-challenge-languages', 
		plugin_dir_path(__FILE__) . 'languages/' . get_user_locale() . '.mo'
	);

	if ( ! file_exists( plugin_dir_path(__FILE__) . 'languages/en_US.mo' ) ) {
		error_log( 'Arquivo de idioma não encontrado!' );
  	}

  	if ( ! is_textdomain_loaded( 'devops-challenge-languages' ) ) {
		error_log( 'Falha ao carregar o text domain!' );
	}
}
add_action( 'plugins_loaded', 'devops_challenge_languages' );


function devops_challenge_css() {
	wp_enqueue_style(
		'devops_challenge_style', 
		plugin_dir_url( __FILE__ ) . 'css/style.css', 
		false, 
		'1.0'
	);
}
add_action( 'admin_enqueue_scripts', 'devops_challenge_css' );


function apiki_segura_o_tchan() {
	global $global_lyrics;
	$lyrics = '';

	if (! empty($global_lyrics)) {
		$lyrics = explode( PHP_EOL, $global_lyrics );

		if (count($lyrics) > 0) {
			return wptexturize( $lyrics[ mt_rand( 0, count( $lyrics ) - 1 ) ] );
		}
	}
		
	return 'Nenhuma frase encontrada';
}