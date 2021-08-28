<?php
/**
 *
 * @fixture customer_groups
 */
class TcManuallyAssignableCustomerGroupsField extends TcBase {
	
	function test(){
		$this->field = new ManuallyAssignableCustomerGroupsField([
			"required" => false,
		]);

		$value = $this->assertValid([]);
		$this->assertEquals([],$value);

		$value = $this->assertValid([$this->customer_groups["vip_customers"]->getId()]);
		$this->assertEquals(1,sizeof($value));
		$this->assertEquals($this->customer_groups["vip_customers"]->getId(),$value[0]->getId());

		$value = $this->assertValid([$this->customer_groups["vip_customers"]->getId(),CustomerGroup::GetInstanceByCode("registered")->getId()]); // Customer group "registered" is not manually assignable and must be filtered out
		$this->assertEquals(1,sizeof($value));
		$this->assertEquals($this->customer_groups["vip_customers"]->getId(),$value[0]->getId());
	}
}
