<html>
    <head>
        <title>Admin Dashboard</title>
        <?php $conn=mysqli_connect("localhost", "root", "", "clubpenguinProject");?>
    </head>
    <body>
        <div id="side-navbar">
            <!--buttons: Account, Dashboard, Orders, Settings,          Log Out-->
        </div>
        <div id="main-container">
            <nav>
                <div id="left-nav">
                    <!--LOGO,       display- Hello Admin 'username'-->
                </div>
                <div id="right-nav">
                    <!--Log Out button-->
                </div>
            </nav>
            <main>
                <article id="left-main">
                    <section class="table-container">
                        <div class="top-part">
                            <div class="top-left-part">
                                <!--Table1: Users,     button: Action= add-->
                            </div>
                            <div class="top-right-part">
                                <!--Search bar for Table1-->
                            </div>
                        </div>
                        <div class="lower-part">
                            <!--
                            Table 1
                                Table rows,          buttons: Action= edit, delete
                            -->
                        </div>
                    </section>

                    <section class="table-container">
                        <div class="top-part">
                            <div class="top-left-part">
                                <!--Table2: Cars,     button: Action= add-->
                            </div>
                            <div class="top-right-part">
                                <!--Search bar for Table2-->
                            </div>
                        </div>
                        <div class="lower-part">
                            <!--
                            Table 2
                                Table rows,          buttons: Action= edit, delete
                            -->
                        </div>
                    </section>

                    <section class="table-container">
                        <div class="top-part">
                            <div class="top-left-part">
                                <!--Table3: Confirmed Orders,     Orders button-->
                            </div>
                            <div class="top-right-part">
                                <!--Search bar for Table3-->
                            </div>
                        </div>
                        <div class="lower-part">
                            <!--
                            Table 3
                                Table rows,          button: Action= cancel
                            -->
                        </div>
                    </section>
                </article>
                <aside id="right-main">
                    <div>
                        <!--Analytics of total users -->
                    </div>
                    <div>
                        <!--Analytics of total pending orders -->
                    </div>
                    <div>
                        <!--Analytics of total confirmed orders -->
                    </div>
                </aside>
            </main>
        </div>
    </body>
</html>