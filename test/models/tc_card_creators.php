<?php
/**
 *
 * @fixture cards
 * @fixture card_creators
 */
class TcCardCreators extends TcBase {

	function test(){
		$book = $this->cards["book"];
		$author = CreatorRole::GetInstanceByCode("author");
		$illustration = CreatorRole::GetInstanceByCode("illustration");

		//

		$creators = CardCreator::GetCreatorsForCard($book);
		$this->assertEquals(2,sizeof($creators));
		$this->assertEquals("John Doe",(string)$creators[0]);
		$this->assertEquals("Author",(string)$creators[0]->getCreatorRole());
		$this->assertEquals("Samantha Doe",(string)$creators[1]);
		$this->assertEquals("Illustration",(string)$creators[1]->getCreatorRole());

		//

		$creators = CardCreator::GetCreatorsForCard($book,$author);
		$this->assertEquals(1,sizeof($creators));
		$this->assertEquals("John Doe",(string)$creators[0]);

		$creators = CardCreator::GetCreatorsForCard($book,$illustration);
		$this->assertEquals(1,sizeof($creators));
		$this->assertEquals("Samantha Doe",(string)$creators[0]);

		//

		$roles = CardCreator::GetCreatorRolesForCard($book);
		$this->assertEquals(2,sizeof($roles));
		$this->assertEquals("Author",$roles[0]->getName());
		$this->assertEquals("Illustration",$roles[1]->getName());

		//

		$creators = CardCreator::GetMainCreatorsForCard($book);
		$this->assertEquals(1,sizeof($creators));
		$this->assertEquals("John Doe",(string)$creators[0]);
		$this->assertEquals("Author",(string)$creators[0]->getCreatorRole());

		CardCreator::$MainCreators->clearCache();
		$creators = CardCreator::GetCreatorsForCard($book);
		$creators[1]->s('is_main_creator', true);

		$creators = CardCreator::GetMainCreatorsForCard($book);
		$this->assertEquals(2,sizeof($creators));
		$this->assertEquals("John Doe",(string)$creators[0]);
		$this->assertEquals("Author",(string)$creators[0]->getCreatorRole());
		$this->assertEquals("Samantha Doe",(string)$creators[1]);
		$this->assertEquals("Illustration",(string)$creators[1]->getCreatorRole());
	}
}
