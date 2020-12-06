<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome to MeowTel!</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/aboutUs.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<?php
include("header.php");
?>
<main>
    <section>
        <div id="mainContainer">
            <div id="bioContainer">
                <div class="bio">
                    <div class="bioImage">
                        <img src="images/bio/sarah.jpg" alt="woman">
                    </div>
                    <div class="bioText">
                        <h3>Sarah</h3>
                        <p> Data Engineering intern with a demonstrated history
                            of working in the real estate industry.
                            Skilled in Database, Python, Data Analysis,
                            and Quantitative Analytics. Strong information
                            technology professional with a Master's degree
                            focused in Management and Systems
                            from New York University. </p>
                        <p><b>Worked on</b> ERD diagram, index page, header and footer, reservation page,
                        about us page, cat page, and PHP validation rules.</p>
                    </div>
                </div>
                <div class="bio">
                    <div class="bioImage">
                        <img src="images/bio/jiyu.jpg" alt="woman">
                    </div>
                    <div class="bioText">
                        <h3>Jiyu</h3>
                        <p>Highly analytical Senior Software Developer and Project Manager
                            with strong software engineering experience supporting development
                            projects for a fintech firm. Proven ability to lead design teams in
                            high-performance transactional front and back-end development. </p>
                        <p><b>Worked on</b> ERD diagram, welcome video, admin pages, confirmation page</p>
                    </div>
                </div>
                <div class="bio">
                    <div class="bioImage">
                        <img src="images/bio/zanchi.jpg" alt="woman">
                    </div>
                    <div class="bioText">
                        <h3>Zanchi</h3>
                        <p>Strong knowledge of and experience with reporting packages (Business Objects etc),
                            databases (SQL etc). Knowledge of statistics and experience using statistical
                            packages for analyzing datasets. Strong analytical skills with the ability to collect,
                            organize, analyze, and disseminate significant amounts of information with attention
                            to detail and accuracy.</p>
                        <p><b>Worked on</b> ERD diagram, database, confirmation page</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
include("footer.php");
?>
</body>
</html>