<?php
/**
 * amadeus-ws-client
 *
 * Copyright 2015 Amadeus Benelux NV
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package Amadeus
 * @license https://opensource.org/licenses/Apache-2.0 Apache 2.0
 */

namespace Amadeus\Client\Struct\Hotel;

use Amadeus\Client\RequestOptions\HotelSellOptions;
use Amadeus\Client\Struct\BaseWsMessage;
use Amadeus\Client\Struct\Hotel\Sell\ArrivalFlightDetailsGrp;
use Amadeus\Client\Struct\Hotel\Sell\BookingCompany;
use Amadeus\Client\Struct\Hotel\Sell\BookingPayerDetails;
use Amadeus\Client\Struct\Hotel\Sell\ExtraIndentification;
use Amadeus\Client\Struct\Hotel\Sell\GroupIndicator;
use Amadeus\Client\Struct\Hotel\Sell\RoomStayData;
use Amadeus\Client\Struct\Hotel\Sell\SystemIdentifier;
use Amadeus\Client\Struct\Hotel\Sell\TravelAgentRef;
use Amadeus\Client\Struct\Hotel\Sell\StatusDetails;
use Amadeus\Client\Struct\Offer\ConfirmHotel\BookingSource;
use Amadeus\Client\Struct\Offer\ConfirmHotel\GlobalBookingInfo;
use Amadeus\Client\Struct\Offer\ConfirmHotel\GuaranteeOrDeposit;
use Amadeus\Client\Struct\Offer\ConfirmHotel\HotelProductReference;
use Amadeus\Client\Struct\Offer\ConfirmHotel\OccupantList;
use Amadeus\Client\Struct\Offer\ConfirmHotel\ReferenceDetails;
use Amadeus\Client\Struct\Offer\ConfirmHotel\RepresentativeParties;
use Amadeus\Client\Struct\Offer\ConfirmHotel\RoomList;
use Amadeus\Client\Struct\Offer\ConfirmHotel\RoomRateDetails;
use Amadeus\Client\Struct\Offer\ConfirmHotel\TattooReference;
use Amadeus\Client\Struct\Offer\PassengerReference;
use Amadeus\Client\Struct\Pnr\ReservationInfo;

/**
 * Hotel_Sell request structure
 *
 * @package Amadeus\Client\Struct\Hotel
 * @author Dieter Devlieghere <dieter.devlieghere@benelux.amadeus.com>
 */
class Sell extends BaseWsMessage
{
  /**
   * @var SystemIdentifier
   */
  public $systemIdentifier;

  /**
   * @var BookingCompany[]
   */
  public $bookingCompany = [];

  /**
   * @var ReservationInfo
   */
  public $reservationInfo;

  /**
   * @var ExtraIndentification
   */
  public $extraIndentification;

  /**
   * @var GroupIndicator
   */
  public $groupIndicator;

  /**
   * @var TravelAgentRef[]
   */
  public $travelAgentRef = [];

  /**
   * @var BookingPayerDetails
   */
  public $bookingPayerDetails;

  /**
   * @var RoomStayData[]
   */
  public $roomStayData = [];

  /**
   * @var ArrivalFlightDetailsGrp
   */
  public $arrivalFlightDetailsGrp;

  /**
   * Hotel_Sell constructor.
   *
   * @param HotelSellOptions $options
   */
  public function __construct(HotelSellOptions $options)
  {
    if (!empty($options->deliveringSystem)) {
      $this->systemIdentifier = new SystemIdentifier($options->deliveringSystem);
    }

    if (!empty($options->statusDetailIndicator) && !empty($options->statusDetailAction)) {
      $this->groupIndicator = new GroupIndicator($options->statusDetailIndicator, $options->statusDetailAction);
    }

    $this->travelAgentRef[] = new TravelAgentRef(TravelAgentRef::REFERENCE_EMAIL, 1);

    $this->loadRoomStayData($options);
  }

  protected function loadRoomStayData(HotelSellOptions $options)
  {
    $this->makeRoomStayData();
    $this->roomStayData[0]->globalBookingInfo = new GlobalBookingInfo([1]);

    $this->roomStayData[0]->globalBookingInfo->bookingSource = new BookingSource('12345675');

    $this->roomStayData[0]->roomList[] = new RoomList();
    $this->roomStayData[0]->roomList[0]->guaranteeOrDeposit = new GuaranteeOrDeposit();
    $this->roomStayData[0]->roomList[0]->roomRateDetails = new RoomRateDetails();

    $hotelProductReference = new HotelProductReference();
    $referenceDetails = new ReferenceDetails(ReferenceDetails::TYPE_BOOKING_CODE, '00000001');
    $hotelProductReference->referenceDetails = $referenceDetails;
    $this->roomStayData[0]->roomList[0]->roomRateDetails->hotelProductReference[0] = $hotelProductReference;

    $representativeParties = [];
    $tmp = new RepresentativeParties();
    $tmp->occupantList = new OccupantList(
      1,
      PassengerReference::TYPE_ROOM_MAIN_OCCUPANT
    );
    $representativeParties[] = $tmp;

    $this->roomStayData[0]->roomList[0]->guestList = $representativeParties;
  }

  protected function makeRoomStayData()
  {
    if (!isset($this->roomStayData[0])) {
      $this->roomStayData[] = new RoomStayData();
    }
  }
}
