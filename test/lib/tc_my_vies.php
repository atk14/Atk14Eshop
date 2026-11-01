<?php
class TcMyVies extends TcBase {

	function test(){
		$mv = new MyVies();
		$this->assertEquals("CZ12345678",$mv->filterVat("CZ 1234-5678"));
	
		try {
			$is_alive = $mv->getHeartBeat()->isAlive();
		} catch(Exception $e){
			file_put_contents("php://stderr","WARNING: Vies is not alive");
			return;
		}

		$result = $mv->validateVat(
			"SK", "2020522042", // Plzeňský Prazdroj Slovensko, a.s.
			"CZ", "24822752" // SNAPPS s.r.o. (requestor)
		); 
		$this->assertEquals(true,$result->isValid());
		$this->assertEquals("Plzeňský Prazdroj Slovensko, a.s.",$result->getName());

		$result = $mv->validateVat(
			"SK", "1112223334", // nonsence
			"CZ", "24822752" // SNAPPS s.r.o. (requestor)
		);
		$this->assertEquals(false,$result->isValid());
	}
}
