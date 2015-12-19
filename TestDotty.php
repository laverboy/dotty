<?php

require("Dotty.php");

class TestDotty extends PHPUnit_Framework_TestCase
{
    protected $fields;
    protected $record;

    protected function setUp()
    {
        parent::setUp();

        $this->fields = [
            'ID' => 'id',
            'Amount' => 'amount',
            'Status' => 'status',
            'Created' => 'created',
            'Gateway' => 'gateway',
            'Donor Email' => 'donor.email',
            'Donor Title' => 'donor.title',
            'Donor First Name' => 'donor.firstName',
            'Donor Last Name' => 'donor.lastName',
            'Donor Address Line 1' => 'donor.address.billingAddress1',
            'Donor Postcode' => 'donor.address.billingPostcode',
            'Gift Aid' => 'gift_aid',
            'Reason for giving' => 'extras.givingReason',
            'How did you hear about us?' => 'extras.referralName',
        ];

        $this->record = [
            'id' => 22,
            'gateway' => 'PayPal_Express',
            'amount' => 44.00,
            'currency' => 'GBP',
            'status' => 'fail',
            'failure_message' => 'Express Checkout PayerID is missing.',
            'extras' => [
                "givingReason" => "Reason 2",
                "referralName" => "Family or Friend"
            ],
            'created' => '2015-12-03 11:08:51',
            'donor' => [
                "firstName" => "Beck",
                "lastName" => "Herring",
                "address" => [
                    "billingAddress1" => "",
                    "billingAddress2" => "",
                    "billingCity" => "York",
                    "billingPostcode" => "YO31RP",
                    "billingState" => "Yorkshire",
                    "billingCountry" => "GB",
                    "billingPhone" => "",
                ],
                "email" => "gazyhof@gmail.com"
            ],
            'gift_aid' => 0
        ];
    }

    public function test_get_value_returns_first_level()
    {
        $array = [
            'firstname' => 'Steve',
            'lastname' => 'Harris'
        ];

        $this->assertEquals("Steve", Dotty::getValue("firstname", $array));
        $this->assertEquals("Harris", Dotty::getValue("lastname", $array));
    }

    public function test_get_value_returns_second_level()
    {
        $this->assertEquals("Beck", Dotty::getValue("donor.firstName", $this->record));
        $this->assertEquals("Reason 2", Dotty::getValue("extras.givingReason", $this->record));
    }

    public function test_get_value_returns_third_level()
    {
        $this->assertEquals('York', Dotty::getValue("donor.address.billingCity", $this->record));
        $this->assertEquals('GB', Dotty::getValue("donor.address.billingCountry", $this->record));
    }

    public function test_get_value_returns_null_for_none_value()
    {
        $this->assertNull(Dotty::getValue("cheesecake", $this->record));
        $this->assertNull(Dotty::getValue("cheesecake.brisket", $this->record));
        $this->assertNull(Dotty::getValue("donor.address.missing", $this->record));
    }

    public function test_get_value_returns_empty_string_when_value_is_empty_string()
    {
        $this->assertEquals('', Dotty::getValue('donor.address.billingAddress1', $this->record));
        $this->assertEquals('', Dotty::getValue('donor.address.billingPhone', $this->record));
    }

    public function test_get_values_gets_all_required_values()
    {
        $this->assertEquals(
            [['First name' => 'Beck', 'Last name' => 'Herring']],
            Dotty::getValuesMultiple(
                ['First name' => 'donor.firstName', 'Last name' => 'donor.lastName'],
                [$this->record]
            )
        );

        $this->assertEquals(
            [
                ['Donor Last name' => 'Herring', 'Donor City' => 'York'],
                ['Donor Last name' => 'Herring', 'Donor City' => 'York']
            ],
            Dotty::getValuesMultiple(
                ['Donor Last name' => 'donor.lastName', 'Donor City' => 'donor.address.billingCity'],
                [$this->record, $this->record]
            )
        );

        $this->assertEquals(
            [
                [
                    'ID' => 22,
                    'Amount' => 44.00,
                    'Status' => 'fail',
                    'Created' => '2015-12-03 11:08:51',
                    'Gateway' => 'PayPal_Express',
                    'Donor Email' => 'gazyhof@gmail.com',
                    'Donor Title' => null,
                    'Donor First Name' => 'Beck',
                    'Donor Last Name' => 'Herring',
                    'Donor Address Line 1' => '',
                    'Donor Postcode' => 'YO31RP',
                    'Gift Aid' => 0,
                    'Reason for giving' => 'Reason 2',
                    'How did you hear about us?' => 'Family or Friend',
                ]
            ],
            Dotty::getValuesMultiple(
                $this->fields,
                [$this->record]
            )
        );
    }

}
