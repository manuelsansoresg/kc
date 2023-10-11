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
        2 => 'WebPage',
        3 => 'WebApp',
        4 => 'Referente',
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
    'reason_archive' => array(
        1 => 'No interesado',
        2 => 'Sin convenio',
        3 => 'Otro',
        4 => 'Conversión',
        5 => 'Asesoría',
    ),
    
    'credit_reason_archive' => array(
        1 => 'Error de sistema',
        2 => 'Otro',
    ),
    
    'credit_reason_reject' => array(
        1 => 'No viable',
        2 => 'no sujeto de crédito',
        3 => 'otro',
    ),
   
    'credit_reason_cancel' => array(
        1 => 'Decisión cliente',
        3 => 'otro',
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
        2 => 'Chat',
        3 => 'Reunión',
        4 => 'Seguimiento',
        5 => 'Plazo',
        6 => 'EMail',
        7 => 'SMS'
    ),
    "type_icon_actions" => array(
        1 => 'icon ni ni-call-fill',
        2 => 'icon ni ni-chat-circle-fill',
        3 => 'icon ni ni-users-fill',
        4 => 'icon ni ni-clock-fill',
        5 => 'icon ni ni-flag-fill',
        6 => 'icon ni ni-mail-fill',
        7 => 'icon ni ni-chat-fill'
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
    
    'sex' => array(
        1 => 'Hombre',
        2 => 'Mujer',
    ),
   
    'interviewer' => array(
        1 => 'KaaxClub',
        2 => 'Financiera',
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
    
];
