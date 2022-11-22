<?php

declare (strict_types=1);

/**
 * Inställningar för siten
 */
class Settings {

    private const settingsfile = __DIR__ . "/settings.json";

    /**
     * Hämtar alla inställningar i settingsfilen om den finns
     * annars returneras en tom standardklass
     * @return \stdClass
     */
    static function getSettings(): \stdClass {
        if (is_file(self::settingsfile)) {
            $fileContent = file_get_contents(self::settingsfile);
            $retur = json_decode($fileContent);
        } else {
            $retur = new stdClass;
        }

        return $retur;
    }

    /**
     * Sparar inställningar till settings-filen
     * @param string $key Inställning
     * @param string $value Värde
     */
    static function saveSettings(string $key, string $value) {
        $content = self::getSettings();
        $content->$key = $value;
        $fileContent = json_encode($content, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_PARTIAL_OUTPUT_ON_ERROR);
        file_put_contents(self::settingsfile, $fileContent);
    }

}

// 'rotmapp' => 'C:/Users/kjellh/OneDrive - Ålands Gymnasium/Git/gitkurs/'