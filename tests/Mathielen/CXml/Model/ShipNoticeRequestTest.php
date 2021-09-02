<?php

namespace Mathielen\CXml\Model;

use Mathielen\CXml\Builder;
use Mathielen\CXml\Endpoint;
use Mathielen\CXml\Model\Request\ShipNoticeHeader;
use Mathielen\CXml\Model\Request\ShipNoticeRequest;
use Mathielen\CXml\Payload\PayloadIdentityFactoryInterface;
use PHPUnit\Framework\TestCase;

class ShipNoticeRequestTest extends TestCase implements PayloadIdentityFactoryInterface
{
	public function testMinimumExample(): void
	{
		$from = new Credential(
			'NetworkId',
			'AN00000123'
		);
		$to = new Credential(
			'NetworkId',
			'AN00000456'
		);
		$sender = new Credential(
			'NetworkId',
			'AN00000123',
			'abracadabra'
		);

		$statusUpdateRequest = ShipNoticeRequest::create(
			ShipNoticeHeader::create(
				'S2-123',
				new \DateTime('2000-10-14T18:39:09-08:00'),
				new \DateTime('2000-10-14T08:30:19-08:00'),
				new \DateTime('2000-10-18T09:00:00-08:00'),
			)
			->addComment('Got it all into one shipment.', 'en-CA')
		)
			->addShipControl(
				ShipControl::create('8202 8261 1194')
					->addCarrierIdentifier('SCAC', 'FDE')
					->addCarrierIdentifier('companyName', 'Federal Express')
			)
			->addShipNoticePortion(
				new ShipNoticePortion('32232995@hub.acme.com', 'DO1234')
			);

		$cxml = Builder::create('en-US', $this)
			->from($from)
			->to($to)
			->sender($sender, 'Supplier’s Super Order Processor')
			->payload($statusUpdateRequest)
			->build();

		$xml = Endpoint::serialize($cxml);

		$this->assertXmlStringEqualsXmlFile('tests/metadata/cxml/samples/ShipNoticeRequest.xml', $xml);
	}

	public function newPayloadIdentity(): PayloadIdentity
	{
		return new PayloadIdentity(
			'0c30050@supplierorg.com',
			new \DateTime('2021-01-08T23:00:06-08:00')
		);
	}
}