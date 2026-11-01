<?php
class TcAnonymizeEmail extends TcBase {

	function test(){
		Atk14Require::Helper("modifier.anonymize_email");

		$this->assertEquals("j......e@example.com",smarty_modifier_anonymize_email("john.doe@example.com"));

		// at least three dots
		$this->assertEquals("s...m@example.com",smarty_modifier_anonymize_email("sam@example.com"));
		$this->assertEquals("j...a@example.com",smarty_modifier_anonymize_email("ja@example.com"));
	}
}
