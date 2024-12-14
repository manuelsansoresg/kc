<?php
return [
    'type_person' => array(
        '' => 'Selecciona una opción',
        1 => 'Física',
        2 => 'Moral',
    ),
    'status' => array(
        '' => 'Selecciona una opción',
        1 => 'Activo',
        2 => 'Inactivo',
    ),
    'origin' => array(
        1 => 'Asesor',
        2 => 'Web/RRSS',
        3 => 'WebApp',
        4 => 'Publicidad',
    ),
    'temperatures' => array(
        '' => '',
        1 => 'Frío',
        2 => 'Tibio',
        3 => 'Caliente',
    ),
    'channel_asesor' => array(
        1 => 'WhatsApp',
        2 => 'Llamada',
        3 => 'Webchat',
        4 => 'Facebook',
        5 => 'Instagram',
    ),
    'channel_web_page' => array(
        1 => 'Formulario',
        2 => 'WhatsApp',
        3 => 'Webchat',
    ),
    'channel_web_app' => array(
        1 => 'Creación de cuenta',
        2 => 'Formulario',
    ),
    
    'channel_rss' => array(
        1 => 'Facebook',
    ),
    'reason_archive' => array(
        1 => 'Nunca contestó',
        2 => 'No tramitable',
        3 => 'Otro',
        4 => 'Conversión',
        5 => 'Asesoría',
        6 => 'Dejó de contestar',
    ),
    
    'credit_reason_archive' => array(
        1 => 'Error de sistema',
        2 => 'Otro',
    ),
    
    'credit_reason_reject' => array(
        1 => 'Sin capacidad de pago',
        2 => 'Mal historial crediticio',
        3 => 'otro',
        4 => 'Fraude',        
    ),
   
    'credit_reason_cancel' => array(
        1 => 'Pérdida de interés',
        2 => 'Otro',
        3 => 'Dejó de contestar',
        4 => 'Optó por otro servicio',
        5 => 'No tramitable',
    ),

    'pagado' => array(
        1 => 'Pagado'
    ),


    'type_lead' => array(
        1 => 'Autoservicio',
        2 => 'Asistido',
    ),
    'role_user_financial' => array(
        1 => 'Ventas',
        2 => 'Administración',
    ),

    //*actions
    "type_actions" => array(
        1 => 'Llamada',
        10 => 'Cotización',
        2 => 'Chat',
        3 => 'Reunión',
        4 => 'Seguimiento',
        5 => 'Plazo',
        6 => 'Enviar Email',
        7 => 'SMS',
        8 => 'Tarea',
        9 => 'Recordatorio'
    ),
    "type_icon_actions" => array(
        1 => 'icon ni ni-call-fill',
        2 => 'icon ni ni-chat-circle-fill',
        3 => 'icon ni ni-users-fill',
        4 => 'icon ni ni-clock-fill',
        5 => 'icon ni ni-flag-fill',
        6 => 'icon ni ni-mail-fill',
        7 => 'icon ni ni-chat-fill',
        8 => 'icon ni ni-note-add',
    ),
    "status_actions" => array(
        1 => 'prospecto'
    ),
    "status_register_actions" => array(
        1 => 'Enviado',
        2 => 'Contacto exitoso',
        3 => 'Número no existe',
        4 => 'No responde',
        5 => 'Buzón',
        6 => 'Número equivocado',
        7 => 'Llamar después',
        8 => 'No llamar',
        9 => 'Ocupado'

    ),
    //*tags
    "type_tags" => array(
        1 => 'Automática',
        2 => 'Manual',
    ),
    "type_section" => array(
        1 => 'Perfíl',
        2 => 'Módulo',
    ),

    //*leyend is required
    'is_required' => array(
        true => 'Obligatorio',
        false => 'Opcional',
    ),

    'loan_type' => array(
        1 => 'Nuevo',
        2 => 'Adicional',
        3 => 'Refinanciamiento',
        4 => 'Recompra',
    ),
    
    'sign_type' => array(
        1 => 'Física',
        2 => 'Digital',
        
    ),
    
    'periodicity' => array(
        1 => 'Mensual',
        2 => 'Quincenal',
        3 => 'Catorcenal',
        
    ),
    
    'periodicity_comision' => array(
        1 => 'Mensual',
        2 => 'Quincenal',
        3 => 'Catorcenal',
        4 => 'Semanal',
        5 => 'Por evento',
        6 => 'Unica vez',
        
    ),
    
    'sex' => array(
        1 => 'Hombre',
        2 => 'Mujer',
    ),
   
    'interviewer' => array(
        1 => 'KaaxClub',
        2 => 'Financiera',
        3 => 'No necesario',
    ),
    'marital_status' => array(
        1 => 'Soltero',
        2 => 'Divorciado',
        3 => 'Viduo',
        4 => 'Union libre',
        5 => 'Otro',
    ),
    'education_level' => array(
        1 => 'Ninguno',
        2 => 'Primaria',
        3 => 'Secundaria',
        4 => 'Preparatoria',
        5 => 'Licenciatura',
    ),
    'home_type' => array(
        1 => 'Propia',
        2 => 'Rentada',
        3 => 'Familiares',
        4 => 'Hipotecada',
        5 => 'Otro',
    ),

    'status_si_no' => array(
        '' => 'Selecciona una opción',
        1 => 'Sí',
        0 => 'No',
    ),

    'fee_reference_percents' => array(
        1 => 'Sobre monto',
        2 => 'linea de crédito',
    ),
    
    'custom_fields_many_chat' => array(
        'Asesor' =>  10202836,
        'Aval o garantía' =>  10202831,
        'Banco' =>  10202826,
        'Canal' =>  10202835,
        'Consulta buró' =>  10202828,
        'Importe solicitado' =>  10202821,
        'Organización' =>  10202821,
        'Origen' =>  10202833,
        'Servicio KC' =>  10202817,
        'Tipo de crédito' =>  10202818,
        'URL Reporte' =>  10298820,
        'URL Encuesta' =>  10357823,
    ),

    "funding_operation" => array(
        1 => 'Mismo banco',
        2 => 'SPEI'
    ),
    
    "operation_status" => array(
        0 => 'En revisión',
        1 => 'Exitosa',
        2 => 'Fallida'
    ),
    
    "status_credit" => array(
        230 => 'Activo',
        231 => 'Baja',
        232 => 'Defunción',
        233 => 'Condonado',
        234 => 'Liquidado',
    ),
    'pago' => array(
        1 => 'Personal',
        2 => 'Liquidación',
        3 => 'Reembolso',
        4 => 'Convenio',
    ),
    
    'periodicidad_valores' => array(
        1 => 7,
        2 => 14,
        3 => 15,
        4 => 30
    ),
    'tipo_tramite' => array(
        1 => 'Crédito nuevo',
        2 => 'Crédito adicional',
        3 => 'Refinanciamiento',
        4 => 'Soluciona tu deuda',
        5 => 'Salario On-Demand',
    ),

    'estatus_statement' => [
        '' => '-',
        0 => 'Pendiente',
        1 => 'Pagado',
    ],
    
    'pertenencia_clabe' => [
        '' => 'no determinada',
        0 => 'Inválida',
        1 => 'Validada',
    ],
    
];
