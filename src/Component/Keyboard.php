<?php

namespace App\Component;

class Keyboard
{
    const KEYBOARD_ANSI = 'ansi';
    const KEYBOARD_ISO = 'iso';

    public static function loadKeyboard(string $type)
    {
        $keyboard = new self();
        $methodName = 'load' . ucfirst($type) . 'Keyboard';
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
                        <span class="key" data-key="\" data-shift-key="|">|<sub>\</sub></span>
                
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
                        <span class="key" data-key="\'" data-shift-key="&quot;">&quot;<sub>&#39;</sub></span>
                        <span class="key key-length-1" data-key="&#10;">enter</span>
                
                    </div>
                    <div class="keyboardRow">   
                    
                        <span class="key key-length-3" data-key="shift">shift</span>
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