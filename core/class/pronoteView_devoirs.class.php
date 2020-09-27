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

class pronoteView_devoirs
{
    function htmldevoirs($eqlogic)
    {

        $idEquiPronote = $eqlogic->getconfiguration('idequip', 0);
        if ($idEquiPronote == 0) return;

        $html = "";

        $homeworks = pronoteView_panel::getinfo($idEquiPronote, 'homeworks');
        if (!(!$homeworks || !is_array($homeworks))) {
            $html .= '<div class="card"><div class="face front">';
            $html .= '<div class="widget-header-pronoteView"><i class="icon-bar-chart"></i><h3>Prochains devoirs</h3>';
            $html .= '</div><div  style="height:100%;" class="widget-content-pronoteView">';
            $html .= '<div c style="width: 100%; height: 100%;"><div class=" box-body no-padding">';
            $html .= '<table style="width: 100%; height: 100%;" class="tabledevoirs"><tbody><tr valign="top"><td class="tableauentete">Matière : </td><td class="tableauentete">Tache : </td><td class="tableauentete">A faire pour :</td></tr>';

            $a = 1;
            foreach ($homeworks['data']['homeworks'] as $homework) {
                if ($a <= 15) {
                    $until = pronoteView_utils::stamptodate($homework['for']);
                    $html .= '<tr valign="top">';
                    $html .= '<td>' . $homework['subject'] . '</td>';
                    $html .= '<td>' . $until . '</td>';
                    $html .= '<td>' . $homework['description'] . '</td>';
                    $html .= '</tr>';
                    $a++;
                }
            }
            $html .= '</tbody></table></div></div></div></div></div></div></div>';
        }

        $pronoteViewCmd = $eqlogic->getCmd(null, "htmlCode");
        $pronoteViewCmd->event($html);
        $pronoteViewCmd->save();
    }
}