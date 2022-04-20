<?php
    include( './include/config.php' );
    include( './libs/session.php' );
    include( './libs/DbConnector.php' );
    include( './controllers/UserController.php' );
    include( './controllers/CatalogController.php' );
    include( './models/CatalogModel.php' );
    include( './models/UserModel.php' );
    
    global $user_controller;
    $user_controller = UserController::getIstance();
    global $catalog_controller;
    $catalog_controller = CatalogController::getIstance();

 	$user_valid_actions=array('login', 'logout', 'insert', 'regenerate');
    $us_action = isset( $_GET[ 'usaction' ] ) && in_array( $_GET[ 'usaction' ], $user_valid_actions ) ? $_GET[ 'usaction' ] : 'login';
    $user_controller->$us_action();

    if ($us_action != 'insert' && $us_action != 'regenerate') {
    	$valid_actions = array( 'index', 'detail', 'create', 'edit', 'delete' );
    	$action = isset( $_GET[ 'action' ] ) && in_array( $_GET[ 'action' ], $valid_actions ) ? $_GET[ 'action' ] : 'index';
    	// exec requested action
    	$catalog_controller->$action();
    }