<?php


namespace App\Domain;


use App\Domain\Authentication\User;
use App\Domain\Constant\ContestProgress;
use App\Domain\Constant\ContestState;
use App\Domain\Constant\PaymentState;

class Contest
{
    public ?string $id;
    public ?User $user;
    public ?\DateTime $createdAt;
    public ?\DateTime $updatedAt;
    public ?\DateTime $deletedAt;
    public ?\DateTime $start;
    public ?\DateTime $end;
    public ?int $numberOfPlaces;
    public ?string $title;
    public ?string $description;
    public ?string $information;
    public ?string $rules;
    public array $location = [];
    public array $pictures = [];
    public ?string $address;
    public ?string $zipcode;
    public ?string $city;
    public ?string $phone;
    public ?string $contestState;
    public ?string $paymentState;
    public ?string $contestProgress;
    public ?int $price;
    public ?int $numberParticipantByTeam;

    public array $payments = [];
    public array $teams = [];
    public array $places = [];

    /**
     * Contest constructor.
     * @param string $id
     * @param User|null $user
     * @param \DateTime|null $createdAt
     * @param \DateTime|null $updatedAt
     * @param \DateTime|null $deletedAt
     * @param \DateTime|null $start
     * @param \DateTime|null $end
     * @param int|null $numberOfPlaces
     * @param string|null $title
     * @param string|null $description
     * @param string|null $information
     * @param string|null $rules
     * @param array $location
     * @param array $pictures
     * @param string|null $address
     * @param string|null $zipcode
     * @param string|null $city
     * @param string|null $phone
     * @param string|null $contestState
     * @param string|null $paymentState
     * @param string|null $contestProgress
     * @param int|null $price
     * @param int|null $numberParticipantByTeam
     * @param array $payments
     * @param array $teams
     * @param array $places
     */
    public function __construct(
        ?string $id = null,
        ?User $user = null,
        ?\DateTime $createdAt = null,
        ?\DateTime $updatedAt = null,
        ?\DateTime $deletedAt = null,
        ?\DateTime $start = null,
        ?\DateTime $end = null,
        ?int $numberOfPlaces = 10,
        ?string $title = null,
        ?string $description = null,
        ?string $information = null,
        ?string $rules = null,
        array $location = [],
        array $pictures = [],
        ?string $address = null,
        ?string $zipcode = null,
        ?string $city = null,
        ?string $phone = null,
        ?string $contestState = ContestState::DRAFT,
        ?string $paymentState = PaymentState::WAITING,
        ?string $contestProgress = ContestProgress::COMMING,
        ?int $price = null,
        ?int $numberParticipantByTeam = 1,
        array $payments = [],
        array $teams = [],
        array $places = []
    )
    {
        $this->id = $id;
        $this->user = $user;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
        $this->start = $start;
        $this->end = $end;
        $this->numberOfPlaces = $numberOfPlaces;
        $this->title = $title;
        $this->description = $description;
        $this->information = $information;
        $this->rules = $rules;
        $this->location = $location;
        $this->pictures = $pictures;
        $this->address = $address;
        $this->zipcode = $zipcode;
        $this->city = $city;
        $this->phone = $phone;
        $this->contestState = $contestState;
        $this->paymentState = $paymentState;
        $this->contestProgress = $contestProgress;
        $this->price = $price;
        $this->numberParticipantByTeam = $numberParticipantByTeam;
        $this->payments = $payments;
        $this->teams = $teams;
        $this->places = $places;
    }
}
