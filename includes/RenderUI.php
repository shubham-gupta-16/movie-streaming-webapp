<?php

class RenderUI
{
    public static function headComponents(string $title, string $basePath = './', ?array $css = null, ?array $js = null, string $extras = '')
    {
?>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?></title>
        <?php
        if ($css != null) {
            foreach ($css as $c) {
                echo '<link rel="stylesheet" href="' . $basePath . 'assets/css/' . $c . '"> ';
            }
        }
        if ($js != null) {
            foreach ($js as $j) {
                echo '<script src="' . $basePath . 'assets/js/' . $j . '"></script> ';
            }
        }
        echo $extras;
        ?>

    <?php
    }

    public static function footer(?array $js = null, string $basePath = './')
    {
    ?>
        <footer>
            <center>
                <p>This website was created for educational purpose.</p>
            </center>
        </footer>
        <?php
        if ($js != null) {
            foreach ($js as $j) {
                echo '<script src="' . $basePath . 'assets/javascript/' . $j . '"></script> ';
            }
        }
    }

    public static function navbar(?string $type = null, ?string $value = 'not-fixed')
    {
        $categories = [
            [
                'name' => 'Newly Added',
                'href' => './',
                'active' => $value == null
            ],
            [
                'name' => 'Bollywood',
                'href' => './?category=hindi-movies',
                'active' => $value == 'hindi-movies'
            ],
            [
                'name' => 'Hollywood',
                'href' => './?category=hollywood-movies',
                'active' => $value == 'hollywood-movies'
            ],
            [
                'name' => 'South Indian',
                'href' => './?category=south-movies',
                'active' => $value == 'south-movies'
            ],
        ];
        ?>
        <nav id="toolbar">
            <div class="container">
                <div class="logo">Movie App</div>
                <div class="navigation">
                    <div>
                        <form class="search" action="./" method="GET">
                            <span id="mobile-search-close" class="image-icon back-icon"></span>
                            <input type="text" name="s" placeholder="Search for a movie..." value="<?= $type == 's' ? $value : '' ?>">
                            <button type="submit" class="image-icon search-icon"></button>
                        </form>
                        <button type="submit" id="mobile-search-open" class="image-icon search-icon"></button>
                    </div>
                    <div class="nav-dropdown">
                        <span class="nav-item image-icon selector"></span>
                        <ul class="nav-dropdown-content">
                            <?php
                            foreach ($categories as $nav) {
                            ?>
                                <li>
                                    <a class="nav-item <?= $nav['active'] == true ? 'active' : '' ?>" href="<?= $nav['href'] ?>"><?= $nav['name'] ?></a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <?php
    }

    // small components

    public static function article(array $data)
    {
        ?>
        <a href="./document?uri=<?= $data['uri'] ?>" class="">
            <div class="doc-card">
                <div style="background-image: url(<?= $data['image'] ?>);"></div>
                <header>
                    <div class="d-name"><?= $data['name'] ?></div>
                    <div><?= $data['year'] ?></div>
                </header>
            </div>
        </a>
<?php
    }

    private static function getHref(int $page, $type, $value)
    {
        $href = "?page=" . $page;
        if ($type != null && $value != null) $href = "?$type=" . $value . self::appendPage("&", $page);
        else $href = self::appendPage("?", $page);
        return $href;
    }
    private static function appendPage(string $with, int $page)
    {
        if ($page > 1)
            return $with . "page=" . $page;
        else if ($with == "?")
            return "./";

        return "";
    }
}



function executeCurl(string $url, ?array $postArr = null) : ?string
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    if ($postArr != null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postArr));
    }

    // curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $server_output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($httpcode != 200) return null;
    return $server_output;
}
