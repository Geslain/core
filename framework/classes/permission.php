<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

namespace Cms;

class Permission {

	public static function forge($app_name, $key, $driver_config) {

		$driver = $driver_config['driver'];
		// @todo Inflector::words_to_upper ?
		$class = '\Cms\Permission_'.ucfirst($driver);

		if (empty($driver_config['label'])) {
			\Debug::dump($driver_config);
		}

		if (class_exists($class)) {
			return new $class($app_name, $key, $driver_config['label'], $driver_config['driver_config']);
		}
		throw new \Exception('The permission driver '.$driver.' has not be found for application '.$app_name.' ('.$key.').');
	}

    public static function check($app, $key) {
        $user = \Session::user();
        $group = reset($user->groups);
        return $group->check_permission($app, $key);
    }

	public static function add($app, $key) {
        $user = \Session::user();
        $group = reset($user->groups);
        try {
	        $access = new Model_User_Permission();
	        $access->perm_group_id    = $group->group_id;
	        $access->perm_application = $key;
	        $access->perm_identifier  = '';
	        $access->perm_key         = $app;
	        $access->save();
        } catch(\Exception $e) {

        }
        return true;
    }
}
