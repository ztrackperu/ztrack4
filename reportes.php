<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3><strong>Search by Date:  </strong><input style="border: 0; " type="text" name="datetimes" /></h3>
    <div>
        <canvas id="densityChart" width="900" height="600"></canvas>
    </div>
      
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0 "></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
      
      <script>
        var densityCanvas = document.getElementById("densityChart");
        

        //acumulado ="";
        var sleepES5 = function(ms){
    var esperarHasta = new Date().getTime() + ms;
    while(new Date().getTime() < esperarHasta) continue;
};

async function GenerarPDF(fecha_pasada,diasC,id){

    diaP = moment(fecha_pasada).add(5,'hours').format('YYYY-MM-DD');
    //diaF = moment(fecha_actual).add(5,'hours').format('YYYY-MM-DD');

    var fecha11 = moment(diaP);
    //var fecha21 = moment(diaF);

    var inic = new Date(fecha11);
    var completo = [];
    //diasC = fecha21.diff(fecha11, 'days');
    //console.log(diasC);
    const config = {method: 'get',dataType: 'json', url: 'principalController.php?option=datosContendores&id='  + id }
    const info =  await axios(config);
    $conte = info.data;
    //nombreMadurador ="Reefer "+$conte["nombre_contenedor"]+" : "+$conte["descripcionC"];

    diasArray=[];
    for( var i= 0 ; i<(diasC+1) ;i++)
    {
        if(i==0){
            variado = inic.setDate(inic.getDate()+0); 
            diaP = moment(variado).format('YYYY-MM-DD');
            diasArray.push(diaP);

        }else{
            variado = inic.setDate(inic.getDate()+1); 
            diaP = moment(variado).format('YYYY-MM-DD');
            diasArray.push(diaP);
        }                
     }
  
    completo.push({
        "telemetria_id" :id,
        //"fecha_pasada" :fecha11,
        //"fecha_final" :diaF,
        "dispositivo": $conte["nombre_contenedor"],
        "empresa":$conte["descripcionC"],
        "rango":diasArray
        
    })
    console.log(completo);

    $datito = JSON.stringify(completo);
    var request = new XMLHttpRequest();
    request.open('POST', 'verpdf2.php', true);
    request.setRequestHeader('Accept', 'multipart/form-data')
    request.send($datito);

}

