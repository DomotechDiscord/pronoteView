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

class pronoteView_utils
{
    public static function stamptodate($_timestamp) {
        $_timestamp = $_timestamp/1000;
        $date = date("d/m",$_timestamp);
        return $date;
    }

    public static function stamptodateheuremin($_timestamp) {
        $_timestamp = $_timestamp/1000;
        $date = date("d/m à H\hi",$_timestamp);
        return $date;
    }

    public static function stamptodatecalendar($_timestamp, $eqLogic_id) {
        $_timestamp = $_timestamp/1000;

        $eqLogic = eqLogic::byId($eqLogic_id);
        $decalage = $eqLogic->getConfiguration('EDTDecalage', 0);

        $_timestamp = $_timestamp-$decalage;

        $date = date("Y-m-d H:i:s",$_timestamp);
        return $date;
    }

    public static function stamptodateheureScenario($_timestamp, $eqLogic) {
        $_timestamp = $_timestamp/1000;
        $decalage = $eqLogic->getConfiguration('EDTDecalage', 0);
        $_timestamp = $_timestamp-$decalage;

        $date = date("Hi",$_timestamp);
        return $date;
    }

    public static function stamptodateheure($_timestamp, $eqLogic) {
        $_timestamp = $_timestamp/1000;
        $decalage = $eqLogic->getConfiguration('EDTDecalage', 0);
        $_timestamp = $_timestamp-$decalage;

        $date = date("H:i",$_timestamp);
        return $date;
    }

    public static function evalicon($_evalicon) {
        if ($_evalicon == "A+" || $_evalicon == "TBM") {
            return '<svg style="width:20px;height:20px;"><circle cx="50%" cy="50%" r="9px" stroke-width="2px" fill="#008000" stroke="#008000"></circle>
            <text x="50%" y="50%" dy="0.35em" fill="#FFFFFF" style="font-size: 1.5em;" text-anchor="middle">+</text></svg>';
        } else if ($_evalicon == "A" || $_evalicon == "MS") {
            return '<svg style="width:20px;height:20px;"><circle cx="50%" cy="50%" r="9px" stroke-width="2px" fill="#008000" stroke="#008000"></circle></svg>';
        }else if ($_evalicon == "B") {
            return '<svg style="width:20px;height:20px;"><circle cx="50%" cy="50%" r="9px" stroke-width="2px" fill="#45B851" stroke="#45B851"></circle></svg>';
        } else if ($_evalicon == "C" || $_evalicon == "MF") {
            return '<svg style="width:20px;height:20px;"><circle cx="50%" cy="50%" r="9px" stroke-width="2px" fill="#FFDA01" stroke="#FFDA01"></circle></svg>';
        } else if ($_evalicon == "E" || $_evalicon == "MI") {
            return '<svg style="width:20px;height:20px;"><circle cx="50%" cy="50%" r="9px" stroke-width="2px" fill="#F80A0A" stroke="#F80A0A"></circle></svg>';
        } else if ($_evalicon == "Ab" || $_evalicon == "Abs") {
            return '<svg style="width:20px;height:20px;"><circle cx="50%" cy="50%" r="9px" stroke-width="2px" fill="#0040FF" stroke="#0040FF"></circle></svg>';
        } else if ($_evalicon == "Nr") {
            return '<svg style="width:20px;height:20px;"><circle cx="50%" cy="50%" r="9px" stroke-width="2px" fill="#F06246" stroke="#F06246"></circle></svg>';
        } else if ($_evalicon == "NE") {
            return '<svg style="width:20px;height:20px;"><circle cx="50%" cy="50%" r="9px" stroke-width="2px" fill="#FFFFFF" stroke="#FFFFFF"></circle></svg>';
        } else if ($_evalicon == "Dsp") {
            return '<svg style="width:20px;height:20px;"><circle cx="50%" cy="50%" r="9px" stroke-width="2px" fill="#04F4D4" stroke="#04F4D4"></circle></svg>';
        } else if ($_evalicon == "D") {
            return '<svg style="width:20px;height:20px;"><circle cx="50%" cy="50%" r="9px" stroke-width="2px" fill="#FF880F" stroke="#FF880F"></circle></svg>';
        }
        return $_evalicon;
    }
}