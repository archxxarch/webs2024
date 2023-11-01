<?php
        include "../connect/session.php";
?>



<header id="header">
    <div class="header_wrap">
        <h1 class="logo">
            <a href="../index.html"><img src="../assets/img/logo.png" alt=""></a>
        </h1>
        <nav>
            <ul>
                <li><a href="#">교복소개</a></li>
                <li><a href="#">인기순위</a></li>
                <li><a href="../board/board.php">수다방</a></li>
                <?php if(isset($_SESSION['memberId'])){ ?>
                    <ul>
                        <li><a href="#"><?=$_SESSION['youName']?> 님 환영합니다.</a></li>
                        <li><a href="../login/logout.php"><img src="../assets/img/로그아웃.png" alt=""></a></li>
                    </ul>
                <?php } else { ?>
                    <ul>
                        <li><a href="../login/login.php">LOGIN</a></li>
                        <li><a href="../join/join.php">JOIN</a></li>
                    </ul>
                <?php } ?>
                <!-- <li><a href="../login/login.php">LOGIN</a></li>
                <li><a href="../join/join.php">JOIN</a></li> -->
            </ul>
        </nav>    
        <div class="m_menu">
            <a class="menu-trigger" href="#">
                <span></span>
                <span></span>
                <span></span>
            </a>
        </div>
    </div>
</header>