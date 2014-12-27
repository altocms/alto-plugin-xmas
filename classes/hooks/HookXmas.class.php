<?php
/*---------------------------------------------------------------------------
 * @Project: Alto CMS
 * @Project URI: http://altocms.com
 * @Description: Advanced Community Engine
 * @Copyright: Alto CMS Team
 * @License: GNU GPL v2 & MIT
 *----------------------------------------------------------------------------
 */

class PluginXmas_HookXmas extends Hook {

    protected $aImages;
    protected $aSnow;

    public function RegisterHook() {

        $sHook = Config::Get('plugin.xmas.template_hook');
        $this->_getParams();
        if ($sHook && $this->aImages) {
            if (strpos($sHook, 'template_') !== 0) {
                $sHook = 'template_' . $sHook;
            }
            $this->AddHook($sHook, 'DisplayImages');
        }
    }

    public function DisplayImages() {

        $sResult = '';
        if ($this->aSnow) {
            if (isset($this->aSnow['options'])) {
                $aOptions = $this->aSnow['options'];
            } else {
                $aOptions = null;
            }
            $sResult .= PHP_EOL . '<script>';
            if ($aOptions) {
                $sResult .= 'var xmas_snow_options=' . json_encode($aOptions) . ';';
            }
            $sResult .= '$.getScript(ls.cfg.assets["xmas.js"]);';
            $sResult .= '</script>' . PHP_EOL;
        }

        foreach ($this->aImages as $aImg) {
            $sClass = '';
            $sStyle = '';
            $sSize = '';
            if (isset($aImg['place'])) {
                $sClass = 'xmas-img ';
                $iPosition = 3;
                if (isset($aImg['place']['position'])) {
                    $iPosition = intval($aImg['place']['position']);
                }
                if ($iPosition < 1 || $iPosition > 4) {
                    $iPosition = 3;
                }
                if (isset($aImg['place']['offset'])) {
                    list($iOffsetX, $iOffsetY) = $aImg['place']['offset'];
                } else {
                    $iOffsetX = $iOffsetY = 0;
                }
                if ($iPosition == 1) {
                    $sClass .= 'xmas-img-pos1 ';
                    if ($iOffsetX) {
                        $sStyle .= 'left:' . $iOffsetX . 'px; ';
                    }
                    if ($iOffsetY) {
                        $sStyle .= 'top:' . $iOffsetY . 'px; ';
                    }
                } elseif ($iPosition == 2) {
                    $sClass .= 'xmas-img-pos2 ';
                    if ($iOffsetX) {
                        $sStyle .= 'right:' . -$iOffsetX . 'px; ';
                    }
                    if ($iOffsetY) {
                        $sStyle .= 'top:' . $iOffsetY . 'px; ';
                    }
                } elseif ($iPosition == 3) {
                    $sClass .= 'xmas-img-pos3 ';
                    if ($iOffsetX) {
                        $sStyle .= 'right:' . -$iOffsetX . 'px; ';
                    }
                    if ($iOffsetY) {
                        $sStyle .= 'bottom:' . -$iOffsetY . 'px; ';
                    }
                } elseif ($iPosition == 4) {
                    $sClass .= 'xmas-img-pos4 ';
                    if ($iOffsetX) {
                        $sStyle .= 'left:' . $iOffsetX . 'px; ';
                    }
                    if ($iOffsetY) {
                        $sStyle .= 'bottom:' . -$iOffsetY . 'px; ';
                    }
                }
            }
            if (isset($aImg['css'])) {
                $sClass .= $aImg['css'] . ' ';
            }
            if (isset($aImg['style'])) {
                $sStyle .= $aImg['style'] . '; ';
            }
            if (isset($aImg['size'])) {
                $sSize = $aImg['size'];
            }
            $sAssetDir = F::File_GetAssetDir() . 'xmas/';
            $sImage = $aImg['image'];
            if ($sSize) {
                $sImgFile = $sAssetDir . $sImage . F::File_ImgModSuffix($sSize, pathinfo($sImage, PATHINFO_EXTENSION));
            } else {
                $sImgFile = $sAssetDir . $sImage;
            }

            if (!F::File_Exists($sImgFile)) {
                $sSource = Plugin::GetTemplateDir(__CLASS__) . 'assets/img/' . $sImage;
                $sTarget = F::File_Copy($sSource, dirname($sImgFile) . '/' . basename($sSource));
                if ($sTarget && $sSize) {
                    $sImgFile = $this->Img_Duplicate($sImgFile);
                }
            }
            if ($sImgFile) {
                $aXmasImg = array(
                    'src' => F::File_GetAssetUrl() . 'xmas/' . basename($sImgFile),
                    'css' => $sClass,
                    'style' => $sStyle,
                );
                $this->Viewer_Assign('aXmasImg', $aXmasImg);
                $sResult .= $this->Viewer_Fetch(Plugin::GetTemplateDir(__CLASS__) . 'tpls/xmas.tpl');
            }
        }
        return $sResult;
    }

    protected function _getParams() {

        $aDefault = (array)Config::Get('plugin.xmas.default');
        if ($aImages = Config::Get('plugin.xmas.images')) {
            foreach ($aImages as $aImg) {
                $aImg = F::Array_Merge($aDefault, $aImg);
                if ($this->_isActive($aImg)) {
                    $this->aImages[] = $aImg;
                }
            }
        }
        if ($aSnow = Config::Get('plugin.xmas.snow')) {
            $aSnow = F::Array_Merge($aDefault, $aSnow);
            if ($this->_isActive($aSnow)) {
                $this->aSnow = $aSnow;
            }
        }
    }

    protected function _isActive($aConfig) {

        $xDisplay = (isset($aConfig['display']) ? $aConfig['display'] : null);
        $xOn = (isset($aConfig['on']) ? $aConfig['on'] : null);
        $xOff = (isset($aConfig['off']) ? $aConfig['off'] : null);
        $bResult = (bool)$xDisplay;
        if ($bResult && is_array($xDisplay)) {
            foreach ($xDisplay as $sParamName => $sParamValue) {
                if ($sParamName == 'date_from' && $sParamValue) {
                    $bResult
                        = $bResult && (date('Y-m-d H:i:s') >= $sParamValue);
                } elseif ($sParamName == 'date_upto' && $sParamValue) {
                    $bResult
                        = $bResult && (date('Y-m-d H:i:s') <= $sParamValue);
                }
            }
        }
        if ($bResult) {
            if (is_null($xOn)) {
                $bPathOn = true;
            } else {
                $bPathOn = Router::CompareWithLocalPath($xOn);
            }
            if (is_null($xOff)) {
                $bPathOff = false;
            } else {
                $bPathOff = Router::CompareWithLocalPath($xOff);
            }
            $bResult = $bPathOn && !$bPathOff;
        }
        return $bResult;
    }

}

// EOF
