<?php
/**
 * @fixture users
 * @fixture customer_groups
 */
class TcUser extends TcBase{

	function test(){
		$rambo = $this->users["rambo"];

		$this->assertEquals("John Rambo",$rambo->getName());
		$this->assertEquals("John Rambo","$rambo"); // toString
		$rambo->s([
			"firstname" => "",
			"lastname" => "",
		]);
		$this->assertEquals("rambo",$rambo->getName());
		$this->assertEquals("rambo","$rambo"); // toString


		$this->assertEquals(true,$rambo->isActive());
		$this->assertEquals(false,$rambo->isAdmin());
		$this->assertEquals(false,$rambo->isSuperAdmin());

		$rambo->s("active",false);
		$this->assertEquals(false,$rambo->isActive());

		$rambo->s("is_admin",true);
		$this->assertEquals(true,$rambo->isAdmin());
		$this->assertEquals(false,$rambo->isSuperAdmin());

		$superadmin = User::FindById(User::ID_SUPERADMIN);
		$this->assertEquals(true,$superadmin->isAdmin());
		$this->assertEquals(true,$superadmin->isSuperAdmin());
	}

	function testHashingPassword(){
		// see test/fixtures/users.yml
		$rambo = $this->users["rambo"];
		$rocky = $this->users["rocky"];

		$this->assertTrue($rambo->getPassword()!="secret");
		$this->assertTrue($rocky->getPassword()!=$rambo->getPassword()); // same passwords, different salts, different hashes

		$this->assertNull(User::Login("rambo","bad try",$bad_password));
		$this->assertTrue($bad_password);

		$user = User::Login("rambo","secret");
		$this->assertEquals($rambo->getId(),$user->getId());

		$user = User::Login("rocky","secret");
		$this->assertEquals($rocky->getId(),$user->getId());

		$rambo->s("password","CrazyWolf");
		$this->assertTrue($rambo->getPassword()!="CrazyWolf");
		$this->assertNull(User::Login("rambo","secret"));
		$this->assertNotNull(User::Login("rambo","CrazyWolf"));

		$hash = $rambo->g("password");
		$rambo->s("password",$hash);
		$this->assertEquals($hash,$rambo->g("password"));

		$rambo->s("password","CrazyWolf");
		$this->assertNotEquals($hash,$rambo->g("password"));
		$this->assertNotNull(User::Login("rambo","CrazyWolf"));

		$this->assertNull(User::Login("mr.cooler","infinity",$bad_password));
		$this->assertEquals(false,$bad_password);
	}

	function test_null_and_empty_password(){
		$rambo = $this->users["rambo"];

		$this->assertTrue($rambo->isPasswordCorrect("secret"));

		$rambo->s("password",null);
		$this->assertTrue($rambo->getPassword()===null);

		$this->assertFalse($rambo->isPasswordCorrect("secret"));
		$this->assertFalse($rambo->isPasswordCorrect(null));
		$this->assertFalse($rambo->isPasswordCorrect(""));

		$rambo->s("password","");
		$this->assertTrue($rambo->getPassword()==="");

		$this->assertFalse($rambo->isPasswordCorrect("secret"));
		$this->assertFalse($rambo->isPasswordCorrect(null));
		$this->assertFalse($rambo->isPasswordCorrect(""));
	}

	function test_Login(){
		$rambo = User::Login("rambo","secret",$bad_password);
		$this->assertTrue(!!$rambo);
		$this->assertFalse($bad_password);

		$rambo = User::Login("rambo","badguess",$bad_password);
		$this->assertNull($rambo);
		$this->assertTrue($bad_password);

		$rambo = User::Login("rambo.xyz","secret",$bad_password);
		$this->assertNull($rambo);
		$this->assertFalse($bad_password);

		$this->users["rambo"]->s("active",false);
		$rambo = User::Login("rambo","secret",$bad_password);
		$this->assertNull($rambo);
		$this->assertFalse($bad_password);
	}

	function test_CustomerGroups(){
		$anonymous = User::GetAnonymousUser();
		$customer_groups = $anonymous->getCustomerGroups();
		$this->assertEquals(1,sizeof($customer_groups));
		$this->assertEquals("unregistered",$customer_groups[0]->getCode());

		$this->assertEquals(true,$anonymous->isInCustomerGroup("unregistered"));
		$this->assertEquals(false,$anonymous->isInCustomerGroup("registered"));
		$this->assertEquals(false,$anonymous->isInCustomerGroup($this->customer_groups["vip_customers"]));

		$rambo = $this->users["rambo"];
		$customer_groups = $rambo->getCustomerGroups();
		$this->assertEquals(1,sizeof($customer_groups));
		$this->assertEquals("registered",$customer_groups[0]->getCode());

		$this->assertEquals(false,$rambo->isInCustomerGroup("unregistered"));
		$this->assertEquals(true,$rambo->isInCustomerGroup("registered"));
		$this->assertEquals(false,$rambo->isInCustomerGroup($this->customer_groups["vip_customers"]->getId()));

		$lister = $rambo->getLister("CustomerGroups");
		$lister->append($this->customer_groups["vip_customers"]);

		$customer_groups = $rambo->getCustomerGroups();
		$this->assertEquals(2,sizeof($customer_groups));
		$this->assertEquals("registered",$customer_groups[0]->getCode());
		$this->assertEquals("vip_customers",$customer_groups[1]->getCode());

		$this->assertEquals(false,$rambo->isInCustomerGroup("unregistered"));
		$this->assertEquals(true,$rambo->isInCustomerGroup("registered"));
		$this->assertEquals(true,$rambo->isInCustomerGroup($this->customer_groups["vip_customers"]->getId()));
	}
}
