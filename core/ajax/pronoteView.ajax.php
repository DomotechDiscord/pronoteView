<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL , "fr_FR" );
date_default_timezone_set("Europe/Paris");

try {
    require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
    include_file('core', 'authentification', 'php');

    switch (init('action')) {
        case 'getajaxEDT':
            $idEquiPronote = eqLogic::byid(init('idEquiPronote'));
            $data = pronoteView_edt::ajaxEDT($idEquiPronote);
            ajax::success($data);
            break;
        default:
            break;
    }

    throw new Exception(__('Aucune méthode correspondante à : ', __FILE__) . init('action'));
    /*     * *********Catch exeption*************** */
} catch (Exception $e) {
    ajax::error(displayException($e), $e->getCode());
}

