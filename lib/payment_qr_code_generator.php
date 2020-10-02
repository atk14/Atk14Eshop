<?php
// https://github.com/sunfoxcz/spayd-php
// http://qr-platba.cz/pro-vyvojare/specifikace-formatu/

use Shoptet\Spayd\Spayd;
use Shoptet\Spayd\Model\CzechAccount;
use Shoptet\Spayd\Utilities\IbanUtilities;

class PaymentQrCodeGenerator {

	static function GetInstanceForOrder($order){
		$payment_method = $order->getPaymentMethod();
		$region = $order->getRegion();
		$bank_account = $region->getBankAccount();
		$currency = $order->getCurrency();

		$message = sprintf(_("obj. %s"),$order->getOrderNo())." - ".$region->getApplicationName()." - QR";
		$message = String4::ToObject($message)->toAscii()->upper()->toString();
		$generator = new PaymentQrCodeGenerator([
			"amount" => $order->getPriceToPay(),
			"variable_symbol" => $order->getOrderNo(),
			"account_number" => $bank_account->getAccountNumber(),
			"iban" => preg_replace('/\s+/','',$bank_account->getIban()),
			"swift" => preg_replace('/\s+/','',$bank_account->getSwiftBic()),
			"currency" => $currency->getCode(),
			"message" => $message,
		]);

		try {
			$generator->getSpayd();
		} catch(Exception $e) {
			$generator = null;
		}

		return $generator;
	}

	function __construct($params = array()){
		$params += array(
			"amount" => null, // 99.80
			"variable_symbol" => "", // "1234567"
			"account_number" => "", // "19-2000145399/0800",
			"iban" => "", // "CZ6508000000192000145399"
			"swift" => "", // "GIBACZPX"
			"currency" => "", // "EUR", "CZK"...
			"message" => "", // toto je zprava pro prijemce!
		);

		$this->amount = $params["amount"];
		$this->variable_symbol = $params["variable_symbol"];
		$this->account_number = $params["account_number"];
		$this->iban = $params["iban"];
		$this->swift = $params["swift"];
		$this->currency = $params["currency"];
		$this->message = $params["message"];
	}

	/**
	 * Returns Short Payment Descriptor (SPAYD)
	 *
	 * $generator = new PaymentQrCodeGenerator(array(...));
	 * header("Content-Type: application/x-shortpaymentdescriptor");
	 * echo $generator->renderSpayd(); // e.g. "SPD*1.0*ACC:CZ6508000000192000145399+GIBACZPX*AM:123.45*CC:EUR*MSG:ORDER 1234567 - QR CODE*X-VS:1234567*CRC32:ad9fa8f1"
	 */
	function getSpayd(){
		$spayd = new Spayd();
		$spayd->add('AM', number_format($this->amount,2,'.',''));
		$spayd->add('CC', $this->currency);
		$spayd->add('X-VS', $this->variable_symbol);

		if(strlen($this->message)){
			$spayd->Add('MSG', $this->message);
		}
		
		if ($this->iban) {
			$spayd->add('ACC', "{$this->iban}+{$this->swift}");
		} else {
			$account = new CzechAccount($this->account_number); // "19-2000145399/0800"
			$spayd->add('ACC', IbanUtilities::computeIbanFromBankAccount($account));
		}

		return (string)$spayd;
	}

	/**
	 *
	 * header("Content-Type: image/png");
	 * echo $generator->renderPng(["size" => 200]);
	 */
	function renderPng($options = array()){
		$options += array(
			"size" => "400",
		);
		$renderer = new \BaconQrCode\Renderer\Image\Png();
		$renderer->setWidth($options["size"]);
		$renderer->setHeight($options["size"]);
		$writer = new \BaconQrCode\Writer($renderer);
		return $writer->writeString($this->getSpayd(["size" => $options["size"]]));
	}
}
