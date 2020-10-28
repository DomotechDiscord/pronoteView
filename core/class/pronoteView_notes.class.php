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

class pronoteView_notes
{
    function htmlNotesByDays($eqlogic)
    {

        $idEquiPronote = $eqlogic->getconfiguration('idequip', 0);
        if ($idEquiPronote == 0) return;

        $html = "";

        $NoteByDate = pronoteView_panel::getinfo($idEquiPronote, 'NoteByDate');
        if (!(!$NoteByDate || !is_array($NoteByDate))) {
            $html .= '<div class="card"><div class="face front">';
            $html .= '<div class="widget-header-pronoteView"><i class="icon-bar-chart"></i><h3>Dernière(s) note(s)</h3>';
            $html .= '</div><div style="height:100%;" class="widget-content-pronoteView">';
            $html .= '<div style="width: 100%; height: 100%;"><div class="box-body no-padding">';
            $html .= '<table style="width: 100%; height: 100%;"><tbody><tr valign="top"><td class="tableauentete">Matière : </td><td class="tableauentete">Date : </td><td class="tableauentete">Note : </td></tr>';
            $c = 0;
            foreach ($NoteByDate as $note) {
                if (!isset($note)) continue;
                if ($c >= 15) continue;
                $date = pronoteView_utils::stamptodate($note['date']);
                $notemax = $note['note'];
                if ($note['max'] != 20 && $notemax != 'Abs') $notemax .= "/" . $note['max'];
                $html .= '<tr valign="top">';
                $html .= '<td>' . $note['matiere'] . '</td>';
                $html .= '<td>' . $date . '</td>';
                $html .= '<td>' . $notemax . '</td>';
                $html .= '</tr>';
                $c++;
            }
            $html .= '</tbody></table></div></div></div></div></div>';
        }

        $pronoteViewCmd = $eqlogic->getCmd(null, "htmlCode");
        $pronoteViewCmd->event($html);
        $pronoteViewCmd->save();
    }
}