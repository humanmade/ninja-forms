<?php
/**
 * Base field class
 * All other field classes extend this one.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Field
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Field_Base {

	// Setup our class variables. These can be overwritten by child classes.

	/**
	 * @var field_id
	 * @since 3.0
	 */
	var $field_id = '';

	/**
	 * @var field_id
	 * @since 3.0
	 */
	var $element_id = '';

	/**
	 * @var class
	 * @since 3.0
	 */
	var $class = '';

	/**
	 * @var value
	 * @since 3.0
	 */
	var $value = false;

	/**
	 * @var label
	 * @since 3.0
	 */
	var $label = 'Your Item';

	/**
	 * @var label
	 * @since 3.0
	 */
	var $label_pos = 'left';

	/**
	 * @var label
	 * @since 3.0
	 */
	var $div_wrapper = true;	

	/**
	 * @var label
	 * @since 3.0
	 */
	var $placeholder = '';

	/**
	 * Get things started
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function __construct() {

	}

	/**
	 * Function that renders our field.
	 * This function handles all of the label stuff, and uses the render_element() function that should be present
	 * in the instantiated child.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function render() {

		if ( $this->div_wrapper ) {
			echo '<div>';
		}
		if ( $this->label_pos != 'none' && $this->label_pos != 'inside' ) {
			echo '<label>';
			if ( $this->label_pos == 'left' ) {
				echo $this->label;
			}			
		}

		if ( $this->label_pos == 'inside' ) {
			$this->placeholder = $this->label;
		}

		$this->render_element();

		if ( $this->label_pos != 'none' && $this->label_pos != 'inside' ) {
			if ( $this->label_pos == 'right' ) {
				echo $this->label;
			}
			echo '</label>';			
		}

		if ( Ninja_Forms()->field( $this->field_id )->get_errors() ) {
			echo '<div class="nf-errors">';
			foreach ( Ninja_Forms()->field( $this->field_id )->get_errors() as $key => $error ) {
				echo '<div>' . $error . '</div>';
			}
			echo '</div>';
		}

		if ( $this->div_wrapper ) {
			echo '</div>';
		}
	}

	/**
	 * This function should be overwritten by child classes
	 *  
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function render_element() {

	}

	/**
	 * Set our current field id.
	 * 
	 * @access public
	 * @param int $field_id
	 * @since 3.0
	 * @return void
	 */
	public function set_field( $field_id ) {
		$this->field_id = $field_id;
		$this->element_id = 'nf_field_' . $field_id;
		foreach( Ninja_Forms()->field_var->settings[ $field_id ] as $setting => $value ) {
			$this->$setting = $value;
		}
		$this->value = Ninja_Forms()->field_var->values[ $field_id ];
	}

	/**
	 * Function that validates our field input.
	 * 
	 * @access public
	 * @since 3.0
	 * @return bool $return
	 */
	public function validate() {
		if ( $this->value === '' ) {
			return false;
		} else {
			return true;
		}
	}

}