//GenerarPDF('2023-11-20',6,386);

        async function filtroFechaM(fecha_pasada,fecha_actual,id){

            function saveImage (base64) {
             //   sleepES5(3000);
            var data = base64.replace(/^data:image\/png;base64,(.+)$/, '$1');
            /*
            var request1 =  new XMLHttpRequest();
            request1.open('POST', 'saveImageOnServer.php', true);
            request1.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            request1.send('telemetria_externa=' + id);
            request1.send('fecha_externa=' + fecha_pasada);
            */
           var inic = new Date(fecha_pasada);
           //variado = inic.setDate(inic.getDate()+0); 
            diaP = moment(fecha_pasada).format('YYYY-MM-DD')
           var completo = [];

           completo.push({
            "telemetria_id" :id,
            "fecha_pasada" :diaP,
            "img" : data

           })
           
           //console.log(completo[0]);
           //console.log("jajaja");
           //console.log(JSON.stringify(completo));
           $datito = JSON.stringify(completo);


            var request = new XMLHttpRequest();
            //console.log(data);
            request.open('POST', 'saveImageOnServer.php', true);
            //request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            request.setRequestHeader('Accept', 'multipart/form-data')
            //request.setRequestHeader("Content-type","multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2));
            //request.send('imageData=' + data);
            request.send($datito);
           // console.log(data);
        }
            acumulado1 = fecha_pasada +','+fecha_actual+';'+id;
            const config = {method: 'get',dataType: 'json', url: 'principalController.php?option=consultaFechaMadurador1&id='  + acumulado1 }
            const info =  await axios(config);
            //console.log(info);
            //console.log(info.data.fecha);
            //console.log(info.returnAir);
            //console.log(info.tempSupply);
            //console.log(info.inyeccionEtileno);
            $conte = info.data.contenedor;
            nombreMadurador ="Reefer "+$conte["nombre_contenedor"]+" : "+$conte["descripcionC"];
            if (typeof X1 !== 'undefined') {

                X1.destroy();
            }
            X1 =new Chart(densityCanvas, {
            type: 'line',// Tipo de gráfica
            data: {
            labels: info.data.fecha,
                datasets: [
                    {
                        label : " Return ",
                        data : info.data.returnAir,
                        backgroundColor: '#ec7063', // Color de fondo
                        borderColor: '#ec7063', // Color del borde
                        borderWidth: 3,// Ancho del borde
                        yAxisID : 'y',
                        pointRadius: 0,
                        cubicInterpolationMode: 'monotone',
                        tension: 0.4,
                        hidden :false,
                        datalabels: {
                            display: 'auto',
                            clip :'true',
                            clamp :'true',
                            align: 'end',   
                        },
                    },
                    {
                        label : " Supply",
                        data : info.data.tempSupply,
                        backgroundColor: '#27ae60', // Color de fondo
                        borderColor: '#27ae60', // Color del borde
                        borderWidth: 3,// Ancho del borde
                        yAxisID : 'y',
                        pointRadius : 0,
                        cubicInterpolationMode: 'monotone',
                        tension: 0.4,
                        hidden :false,
                        datalabels: {
                            display: 'auto',
                            clip :'true',
                            clamp :'true',
                            align: 'end',   
                        },
                    },
                    {
                        label : " SetPoint",
                        data : info.data.setPoint ,
                        backgroundColor: '#f1c40f', // Color de fondo
                        borderColor: '#f1c40f', // Color del borde
                        borderWidth: 3,
                        yAxisID : 'y',
                        pointRadius: 0,
                        cubicInterpolationMode: 'monotone',
                        tension: 0.4 ,
                        hidden :false,
                        datalabels: {
                            //display: 'false', 
                            labels: {
                                title: null
                            }  
                        },
                    },

                   {
                        label : " Humedity",
                        data : info.data.setPoint ,
                        backgroundColor: '#f1c46f', // Color de fondo
                        borderColor: '#f1c46f', // Color del borde
                        borderWidth: 3,
                        yAxisID : 'y1',
                        pointRadius: 0,
                        cubicInterpolationMode: 'monotone',
                        tension: 0.4 ,
                        hidden :false,
                        datalabels: {
                            //display: 'false',
                            labels: {
                                title: null
                            }
                        },
                    },
                    {
                        label : " ON/OFF",
                        data :  info.data.inyeccionEtileno ,
                        backgroundColor: '#FFB8AF', // Color de fondo
                        borderColor: '#FFB8AF', // Color del borde
                        borderWidth: 1,
                        yAxisID : 'y1',
                        pointRadius: 0,
                        cubicInterpolationMode: 'monotone',
                        tension: 0.4 ,
                        hidden :false,
                        fill: true,  
                        datalabels: {
                            //display: 'false',  
                            labels: {
                                title: null
                            } 
                        },
                    }                          
                ]
            },
            options: {
                animation: {
                    onComplete: function () {
                        /*
                        setTimeout(function(){
                            saveImage(X1.toBase64Image());

                        },1000);
                        */
                        //sleepES5(3000);

                        saveImage(X1.toBase64Image());
                    },
                },

                responsive : false,
                backgroundColor: '#fff',
                interaction :{
                    mode : 'index',
                    intersect :false,
                },
                stacked :false,
                scales: {

                    y: {
                        position: 'left',
                        display: true,
                        title: {
                            display: true,
                            text: 'Temperature (C°)',
                            color: '#1a2c4e',
                            font: {     
                                size: 20,
                                style: 'normal',
                                lineHeight: 1.2
                            },
                            padding: {top: 30, left: 0, right: 0, bottom: 0}
                        },
                        suggestedMin: -30,
                        suggestedMax: 0
                    },

                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Percentage (%)',
                            color: '#1a2c4e',
                            font: {                      
                                size: 20,
                                style: 'normal',
                                lineHeight: 1.2
                            },
                            padding: {top: 30, left: 0, right: 0, bottom: 0}
                        },
                        grid: {
                            drawOnChartArea: false, // only want the grid lines for one axis to show up
                        },
                        suggestedMin: 0,
                        suggestedMax: 100,
                    },
                },
                plugins: {
                    datalabels: {
                        color: function(context) {
                        return context.dataset.backgroundColor;
                        },
                        font: {
                        weight: 'bold'
                        },          
                        padding: 6,
        
                    },
                    title: {
                        display: true,
                        text: nombreMadurador,
                        color: '#1a2c4e',
                        font: {                        
                            size: 30,
                            style: 'normal',
                            lineHeight: 1.2
                        },
                        padding: {top: 30, left: 0, right: 0, bottom: 0}
                    },

                    customCanvasBackgroundColor : {
                        color :'#fff',
                    },
                    legend : {
                        position :'bottom',
                        align : 'center',
                        labels : {
                            boxWidth :20 ,
                            boxHeight : 20,
                            color :'#1a2c4e',
                            padding :15 ,
                            textAlign : 'left',
                            font: {
                                size: 12,
                                style: 'normal',
                                lineHeight: 1.2
                            },
                            title : {
                                text :'Datos Graficados:',
                            },
                        },
                    },

                }           
            },
            plugins : [ChartDataLabels],          
        })

        }

        
        $('input[name="datetimes"]').daterangepicker({ timePicker: true,startDate : moment().add(-24,'hour'),endDate: moment(),locale: { format: 'YYYY-MM-DD ' }, },
        async function(start,end,label){
            /*
            $(".loader").show();
            idf =start.format('YYYY-MM-DD HH:mm ');
            idf1 =end.format('YYYY-MM-DD HH:mm ');
            acumulado = idf +','+idf1+';'+id;
            console.time('loop');
            console.log(acumulado);
            const config = {method: 'get',dataType: 'json', url: '../../ztrack4/controllers/principalController.php?option=consultaFechaMadurador1&id='  + acumulado }
           //const config = {method: 'get',dataType: 'json', url: '../../mensaje.py'}
            const buena =  await axios(config);
            console.log(buena)
            const info1 = buena.data;
            console.timeEnd('loop');
            $(".loader").fadeOut("fast");
            
            console.time('loop');

            //ultimoPuntoMadurador(info1,id);
            console.timeEnd('loop');
            console.time('loop');

            graficaMadurador(info1);  
            console.timeEnd('loop');
            
            console.time('loop');
            tablaDatosMadurador(info1);
            console.timeEnd('loop');

            */
            idf =start.format('YYYY-MM-DD');
            idf1 =end.format('YYYY-MM-DD');
            var fecha1 = moment(idf).add(0,'days').format('YYYY-MM-DD HH:mm ');
            var fecha2 = moment(idf1).add(5,'hours').format('YYYY-MM-DD HH:mm ');

            var fecha11 = moment(idf).add(5,'hours');
            var fecha21 = moment(idf1).add(5,'hours');
            diasC = fecha21.diff(fecha11, 'days');
            console.log(diasC);
            //console.log(idf);

            //console.log(fecha1);
            var inic = new Date(fecha1);
            //console.log(inic);
            //variado = inic.setDate(inic.getDate()+1);
            //console.log(variado);
            //console.log(moment(variado).format('YYYY-MM-DD'));
            idx=1;
            const config1 = {method: 'get',dataType: 'json', url: 'principalController.php?option=listaNestle&id='+ idx }
            const info1 =  await axios(config1);
            const info2 = info1.data;

  

            console.log(info2);
            i=0;
            teleme = [];

            info2.forEach(permiso => {
                teleme.unshift(parseFloat(permiso.telemetria_id));
            });
        for (var j=0 ;j<teleme.length;j++){
            for( var i= 0 ; i<(diasC+1) ;i++)
            {
                if(i==0){
                    variado = inic.setDate(inic.getDate()+0); 
                    diaP = moment(variado).format('YYYY-MM-DD')
                    diaP1 =diaP+" 00:00";
                    diaP2 =diaP+" 23:59";
                    console.log("inicio : "+diaP1+" final : "+diaP2);
                }else{
                    variado = inic.setDate(inic.getDate()+1); 
                    diaP = moment(variado).format('YYYY-MM-DD')
                    diaP1 =diaP+" 00:00";
                    diaP2 =diaP+" 23:59";
                    console.log("inicio : "+diaP1+" final : "+diaP2);

                }

                 await filtroFechaM( diaP1,diaP2,teleme[j]);
                 
            }
            inic=new Date(fecha1);
            sleepES5(3000);
            await GenerarPDF(inic,diasC,teleme[j]);
        }

/*

            for( var i= 0 ; i<(diasC+1) ;i++)
            {
                if(i==0){
                    variado = inic.setDate(inic.getDate()+0); 
                    diaP = moment(variado).format('YYYY-MM-DD')
                    diaP1 =diaP+" 00:00";
                    diaP2 =diaP+" 23:59";
                    console.log("inicio : "+diaP1+" final : "+diaP2);
                }else{
                    variado = inic.setDate(inic.getDate()+1); 
                    diaP = moment(variado).format('YYYY-MM-DD')
                    diaP1 =diaP+" 00:00";
                    diaP2 =diaP+" 23:59";
                    console.log("inicio : "+diaP1+" final : "+diaP2);

                }

                await filtroFechaM( diaP1,diaP2,386);
                //await GenerarPDF(fecha_pasada,diasC,id)
                

                
                */
            // crear el pdf cn todas las imagenes


            //console.log(fecha2.diff(fecha1, 'days'), ' dias de diferencia');
          });
    

        //var fecha1 = moment('2023-10-20 23:44');
        //var fecha2 = moment('2023-10-26 11:44');

        
      </script>
       
    
</body>
</html>
