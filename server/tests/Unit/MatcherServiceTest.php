<?php

namespace Tests\Unit;

use App\Services\MatcherService;
use PHPUnit\Framework\TestCase;
use App\Exceptions\InvalidCountException;

class MatcherServiceTest extends TestCase
{
    protected $matcher_service;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setup();
        $this->matcher_service = new MatcherService();
    }

    /**
     * @return void
     */
    public function testGetBestMatchesWithOneEmployee() : void
    {
        $employees = [
            0 => [
              "Name" => "Gabrielle Clarkson",
              "Email" => "tamas@me_example.com",
              "Division" => "Accounting",
              "Age" => "25",
              "Timezone" => "2"
            ],
        ];

        $this->expectException(InvalidCountException::class);

        $this->matcher_service->getBestMatches($employees);
    }

    /**
     * @return void
     */
    public function testGetBestMatchesForEmployee() : void
    {
        $employees = [
            0 => [
                "Name" => "Gabrielle Clarkson",
                "Email" => "tamas@me_example.com",
                "Division" => "Accounting",
                "Age" => "25",
                "Timezone" => "2"
            ],
            1 => [
                "Name" => "Zoe Peters",
                "Email" => "gozer@icloud_example.com",
                "Division" => "Finance",
                "Age" => "30",
                "Timezone" => "3",
            ],
            2 => [
                "Name" => "Jacob Murray",
                "Email" => "lstein@me_example.com",
                "Division" => "Accounting",
                "Age" => "22",
                "Timezone" => "2",
            ],
            3 => [
                "Name" => "Nicholas Vance",
                "Email" => "saridder@outlook_example.com",
                "Division" => "HR",
                "Age" => "35",
                "Timezone" => "4",
            ],
        ];

        $best = $this->matcher_service->getBestMatches($employees);

        $this->assertEquals($best, [
            0 => [
              0 => [
                "employee1" => "Zoe Peters",
                "employee2" => "Nicholas Vance",
                "score" => 30,
              ],
              1 => [
                "employee1" => "Gabrielle Clarkson",
                "employee2" => "Jacob Murray",
                "score" => 100,
              ],
              "average" => 65.0,
            ]
        ]);
    }

    /**
     * @return void
     */
    public function testPairWithTwoEmployee() : void
    {
        $employees = [
            0 => [
              "Name" => "Gabrielle Clarkson",
              "Email" => "tamas@me_example.com",
              "Division" => "Accounting",
              "Age" => "25",
              "Timezone" => "2"
            ],
            1 => [
              "Name" => "Zoe Peters",
              "Email" => "gozer@icloud_example.com",
              "Division" => "Finance",
              "Age" => "30",
              "Timezone" => "3",
            ],
        ];

        $employee_pairs = $this->matcher_service->pair($employees);

        $this->assertEquals($employee_pairs, [
            0 => [
              0 => [
                0 => [
                  "Name" => "Gabrielle Clarkson",
                  "Email" => "tamas@me_example.com",
                  "Division" => "Accounting",
                  "Age" => "25",
                  "Timezone" => "2",
                ],
                1 => [
                  "Name" => "Zoe Peters",
                  "Email" => "gozer@icloud_example.com",
                  "Division" => "Finance",
                  "Age" => "30",
                  "Timezone" => "3",
                ]
              ]
            ]
        ]);
    }

    /**
     * @return void
     */
    public function testPairWithThreeEmployee() : void
    {
        $employees = [
            0 => [
                "Name" => "Gabrielle Clarkson",
                "Email" => "tamas@me_example.com",
                "Division" => "Accounting",
                "Age" => "25",
                "Timezone" => "2"
            ],
            1 => [
                "Name" => "Zoe Peters",
                "Email" => "gozer@icloud_example.com",
                "Division" => "Finance",
                "Age" => "30",
                "Timezone" => "3",
            ],
            2 => [
                "Name" => "Jacob Murray",
                "Email" => "lstein@me_example.com",
                "Division" => "Accounting",
                "Age" => "22",
                "Timezone" => "2",
            ],
        ];

        $employee_pairs = $this->matcher_service->pair($employees);

        $this->assertEquals($employee_pairs, [
            0 => [
              0 => [
                "Name" => "Gabrielle Clarkson",
                "Email" => "tamas@me_example.com",
                "Division" => "Accounting",
                "Age" => "25",
                "Timezone" => "2",
              ],
              1 => [
                "Name" => "Zoe Peters",
                "Email" => "gozer@icloud_example.com",
                "Division" => "Finance",
                "Age" => "30",
                "Timezone" => "3",
              ]
            ],
            1 => [
              0 => [
                "Name" => "Gabrielle Clarkson",
                "Email" => "tamas@me_example.com",
                "Division" => "Accounting",
                "Age" => "25",
                "Timezone" => "2",
              ],
              1 => [
                "Name" => "Jacob Murray",
                "Email" => "lstein@me_example.com",
                "Division" => "Accounting",
                "Age" => "22",
                "Timezone" => "2",
              ],
            ],
            2 => [
              0 => [
                "Name" => "Zoe Peters",
                "Email" => "gozer@icloud_example.com",
                "Division" => "Finance",
                "Age" => "30",
                "Timezone" => "3",
              ],
              1 => [
                "Name" => "Jacob Murray",
                "Email" => "lstein@me_example.com",
                "Division" => "Accounting",
                "Age" => "22",
                "Timezone" => "2",
              ]
            ]
        ]);
    }

    /**
     * @return void
     */
    public function testPairWithMultipleEmployee() : void
    {
        $employees = [
            0 => [
                "Name" => "Gabrielle Clarkson",
                "Email" => "tamas@me_example.com",
                "Division" => "Accounting",
                "Age" => "25",
                "Timezone" => "2"
            ],
            1 => [
                "Name" => "Zoe Peters",
                "Email" => "gozer@icloud_example.com",
                "Division" => "Finance",
                "Age" => "30",
                "Timezone" => "3",
            ],
            2 => [
                "Name" => "Jacob Murray",
                "Email" => "lstein@me_example.com",
                "Division" => "Accounting",
                "Age" => "22",
                "Timezone" => "2",
            ],
            3 => [
                "Name" => "Nicholas Vance",
                "Email" => "saridder@outlook_example.com",
                "Division" => "HR",
                "Age" => "35",
                "Timezone" => "4",
            ],
            4 => [
                "Name" => "Jason Hamilton",
                "Email" => "osaru@live_example.com",
                "Division" => "HR",
                "Age" => "35",
                "Timezone" => "4",
            ],
        ];

        $employee_pairs = $this->matcher_service->pair($employees);

        dump( $employee_pairs);
        $this->assertEquals($employee_pairs, [
            0 => [
              0 => [
                "Name" => "Jacob Murray",
                "Email" => "lstein@me_example.com",
                "Division" => "Accounting",
                "Age" => "22",
                "Timezone" => "2",
              ],
              1 => [
                "Name" => "Nicholas Vance",
                "Email" => "saridder@outlook_example.com",
                "Division" => "HR",
                "Age" => "35",
                "Timezone" => "4",
              ],
              2 => [
                0 => [
                  "Name" => "Gabrielle Clarkson",
                  "Email" => "tamas@me_example.com",
                  "Division" => "Accounting",
                  "Age" => "25",
                  "Timezone" => "2",
                ],
                1 => [
                  "Name" => "Zoe Peters",
                  "Email" => "gozer@icloud_example.com",
                  "Division" => "Finance",
                  "Age" => "30",
                  "Timezone" => "3",
                ],
                ],
            ],
            1 => [
              0 => [
                "Name" => "Jacob Murray",
                "Email" => "lstein@me_example.com",
                "Division" => "Accounting",
                "Age" => "22",
                "Timezone" => "2",
              ],
              1 => [
                "Name" => "Jason Hamilton",
                "Email" => "osaru@live_example.com",
                "Division" => "HR",
                "Age" => "35",
                "Timezone" => "4",
              ],
              2 => [
                0 => [
                  "Name" => "Gabrielle Clarkson",
                  "Email" => "tamas@me_example.com",
                  "Division" => "Accounting",
                  "Age" => "25",
                  "Timezone" => "2",
                ],
                1 => [
                  "Name" => "Zoe Peters",
                  "Email" => "gozer@icloud_example.com",
                  "Division" => "Finance",
                  "Age" => "30",
                  "Timezone" => "3",
                ]
              ]
            ],
            2 => [
              0 => [
                "Name" => "Nicholas Vance",
                "Email" => "saridder@outlook_example.com",
                "Division" => "HR",
                "Age" => "35",
                "Timezone" => "4",
              ],
              1 => [
                "Name" => "Jason Hamilton",
                "Email" => "osaru@live_example.com",
                "Division" => "HR",
                "Age" => "35",
                "Timezone" => "4",
              ],
              2 => [
                0 => [
                  "Name" => "Gabrielle Clarkson",
                  "Email" => "tamas@me_example.com",
                  "Division" => "Accounting",
                  "Age" => "25",
                  "Timezone" => "2",
                ],
                1 => [
                  "Name" => "Zoe Peters",
                  "Email" => "gozer@icloud_example.com",
                  "Division" => "Finance",
                  "Age" => "30",
                  "Timezone" => "3",
                ]
              ]
            ],
            3 => [
              0 => [
                "Name" => "Zoe Peters",
                "Email" => "gozer@icloud_example.com",
                "Division" => "Finance",
                "Age" => "30",
                "Timezone" => "3",
              ],
              1 => [
                "Name" => "Nicholas Vance",
                "Email" => "saridder@outlook_example.com",
                "Division" => "HR",
                "Age" => "35",
                "Timezone" => "4",
              ],
              2 => [
                0 => [
                  "Name" => "Gabrielle Clarkson",
                  "Email" => "tamas@me_example.com",
                  "Division" => "Accounting",
                  "Age" => "25",
                  "Timezone" => "2",
                ],
                1 => [
                  "Name" => "Jacob Murray",
                  "Email" => "lstein@me_example.com",
                  "Division" => "Accounting",
                  "Age" => "22",
                  "Timezone" => "2",
                ]
              ]
            ],
            4 => [
              0 => [
                "Name" => "Zoe Peters",
                "Email" => "gozer@icloud_example.com",
                "Division" => "Finance",
                "Age" => "30",
                "Timezone" => "3",
              ],
              1 => [
                "Name" => "Jason Hamilton",
                "Email" => "osaru@live_example.com",
                "Division" => "HR",
                "Age" => "35",
                "Timezone" => "4",
              ],
              2 => [
                0 => [
                  "Name" => "Gabrielle Clarkson",
                  "Email" => "tamas@me_example.com",
                  "Division" => "Accounting",
                  "Age" => "25",
                  "Timezone" => "2",
                ],
                1 => [
                  "Name" => "Jacob Murray",
                  "Email" => "lstein@me_example.com",
                  "Division" => "Accounting",
                  "Age" => "22",
                  "Timezone" => "2",
                ]
              ]
            ],
            5 => [
              0 => [
                "Name" => "Nicholas Vance",
                "Email" => "saridder@outlook_example.com",
                "Division" => "HR",
                "Age" => "35",
                "Timezone" => "4",
              ],
              1 => [
                "Name" => "Jason Hamilton",
                "Email" => "osaru@live_example.com",
                "Division" => "HR",
                "Age" => "35",
                "Timezone" => "4",
              ],
              2 => [
                0 => [
                  "Name" => "Gabrielle Clarkson",
                  "Email" => "tamas@me_example.com",
                  "Division" => "Accounting",
                  "Age" => "25",
                  "Timezone" => "2",
                ],
                1 => [
                  "Name" => "Jacob Murray",
                  "Email" => "lstein@me_example.com",
                  "Division" => "Accounting",
                  "Age" => "22",
                  "Timezone" => "2",
                ]
              ]
            ],
            6 => [
              0 => [
                "Name" => "Zoe Peters",
                "Email" => "gozer@icloud_example.com",
                "Division" => "Finance",
                "Age" => "30",
                "Timezone" => "3",
              ],
              1 => [
                "Name" => "Jacob Murray",
                "Email" => "lstein@me_example.com",
                "Division" => "Accounting",
                "Age" => "22",
                "Timezone" => "2",
              ],
              2 => [
                0 => [
                  "Name" => "Gabrielle Clarkson",
                  "Email" => "tamas@me_example.com",
                  "Division" => "Accounting",
                  "Age" => "25",
                  "Timezone" => "2",
                ],
                1 => [
                  "Name" => "Nicholas Vance",
                  "Email" => "saridder@outlook_example.com",
                  "Division" => "HR",
                  "Age" => "35",
                  "Timezone" => "4",
                ]
              ]
            ],
            7 => [
              0 => [
                "Name" => "Zoe Peters",
                "Email" => "gozer@icloud_example.com",
                "Division" => "Finance",
                "Age" => "30",
                "Timezone" => "3",
              ],
              1 => [
                "Name" => "Jason Hamilton",
                "Email" => "osaru@live_example.com",
                "Division" => "HR",
                "Age" => "35",
                "Timezone" => "4",
              ],
              2 => [
                0 => [
                  "Name" => "Gabrielle Clarkson",
                  "Email" => "tamas@me_example.com",
                  "Division" => "Accounting",
                  "Age" => "25",
                  "Timezone" => "2",
                ],
                1 => [
                  "Name" => "Nicholas Vance",
                  "Email" => "saridder@outlook_example.com",
                  "Division" => "HR",
                  "Age" => "35",
                  "Timezone" => "4",
                ]
              ]
            ],
            8 => [
              0 => [
                "Name" => "Jacob Murray",
                "Email" => "lstein@me_example.com",
                "Division" => "Accounting",
                "Age" => "22",
                "Timezone" => "2",
              ],
              1 => [
                "Name" => "Jason Hamilton",
                "Email" => "osaru@live_example.com",
                "Division" => "HR",
                "Age" => "35",
                "Timezone" => "4",
              ],
              2 => [
                0 => [
                  "Name" => "Gabrielle Clarkson",
                  "Email" => "tamas@me_example.com",
                  "Division" => "Accounting",
                  "Age" => "25",
                  "Timezone" => "2",
                ],
                1 => [
                  "Name" => "Nicholas Vance",
                  "Email" => "saridder@outlook_example.com",
                  "Division" => "HR",
                  "Age" => "35",
                  "Timezone" => "4",
                ]
              ]
            ],
            9 => [
              0 => [
                "Name" => "Zoe Peters",
                "Email" => "gozer@icloud_example.com",
                "Division" => "Finance",
                "Age" => "30",
                "Timezone" => "3",
              ],
              1 => [
                "Name" => "Jacob Murray",
                "Email" => "lstein@me_example.com",
                "Division" => "Accounting",
                "Age" => "22",
                "Timezone" => "2",
              ],
              2 => [
                0 => [
                  "Name" => "Gabrielle Clarkson",
                  "Email" => "tamas@me_example.com",
                  "Division" => "Accounting",
                  "Age" => "25",
                  "Timezone" => "2",
                ],
                1 => [
                  "Name" => "Jason Hamilton",
                  "Email" => "osaru@live_example.com",
                  "Division" => "HR",
                  "Age" => "35",
                  "Timezone" => "4",
                ],
              ]
            ],
            10 => [
              0 => [
                "Name" => "Zoe Peters",
                "Email" => "gozer@icloud_example.com",
                "Division" => "Finance",
                "Age" => "30",
                "Timezone" => "3",
              ],
              1 => [
                "Name" => "Nicholas Vance",
                "Email" => "saridder@outlook_example.com",
                "Division" => "HR",
                "Age" => "35",
                "Timezone" => "4",
              ],
              2 => [
                0 => [
                  "Name" => "Gabrielle Clarkson",
                  "Email" => "tamas@me_example.com",
                  "Division" => "Accounting",
                  "Age" => "25",
                  "Timezone" => "2",
                ],
                1 => [
                  "Name" => "Jason Hamilton",
                  "Email" => "osaru@live_example.com",
                  "Division" => "HR",
                  "Age" => "35",
                  "Timezone" => "4",
                ]
              ]
            ],
            11 => [
              0 => [
                "Name" => "Jacob Murray",
                "Email" => "lstein@me_example.com",
                "Division" => "Accounting",
                "Age" => "22",
                "Timezone" => "2",
              ],
              1 => [
                "Name" => "Nicholas Vance",
                "Email" => "saridder@outlook_example.com",
                "Division" => "HR",
                "Age" => "35",
                "Timezone" => "4",
              ],
              2 => [
                0 => [
                  "Name" => "Gabrielle Clarkson",
                  "Email" => "tamas@me_example.com",
                  "Division" => "Accounting",
                  "Age" => "25",
                  "Timezone" => "2",
                ],
                1 => [
                  "Name" => "Jason Hamilton",
                  "Email" => "osaru@live_example.com",
                  "Division" => "HR",
                  "Age" => "35",
                  "Timezone" => "4",
                ]
              ]
            ]
        ]);
    }
}
