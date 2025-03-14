<?php include('app/views/Layout/NavBar.php'); ?>
<?php include('app\views\Layout\LoginSection.php') ?>

<!-- Header Section -->
<header id="header" class="header-section section-animation">
    <a href="#infolab" class="discover-button">Discover</a>
</header>
<!-- Fin de la Header Section -->
<?php include('app\views\Layout\InfolabSection.php') ?>
<?php include('app\views\Layout\EnactusSection.php') ?>
<?php include('app\views\Layout\ClubRadio.php') ?>
<!-- Map Section -->
<section id="map" class="section-animation">
    <h5><strong>Our location</strong></h5>
    <div class="mapHome">
        <div>
            <div id="home_map">
                <div class="map_canvas">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7599.725803087307!2d10.172196108299469!3d36.78757052997988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12fd3408c0a06d69%3A0x3b8c5efde9487a09!2sESSECT%2C%20Ave%20Ali%20Trad%2C%20Tunis!5e0!3m2!1sfr!2stn!4v1587574590390!5m2!1sfr!2stn"
                        width="100%" height="400" style="border:0;" allowfullscreen="" aria-hidden="false"
                        tabindex="0"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Fin de la Map Section -->
<?php include('app\views\Layout\Footer.php') ?>