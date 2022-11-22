<?php

declare (strict_types=1);

/**
 * Menu
 * Klass för hantering av meny
 * @author kjellh
 */
class Menu {

    private $top;
    private $baseDir;

    /**
     * Skapar en menystruktur baserat på filerna i en mapp
     * @param string $base
     */
    public function __construct(string $base) {
        $this->baseDir = $base;
        $hem = new stdClass();
        $hem->url = $this->baseDir . "/";
        $hem->text = "Hem";
        $menu[] = $hem;
        $about = new stdClass();
        $about->url = $this->baseDir . "/about";
        $about->text = "Om...";
        $menu[] = $about;
        $avgransare = new stdClass();
        $avgransare->text = "-";
        $menu[] = $avgransare;

        $this->top = $menu;
    }

    /**
     * Hämtar filer ur en mapp och returnerar dem som en array för anropande
     * funktion att hantera
     * @param string $path
     * @return array
     */
    public function getMenu(string $path): array {
        $fullmenu = array_merge($this->top, $this->readPath($path, "$this->baseDir/"));

        return $fullmenu;
    }

    /**
     * Läser en mapp rekursivt och returnerar innehållet som en array
     * @param string $path nuvarande mapp
     * @param string $relPath överliggande mapp
     * @return array
     */
    private function readPath(string $path, string $relPath): array {
        // Läs aktuell mapp
        $curPath = scandir($path);
        $subMenu = [];

        // Loopa igenom alla filer och mappar i 
        foreach ($curPath as $item) {
            if (is_file("$path/$item")) {
                // Aktuellt item är en fil!
                $menuItem = new stdClass();
                if (mb_strrpos($item, ".")) {
                    $itemName = mb_substr($item, 0, mb_strrpos($item, "."));
                } else {
                    $itemName = $item;
                }
                $menuItem->text = $itemName;
                $menuItem->url = "$relPath/$item";
                $menuItem->class = "file";
                $subMenu[] = $menuItem;
            } else {
                // Aktuellt item är en mapp
                if (substr($item, 0, 1) !== ".") {  // Hoppa över mappar som börjar med .
                    $menuItem = new stdClass();
                    $menuItem->text = $item;
                    $menuItem->class = "dir";
                    if (file_exists("content/{$item}.md")) {
                        $menuItem->url = "$this->baseDir/$item";
                    }
                    $menuItem->subMenu = $this->readPath("$path/$item", "$relPath./$item");
                    $subMenu[] = $menuItem;
                }
            }
        }
        return $subMenu;
    }

    /**
     * Konverterar en array av meny-objekt rekursivt till en punktlista i html
     * @param array $menu
     * @return string
     */
    public function parseArray(array $menu): string {
        $retur = "<ul class='nav'>";

        // Loopa igenom alla items i menyn
        foreach ($menu as $item) {
            if ($item->text === "-") {
                $retur .= "<hr>";
                continue;
            }
            if (isset($item->class) && $item->class === 'dir') {
                $retur .= "<li><img src='$this->baseDir/images/mapp.png' height=15>";
            } elseif (isset($item->class) && $item->class === 'file') {
                $retur .= "<li><img src='$this->baseDir/images/song.png' height=15>";
            } else {
                $retur .= "<li>";
            }
            if (isset($item->url)) {
                // aktuellt item har en url - lägg till en länk
                $retur .= " <a href='$item->url'>$item->text</a>";
            } else {
                // Skriv bara ut texten
                $retur .= " $item->text";
            }
            if (isset($item->subMenu)) {
                // aktuellt item har en undermeny - anropa parseArray
                $retur .= $this->parseArray($item->subMenu);
            }
            $retur .= "</li>";
        }
        $retur .= "</ul>";

        return $retur;
    }

}
