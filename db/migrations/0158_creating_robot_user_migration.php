<?php
class CreatingRobotUserMigration extends ApplicationMigration {

	function up(){
		User::CreateNewRecord([
			"id" => 3,
			"login" => "robot",
			"password" => null,
			"firstname" => "Robot",
		]);
	}
}
