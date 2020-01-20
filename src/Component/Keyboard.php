<?php

namespace App\Component;

use App\Entity\Languages;

class Keyboard
{
    const KEYBOARD_ANSI = 1;
    const KEYBOARD_ISO = 2;

    const DEFAULT = self::KEYBOARD_ANSI;

    const KEYBOARD_TITLES = [
        self::KEYBOARD_ANSI => 'ansi',
        self::KEYBOARD_ISO => 'iso',
    ];

    public static function loadKeyboard(string $type, int $language = Languages::DEFAULT_LANGUAGE)
    {
        $keyboard = new self();
        $methodName = 'load' . ucfirst(self::KEYBOARD_TITLES[$type] ?? '') . (Languages::LANGUAGES_TITLES[$language] ?? '') . 'Keyboard';
        if (method_exists($keyboard, $methodName)) {
            return $keyboard::$methodName();
        }

        return self::loadAnsiUsKeyboard();
    }

    private static function loadAnsiUsKeyboard()
    {
        return '<div class="keyboard">

                    <div class="keyboardRow">   
                    
                        <span class="key" data-key="~">~</span>
                        <span class="key" data-key="1" data-finger="1">1</span>
                        <span class="key" data-key="2" data-finger="2">2</span>
                        <span class="key" data-key="3" data-finger="3">3</span>
                        <span class="key" data-key="4" data-finger="4">4</span>
                        <span class="key" data-key="5" data-finger="4">5</span>
                        <span class="key" data-key="6" data-finger="6">6</span>
                        <span class="key" data-key="7" data-finger="6">7</span>
                        <span class="key" data-key="8" data-finger="7">8</span>
                        <span class="key" data-key="9" data-finger="8" data-shift="lshift" data-shift-key="(">9<sub>(</sub></span>
                        <span class="key" data-key="0" data-finger="9" data-shift="lshift" data-shift-key=")">0<sub>)</sub></span>
                        <span class="key" data-key="-">-</span>
                        <span class="key" data-key="=">=</span>
                        <span class="key key-length-1" data-key="del">delete</span>
                
                    </div>

                    <div class="keyboardRow">   
                    
                        <span class="key key-length-1" data-key="tab">tab</span>
                        <span class="key" data-key="q" data-finger="1" data-shift="rshift">Q</span>
                        <span class="key" data-key="w" data-finger="2" data-shift="rshift">W</span>
                        <span class="key" data-key="e" data-finger="3" data-shift="rshift">E</span>
                        <span class="key" data-key="r" data-finger="4" data-shift="rshift">R</span>
                        <span class="key" data-key="t" data-finger="4" data-shift="rshift">T</span>
                        <span class="key" data-key="y" data-finger="6" data-shift="lshift">Y</span>
                        <span class="key" data-key="u" data-finger="6" data-shift="lshift">U</span>
                        <span class="key" data-key="i" data-finger="7" data-shift="lshift">I</span>
                        <span class="key" data-key="o" data-finger="8" data-shift="lshift">O</span>
                        <span class="key" data-key="p" data-finger="9" data-shift="lshift">P</span>
                        <span class="key" data-key="[" data-shift="lshift" data-finger="9" data-shift-key="{">{<sub>[</sub></span>
                        <span class="key" data-key="]" data-shift="lshift" data-finger="9" data-shift-key="}">}<sub>]</sub></span>
                        <span class="key" data-key="\" data-shift="lshift" data-finger="9" data-shift-key="|">|<sub>\</sub></span>
                
                    </div>
                    
                    <div class="keyboardRow">   
                    
                        <span class="key" data-key="caps">caps lock</span>
                        <span class="key" data-key="a" data-finger="1" data-shift="rshift">A</span>
                        <span class="key" data-key="s" data-finger="2" data-shift="rshift">S</span>
                        <span class="key" data-key="d" data-finger="3" data-shift="rshift">D</span>
                        <span class="key" data-key="f" data-finger="4" data-shift="rshift">F</span>
                        <span class="key" data-key="g" data-finger="4" data-shift="rshift">G</span>
                        <span class="key" data-key="h" data-finger="6" data-shift="lshift">H</span>
                        <span class="key" data-key="j" data-finger="6" data-shift="lshift">J</span>
                        <span class="key" data-key="k" data-finger="7" data-shift="lshift">K</span>
                        <span class="key" data-key="l" data-finger="8" data-shift="lshift">L</span>
                        <span class="key" data-key=";" data-finger="9" data-shift="lshift" data-shift-key=":">:<sub>;</sub></span>
                        <span class="key" data-key="&apos;" data-finger="9" data-shift="lshift" data-shift-key="&quot;">&quot;<sub>&#39;</sub></span>
                        <span class="key key-length-1" data-finger="9" data-key="&#10;">enter</span>
                
                    </div>
                    <div class="keyboardRow">   
                    
                        <span class="key key-length-3" id="lshift" data-key="shift" data-finger="1">shift</span>
                        <span class="key" data-key="z" data-finger="1" data-shift="rshift">Z</span>
                        <span class="key" data-key="x" data-finger="2" data-shift="rshift">X</span>
                        <span class="key" data-key="c" data-finger="3" data-shift="rshift">C</span>
                        <span class="key" data-key="v" data-finger="4" data-shift="rshift">V</span>
                        <span class="key" data-key="b" data-finger="4" data-shift="rshift">B</span>
                        <span class="key" data-key="n" data-finger="6" data-shift="lshift">N</span>
                        <span class="key" data-key="m" data-finger="6" data-shift="lshift">M</span>
                        <span class="key" data-key="," data-finger="7" data-shift="lshift" data-shift-key="<">&lt;<sub>,</sub></span>
                        <span class="key" data-key="." data-finger="8" data-shift="lshift" data-shift-key=">">&gt;<sub>.</sub></span>
                        <span class="key" data-key="/" data-finger="9" data-shift="lshift" data-shift-key="?">?<sub>/</sub></span>
                        <span class="key key-length-3" id="rshift" data-key="shift" data-finger="9">shift</span>

                    </div>
                    
                        <div class="keyboardRow">   
                    
                        <span class="key" data-key="dn">fn</span>
                        <span class="key" data-key="ctrl">ctrl</span>
                        <span class="key" data-key="lalt">alt</span>
                        <span class="key" data-key="lmeta">meta</span>
                        <span class="key key-length-3 space" data-key=" " data-finger="5">space</span>
                        <span class="key" data-key="rmeta">meta</span>
                        <span class="key" data-key="ralt">alt</span>

                    </div>
                </div>'
            ;
    }

