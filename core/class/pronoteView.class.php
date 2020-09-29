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
require_once __DIR__  . '/../../../../core/php/core.inc.php';
require_once dirname(__FILE__) . '/../../core/php/pronoteView.inc.php';

class pronoteView extends eqLogic {
    /*     * *************************Attributs****************************** */
    
  /*
   * Permet de définir les possibilités de personnalisation du widget (en cas d'utilisation de la fonction 'toHtml' par exemple)
   * Tableau multidimensionnel - exemple: array('custom' => true, 'custom::layout' => false)
	public static $_widgetPossibility = array();
   */
    
    /*     * ***********************Methode static*************************** */

    /*
     * Fonction exécutée automatiquement toutes les minutes par Jeedom
      public static function cron() {
      }
     */

    /*
     * Fonction exécutée automatiquement toutes les 5 minutes par Jeedom*/
      public static function cron5()
      {
          $eqLogics = eqLogic::byType("pronoteView");
          foreach ($eqLogics as $eqLogic) {
              self::updateHTML($eqLogic);
          }
      }

    /*
     * Fonction exécutée automatiquement toutes les 10 minutes par Jeedom
      public static function cron10() {
      }
    
    /*
     * Fonction exécutée automatiquement toutes les 15 minutes par Jeedom
      public static function cron15() {
      }
     */
    
    /*
     * Fonction exécutée automatiquement toutes les 30 minutes par Jeedom
      public static function cron30() {
      }
     */
    
    /*
     * Fonction exécutée automatiquement toutes les heures par Jeedom
      public static function cronHourly()
      {

      }*/

    /*
     * Fonction exécutée automatiquement tous les jours par Jeedom
      public static function cronDaily() {
      }
     */



    /*     * *********************Méthodes d'instance************************* */
    
 // Fonction exécutée automatiquement avant la création de l'équipement 
    public function preInsert() {
        
    }

 // Fonction exécutée automatiquement après la création de l'équipement 
    public function postInsert() {
        
    }

 // Fonction exécutée automatiquement avant la mise à jour de l'équipement 
    public function preUpdate() {
        
    }

 // Fonction exécutée automatiquement après la mise à jour de l'équipement 
    public function postUpdate() {
        
    }

 // Fonction exécutée automatiquement avant la sauvegarde (création ou mise à jour) de l'équipement 
    public function preSave() {

    }

 // Fonction exécutée automatiquement après la sauvegarde (création ou mise à jour) de l'équipement 
    public function postSave() {
        self::createcmd($this);
        self::updateHTML($this);
    }

 // Fonction exécutée automatiquement avant la suppression de l'équipement 
    public function preRemove() {
        
    }

 // Fonction exécutée automatiquement après la suppression de l'équipement 
    public function postRemove() {
        
    }

    function createcmd($eqlogic) {
        $pronoteViewCmd = $eqlogic->getCmd(null, "htmlCode");
        if (!is_object($pronoteViewCmd) ) {
            $pronoteViewCmd = new pronotlinkCmd();
        }
        $pronoteViewCmd->setName("htmlCode");
        $pronoteViewCmd->setEqLogic_id($eqlogic->getId());
        $pronoteViewCmd->setType("info");
        $pronoteViewCmd->setSubType("string");
        $pronoteViewCmd->setLogicalId("htmlCode");
        $pronoteViewCmd->setEventOnly(1);
        $pronoteViewCmd->setIsVisible(0);
        $pronoteViewCmd->setDisplay('generic_type','GENERIC_INFO');
        $pronoteViewCmd->save();
    }

    function updateHTML($eqLogic) {
        if ($eqLogic->getIsEnable() != 1) return;
        if ($eqLogic->getconfiguration('idequip', 0) == 0) return;

        switch ($eqLogic->getconfiguration("type_widget", 1)) {
            case 1:
                pronoteView_notes::htmlNotesByDays($eqLogic);
                break;
            case 2:
                pronoteView_devoirs::htmldevoirs($eqLogic);
                break;
            case 3:
                pronoteView_edt::htmledt7day($eqLogic);
                break;
        }


    }
    /*
     * Non obligatoire : permet de modifier l'affichage du widget (également utilisable par les commandes)*/
      public function toHtml($_version = 'dashboard') {
          $replace = $this->preToHtml($_version, array(), true);
          if (!is_array($replace)) {
              return $replace;
          }
          $version = jeedom::versionAlias($_version);
          $replace['#width#'] = $this->getDisplay('width', 'auto');
          $replace['#height#'] = $this->getDisplay('height', 'auto');
          $replace['#cmd#'] = $this->toHtmlCmd($_version,  false, $this);
          $templ = getTemplate('core', $version, 'main', 'pronoteView');
          return $this->postToHtml($_version, template_replace($replace, $templ));
      }

    public function toHtmlCmd($_version = 'dashboard', $transparent = false, $eqlogic) {
        $pronoteViewCmd = $eqlogic->getCmd(null, "htmlCode");
        $html = $pronoteViewCmd->execCmd();
        return ' <div class="code">
			'.$html.'
			</div> ';
    }
    /*
     * Non obligatoire : permet de déclencher une action après modification de variable de configuration
    public static function postConfig_<Variable>() {
    }
     */

    /*
     * Non obligatoire : permet de déclencher une action avant modification de variable de configuration
    public static function preConfig_<Variable>() {
    }
     */

    /*     * **********************Getteur Setteur*************************** */
}

class pronoteViewCmd extends cmd {
    /*     * *************************Attributs****************************** */
    
    /*
      public static $_widgetPossibility = array();
    */
    
    /*     * ***********************Methode static*************************** */


    /*     * *********************Methode d'instance************************* */

    /*
     * Non obligatoire permet de demander de ne pas supprimer les commandes même si elles ne sont pas dans la nouvelle configuration de l'équipement envoyé en JS
      public function dontRemoveCmd() {
      return true;
      }
     */

  // Exécution d'une commande  
     public function execute($_options = array()) {
        
     }

    /*     * **********************Getteur Setteur*************************** */
}


