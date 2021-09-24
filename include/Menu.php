<?php

declare (strict_types=1);

/**
 * Description of Menu
 *
 * @author kjellh
 */
class Menu {

    private $top;
    private $baseDir;

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

    public function getMenu(string $path): array {
        $fullmenu = array_merge($this->top, $this->readPath($path, "$this->baseDir/"));

        return $fullmenu;
    }

    private function readPath(string $path, string $relPath): array {
        $curPath = scandir($path);
        $subMenu = [];
        foreach ($curPath as $item) {
            if (is_file("$path/$item")) {
                $menuItem = new stdClass();
                if (mb_strrpos($item, ".")) {
                    $itemName = mb_substr($item, 0, mb_strrpos($item, "."));
                } else {
                    $itemName = $item;
                }
                $menuItem->text = $itemName;
                $menuItem->url = "$relPath/$item";
                $subMenu[] = $menuItem;
            } else {
                if (substr($item, 0, 1) !== ".") {
                    $menuItem = new stdClass();
                    $menuItem->text = $item;
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

    public function parseArray(array $menu): string {
        $retur = "<ul class='nav'>";
        foreach ($menu as $item) {
            $retur .= "<li>";
            if (isset($item->url)) {
                $retur .= "<a href='$item->url'>$item->text</a>";
            } else {
                $retur .= "$item->text";
            }
            if (isset($item->subMenu)) {
                $retur .= $this->parseArray($item->subMenu);
            }
            $retur .= "</li>";
        }
        $retur .= "</ul>";

        return $retur;
    }

}
