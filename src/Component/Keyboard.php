<?php

namespace App\Component;

class Keyboard
{
    const KEYBOARD_ANSI = 1;
    const KEYBOARD_ISO = 2;

    const DEFAULT = self::KEYBOARD_ANSI;

    const KEYBOARD_TITLES = [
        self::KEYBOARD_ANSI => 'ansi',
        self::KEYBOARD_ISO => 'iso',
    ];

    public static function loadKeyboard(string $type)
    {
        $keyboard = new self();
        $methodName = 'load' . ucfirst(self::KEYBOARD_TITLES[$type]) . 'Keyboard';
        if (method_exists($keyboard, $methodName)) {
            return $keyboard::$methodName();
        }

        return null;
    }

    private static function loadAnsiKeyboard()
    {
        return '<div class="keyboard">

                    <div class="keyboardRow">   
                    
                        <span class="key" data-key="~">~</span>
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
                        <span class="key" data-key="[" data-shift="lshift" data-shift-key="{">{<sub>[</sub></span>
                        <span class="key" data-key="]" data-shift="lshift" data-shift-key="}">}<sub>]</sub></span>
                        <span class="key" data-key="\" data-shift="lshift" data-shift-key="|">|<sub>\</sub></span>
                
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
                        <span class="key" data-key="\'" data-finger="9" data-shift="lshift" data-shift-key="&quot;">&quot;<sub>&#39;</sub></span>
                        <span class="key key-length-1" data-finger="9" data-key="&#10;">enter</span>
                
                    </div>
                    <div class="keyboardRow">   
                    
                        <span class="key key-length-3" data-key="shift" id="lshift">shift</span>
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
                        <span class="key key-length-3" data-key="shift" id="rshift">shift</span>

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

    private static function loadIsoKeyboard()
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
                        <span class="key" data-key="q">Q</span>
                        <span class="key" data-key="w">W</span>
                        <span class="key" data-key="e">E</span>
                        <span class="key" data-key="r">R</span>
                        <span class="key" data-key="t">T</span>
                        <span class="key" data-key="y">Y</span>
                        <span class="key" data-key="u">U</span>
                        <span class="key" data-key="i">I</span>
                        <span class="key" data-key="o">O</span>
                        <span class="key" data-key="p">P</span>
                        <span class="key" data-key="[" data-shift-key="{">{<sub>[</sub></span>
                        <span class="key" data-key="]" data-shift-key="}">}<sub>]</sub></span>
                                        
                    </div>
                    
                    <div class="keyboardRow">   
                    
                        <span class="key" data-key="caps">caps lock</span>
                        <span class="key" data-key="a">A</span>
                        <span class="key" data-key="s">S</span>
                        <span class="key" data-key="d">D</span>
                        <span class="key" data-key="f">F</span>
                        <span class="key" data-key="g">G</span>
                        <span class="key" data-key="h">H</span>
                        <span class="key" data-key="j">J</span>
                        <span class="key" data-key="k">K</span>
                        <span class="key" data-key="l">L</span>
                        <span class="key" data-key=";" data-shift-key=":">:<sub>;</sub></span>
                        <span class="key" data-key="\'" data-shift-key="&#34;">&#34;<sub>&#39;</sub></span>
                        <span class="key" data-key="\" data-shift-key="|">|<sub>\</sub></span>
                        <span class="key iso-enter" data-key="&#10;">enter</span>
                
                    </div>
                    <div class="keyboardRow">   
                    
                        <span class="key" data-key="shift">shift</span>
                        <span class="key" data-key="`" data-shift-key="~">~<sub>`</sub></span>
                        <span class="key" data-key="z">Z</span>
                        <span class="key" data-key="x">X</span>
                        <span class="key" data-key="c">C</span>
                        <span class="key" data-key="v">V</span>
                        <span class="key" data-key="b">B</span>
                        <span class="key" data-key="n">N</span>
                        <span class="key" data-key="m">M</span>
                        <span class="key" data-key="," data-shift-key="<">&lt;<sub>,</sub></span>
                        <span class="key" data-key="." data-shift-key=">">&gt;<sub>.</sub></span>
                        <span class="key" data-key="/" data-shift-key="?">?<sub>/</sub></span>
                        <span class="key key-length-3" data-key="shift">shift</span>

                    </div>
                    
                        <div class="keyboardRow">   
                    
                        <span class="key" data-key="dn">fn</span>
                        <span class="key" data-key="ctrl">ctrl</span>
                        <span class="key" data-key="lalt">alt</span>
                        <span class="key" data-key="lmeta">meta</span>
                        <span class="key key-length-3 space" data-key=" ">space</span>
                        <span class="key" data-key="rmeta">meta</span>
                        <span class="key" data-key="ralt">alt</span>

                    </div>
                </div>'
            ;
    }
}