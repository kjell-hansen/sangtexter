<?php
declare (strict_types=1);

// Inställningar för siten

class Settings{
    private $settingsfile=__DIR__ . "settings.json";
    static function getSettings():\stdClass {
        if (is_file(self::settingsfile)) {
            $fileContent= file_get_contents(self::settingsfile);
            $retur= json_decode($fileContent);
        } else {
            $retur=new stdClass;
        }
        
        return $retur;
    }
    
    static function saveSettings(string $key, string $value) {
        $content=self::getSettings();
        $content->$key=$value;
        $fileContent= json_encode($content, JSON_PRETTY_PRINT|JSON_PARTIAL_OUTPUT_ON_ERROR);
        file_put_contents(self::settingsfile, $fileContent);
    }
}