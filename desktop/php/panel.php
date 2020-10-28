<?php

        $eqlogic = Eqlogic::byid(1302);
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
        $html .= pronoteView_utils::sendVarToJSString($varName, $cours);
        $html .= '<script>func_note_button("'.$divID.'","'.$varName.'");</script>';
        $html .= '<div id="div_DashboardAlert" style="display: none;"></div><div id="'.$divID.'"></div></div>';
        $html .= '</div></div></div></div></div></div></div>';


        echo $html;