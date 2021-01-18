
$('#number').on("keyup", function (e) {
    $("#result").empty();
})


$('#calcule').on("click", function (e) {

    $('#calcule').css("display", "none");
    $('#calcule2').css("display", "block");

    if ($('#number').val() == '') {
        Swal.fire({
            icon: 'error',
            title: 'Digite um codigo de rastreio!',
            showConfirmButton: false,
            timer: 2500
        })
    } else {
        $.ajax({
            type: 'get',
            url: "rastrear/" + $('#number').val() + "",
            dataType: 'json',
            success: function (data) {
                $('#calcule').css("display", "block");
                $('#calcule2').css("display", "none");
                console.log(data);

                $("#result").empty();

                if (data.eventos.length == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Codigo de rastreio invalido!',
                        showConfirmButton: false,
                        timer: 2500
                    })
                } else {

                    for (var i = 0; i < data.eventos.length; i++) {
                        var destino = '';
                        if (data.eventos[i].subStatus.length != 0) {
                            var loc = data.eventos[i].subStatus[0].replace("CTE", "Unidade de Tratamento");

                            loc = loc.replace("CDD", "Unidade de Distribuição");
                            loc = loc.replace("AGF NBE", "Agência dos Correios");
                            loc = loc.replace("Origem:", "de");
                            loc = loc.replace("Destino:", "para");

                            if (data.eventos[i].subStatus.length == 2) {
                                var loc2 = data.eventos[i].subStatus[1].replace("CTE", "Unidade de Tratamento");
                                loc2 = loc2.replace("CDD", "Unidade de Distribuição");
                                loc2 = loc2.replace("AGF NBE", "Agência dos Correios");
                                loc2 = loc2.replace("Origem:", "de");
                                loc2 = loc2.replace("Destino:", "para");
                                destino = "<br>" + loc2;

                            }
                        } else {
                            loc = '';
                            destino = '';

                        }

                        if (data.eventos[i].status == undefined) {
                            data.eventos[i].status = '';
                        }
                        $html = '<table class="listEvent sro"><tbody><tr><td class="sroDtEvent top" valign="top">' + data.eventos[i].data + '<br>' + data.eventos[i].hora + '<br><label style="text-transform:capitalize;">' + data.eventos[i].local + '</label></td><td class="sroLbEvent"><strong>' + data.eventos[i].status + '</strong><br>' + loc + '  ' + destino + '</td></tr></tbody> </table>';
                        $("#result").append($html);
                    }
                }

            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Codigo de rastreio invalido!',
                    showConfirmButton: false,
                    timer: 2500
                })
                $('#calcule').css("display", "block");
                $('#calcule2').css("display", "none");
                console.log(data);

                $("#result").empty();
            }
        });
    }
});