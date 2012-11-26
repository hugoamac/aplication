<?

class Helper {

    static function getMsg($mod) {
        switch ($mod) {
            case "S" :
                $msg = "A opera&ccedil;&atilde;o foi realizada com sucesso!";
                break;
            case "E" :
                $msg = "A opera&ccedil;ao n&atilde;o pode ser realizada!";
                break;
            case "N" :
                $msg = "Nenhum registro foi encontrado!";
                break;
            case "P" :
                $msg = "Voc&ecirc; n&atilde;o tem permiss&atilde;o para executar esta a&ccedil;&atilde;o!";
                break;
        }

        return $msg;
    }

    static function getDataAtual() {
        return date("Y-m-d");
    }

    static function getHoraAtual() {
        return date("H:i:s");
    }

    static function converteMdaParaDma(&$sData, $sSeparador = "") {
        if (!empty($sData)) {
            list ( $nMes, $nDia, $nAno ) = explode($sData[2], $sData);
            $sSeparador = $sSeparador ? $sSeparador : $sData[2];
            return ((checkdate((INT) $nMes, (INT) $nDia, (INT) $nAno) and !is_numeric($sData[2])) ? ($nDia . $sSeparador . $nMes . $sSeparador . $nAno) : $sData);
        } else {
            return $sData;
        }
    }

    static function converteDmaParaMda(&$sData, $sSeparador = "") {
        if (!empty($sData)) {
            list ( $nDia, $nMes, $nAno ) = explode($sData[2], $sData);
            $sSeparador = $sSeparador ? $sSeparador : $sData[2];
            return ((checkdate((INT) $nMes, (INT) $nDia, (INT) $nAno) and !is_numeric($sData[2])) ? ($nMes . $sSeparador . $nDia . $sSeparador . $nAno) : $sData);
        } else {
            return $sData;
        }
    }

    static function converteDmaParaAmd($sData, $sSeparador = "") {
        if (!empty($sData)) {
            $sSeparadorQuebra = !is_numeric($sData[2]) ? $sData[2] : (!is_numeric($sData[4]) ? $sData[4] : "/");

            list ( $nDia, $nMes, $nAno ) = explode($sSeparadorQuebra, $sData);

            $sSeparador = $sSeparador ? $sSeparador : $sSeparadorQuebra;
            return ((checkdate((INT) $nMes, (INT) $nDia, (INT) $nAno)) ? ($nAno . $sSeparador . $nMes . $sSeparador . $nDia) : $sData);
        } else {
            return $sData;
        }
    }

    static function converteAmdParaDma($sData, $sSeparador = "") {
        if (!empty($sData)) {
            $sSeparadorQuebra = !is_numeric($sData[4]) ? $sData[4] : (!is_numeric($sData[2]) ? $sData[2] : "-");

            list ( $nAno, $nMes, $nDia ) = explode($sSeparadorQuebra, $sData);

            $sSeparador = $sSeparador ? $sSeparador : $sSeparadorQuebra;
            return ((checkdate((INT) $nMes, (INT) $nDia, (INT) $nAno)) ? ($nDia . $sSeparador . $nMes . $sSeparador . $nAno) : $sData);
        } else {
            return $sData;
        }
    }

    static function DecimalParaBanco($valor) {
        return str_replace(",", ".", str_replace(".", "", $valor));
    }

    static function DecimalParaPagina($valor, $decimals = 2) {
        return number_format($valor, $decimals, ",", ".");
    }

    static function filtroHTTP($array, $execoes = array(), $sAnterior = "") {
        if (empty($array))
            return false;
        else {
            foreach ($array as $key => $values) {
                switch (true) {
                    case is_array($values):
                        $sAnterior = $key;
                        $array[$key] = self::filtroHTTP($values, $execoes, $sAnterior);
                        $sAnterior = "";
                        break;
                    case is_string($values):
                        if (in_array("$key", $execoes) or in_array("$sAnterior", $execoes)) {
                            if (!get_magic_quotes_gpc()) {
                                $array[$key] = htmlspecialchars(addslashes(trim($values)));
                            }
                        } else {
                            if (!get_magic_quotes_gpc())
                                $array[$key] = htmlspecialchars(strip_tags(addslashes(trim($values))));
                            else
                                $array[$key] = htmlspecialchars(strip_tags(trim($values)));
                        }

                        break;
                    default:
                        $array[$key] = trim($values);
                        break;
                }
            }
        }

        return $array;
    }

    static function limpaArray($array) {
        $vvNovoArray = array();
        if (empty($array))
            return NULL;
        else {
            foreach ($array as $key => $values) {
                if ($values OR ((STRING) $values == "0")) {
                    if (is_array($values)) {
                        $vvNovoArray[$key] = self::limpaArray($values);
                    } else {
                        $vvNovoArray[$key] = $values;
                    }
                }
            }
        }

        return $vvNovoArray;
    }

