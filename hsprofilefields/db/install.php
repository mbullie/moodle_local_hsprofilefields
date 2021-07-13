<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Local plugin "local_hsprofilefields"
 *
 * @package   local_hsprofilefields
 * @copyright 2021 Michael Bulwick, Highskills and more <michael@highskills.co.il>
 */

defined('MOODLE_INTERNAL') || die();


function xmldb_local_hsprofilefields_install() {
    global $DB, $CFG;
	
	//we get the values for fields first
	$fields = array_map('str_getcsv', file($CFG->dirroot.'\local\hsprofilefields\db\profilefields.csv'));
	
	if($fields[0]){
 
		$dbman = $DB->get_manager(); // loads ddl manager and xmldb classes
		
		///  Install code goes here

		/// To detect if table exists:
		$tablename = 'user_info_field';
		$table = new xmldb_table($tablename);
		
		if($dbman->table_exists($table)){
			foreach ($fields[0] as $fieldname){
				if(!$DB->record_exists($tablename, array('shortname'=> $fieldname) )){
					$dataobject = new stdclass();
					$dataobject->shortname = $fieldname;
					$dataobject->name = $fieldname;
					$dataobject->datatype = 'text';
					$dataobject->descriptionformat = 1;
					$dataobject->categoryid = 1;
					$dataobject->required = 0;
					$dataobject->locked = 1;
					$dataobject->visible = 2;
					$dataobject->param1 = 30;
					$dataobject->param2 = 2048;
					$dataobject->param3 = 0;
					
					if($DB->insert_record($tablename, $dataobject, true)){
						echo("Profile field ".$fieldname." has been added.".PHP_EOL);
					}
				}
			}
		}
	}
}