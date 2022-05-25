<?php

namespace CXml\Model;

use Assert\Assertion;
use JMS\Serializer\Annotation as Ser;

class Request implements RequestInterface
{
	public const DEPLOYMENT_TEST = 'test';
	public const DEPLOYMENT_PROD = 'production';

	/**
	 * @Ser\SerializedName("Status")
	 */
	private ?Status $status;

	/**
	 * @Ser\XmlAttribute
	 * @Ser\SerializedName("deploymentMode")
	 */
	private ?string $deploymentMode;

	/**
	 * @Ser\XmlAttribute
	 * @Ser\SerializedName("Id")
	 */
	private ?string $id;

	/**
	 * @Ser\Exclude
	 * see JmsEventSubscriber
	 */
	private RequestInterface $payload;

	public function __construct(
		RequestInterface $payload,
		?Status $status = null,
		?string $id = null,
		?string $deploymentMode = null
	) {
		if (null !== $deploymentMode) {
			Assertion::inArray($deploymentMode, [self::DEPLOYMENT_PROD, self::DEPLOYMENT_TEST]);
		}

		$this->status = $status;
		$this->id = $id;
		$this->payload = $payload;
		$this->deploymentMode = $deploymentMode;
	}

	public function getStatus(): ?Status
	{
		return $this->status;
	}

	public function getId(): ?string
	{
		return $this->id;
	}

	public function getDeploymentMode(): ?string
	{
		return $this->deploymentMode;
	}

	public function getPayload(): RequestInterface
	{
		return $this->payload;
	}
}