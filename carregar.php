<?php

include './mysql.function.php';

function validar_cnpj($cnpj) {
    $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
    // Valida tamanho
    if (strlen($cnpj) != 14)
        return false;
    // Valida primeiro dígito verificador
    for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
        $soma += $cnpj{$i} * $j;
        $j = ($j == 2) ? 9 : $j - 1;
    }
    $resto = $soma % 11;
    if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
        return false;
    // Valida segundo dígito verificador
    for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
        $soma += $cnpj{$i} * $j;
        $j = ($j == 2) ? 9 : $j - 1;
    }
    $resto = $soma % 11;
    return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
}

function corrige($var, $need) {
    $res = '';
    if (strlen($var) >= $need) {
        $res = $var;
    } else {
        for ($i = 0; $i < ($need - strlen($var)); $i++) {
            $res .= '0';
        }
        $res .= $var;
    }
    return $res;
}
echo 'Iniciando...';
for ($i1 = $argv[1]; $i1 < 99; $i1++) {
    for ($i2 = 0; $i2 < 999; $i2++) {
        if ($i2 > $argv[2]) {
            for ($i3 = 0; $i3 < 999; $i3++) {
                for ($i4 = 0; $i4 < 99; $i4++) {
                    $cnpj = corrige($i1, 2) . '.' . corrige($i2, 3) . '.' . corrige($i3, 3) . '/0001-' . corrige($i4, 2);
                    $res = init_data('select', 'empresas_continuo', null, array('cnpj', $cnpj));
                    if (!$res) {
                        if (validar_cnpj($cnpj)) {
                            init_data('insert', 'empresas_continuo', array('', $cnpj, ''));
  	                    echo corrige($i1, 2) . '.' . corrige($i2, 3) . corrige($i3, 3) . corrige($i4, 2) . '
';
                        }
                    }
                }
            }
        }
    }
//    echo $i1 . ' Recuperados
//';
}
?>
