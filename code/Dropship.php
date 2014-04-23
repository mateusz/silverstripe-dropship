<?php

class Dropship extends Controller {

	static $allowed_actions = array(
		'install',
		'InstallForm'
	);

	function init() {

		parent::init();

		// Allow only admins.
		$member = Member::currentUser();
		if (!$member || !Permission::checkMember($member, 'ADMIN')) {
			return Security::permissionFailure();
		}

	}

	function index() {

		return $this->customise(array(
			'Title' => 'Dropship',
			'Content' => <<<EOM
<p>Note: usage of these tools is logged.</p>
<ul>
	<li><a href='Dropship/install'>Install module (WARNING: this is only a proof-of-concept)</a></li>
</ul>
EOM
		));

	}

	function install() {

		return $this->customise(array(
			'Title' => 'Install',
			'Content' => 'This will install the module',
			'Form' => $this->InstallForm()
		));

	}

	function InstallForm() {

		$fields = new FieldList(
			new TextField('Name', 'Module name')
		);
		$actions = new FieldList(
			FormAction::create("doInstall")->setTitle("Install")
		);
		$form = new Form($this, 'InstallForm', $fields, $actions);
		$form->setFormMethod('GET');
		$form->disableSecurityToken();

		return $form;
	}

	function doInstall($data, $form) {

		increase_time_limit_to(0);
		$moduleName = $data['Name'];
		$basePath = BASE_PATH;

		echo "This module is a proof of concept and has a horrible shell injection. Delete this line if you really want to use it...";
		exit;

		echo `cd $basePath && composer require "$moduleName:*"`;

	}

}