    private static function loadIsoUsKeyboard()
    {
        return '<div class="keyboard">

                    <div class="keyboardRow">   
                    
                        <span class="key" data-key="&pm;">&pm;</span>
                        <span class="key" data-key="1">1</span>
                        <span class="key" data-key="2">2</span>
                        <span class="key" data-key="3">3</span>
                        <span class="key" data-key="4">4</span>
                        <span class="key" data-key="5">5</span>
                        <span class="key" data-key="6">6</span>
                        <span class="key" data-key="7">7</span>
                        <span class="key" data-key="8">8</span>
                        <span class="key" data-key="9">9</span>
                        <span class="key" data-key="0">0</span>
                        <span class="key" data-key="-">-</span>
                        <span class="key" data-key="=">=</span>
                        <span class="key key-length-1" data-key="tab">delete</span>
                
                    </div>

                    <div class="keyboardRow">   
                    
                        <span class="key key-length-1" data-key="tab">tab</span>
                        <span class="key" data-key="q" data-finger="1" data-shift="rshift">Q</span>
                        <span class="key" data-key="w" data-finger="2" data-shift="rshift">W</span>
                        <span class="key" data-key="e" data-finger="3" data-shift="rshift">E</span>
                        <span class="key" data-key="r" data-finger="4" data-shift="rshift">R</span>
                        <span class="key" data-key="t" data-finger="4" data-shift="rshift">T</span>
                        <span class="key" data-key="y" data-finger="6" data-shift="lshift" >Y</span>
                        <span class="key" data-key="u" data-finger="6" data-shift="lshift" >U</span>
                        <span class="key" data-key="i" data-finger="7" data-shift="lshift" >I</span>
                        <span class="key" data-key="o" data-finger="8" data-shift="lshift" >O</span>
                        <span class="key" data-key="p" data-finger="9" data-shift="lshift" >P</span>
                        <span class="key" data-key="[" data-finger="9" data-shift="lshift" data-shift-key="{">{<sub>[</sub></span>
                        <span class="key" data-key="]" data-finger="9" data-shift="lshift" data-shift-key="}">}<sub>]</sub></span>
                                        
                    </div>
                    
                    <div class="keyboardRow">   
                    
                        <span class="key" data-key="caps">caps lock</span>
                        <span class="key" data-key="a" data-finger="1" data-shift="rshift">A</span>
                        <span class="key" data-key="s" data-finger="2" data-shift="rshift">S</span>
                        <span class="key" data-key="d" data-finger="3" data-shift="rshift">D</span>
                        <span class="key" data-key="f" data-finger="4" data-shift="rshift">F</span>
                        <span class="key" data-key="g" data-finger="4" data-shift="rshift">G</span>
                        <span class="key" data-key="h" data-finger="6" data-shift="lshift">H</span>
                        <span class="key" data-key="j" data-finger="6" data-shift="lshift">J</span>
                        <span class="key" data-key="k" data-finger="7" data-shift="lshift">K</span>
                        <span class="key" data-key="l" data-finger="8" data-shift="lshift">L</span>
                        <span class="key" data-key=";" data-finger="9" data-shift="lshift" data-shift-key=":">:<sub>;</sub></span>
                        <span class="key" data-key="&apos;" data-finger="9" data-shift="lshift" data-shift-key="&quot;">&quot;<sub>&#39;</sub></span>
                        <span class="key" data-key="\" data-finger="9" data-shift="lshift" data-shift-key="|">|<sub>\</sub></span>
                        <span class="key iso-enter" data-finger="9" data-key="&#10;">enter</span>
                
                    </div>
                    <div class="keyboardRow">   
                    
                        <span class="key" id="lshift" data-key="shift" data-finger="1">shift</span>
                        <span class="key" data-key="`" data-shift-key="~">~<sub>`</sub></span>
                        <span class="key" data-key="z" data-finger="1" data-shift="rshift">Z</span>
                        <span class="key" data-key="x" data-finger="2" data-shift="rshift">X</span>
                        <span class="key" data-key="c" data-finger="3" data-shift="rshift">C</span>
                        <span class="key" data-key="v" data-finger="4" data-shift="rshift">V</span>
                        <span class="key" data-key="b" data-finger="4" data-shift="rshift">B</span>
                        <span class="key" data-key="n" data-finger="6" data-shift="lshift">N</span>
                        <span class="key" data-key="m" data-finger="6" data-shift="lshift">M</span>
                        <span class="key" data-key="," data-finger="7" data-shift="lshift" data-shift-key="<">&lt;<sub>,</sub></span>
                        <span class="key" data-key="." data-finger="8" data-shift="lshift" data-shift-key=">">&gt;<sub>.</sub></span>
                        <span class="key" data-key="/" data-finger="9" data-shift="lshift" data-shift-key="?">?<sub>/</sub></span>
                        <span class="key key-length-3" id="rshift" data-key="shift" data-finger="9">shift</span>

                    </div>
                    
                        <div class="keyboardRow">   
                    
                        <span class="key" data-key="dn">fn</span>
                        <span class="key" data-key="ctrl">ctrl</span>
                        <span class="key" data-key="lalt">alt</span>
                        <span class="key" data-key="lmeta">meta</span>
                        <span class="key key-length-3 space" data-finger="5" data-key=" ">space</span>
                        <span class="key" data-key="rmeta">meta</span>
                        <span class="key" data-key="ralt">alt</span>

                    </div>
                </div>'
            ;
    }

    private static function loadAnsiRuKeyboard()
    {
        return '<div class="keyboard">

                    <div class="keyboardRow">   
                    
                        <span class="key" data-key="~">~</span>
                        <span class="key" data-key="1" data-shift-key="!">1<sub>!</sub></span>
                        <span class="key" data-key="2" data-shift-key="&quot;">2<sub>&quot;</sub></span>
                        <span class="key" data-key="3" data-shift-key="№">3<sub>№</sub></span>
                        <span class="key" data-key="4" data-shift-key="%">4<sub>%</sub></span>
                        <span class="key" data-key="5" data-shift-key=":">5<sub>:</sub></span>
                        <span class="key" data-key="6" data-shift-key=",">6<sub>,</sub></span>
                        <span class="key" data-key="7" data-shift-key=".">7<sub>.</sub></span>
                        <span class="key" data-key="8" data-shift-key=";">8 <sub>;</sub></span>
                        <span class="key" data-key="9" data-shift-key="(">9<sub>(</sub></span>
                        <span class="key" data-key="0" data-shift-key=")">0<sub>)</sub></span>
                        <span class="key" data-key="-">-</span>
                        <span class="key" data-key="=">=</span>
                        <span class="key key-length-1" data-key="del">delete</span>
                
                    </div>

                    <div class="keyboardRow">   
                    
                        <span class="key key-length-1" data-key="tab">tab</span>
                        <span class="key" data-key="й" data-finger="1" data-shift="rshift">Й</span>
                        <span class="key" data-key="ц" data-finger="2" data-shift="rshift">Ц</span>
                        <span class="key" data-key="у" data-finger="3" data-shift="rshift">У</span>
                        <span class="key" data-key="к" data-finger="4" data-shift="rshift">К</span>
                        <span class="key" data-key="е" data-finger="4" data-shift="rshift">Е</span>
                        <span class="key" data-key="н" data-finger="6" data-shift="lshift">Н</span>
                        <span class="key" data-key="г" data-finger="6" data-shift="lshift">Г</span>
                        <span class="key" data-key="ш" data-finger="7" data-shift="lshift">Ш</span>
                        <span class="key" data-key="щ" data-finger="8" data-shift="lshift">Щ</span>
                        <span class="key" data-key="з" data-finger="9" data-shift="lshift">З</span>
                        <span class="key" data-key="х" data-shift="lshift" data-finger="9" data-shift-key="Х">Х<sub>х</sub></span>
                        <span class="key" data-key="ъ" data-shift="lshift" data-finger="9" data-shift-key="Ъ">Ъ<sub>ъ</sub></span>
                        <span class="key" data-key="\" data-shift="lshift" data-finger="9" data-shift-key="|">|<sub>\</sub></span>
                
                    </div>
                    
                    <div class="keyboardRow">   
                    
                        <span class="key" data-key="caps">caps lock</span>
                        <span class="key" data-key="ф" data-finger="1" data-shift="rshift">Ф</span>
                        <span class="key" data-key="ы" data-finger="2" data-shift="rshift">Ы</span>
                        <span class="key" data-key="в" data-finger="3" data-shift="rshift">В</span>
                        <span class="key" data-key="а" data-finger="4" data-shift="rshift">А</span>
                        <span class="key" data-key="п" data-finger="4" data-shift="rshift">П</span>
                        <span class="key" data-key="р" data-finger="6" data-shift="lshift">Р</span>
                        <span class="key" data-key="о" data-finger="6" data-shift="lshift">О</span>
                        <span class="key" data-key="л" data-finger="7" data-shift="lshift">Л</span>
                        <span class="key" data-key="д" data-finger="8" data-shift="lshift">Д</span>
                        <span class="key" data-key="ж" data-finger="9" data-shift="lshift" data-shift-key="Ж">Ж<sub>ж</sub></span>
                        <span class="key" data-key="э" data-finger="9" data-shift="lshift" data-shift-key="Э">Э<sub>э</sub></span>
                        <span class="key key-length-1" data-finger="9" data-key="&#10;">enter</span>
                
                    </div>
                    <div class="keyboardRow">   
                    
                        <span class="key key-length-3" id="lshift" data-key="shift" data-finger="1">shift</span>
                        <span class="key" data-key="я" data-finger="1" data-shift="rshift">Я</span>
                        <span class="key" data-key="ч" data-finger="2" data-shift="rshift">Ч</span>
                        <span class="key" data-key="с" data-finger="3" data-shift="rshift">С</span>
                        <span class="key" data-key="м" data-finger="4" data-shift="rshift">М</span>
                        <span class="key" data-key="и" data-finger="4" data-shift="rshift">И</span>
                        <span class="key" data-key="т" data-finger="6" data-shift="lshift">Т</span>
                        <span class="key" data-key="ь" data-finger="6" data-shift="lshift">Ь</span>
                        <span class="key" data-key="б" data-finger="7" data-shift="lshift" data-shift-key="Б">Б<sub>б</sub></span>
                        <span class="key" data-key="ю" data-finger="8" data-shift="lshift" data-shift-key="Ю">Ю<sub>ю</sub></span>
                        <span class="key" data-key="/" data-finger="9" data-shift="lshift" data-shift-key="?">?<sub>/</sub></span>
                        <span class="key key-length-3" id="rshift" data-key="shift" data-finger="9">shift</span>

                    </div>
                    
                        <div class="keyboardRow">   
                    
                        <span class="key" data-key="dn">fn</span>
                        <span class="key" data-key="ctrl">ctrl</span>
                        <span class="key" data-key="lalt">alt</span>
                        <span class="key" data-key="lmeta">meta</span>
                        <span class="key key-length-3 space" data-key=" " data-finger="5">space</span>
                        <span class="key" data-key="rmeta">meta</span>
                        <span class="key" data-key="ralt">alt</span>

                    </div>
                </div>'
            ;
    }
}