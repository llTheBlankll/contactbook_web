<nav class="navbar navbar-dark text-white bg-dark navbar-expand">
    <div class="container-fluid">
        <div class="navbar-brand">CB</div>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav">
                <div class="nav-item">
                    <a href="/dashboard/" class="nav-link">Home</a>
                </div>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-address-book fa-lg"></i>
                        <span>Contacts</span>
                    </a>
                    <div class="dropdown-menu">
                        <li>
                            <a href="?page=save" class="dropdown-item">Save contact</a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a href="?page=clear" class="dropdown-item">Clear all contacts</a>
                        </li>
                    </div>
                </div>
            </ul>
        </div>
        <div class="float-end dropdown">
            <a href="#" class="dropdown-toggle nav-link text-decoration-none text-white" data-bs-toggle="dropdown">
                <i class="fas fa-user-circle fa-lg" style="font-size: 18px;margin-right: 4px;"></i>
                <span><?php echo getLoggedUser(); ?></span>
            </a>
            <div class="dropdown-menu" id="dropdownUser">
                <li>
                    <a href="/dashboard/settings/" class="dropdown-item">Settings</a>
                </li>
                <li>
                    <a href="logout.php" class="dropdown-item">Logout</a>
                </li>
            </div>
        </div>
    </div>
</nav>