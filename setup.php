<?php
/**
 * @version $Id$
 -------------------------------------------------------------------------
 LICENSE

 This file is part of PDF plugin for GLPI.

 PDF is free software: you can redistribute it and/or modify
 it under the terms of the GNU Affero General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

 PDF is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU Affero General Public License for more details.

 You should have received a copy of the GNU Affero General Public License
 along with Reports. If not, see <http://www.gnu.org/licenses/>.

 @package   pdf
 @authors   Nelly Mahu-Lasson, Remi Collet
 @copyright Copyright (c) 2009-2015 PDF plugin team
 @license   AGPL License 3.0 or (at your option) any later version
            http://www.gnu.org/licenses/agpl-3.0-standalone.html
 @link      https://forge.indepnet.net/projects/pdf
 @link      http://www.glpi-project.org/
 @since     2009
 --------------------------------------------------------------------------
*/

function plugin_init_pdf() {
   global $PLUGIN_HOOKS;

   $PLUGIN_HOOKS['csrf_compliant']['pdf'] = true;

   Plugin::registerClass('PluginPdfProfile',    array('addtabon' => 'Profile'));
   Plugin::registerClass('PluginPdfPreference', array('addtabon' => 'Preference'));


   $plugin = new Plugin();
//   if ($plugin->isActivated("datainjection")) {
      $PLUGIN_HOOKS['menu_entry']['pdf'] = 'front/preference.form.php';
 //  }

   if (isset($_SESSION['glpiactiveprofile']['plugin_pdf'])
       && ($_SESSION['glpiactiveprofile']['plugin_pdf'] == 1)){

      $PLUGIN_HOOKS['use_massive_action']['pdf'] = 1;


      // Define the type for which we know how to generate PDF :
      $PLUGIN_HOOKS['plugin_pdf']['Computer']         = 'PluginPdfComputer';
      $PLUGIN_HOOKS['plugin_pdf']['Group']            = 'PluginPdfGroup';
      $PLUGIN_HOOKS['plugin_pdf']['KnowbaseItem']     = 'PluginPdfKnowbaseItem';
      $PLUGIN_HOOKS['plugin_pdf']['Monitor']          = 'PluginPdfMonitor';
      $PLUGIN_HOOKS['plugin_pdf']['NetworkEquipment'] = 'PluginPdfNetworkEquipment';
      $PLUGIN_HOOKS['plugin_pdf']['Peripheral']       = 'PluginPdfPeripheral';
      $PLUGIN_HOOKS['plugin_pdf']['Phone']            = 'PluginPdfPhone';
      $PLUGIN_HOOKS['plugin_pdf']['Printer']          = 'PluginPdfPrinter';
      $PLUGIN_HOOKS['plugin_pdf']['Software']         = 'PluginPdfSoftware';
      $PLUGIN_HOOKS['plugin_pdf']['SoftwareLicense']  = 'PluginPdfSoftwareLicense';
      $PLUGIN_HOOKS['plugin_pdf']['SoftwareVersion']  = 'PluginPdfSoftwareVersion';
      $PLUGIN_HOOKS['plugin_pdf']['Ticket']           = 'PluginPdfTicket';
      $PLUGIN_HOOKS['plugin_pdf']['Problem']          = 'PluginPdfProblem';

      // End init, when all types are registered by all plugins
      $PLUGIN_HOOKS['post_init']['pdf'] = 'plugin_pdf_postinit';
   }
}


function plugin_version_pdf() {

   return array('name'           => __('Print to pdf', 'pdf'),
                'version'        => '0.85',
                'author'         => 'Remi Collet, Nelly Mahu-Lasson',
                'license'        => 'GPLv3+',
                'homepage'       => 'https://forge.indepnet.net/projects/pdf',
                'minGlpiVersion' => '0.85');
}


// Optional : check prerequisites before install : may print errors or add to message after redirect
function plugin_pdf_check_prerequisites(){

   if (version_compare(GLPI_VERSION,'0.85','lt') || version_compare(GLPI_VERSION,'0.91','ge')) {
      _e('This plugin requires GLPI >= 0.85', 'pdf');
      return false;
   }
   return true;
}


// Config process for plugin : need to return true if succeeded : may display messages or add to message after redirect
function plugin_pdf_check_config(){
   return true;
}
?>