<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

namespace Nos;

class Widget_Wysiwyg extends \Fieldset_Field {

	protected $options = array();

    public function __construct($name, $label = '', array $attributes = array(), array $rules = array(), \Fuel\Core\Fieldset $fieldset = null) {

        $attributes['type']  = 'textarea';
		$attributes['class'] = (isset($attributes['class']) ? $attributes['class'] : '').' tinymce';

		if (empty($attributes['id'])) {
			$attributes['id'] = uniqid('wysiwyg_');
		}
		if (!empty($attributes['widget_options'])) {
			$this->options = \Arr::merge($this->options, $attributes['widget_options']);
		}
		unset($attributes['widget_options']);

        parent::__construct($name, $label, $attributes, $rules, $fieldset);
    }

    /**
     * How to display the field
     * @return string
     */
    public function build() {

	    $this->fieldset()->append($this->js_init());

		$this->set_attribute('data-wysiwyg-options', htmlspecialchars(\Format::forge()->to_json($this->options)));
        return (string) parent::build();
    }

	public function js_init() {
		$id = $this->get_attribute('id');
		return '<script type="text/javascript">require(["wysiwyg"], function() {var $t = $("textarea#'.$id.'");$t.wysiwyg($t.data("wysiwyg-options"));});</script>';
	}

}
