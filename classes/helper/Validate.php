<?php

class Validate {

    private $dados;
    private $erro;

    public function setDados($dado, $campo) {

        $this->dados = array($dado, $campo);

        return $this;
    }

    public function obrigatorio() {

        if (is_array($this->dados)) {

            if (empty($this->dados[0])) {

                $this->erro[] = "O campo " . $this->dados[1] . " é obrigatório";
                return false;
            } else {

                return true;
            }
        }
    }

    public function is_email() {


        if (is_array($this->dados)) {

            if (!filter_var($this->dados[0], FILTER_VALIDATE_EMAIL)) {

                $this->erro[] = "O campo " . $this->dados[1] . " é inválido";

                return false;
            } else {

                return true;
            }
        }
    }

    public function is_phone() {

        if (is_array($this->dados)) {

            if (!preg_match("/^\([0-9]{2}\)[0-9]{4}\-[0-9]{4}$/", $this->dados[0])) {

                $this->erro[] = "O campo " . $this->dados[1] . " é inválido";

                return false;
            } else {

                return true;
            }
        }
    }

    public function is_data_nascimento() {

        if (is_array($this->dados)) {

            $data = $this->dados[0];

            if (!preg_match("/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/", $data)) {

                $this->erro[] = "O campo " . $this->dados[1] . " é inválido";

                return false;
            } else {

                return true;
            }
        }
    }

    public function is_cpf() {

        if (is_array($this->dados)) {

            $nCpf = ereg_replace('[.-]', "", $this->dados[0]);
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
                    $bResultado = false;
                }
                $a = 0;
                for ($i = 0; $i < 10; $i++) {
                    $a += ( $nCpf[$i] * (11 - $i));
                }
                $b = ($a % 11);
                $a = (($b > 1) ? (11 - $b) : 0);
                if ($a != $nCpf[10]) {
                    $bResultado = false;
                }

                $bResultado = true;
            } else {
                $bResultado = false;
            }

            if ($bResultado == false) {
                $this->erro[] = "O campo " . $this->dados[1] . " é inválido";
                return false;
            } else {
                return true;
            }
        }
    }

    public function getErro() {

        if (is_array($this->erro)) {

            if (count($this->erro) > 0) {

                return $this->erro;
            }
        }
    }

}

?>
