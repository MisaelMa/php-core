<?php


namespace Signati\Core\Types;
class UsoCFDI extends Enum
{
    const ADQUISICION_MERCANCIAS = 'G01';
    const DEVOLUCIONES_DESCUENTOS_BONIFICACIONES = 'G02';
    const GASTOS_EN_GENERAL = 'G03';
    const CONSTRUCCIONES = 'I01';
    const MOBILIARIO_Y_EQUIPO_DE_OFICINA = 'I02';
    const EQUIPO_DE_TRANSPORTE = 'I03';
    const EQUIPO_DE_COMPUTO = 'I04';
    const DADOS_TROQUELES_HERRAMENTAL = 'I05';
    const COMUNICACIONES_TELEFONICAS = 'I06';
    const COMUNICACIONES_SATELITALES = 'I07';
    const OTRA_MAQUINARIA = 'I08';
    const HONORARIOS_MEDICOS = 'D01';
    const GASTOS_MEDICOS_POR_INCAPACIDAD = 'D02';
    const GASTOS_FUNERALES = 'D03';
    const DONATIVOS = 'D04';
    const INTERESES_POR_CREDITOS_HIPOTECARIOS = 'D05';
    const APORTACIONES_VOLUNTARIAS_SAR = 'D06';
    const PRIMA_SEGUROS_GASTOS_MEDICOS = 'D07';
    const GASTOS_TRANSPORTACION_ESCOLAR = 'D08';
    const CUENTAS_AHORRO_PENSIONES = 'D09';
    const SERVICIOS_EDUCATIVOS = 'D10';
    const POR_DEFINIR = 'P01';

    function usoCFDIList()
    {
        $list = [
            array(
                'value' => 'G01',
                'label' => 'Adquisición de mercancias',
            ),
            array(
                'value' => 'G02',
                'label' => 'Devoluciones, descuentos o bonificaciones',
            ),
            array(
                'value' => 'G03',
                'label' => 'Gastos en general',
            ),
            array(
                'value' => 'I01',
                'label' => 'Construcciones',
            ),
            array(
                'value' => 'I02',
                'label' => 'Mobilario y equipo de oficina por inversiones',
            ),
            array(
                'value' => 'I03',
                'label' => 'Equipo de transporte',
            ),
            array(
                'value' => 'I04',
                'label' => 'Equipo de computo y accesorios',
            ),
            array(
                'value' => 'I05',
                'label' => 'Dados, troqueles, moldes, matrices y herramental',
            ),
            array(
                'value' => 'I06',
                'label' => 'Comunicaciones telefónicas',
            ),
            array(
                'value' => 'I07',
                'label' => 'Comunicaciones satelitales',
            ),
            array(
                'value' => 'I08',
                'label' => 'Otra maquinaria y equipo',
            ),
            array(
                'value' => 'D01',
                'label' => 'Honorarios médicos, dentales y gastos hospitalarios.',
            ),
            array(
                'value' => 'D02',
                'label' => 'Gastos médicos por incapacidad o discapacidad',
            ),
            array(
                'value' => 'D03',
                'label' => 'Gastos funerales.',
            ),
            array(
                'value' => 'D04',
                'label' => 'Donativos.',
            ),
            array(
                'value' => 'D05',
                'label' => 'Intereses reales efectivamente pagados por créditos hipotecarios (casa habitación).',
            ),
            array(
                'value' => 'D06',
                'label' => 'Aportaciones voluntarias al SAR.',
            ),
            array(
                'value' => 'D07',
                'label' => 'Primas por seguros de gastos médicos.',
            ),
            array(
                'value' => 'D08',
                'label' => 'Gastos de transportación escolar obligatoria.',
            ),
            array(
                'value' => 'D09',
                'label' => 'Depósitos en cuentas para el ahorro, primas que tengan como base planes de pensiones.',
            ),
            array(
                'value' => 'D10',
                'label' => 'Pagos por servicios educativos (colegiaturas)',
            ),
            array(
                'value' => 'P01',
                'label' => 'Por definir',
            ),
        ];
        return $list;
    }
}

usoCFDI::usoCFDIList();