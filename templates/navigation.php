<nav class="nav bg-dark text-white p-2">
    <li class="nav-item">
        <?php if ($_GET["page"] == "home") {?>
        <a href="/?page=home" class="nav-link disabled">Home</a>
        <?php } else {?>
        <a href="/?page=home" class="nav-link">Home</a>
        <?php }?>
    </li>
    <li class="nav-item">
        <?php if ($_GET["page"] == "login") {?>
        <a href="/?page=login" class="nav-link disabled">Login</a>
        <?php } else {?>
        <a href="/?page=login" class="nav-link">Login</a>
        <?php }?>
    </li>
    <li class="nav-item">
        <?php if ($_GET["page"] == "register") {?>
        <a href="/?page=register" class="nav-link disabled">Register</a>
        <?php } else {?>
        <a href="/?page=register" class="nav-link">Register</a>
        <?php }?>
    </li>
    <li class="nav-item">
        <?php if ($_GET["page"] == "about") {?>
        <a href="/?page=about" class="nav-link disabled">About me</a>
        <?php } else {?>
        <a href="/?page=about" class="nav-link">About me</a>
        <?php }?>
    </li>
</nav>