    static function removeAcentuacao($string) {
        $characteres = array(
            'Ð' => 'Dj', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
            'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',
            'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
            'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
            'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
            'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
            'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y'
        );
        return strtr($string, $characteres);
    }

    static function recuperaHTTP($array = array(), $vsExecoes = array()) {
        $valor = array();
        if (!empty($array)) {
            foreach ($array as $key => $value) {
                if (array_search($key, $vsExecoes) === FALSE)
                    $valor[] = "$key=$value";
            }
        }

        return implode("&", $valor);
    }

    static function selected($v1, $v2) {
        if ($v1 == $v2) {
            return "selected";
        }
    }

    static function checked($v1, $v2) {
        if ($v1 == $v2) {
            return "checked";
        }
    }

    static function getSemana($var) {
        // Usar funcao date('w'); do php
        switch ($var) {
            case"0": return $var = "Domingo";
                break;
            case"1": return $var = "Segunda-Feira";
                break;
            case"2": return $var = "Ter&ccedil;a-Feira";
                break;
            case"3": return $var = "Quarta-Feira";
                break;
            case"4": return $var = "Quinta-Feira";
                break;
            case"5": return $var = "Sexta-Feira";
                break;
            case"6": return $var = "S&aacute;bado";
                break;
        }
    }

    static function getMes($var) {
        // Usar funcao date('n'); do php
        switch ($var) {
            case"1": return $var = "Janeiro";
                break;
            case"2": return $var = "Fevereiro";
                break;
            case"3": return $var = "Mar&ccedil;o";
                break;
            case"4": return $var = "Abril";
                break;
            case"5": return $var = "Maio";
                break;
            case"6": return $var = "Junho";
                break;
            case"7": return $var = "Julho";
                break;
            case"8": return $var = "Agosto";
                break;
            case"9": return $var = "Setembro";
                break;
            case"10": return $var = "Outubro";
                break;
            case"11": return $var = "Novembro";
                break;
            case"12": return $var = "Dezembro";
                break;
        }
    }

    static function redirect($url) {
        $url = "<script>document.location.href='" . $url . "'</script>";
        return $url;
    }

    static function alert($mensagem) {
        $mensagem = "<script language='JavaScript'> alert('" . $mensagem . "'); </script>";
        return $mensagem;
    }

    static function PostGet() {
        if ($_POST) {
            return $_POST;
        } else
            return $_GET;
    }

    static public function converteDataParaBanco($sDataHora) {
        if (!empty($sDataHora)) {
            $sDataHora = explode(" ", trim($sDataHora));
            $sDataHora[0] = self::converteDmaParaAmd($sDataHora[0], "-");
            return trim(implode(" ", $sDataHora));
        } else {
            return FALSE;
        }
    }

    static public function converteDataParaPagina($sDataHora) {
        if (!empty($sDataHora)) {
            $sDataHora = explode(" ", trim($sDataHora));
            $sDataHora[0] = self::converteAmdParaDma($sDataHora[0], "/");
            return trim(implode(" ", $sDataHora));
        } else {
            return FALSE;
        }
    }

    static public function getLarguraAltura($sImagem, $nDimensao, $bLargura = true) {
        $dimensaoImage = @getimagesize($sImagem);
        if ($dimensaoImage) {
            if ($nDimensao > $dimensaoImage[0] AND $nDimensao > $dimensaoImage[1]) {
                return $dimensaoImage;
            } else {
                if ($bLargura) {
                    $nPorcentagem = 100 * $nDimensao / $dimensaoImage[0];
                } else {
                    $nPorcentagem = 100 * $nDimensao / $dimensaoImage[1];
                }
                $nLargura = number_format(($dimensaoImage[0] * $nPorcentagem) / 100, 2, ".", "");
                $nAltura = number_format(($dimensaoImage[1] * $nPorcentagem) / 100, 2, ".", "");

                return array($nLargura, $nAltura);
            }
        } else
            return false;
    }

    static function print_r($sValor) {
        echo "\n\n<pre>\n";
        print_r($sValor);
        echo "\n</pre>\n\n";
    }

    static function getMsgErro() {
        $sMsg = $_SESSION["mensagem"];
        $_SESSION["mensagem"] = "";
        return $sMsg;
    }

    static function validaCPF($nCpf) {
        $nCpf = ereg_replace('[.-]', "", $nCpf);
        $proibidos = array('11111111111', '22222222222', '33333333333',
            '44444444444', '55555555555', '66666666666', '77777777777',
            '88888888888', '99999999999', '00000000000', '12345678909');
        if (is_numeric($nCpf) AND strlen($nCpf) == 11 AND !in_array($nCpf, $proibidos)) {
            $a = 0;
            for ($i = 0; $i < 9; $i++) {
                $a += ( $nCpf[$i] * (10 - $i));
            }
            $b = ($a % 11);
            $a = (($b > 1) ? (11 - $b) : 0);
            if ($a != $nCpf[9]) {
                return false;
            }
            $a = 0;
            for ($i = 0; $i < 10; $i++) {
                $a += ( $nCpf[$i] * (11 - $i));
            }
            $b = ($a % 11);
            $a = (($b > 1) ? (11 - $b) : 0);
            if ($a != $nCpf[10]) {
                return false;
            }

            return true;
        } else {
            return false;
        }
    }

