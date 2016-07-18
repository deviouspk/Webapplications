<?php

class Template
{
    private $login;
    
    public function __construct($login) {
        $this->login=$login;
    }

    public function printSidebar()
    {
        echo '<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <h3>' . ucfirst($this->login->getRankName()) . '</h3>
                                <ul class="nav side-menu">
                                    <li><a href="../index.php"><i class="fa fa-home"></i> Home</a>
                                    </li>
                                    <li><a href="../logs.php"><i class="fa fa-bar-chart-o"></i> Logs</a>
                                    </li>
                                    <li><a href="../drops.php"><i class="fa fa-bug"></i> Drops</a>
                                    </li>';
                                    if( $this->login->hasPermission(Rank::HEAD_MODERATOR)){
                                        echo '<li><a href="../admin.php"><i class="fa fa-desktop"></i> Admin Panel</a>
                                    </li>';
                                    }
                                    echo'</ul>
                    </div>
              </div>';
    }

    public function printTopNavigation()
    {
        echo '<div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <img src="images/img.jpg" alt="">' . ucfirst($this->login->getName()) . '
<span class=" fa fa-angle-down"></span>
</a>
<ul class="dropdown-menu dropdown-usermenu pull-right">
    <li><a href="javascript:;"> Profile</a></li>
    <li>
        <a href="javascript:;">
            <span class="badge bg-red pull-right">50%</span>
            <span>Settings</span>
        </a>
    </li>
    <li><a href="javascript:;">Help</a></li>
    <li><a href="login.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
</ul>
</li>

<li role="presentation" class="dropdown">
    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-envelope-o"></i>
        <span class="badge bg-green">6</span>
    </a>
    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
        <li>
            <a>
                <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
            </a>
        </li>
        <li>
            <a>
                <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
            </a>
        </li>
        <li>
            <a>
                <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
            </a>
        </li>
        <li>
            <a>
                <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
            </a>
        </li>
        <li>
            <div class="text-center">
                <a>
                    <strong>See All Alerts</strong>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </li>
    </ul>
</li>
</ul>
</nav>
</div>
</div>';
    }
    
    public function printFooterButtons(){
        echo '<div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout" href="../index.php/?logout=true">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>';
    }
    
    public function printPageTitle($title){
            echo '<div class="title_left">
                        <h3>'.$title.'</h3>
                  </div>';
    }
    public function printLogsSearchBar(){
        echo '<div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input id="searchform" type="text" class="form-control" placeholder="Search for...">


                                <span class="input-group-btn">
                      <div class="btn-group open">
                                    <button id="logTypeButton" data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="true"> <span id="type">Log Type</span> </button>
                                    <ul id="loglist" class="dropdown-menu">
                                        <li id="death"><a>Death Logs</a>
                                        </li>
                                        <li id="trade"><a>Trade Logs</a>
                                        </li>
                                        <li id="accountvalues"><a>Accountvalue Logs</a>
                                        </li>
                                    </ul>
                                </div>
                                  <button id="searchButton" class="btn btn-default" type="button">Search</button>
                    </span>
                            </div>
                        </div>
                    </div>';
    }
    
    public function printMenuProfile(){
        echo '<div class="profile">
                    <div class="profile_pic">
                        <img src="images/img.jpg" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Welcome,</span>
                        <h2>' . ucfirst($this->login->getName()) . '</h2>
                    </div>
                </div>';
    }
}