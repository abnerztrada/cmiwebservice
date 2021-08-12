<?php

class block_cmi_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

		// A sample string variable with a default value.
		$mform->addElement('text', 'config_title', get_string('blocktitle', 'block_cmi'));
		$mform->setDefault('config_title', 'default value');
		$mform->setType('config_title', PARAM_TEXT);

        // A sample string variable with a default value.
        $mform->addElement('text', 'config_text', get_string('blockstring', 'block_cmi'));
        $mform->setDefault('config_text', 'default value');
        $mform->setType('config_text', PARAM_RAW);

        // A sample string variable with a default value.
        $mform->addElement('text', 'config_footer', get_string('blockfooter', 'block_cmi'));
        $mform->setDefault('config_footer', 'default value');
        $mform->setType('config_footer', PARAM_TEXT);

    }
}
