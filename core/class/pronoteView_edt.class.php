<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class pronoteView_edt
{
    function htmledt7day($eqlogic)
    {
        $idEquiPronote = $eqlogic->getId();
        if ($idEquiPronote == 0) return;
        $html = "";

        $html .= '<div class="card"><div class="face front">';
        $html .= '<div class="widget-header-pronoteView"><i class="icon-bar-chart"></i><h3>Emploi du temps</h3>';
        $html .= '</div><div style="width: 100%; height: 100%;" class="widget-content-pronoteView"><div style="width: 100%; height: 100%;"><div class="box-body no-padding">';

        $varName = 'cours7D_'.$idEquiPronote;
        $divID = 'calendrier7Day_'.$idEquiPronote;

        $html .= '<link rel="stylesheet" href="/plugins/pronotlink/3rdparty/fullcalendar/core/main.css"></link>';
        $html .= '<link rel="stylesheet" href="/plugins/pronotlink/3rdparty/fullcalendar/daygrid/main.css"></link>';
        $html .= '<link rel="stylesheet" href="/plugins/pronotlink/3rdparty/fullcalendar/timegrid/main.css"></link>';
        $html .= '<link rel="stylesheet" href="/plugins/pronotlink/3rdparty/fullcalendar/bootstrap/main.css"></link>';
        $html .= '<script type="text/javascript" src="/plugins/pronotlink/3rdparty/fullcalendar/core/main.js"></script>';
        $html .= '<script type="text/javascript" src="/plugins/pronotlink/3rdparty/fullcalendar/daygrid/main.js"></script>';
        $html .= '<script type="text/javascript" src="/plugins/pronotlink/3rdparty/fullcalendar/timegrid/main.js"></script>';
        $html .= '<script type="text/javascript" src="/plugins/pronotlink/3rdparty/fullcalendar/bootstrap/main.js"></script>';
        $html .= '<script type="text/javascript" src="/plugins/pronoteView/desktop/js/edt7Day.js"></script>';
        $html .= '<div id="div_DashboardAlert" style="display: none;"></div><div id="'.$divID.'"></div></div>';
        $html .= '</div></div></div></div></div></div></div>';
        $html .= '<script type="text/javascript">func_get_AjaxEdt7("'.$divID.'","'.$idEquiPronote.'")</script>';

        $pronoteViewCmd = $eqlogic->getCmd(null, "htmlCode");
        $pronoteViewCmd->event($html);
        $pronoteViewCmd->save();
    }

    function htmledt1day($eqlogic)
    {
        $idEquiPronote = $eqlogic->getId();
        if ($idEquiPronote == 0) return;
        $html = "";

        $html .= '<div class="card"><div class="face front">';
        $html .= '<div class="widget-header-pronoteView"><i class="icon-bar-chart"></i><h3>Emploi du temps</h3>';
        $html .= '</div><div style="width: 100%; height: 100%;" class="widget-content-pronoteView"><div style="width: 100%; height: 100%;"><div class="box-body no-padding">';

        $varName = 'cours1D_'.$idEquiPronote;
        $divID = 'calendrier1Day_'.$idEquiPronote;

        $html .= '<link rel="stylesheet" href="/plugins/pronotlink/3rdparty/fullcalendar/core/main.css"></link>';
        $html .= '<link rel="stylesheet" href="/plugins/pronotlink/3rdparty/fullcalendar/daygrid/main.css"></link>';
        $html .= '<link rel="stylesheet" href="/plugins/pronotlink/3rdparty/fullcalendar/timegrid/main.css"></link>';
        $html .= '<link rel="stylesheet" href="/plugins/pronotlink/3rdparty/fullcalendar/bootstrap/main.css"></link>';
        $html .= '<script type="text/javascript" src="/plugins/pronotlink/3rdparty/fullcalendar/core/main.js"></script>';
        $html .= '<script type="text/javascript" src="/plugins/pronotlink/3rdparty/fullcalendar/daygrid/main.js"></script>';
        $html .= '<script type="text/javascript" src="/plugins/pronotlink/3rdparty/fullcalendar/timegrid/main.js"></script>';
        $html .= '<script type="text/javascript" src="/plugins/pronotlink/3rdparty/fullcalendar/bootstrap/main.js"></script>';
        $html .= '<script type="text/javascript" src="/plugins/pronoteView/desktop/js/edt1Day.js"></script>';
        $html .= '<div id="div_DashboardAlert" style="display: none;"></div><div id="'.$divID.'"></div></div>';
        $html .= '</div></div></div></div></div></div></div>';
        $html .= '<script type="text/javascript">func_get_AjaxEdt1("'.$divID.'","'.$idEquiPronote.'")</script>';

        $pronoteViewCmd = $eqlogic->getCmd(null, "htmlCode");
        $pronoteViewCmd->event($html);
        $pronoteViewCmd->save();
    }

    function ajaxEDT($eqlogic) {
        $idEquiPronote = $eqlogic->getconfiguration('idequip', 0);
        if ($idEquiPronote == 0) return;

        $cours = array();
        $timetables = pronoteView_panel::getinfo($idEquiPronote, 'timetable');

        foreach ($timetables['data']['timetable'] as $timetable) {
            $color = "#3788d8";
            $name = "";
            if ($timetable['isAway']) {
                $name = "[Prof. absent] \n";
                $color = "#a51818";
            } elseif ($timetable['isCancelled']) {
                $name = "[Classe absente] \n";
                $color = "#c16c13";
            } elseif ($timetable['isDetention']) {
                $name = "[Retenu] \n";
                $color = "#a142ea";
            }
            $name .= $timetable['subject'];
            $start = pronoteView_utils::stamptodatecalendar($timetable['from'], $idEquiPronote);
            $end = pronoteView_utils::stamptodatecalendar($timetable['to'], $idEquiPronote);
            $cour = array('title' => $name, 'start'=>$start, 'end'=>$end, 'color' => $color);
            array_push($cours, $cour);
        }

        $result = array('height'=>$eqlogic->getDisplay('height', 'auto'), 'EDT'=>$cours);
        return $result;
    }
}