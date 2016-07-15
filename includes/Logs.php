<?php

require_once '../libs/AutoLoader.php';

class Logs
{
    private $playerData;
    private $logsData;
    private $core;


    public function printLogs()
    {
        $logType = $this->getLogType();
        $name = $this->getName();
        $id = $this->getID();
        if ( $logType == "accountvalues") {
            $this->printAccountValueLogs();
        }
        elseif ($logType == "trade" ) {
            if(isset($name)){
                $this->printTradeLogs();
            }
            elseif(isset($id)){
                echo '<h1>TODO</h1>';
            }
            else{
                $this->enterName();
            }
        }
    }

    private function initPlayerData()
    {
        if (!isset($this->playerData)) {
            $this->playerData = new PlayerData();
        }
    }

    private function initLogsData()
    {
        if (!isset($this->logsData)) {
            $this->logsData = new LogsData();
        }
    }

    private function initCore()
    {
        if (!isset($this->core)) {
            $this->core = new Core();
        }
    }

    private function enterName(){
        echo '<h2>Please Enter A Playername</h2>';
    }

    private function getLookupTitle($ip = 'Here Comes IP', $mac = 'Here Comes MAC')
    {
        $name = $this->getName();

        if (isset($name)) {
            return ucfirst($this->getLogType()) . '<small>' . $name . '</small> | ' . $ip . ' | ' . $mac;
        } else {
            return ucfirst($this->getLogType()) . '<small>ALL</small>';
        }
    }
    public function printPageTitle()
    {
        echo ucwords($this->getLogType()).' Logs';
    }

    private function getName()
    {
        if (isset($_GET["name"])) {
            $this->initCore();
            return (string)$this->core->normalizeUsername($_GET["name"]);
        } else {
            return null;
        }
    }

    private function getLogType()
    {
        if (isset($_GET["logtype"])) {
            return (string)$_GET["logtype"];
        } else {
            return null;
        }

    }
    private function getID()
    {
        if (isset($_GET["id"])) {
            return (string)$_GET["id"];
        } else {
            return null;
        }

    }


    private function printAccountValueLogs()
    {
        $this->initPlayerData();

        $playerValuesArray = $this->playerData->getAccountvalues();

        echo '<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title"><h2>' . $this->getLookupTitle() . '</h2>
                        <div class="clearfix"></div>
                    </div>
                        <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%"><thead>
                        <tr>
                          <th>Rank</th>
                          <th>Playername</th>
                          <th>GP Value (Mil)</th>
                          <th>DP Value ($)</th>
                          <th>Weighted Acc Value</th>
                        </tr>
                      </thead>
                      
                      <tbody>';
        $i = 1;
        foreach ($playerValuesArray as $key => $playerValue) {

            if (isset($playerValue)) {
                echo '<tr>';
                echo '<td>' . $i . '</td>';
                echo '<td>' . $playerValue["name"] . '</td>';
                echo '<td>' . $playerValue["gp"] . '</td>';
                echo '<td>' . $playerValue["dp"] . '</td>';
                echo '<td>' . $playerValue["accworth"] . '</td>';
                echo '</tr>';
            }
            $i++;
        }
        echo '</tbody></table>

                        </div>
                    </div>
                </div>';

    }

    private function printTradeLogs()
    {
        $this->initLogsData();
        $this->initCore();

        $cursor = $this->logsData->getTradeLogsData($this->getName());

        echo '<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title"><h2>' . $this->getLookupTitle() . '</h2>
                        <div class="clearfix"></div>
                    </div>
                        <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%"><thead>
                        <tr>
                          <th>TradeID</th>
                          <th>TimeStamp</th>
                          <th>Traded With</th>
                          <th>Trade Value GP (Mil)</th>
                          <th>Trade Value DP ($)</th>
                          <th>Trade Weighted Value</th>
                        </tr>
                      </thead>
                      
                      <tbody>';

        foreach ($cursor as $trade) {
            if ($trade['content']['user']['player-name'] == $this->getName()) {
                $name = $trade['content']['user-2']['player-name'];
            } else {
                $name = $trade['content']['user']['player-name'];
            }
            if (isset($trade)) {
                echo '<tr>';
                echo '<td><a href="../logs.php?logtype=trade&id=' . $trade["_id"] . '">' . $trade["_id"] . '</a></td>';
                echo '<td>' . $this->core->convertToTime($trade['time']) . '</td>';
                echo '<td>' . $name . '</td>';
                echo '<td>TODO</td>';
                echo '<td>TODO</td>';
                echo '<td>TODO</td>';
                echo '</tr>';
            }
        }
        echo '</tbody></table>

                        </div>
                    </div>
                </div>';
    }


}