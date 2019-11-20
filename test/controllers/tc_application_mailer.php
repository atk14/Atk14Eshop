<?php
/**
 *
 * @fixture orders
 */
class TcApplicationMailer extends TcBase {

	function test_notify_order_creation(){
		$mailer = Atk14MailerProxy::GetInstance();

		$bcc = SystemParameter::GetInstanceByCode("app.bcc");
		
		$order_status = OrderStatus::GetInstanceByCode("new");
		$order_status->s("bcc_email","orders@example.com");

		//
		$bcc->s("content","admin@example.com");
		$email_ar = $mailer->notify_order_creation($this->orders["test"]);
		$this->assertEquals("admin@example.com, orders@example.com",$email_ar["bcc"]);

		//
		$bcc->s("content",null);
		$email_ar = $mailer->notify_order_creation($this->orders["test"]);
		$this->assertEquals("orders@example.com",$email_ar["bcc"]);
	}
}
