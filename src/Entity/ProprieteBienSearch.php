<?php

namespace App\Entity;

class ProprieteBienSearch
{

	/**
	 * @var int|null
	 */
	private $maxPrice;

	/**
	 * @var int|null
	 */
	private $minSurface;

	/**
	 * @var int|null
	 */
	private $minRooms;

	/**
	 * @var int|null
	 */
	private $minBedrooms;

	/**
	 * @return int|null
	 */
	public function getMaxPrice(): ?int
	{
		return $this->maxPrice;
	}

	/**
	 * @param int|null $maxPrice
	 * @return ProprieteBienSearch
	 */
	public function setMaxPrice(?int $maxPrice): ProprieteBienSearch
	{
		$this->maxPrice = $maxPrice;
		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getMinSurface(): ?int
	{
		return $this->minSurface;
	}

	/**
	 * @param int|null $minSurface
	 * @return ProprieteBienSearch
	 */
	public function setMinSurface(?int $minSurface): ProprieteBienSearch
	{
		$this->minSurface = $minSurface;
		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getMinRooms(): ?int
	{
		return $this->minRooms;
	}

	/**
	 * @param int|null $minRooms
	 * @return ProprieteBienSearch
	 */
	public function setMinRooms(?int $minRooms): ProprieteBienSearch
	{
		$this->minRooms = $minRooms;
		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getMinBedrooms(): ?int
	{
		return $this->minBedrooms;
	}

	/**
	 * @param int|null $minBedrooms
	 * @return ProprieteBienSearch
	 */
	public function setMinBedrooms(?int $minBedrooms): ProprieteBienSearch
	{
		$this->minBedrooms = $minBedrooms;
		return $this;
	}

}
