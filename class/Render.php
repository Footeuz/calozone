<?php
/**
 * Fonctions utilitaires
 *
 * @author vincent
 */
class Render {
    
    
    /**
     * 
     * @param string $name
     * @param string[] | mysqli_result $values
     * @param string | bool $selected
     * @return string HTML select
     */
    public static function select($name, $values, $selected = false, $withempty = false){
        $options = "";

        if($withempty){
            if (($selected > 0)) {
                $options .= '<option value=""></option>';
            } else {
                $options .= '<option value="" selected></option>';
            }
        }
        if(is_array($values)){
            foreach($values as $k => $v){            
                $options.="<option value=\"$k\"";
                if($selected!==false && $k == $selected){
                    $options .= ' selected';
                }
                $options.=">$v</option>";
            }                    
        }
        else{
            while($rec = $values->fetch_array()){            
                $options.="<option value=\"".$rec[0]."\"";
                if($selected!==false && $rec[0] == $selected){
                    $options .= ' selected';
                }
                $options.=">".$rec[1]."</option>";
            }                                
        }
        
        return "<select name=\"$name\" id=\"$name\">$options</select>";
    }
    
    public static function prix($valeur){
        return number_format($valeur, 2, ',', '&nbsp;').'€';
    }

    /**
     * Do xml for sitemap
     * @param string $url
     * @param string $freq
     * @param string $priority
     * @return string xml
     */
    public static function xmlSitemap($url, $freq, $priority){
        $ret = '';

        if (!empty($url)) {
            $ret .= "<url>";
            $ret .= "<loc>".$url."</loc>";
            $ret .= "<changefreq>".$freq."</changefreq>";
            $ret .= "<priority>".$priority."</priority>";
            $ret .= "</url>\r\n";
        }

        return $ret;
    }
}
