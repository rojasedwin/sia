<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['js_version'] =  rand(0,999999);
$config['js_admin_version'] =   rand(0,999999);
$config['js_min_version'] = ""; //"/min";
$config['css_version'] =  rand(0,999999);
$config['css_admin_version'] = /*5.4;*/ rand(0,999999); //5.2; //rand(0,999999);

$config['css_min_version'] = ""; //min
$config['v3css_min'] = ""; //.min
$config['v3js_min'] = ""; //.min
//Ahorta estoy en test
/*  MENU ADMINISTRAODRES */
$config['menu_admin_app']['dashboard']['content'] = "Home";
$config['menu_admin_app']['dashboard']['icon'] = "star";

//$config['menu_admin_app']['usuarios']['content'] = "Usuarios";
//$config['menu_admin_app']['usuarios']['icon'] = "users";

$config['menu_admin_app']['proveedores']['content'] = "Proveedores";
$config['menu_admin_app']['proveedores']['icon'] = "fas fa-columns";

$config['menu_admin_app']['laboratorios']['content'] = "Laboratorios";
$config['menu_admin_app']['laboratorios']['icon'] = "fas fa-columns";

$config['menu_admin_app']['condiciones']['content'] = "Condiciones";
$config['menu_admin_app']['condiciones']['icon'] = "fas fa-columns";

$config['menu_admin_app']['realizarpedido']['content'] = "Realizar Pedido";
$config['menu_admin_app']['realizarpedido']['icon'] = "fas fa-columns";


$config['menu_admin_app']['pedidos']['content'] = "Pedidos";
$config['menu_admin_app']['pedidos']['icon'] = "fas fa-list";


$config['menu_externo_app']['provexterno']['content'] = "Inicio";
$config['menu_externo_app']['provexterno']['icon'] = "home";


$config['error_prefix_message'] = '<div class="alert alert-danger alert-sm"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
$config['error_suffix_message'] = '</div>';

$config['success_prefix_message'] = '<div class="alert alert-success alert-sm"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
$config['success_suffix_message'] = '</div>';

$config['warning_prefix_message'] = '<div class="alert alert-warning alert-sm"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
$config['warning_suffix_message'] = '</div>';

$config['bootstrap']['col-12'] = 'col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12';
$config['bootstrap']['col-11'] = 'col-xl-11 col-lg-11 col-md-11 col-sm-11 col-xs-12';
$config['bootstrap']['col-11_total'] = 'col-xl-11 col-lg-11 col-md-11 col-sm-11 col-xs-11';
$config['bootstrap']['col-10'] = 'col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-12';
$config['bootstrap']['col-10_total'] = 'col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10';
$config['bootstrap']['col-9'] = 'col-xl-9 col-lg-9 col-md-9 col-sm-9 col-xs-12';
$config['bootstrap']['col-9_total'] = 'col-xl-9 col-lg-9 col-md-9 col-sm-9 col-xs-9';
$config['bootstrap']['col-8'] = 'col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-12';

$config['bootstrap']['col-8_total'] = 'col-lg-8 col-md-8 col-sm-8 col-xs-8';
$config['bootstrap']['col-7'] = 'col-lg-7 col-md-7 col-sm-7 col-xs-12';
$config['bootstrap']['col-7_total'] = 'col-lg-7 col-md-7 col-sm-7 col-xs-7';
$config['bootstrap']['col-6'] = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12';
$config['bootstrap']['col-6_total'] = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6';
$config['bootstrap']['col-5'] = 'col-lg-5 col-md-5 col-sm-5 col-xs-12';
$config['bootstrap']['col-5_total'] = 'col-lg-5 col-md-5 col-sm-5 col-xs-5';
$config['bootstrap']['col-4'] = 'col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12';
$config['bootstrap']['col-4_tablet'] = 'col-xl-4 col-lg-4 col-md-4 col-sm-7 col-xs-12';
$config['bootstrap']['col-4_movil'] = 'col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12';
$config['bootstrap']['col-4_total'] = 'col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4';
$config['bootstrap']['col-3'] = 'col-lg-3 col-md-3 col-sm-3 col-xs-12';
$config['bootstrap']['col-3_tablet'] = 'col-lg-3 col-md-3 col-sm-6 col-xs-12';
$config['bootstrap']['col-3_total'] = 'col-lg-3 col-md-3 col-sm-3 col-xs-3';
$config['bootstrap']['col-3_red'] = 'col-lg-3 col-md-3 col-sm-3 col-xs-6';
$config['bootstrap']['col-2'] = 'col-lg-2 col-md-2 col-sm-2 col-xs-12';
$config['bootstrap']['col-2_intereses'] = 'col-xl-2 col-lg-2 col-md-2 col-sm-3 col-xs-12'; //Es especial para los intereses cliente
$config['bootstrap']['col-2_tablet'] = 'col-lg-2 col-md-2 col-sm-5 col-xs-12';
$config['bootstrap']['col-2_red'] = 'col-lg-2 col-md-2 col-sm-2 col-xs-6';
$config['bootstrap']['col-2_total'] = 'col-lg-2 col-md-2 col-sm-2 col-xs-2';
$config['bootstrap']['col-1'] = 'col-lg-1 col-md-1 col-sm-1 col-xs-12';
$config['bootstrap']['col-1_total'] = 'col-lg-1 col-md-1 col-sm-1 col-xs-1';
$config['bootstrap']['col-1_tablet'] = 'col-lg-1 col-md-1 col-sm-1 col-xs-6';
