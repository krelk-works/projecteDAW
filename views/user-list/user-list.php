<main id="user-list-wrapper">
    <div id="user-list-container">
        <?php
            $UserController = new UserController();
            $totalUsers = $UserController->getTotalCount();
            $limit = 9; // Número máximo de obras por página
            $currentPagePagination = isset($_GET['pagination']) ? (int)$_GET['pagination'] : 1;
            $offset = ($currentPagePagination - 1) * $limit;
            $data = $UserController->getUsers($limit, $offset); // Asegúrate de modificar el método en el controlador
            foreach ($data as $user) {
                echo '<div class="user-list-item">
                    <div class="user-list-item-img">
                        <img src="' . $user['profileimg'] . '" alt="Obra 1">
                    </div>
                    <div class="user-list-item-info">
                        <h3>' . $user['firstname'] . ' ' . $user['lastname'] . '</h3>
                        <p> <i class="fa-solid fa-user"></i> '. $user['email'].'</p>
                        <p> <i class="fa-solid fa-bookmark"></i> '. $user['role'].'</p>
                        <a href="?page=user-administration"><button>Modificar</button></a>
                    </div>
                </div>';
            }
        ?>
    </div>
    <div id="user-list-pagination">
        <?php
            // CALCULATE TOTAL PAGES
            $totalPages = (int)ceil($totalUsers / $limit);

            // CSS VARS
            $disabledClass = 'pagination_disabled';
            $currentPaginationClass = 'current_pagination';

            // BOOLEAN VARS
            $isForwardDisabled = ($currentPagePagination >= $totalPages) ? true : false;
            $isBackwardDisabled = ($currentPagePagination <= 1) ? true : false;

            // PAGINATION BACK BUTTON
            if ($isBackwardDisabled) {
                echo '<button id="user-list-pagination-previous" class="' . $disabledClass . '">Anterior</button>';
            } else {
                echo '<button id="user-list-pagination-previous" onclick="location.href=\'?page=usuaris&pagination=' . (($currentPagePagination > 1) ? ($currentPagePagination - 1) : 1) . '\';">Anterior</button>';
            }
            
            // PAGINATION PAGES
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<button class="user-list-pagination-page ' . ($currentPagePagination == $i ? 'current_pagination' : '') . '" onclick="location.href=\'?page=usuaris&pagination=' . $i . '\'">' . $i . '</button>';
            }  

            // PAGINATION NEXT BUTTON
            if ($isForwardDisabled) {
                echo '<button id="user-list-pagination-next" class="' . $disabledClass . '">Següent</button>';
            } else {
                echo '<button id="user-list-pagination-next" onclick="location.href=\'?page=usuaris&pagination=' . (($currentPagePagination <= $totalPages) ? ($currentPagePagination + 1) : $totalPages) . '\';">Següent</button>';
            }
        ?>
    </div>
</main>