    static function validaCNPJ($str) {
        if (!preg_match('|^(\d{2,3})\.?(\d{3})\.?(\d{3})\/?(\d{4})\-?(\d{2})$|', $str, $matches))
            return false;

        array_shift($matches);

        $str = implode('', $matches);
        if (strlen($str) > 14)
            $str = substr($str, 1);

        $sum1 = 0;
        $sum2 = 0;
        $sum3 = 0;
        $calc1 = 5;
        $calc2 = 6;

        for ($i = 0; $i <= 12; $i++) {
            $calc1 = $calc1 < 2 ? 9 : $calc1;
            $calc2 = $calc2 < 2 ? 9 : $calc2;

            if ($i <= 11)
                $sum1 += $str[$i] * $calc1;

            $sum2 += $str[$i] * $calc2;
            $sum3 += $str[$i];
            $calc1--;
            $calc2--;
        }

        $sum1 %= 11;
        $sum2 %= 11;

        return ($sum3 && $str[12] == ($sum1 < 2 ? 0 : 11 - $sum1) && $str[13] == ($sum2 < 2 ? 0 : 11 - $sum2)) ? $str : false;
    }

    static function gerar_senha($tamanho, $maiuscula, $minuscula, $numeros, $codigos) {
        $maius = "ABCDEFGHIJKLMNOPQRSTUWXYZ";
        $minus = "abcdefghijklmnopqrstuwxyz";
        $numer = "0123456789";
        $codig = '!@#$%&*()-+.,;?{[}]^><:|';

        $base = '';
        $base .= ($maiuscula) ? $maius : '';
        $base .= ($minuscula) ? $minus : '';
        $base .= ($numeros) ? $numer : '';
        $base .= ($codigos) ? $codig : '';

        srand((float) microtime() * 10000000);
        $senha = '';
        for ($i = 0; $i < $tamanho; $i++) {
            $senha .= substr($base, rand(0, strlen($base) - 1), 1);
        }
        return $senha;
    }

    static function nome_para_url_encurtada($sString) {
        $sString = strtolower(ereg_replace("[[:blank:][:space:]]", "-", ereg_replace("(  )", " ", trim(ereg_replace("[[:punct:]]", "", trim(self::removeAcentuacao($sString)))))));
        $characteres = array(
            '¹' => '1', '²' => '2', '³' => '3'
        );
        $sString = strtr($sString, $characteres);
        return $sString;
    }

    static function substr($sString, $nLimite = 100) {
        return substr($sString, 0, $nLimite) . (strlen($sString) > $nLimite ? ' (...)' : '');
    }

    static function limitarCaracteres($str, $limit) {

        if (strlen($str) <= $limit)
            return strip_tags($str);

        if (strlen($str) > $limit) {
            $str = strip_tags($str);
            $strLimitada = substr($str, 0, $limit);
            $ultimaPalavra = strrpos($strLimitada, " ");
            $str = substr($str, 0, $ultimaPalavra) . " ...";

            return $str;
        }
    }

    static function formatData($formato, $data) {
        if (strtotime($data))
            $data = date($formato, strtotime($data));
        else
            $data = "não é uma string data";

        return $data;
    }

    static function viewPaginacao(array $paginators) {

        if (count($paginators)) {
            $request = self::PostGet();
            $first = isset($paginators["first"]) ? $paginators["first"] : FALSE;
            $last = isset($paginators["last"]) ? $paginators["last"] : FALSE;
            $previous = isset($paginators["previous"]) ? $paginators["previous"] : FALSE;
            $next = isset($paginators["next"]) ? $paginators["next"] : FALSE;
            $pages = is_array($paginators["page"]) ? $paginators["page"] : FALSE;

            $view = '<ul id="Paginacao">';

            if ($previous) {
                $view.='<li><a href="' . $previous . '">Anterior</a></li>';
            }
            if ($first) {
                $view.='<li><a href="' . $first . '">Primeiro</a></li>';
            }
            foreach ($pages as $page => $link) {
                $class = $request["page"] == $page ? 'class="PaginacaoActive"' : "";
                $view.=' <li><a href="' . $link . '" ' . $class . '>' . $page . '</a></li>';
            }

            if ($last) {
                $view.='<li><a href="' . $last . '">Último</a></li>';
            }
            if ($next) {
                $view.='<li><a href="' . $next . '">Próximo</a></li>';
            }
            $view .= '</ul>';

            return $view;
        }
    }

}

?>