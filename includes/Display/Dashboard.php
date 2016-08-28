<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 29/08/2016
 * Time: 0:26
 */
class Dashboard
{
    private $core;
    private $player;
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function printTopPVMKills()
    {
        $topPVMKills = $this->getPlayerData()->getTopPVMKills();

        echo ' <div class="col-md-4 col-sm-4 col-xs-12"><div class="x_panel tile fixed_height_320">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Top 5 PvM Kills </h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <table class="table">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>NPC Name</th>
                          <th>Kill Count</th>
                        </tr>
                      </thead>
                      <tbody>';

        $i = 1;
        foreach ($topPVMKills as $topPVMKill) {
            echo '<tr>
                          <th scope="row">' . $i . '</th>
                          <td>' . $topPVMKill['_id'] . '</td>
                          <td>' . $topPVMKill['amount'] . '</td>
                        </tr>';
            $i++;
        }
        echo '</tbody>
                    </table>

                  </div>
                </div>
              </div>
              </div>';
    }

    private function getPlayerData()
    {
        if (!isset($this->player)) {
            $this->player = new PlayerInfo($this->getName());
        }
        return $this->player;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    public function printExperienceGained()
    {
        $topPVMKills = $this->getPlayerData()->getTopPVMKills();

        echo ' <div class="col-md-4 col-sm-4 col-xs-12"><div class="x_panel tile fixed_height_320">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Experience Gained</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <table class="table">
                      <thead>
                        <tr>
                          <th>Time</th>
                          <th>Experience Increase</th>
                        </tr>
                      </thead>
                      <tbody>';

        $i = 1;
        foreach ($topPVMKills as $topPVMKill) {
            echo '<tr>
                          <td>' . $topPVMKill['_id'] . '</td>
                          <td>' . $topPVMKill['amount'] . '</td>
                        </tr>';
            $i++;
        }
        echo '</tbody>
                    </table>

                  </div>
                </div>
              </div>
              </div>';
    }

    public function printLatestDuels()
    {
        $topPVMKills = $this->getPlayerData()->getTopPVMKills();

        echo ' <div class="col-md-4 col-sm-4 col-xs-12"><div class="x_panel tile fixed_height_320">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Latest Duels</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <table class="table">
                      <thead>
                        <tr>
                          <th>Opponent Name</th>
                          <th>Outcome</th>
                          <th>Stake Value</th>
                        </tr>
                      </thead>
                      <tbody>';

        $i = 1;
        foreach ($topPVMKills as $topPVMKill) {
            echo '<tr>
                          <td>' . $topPVMKill['_id'] . '</td>
                          <td>WON</td>
                          <td>' . $topPVMKill['amount'] . '</td>
                        </tr>';
            $i++;
        }
        echo '</tbody>
                    </table>

                  </div>
                </div>
              </div>
              </div>';
    }

    private function getCore()
    {
        if (!isset($this->core)) {
            $this->core = new Core();
        }
        return $this->core;
    }

}