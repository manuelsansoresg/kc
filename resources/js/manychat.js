import RfcFacil from 'rfc-facil'

$(document).ready(function() {
    function calcularRFC() {
        const nacimiento = $('input[name="fecha_nacimiento"]').val();
        const primerApellido = $('input[name="primer_apellido"]').val();
        const segundoApellido = $('input[name="segundo_apellido"]').val();
        const nombres = $('input[name="nombres"]').val();

        // Verificar que todos los campos necesarios estén llenos
        if (nacimiento && primerApellido && segundoApellido && nombres) {
            const [year, month, day] = nacimiento.split('-');

            const rfc = RfcFacil.forNaturalPerson({
                name: nombres,
                firstLastName: primerApellido,
                secondLastName: segundoApellido,
                day: day,
                month: month,
                year: year
            });

            $('input[name="rfc"]').val(rfc);
            if (rfc != '') {
                $('#text-rfc-error').show();
            } else {
                $('#text-rfc-error').hide();
            }
        }
    }

    // Calcular RFC cuando cambie cualquiera de los campos relevantes
    $('input[name="fecha_nacimiento"], input[name="primer_apellido"], input[name="segundo_apellido"], input[name="nombres"]').on('change', function() {
        calcularRFC();
    });
});