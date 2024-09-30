<?php 
    session_start();
?>
<main id="home-list-wrapper">
    <div id="home-list-container">
        <?php
            $ArtworkController = new ArtworkController();
            $data = $ArtworkController->getData();
            foreach ($data as $artwork) {
                echo '<div class="home-list-item">';
                    echo '<div class="home-list-item-img">';
                        echo '<img src="'.$artwork['URL'].'" alt="Obra 1">';
                    echo '</div>';
                    echo '<div class="home-list-item-info">';
                        echo '<h3>'.$artwork['Artwork_name'].'</h3>';
                        echo '<p><i class="fa-solid fa-user"></i> '.$artwork['Author_name'].'</p>';
                        echo '<p><i class="fa-solid fa-location-dot"></i> '.$artwork['Location_name'].'</p>';
                        echo '<p><i class="fa-solid fa-bookmark"></i> '.$artwork['Creation_date'].'</p>';
                        echo '<p><i class="fa-regular    fa-clipboard"></i> Museu</p>';
                    echo '</div>';
                echo '</div>';
            }
        ?>
    </div>
    <div id="home-list-pagination">
        <button id="home-list-pagination-previous">Anterior</button>
        <button class="home-list-pagination-page">1</button>
        <button class="home-list-pagination-page">2</button>
        <button class="home-list-pagination-page">3</button>
        <button id="home-list-pagination-next">Següent</button>
    </div>
</main>