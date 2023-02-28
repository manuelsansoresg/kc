@extends('layouts.report')

@section('title', 'Metodología')

@section('header')
@include('layouts.content_report_nav')
@endsection

@section('content')

<section class="position-relative bg-style-1">
    <div class="container py-9 py-lg-11 position-relative z-index-1">
       
        <div class="row justify-content-between align-items-start">
            <div class="col-12">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="analytics1" role="tabpanel">
                        <div class="row align-items-center">
                          
                            <div class="col-12 mx-auto">
                                <p class="position-relative h2 ms-md-n3 ms-lg-0 ms-0 me-lg-n5 fs-1  mt-5"
                                    data-aos="fade-up"> Metodología.
                                </p>
                                <p class="mb-4 h5" data-aos="fade-up" data-aos-delay="100">
                                    Elegir entre varias opciones puede ser confuso y difícil. Pero no tiene que ser así.
                                </p>
                                <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
                                    Hemos creado un algoritmo para calificar a cada una de las financieras. Consideremos los aspectos más importantes que se deben tener en cuenta al momento de elegir la mejor opción de crédito.
                                </p>
                                <p class="position-relative h2 ms-md-n3 ms-lg-0 ms-0 me-lg-n5 fs-1  mt-5"
                                data-aos="fade-up"> CAT Real.
                                </p>
                                <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
                                    En algunos lugares encontrarás términos confusos como "CAT promedio" o  "CAT para fines informativos” 
                                    <br><br>
                                    Para evitar confusiones creamos el concepto “CAT Real” a través del cual calculamos el costo anual total del producto financiero en base a la fórmula original del Banco de México.

                                </p>
                               
                                <p class="position-relative h2 ms-md-n3 ms-lg-0 ms-0 me-lg-n5 fs-1  mt-5"
                                data-aos="fade-up">Comisiones.
                                </p>
                                <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
                                    En la mayoría de los casos, mientras menos comisiones tenga un producto financiero; mejor.
                                    <br><br>
                                    Analizamos el producto financiero en busca de las siguientes comisiones:
                                </p>
                               <div class="row"  data-aos="fade-up" data-aos-delay="100">
                                <div class="col-12 col-md-6">
                                    <ul>
                                        <li> Comisión por apertura </li>
                                        <li> Seguro de vida</li>
                                        <li> Interés moratorio </li>
                                        <li> Seguro de desempleo </li>
                                        <li> Aclaración improcedente de la cuenta </li>
                                        <li> Administración o manejo de cuenta </li>
                                        <li> Disposición de crédito </li>
                                    </ul>
                                </div>
                                <div class="col-12 col-md-6">
                                    <li> Falta de pago </li>
                                    <li> Gastos de cobranza</li>
                                    <li> Gastos de investigación y/o formalización </li>
                                    <li> Pago anticipado / Prepago </li>
                                    <li> Pago tardío o inoportuno </li>
                                    <li> Reimpresión del estado de cuenta </li>
                                    <li> Reposición de medios de disposición </li>
                                </div>
                               </div>

                               <p class="position-relative h2 ms-md-n3 ms-lg-0 ms-0 me-lg-n5 fs-1  mt-5"
                               data-aos="fade-up">Plazo máximo.
                               </p>
                               <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
                                Un plazo mayor; permite que los pagos de un crédito sean menores y más cómodos. 
                                   <br><br>
                                   Una buena estrategia para adquirir un crédito es solicitar el plazo máximo para obtener un pago menor y realizar pagos anticipados (abono a capital) cada vez que sea posible. De ese modo, pagarás menos interés.

                               </p>
                              
                               <p class="position-relative h2 ms-md-n3 ms-lg-0 ms-0 me-lg-n5 fs-1  mt-5"
                               data-aos="fade-up">Contrato.
                               </p>
                               <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
                                Analizamos a detalle cada contrato para asegurarnos que tus derechos como usuario se respeten en los términos de en términos de lo dispuesto por la Ley para la Transparencia y Ordenamiento de los Servicios Financieros.

                                   <br><br>
                                   Así mismo consideramos las siguientes cláusulas abusivas:


                               </p>
                               <div class="row" data-aos="fade-up" data-aos-delay="100">
                                <div class="col-12">
                                    <ul>
                                        <li> Establece como causal de vencimiento anticipado del crédito, la cancelación de la cuenta de depósito en la que el acreditado recibe su nómina.
                                        </li>
                                        <li> Establece como causal de vencimiento anticipado del crédito, que el acreditado termine con la relación laboral existente al momento de la firma.</li>
                                        <li> Establece que la acreditación del pago será hasta el momento en que el patrón realice la transferencia de los recursos a la Institución Financiera, sin señalar un plazo cierto para tal acreditación. </li>
                                        <li> Establece que la Institución Financiera unilateralmente podrá realizar modificaciones a la forma de pago establecida en el Contrato de Adhesión.
                                        </li>
                                        <li> Prohíbe en general la contratación de cualquier otro tipo de crédito durante la vigencia del contrato o limita la movilidad del crédito.
                                        </li>
                                        <li> Traslada al Usuario obligaciones que no deriven de manera directa del contrato celebrado, sino que corresponda cumplir a la Institución Financiera por actos o requisitos establecidos por la Secretaría de Hacienda y Crédito Público, el Banco de México, la Comisión Nacional Bancaria y de Valores y cualquier otra autoridad.
                                        </li>
                                        <li> Establece el cargo de adeudos vencidos en cuentas de depósito, sin que se indique el plazo en el que se realizará el cargo ni el saldo por el cual se hará el cargo.
                                        </li>
                                        <li>
                                            Establece la autorización irrevocable para cargar las parcialidades del crédito en cualquier cuenta de nómina o de depósito a nombre del Usuario contratada con otra Institución Financiera.
                                        </li>
                                        <li>
                                            Establece que el acreditado debe avisar con antelación a la Institución Financiera la realización de un pago anticipado total o parcial del crédito.

                                        </li>
                                        <li>
                                            Establece que los pagos anticipados o adelantados se aplican a discreción de la Institución Financiera.
                                        </li>
                                        <li>
                                            Restringe o limite la disposición de saldos existentes en las cuentas de depósito que el acreditado tenga abiertas con la Institución Financiera, mientras el crédito esté vigente, excepto cuando los recursos depositados en la cuenta se hubiesen otorgado en garantía.
                                        </li>
                                        <li>
                                            Establece que la acreditación del pago con cheque sería hasta el momento en que la Institución Financiera dé por cumplido el pago, sin determinar una fecha cierta
                                        </li>
                                        <li>
                                            Establece como causal de vencimiento anticipado el incumplimiento de otros créditos celebrados con un tercero ajeno al grupo financiero.

                                        </li>
                                       
                                    </ul>
                                </div>
                               </div>

                               <p class="position-relative h2 ms-md-n3 ms-lg-0 ms-0 me-lg-n5 fs-1  mt-5"
                               data-aos="fade-up">Privacidad de datos.
                               </p>
                               <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
                                La protección de tus datos personales es tu derecho. Analizamos los avisos de privacidad para asegurarnos de que tus datos se usen únicamente para los fines requeridos y asegurarnos que no se compartan ni se vendan a empresas con otro fin ajeno.
                                   <br><br>
                                   Consideramos los siguientes aspectos:
                               </p>

                               <div class="row" data-aos="fade-up" data-aos-delay="100">
                                <div class="col-12">
                                    <ul>
                                        <li> Fines de mercadotecnia.
                                        </li>
                                        <li> Fines de prospección.</li>
                                        <li> Datos para fines secundarios. </li>
                                        <li> Datos sensibles.
                                        </li>
                                        <li> Transferencia a terceros.
                                        </li>
                                        <li> Transferencia a terceros cobranza.
                                        </li>
                                        <li> Derechos ARCO.
                                        </li>
                                        <li>
                                            Revocación del consentimiento.
                                        </li>
                                        <li>
                                            Opciones para limitar uso de datos.

                                        </li>
                                        <li>
                                            Tecnologías de rastreo.
                                        </li>
                                        <li>
                                            Concentimiento del titular.
                                        </li>
                                       
                                    </ul>
                                </div>
                               </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('add_script')
    @include('layouts.script_report')
@endsection