<header class="header">
            <div class="logo-container">
                <a href="http://www.peigriega.com/Digicolors" class="logo">
                    <img src="assets/images/logo.png" height="35" alt="Digicolors" />
                </a>
                <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
                    <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                </div>
            </div>

            <!-- start: search & user box -->
            <div class="header-right">

                <span class="separator"></span>

                <div id="userbox" class="userbox">
                    <a href="#" data-toggle="dropdown">
                        <figure class="profile-picture">
                            <img src="assets/images/%21logged-user.jpg" alt="<?php echo $_SESSION['MS_USER_NAME']?>" class="img-circle" data-lock-picture="assets/images/%21logged-user.jpg" />
                        </figure>
                        <div class="profile-info" data-lock-name="<?php echo $_SESSION['MS_USER_NAME']?>" >
                            <span class="name"><?php echo $_SESSION['MS_USER_NAME']?></span>
                            <span class="role"><?php echo $_SESSION['MS_USER_ROL_NAME']?></span>
                        </div>

                        <i class="fa custom-caret"></i>
                    </a>

                    <div class="dropdown-menu">
                        <ul class="list-unstyled">
                            <li class="divider"></li>
                            <li>
                                <a role="menuitem" tabindex="-1" href="#"><i class="fa fa-user"></i> Mi Perfil</a>
                            </li>
                            <li>
                                <a role="menuitem" tabindex="-1" href="includes/login/cerrar_sesion.php"><i class="fa fa-power-off"></i> Cerrar Sesión</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- end: search & user box -->
        </header>