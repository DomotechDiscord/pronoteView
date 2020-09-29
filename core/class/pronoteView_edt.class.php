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
        $idEquiPronote = $eqlogic->getconfiguration('idequip', 0);
        if ($idEquiPronote == 0) return;
        $html = "";

        $html .= '<div class="card"><div class="face front">';
        $html .= '<div class="widget-header-pronoteView"><i class="icon-bar-chart"></i><h3>Emploi du temps</h3>';
        $html .= '</div><div style="width: 100%; height: 100%;" class="widget-content-pronoteView"><div style="width: 100%; height: 100%;"><div class="box-body no-padding">';
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

        sendVarToJS('cours7D'.$idEquiPronote, $cours);
        $html .= '<script>var "cours7D_'.$idEquiPronote.'" = jQuery.parseJSON("'.json_encode($cours).'")</script>';
        $html .= '<div id="div_DashboardAlert" style="display: none;"></div><div id="calendrier7Day"></div></div>';
        $html .= '</div></div></div></div></div></div></div>';

        $pronoteViewCmd = $eqlogic->getCmd(null, "htmlCode");
        $pronoteViewCmd->event($html);
        $pronoteViewCmd->save();
    }
}