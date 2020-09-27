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

class pronoteView_panel {

    public static function getinfo($_eqlogicsid, $_choix) {

        $eqLogic = eqLogic::byId($_eqlogicsid);

        switch ($_choix) {
            case 'marks':
                $cmd = $eqLogic->getCmd('info', "JsonNotes");
                break;
            case 'timetable':
                $cmd = $eqLogic->getCmd('info', "JsonEDT");
                break;
            case 'periods':
                $cmd = $eqLogic->getCmd('info', "JsonPeriods");
                break;
            case 'homeworks':
                $cmd = $eqLogic->getCmd('info', "JsonDevoirs");
                break;
            case 'absences':
                $cmd = $eqLogic->getCmd('info', "JsonAbsences");
                break;
            case 'reports':
                break;
            case 'competences':
                $cmd = $eqLogic->getCmd('info', "JsonComp");
                break;
            case 'NoteByDate':
                $cmd = $eqLogic->getCmd('info', "JsonNoteByDate");
                break;
        }
        if (isset($cmd)) {
            $json = $cmd->execCmd();
            return json_decode($json, true);
        } elseif (isset($result)) {
            return $result;
        }
    }
}