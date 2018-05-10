<?php

//if(is_admin()){
//    // Add Scripts
//    function tl_admin_add_style(){
//        wp_enqueue_style('tl-admin-style', plugins_url().'/my-todo-list/assets/css/style-admin.css', '', null, false);
//    }
//    add_action('admin_init', 'tl_admin_add_style');
//
//
//    function tl_admin_add_scripts(){
//        wp_enqueue_script('tl-admin-script', plugins_url() .'/my-todo-list/assets/js/main-admin.js', array(), null, 'all');
//    }
//    add_action('admin_init', 'tl_admin_add_scripts');
//
//
//
//}
//else {
//    // Add Scripts
//    function tl_add_style(){
//        wp_enqueue_style('tl-main-style', plugins_url().'/my-todo-list/assets/css/style.css', '', null, false);
//    }
//    add_action('wp_enqueue_scripts', 'tl_add_style');
//
//
//    function tl_add_scripts(){
//        wp_enqueue_script('tl-main-script', plugins_url() .'/my-todo-list/assets/js/main.js', array(), null, 'all');
//    }
//    add_action('wp_enqueue_scripts', 'tl_add_scripts');
//
//}