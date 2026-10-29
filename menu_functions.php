<?php
function render_steampunk_menu($menu_data)
{
    ob_start();
    ?>
    <nav>
        <ul class="steampunk-menu">
            <?php foreach ($menu_data as $topic_key => $topic): ?>
                <li class="menu-item">
                    <!-- Pass the topic identifier in the URL -->
                    <a href="index.php?topic=<?php echo htmlspecialchars($topic['title']); ?>" class="menu-link">
                        <?php echo htmlspecialchars($topic['title']); ?>
                    </a>
                    <ul class="submenu">
                        <?php foreach ($topic['subtopics'] as $sub_key => $subtopic): ?>
                            <li class="submenu-item">
                                <!-- Pass both topic and subtopic in the URL -->
                              <!--  <a href="index.php?topic=<?php echo urlencode($topic_key); ?>&subtopic=<?php echo urlencode($sub_key); ?>" class="submenu-link">
                                   -->
                               <a href="index.php?topic=<?php echo htmlspecialchars($topic['title']); ?>&subtopic=<?php echo htmlspecialchars($subtopic); ?>" class="submenu-link">  
                              <?php echo htmlspecialchars($subtopic); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <?php
    return ob_get_clean();
}

function sucursales_steampunk_menu($menu_sucursales)
{
    ob_start();
    ?>
    <nav>
        <ul class="steampunk-menu">
            <?php foreach ($menu_sucursales as $topic_key => $topic): ?>
                <li class="menu-item">
   <?php switch ($topic['title']) {
            case 'Menu': ?>
         <a href="index.php?topic=<?php echo htmlspecialchars($topic['title']); ?>" class="menu-link">
    <?php break; ?>
        <?php case 'Agregar': ?>
         <a href="agregar_sucursal.php?topic=<?php echo htmlspecialchars($topic['title']); ?>" class="menu-link">
    <?php break; ?>
        <?php case 'Buscar': ?>
         <a href="prepara_busqueda_sucursal.php?topic=<?php echo htmlspecialchars($topic['title']); ?>" class="menu-link">
    <?php break; ?>
   
    <?php    } ?>
                    <!-- Pass the topic identifier in the URL -->
                        <?php echo htmlspecialchars($topic['title']); ?>
                    </a>
      
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <?php
    return ob_get_clean();
}

?>
 