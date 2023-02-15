/**
 * @file
 * highchart js.
 *
 */
(function ($, Drupal, drupalSettings) {
    'use strict';

    Drupal.behaviors.highchartExample = {
        attach: function (context, settings) {
            once('highchartExample', 'html', context).forEach(function (element) {

                // Gas Emissions.
                let gasEmissions = drupalSettings.gasEmissions
                let data = gasEmissions.entries
                let xAxis = []
                let yValue = []
                data.forEach(ele => {
                    let startDate = ele.startDate
                    let year = moment(startDate).format('YYYY');
                    xAxis.push(year)
                    yValue.push(ele.value)
                })
                const greenhouse_gas_emissions = Highcharts.chart('greenhouse_gas_emissions', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: `ID: ${gasEmissions.id} - ${gasEmissions.title}`
                    },
                    subtitle: {
                        text: gasEmissions.description
                    },
                    xAxis: {
                        categories: xAxis,
                        crosshair: true,
                        title: {
                            text: 'Year'
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: gasEmissions.unitOfMeasurementName
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: gasEmissions.unitOfMeasurementSymbol,
                        data: yValue
                    }]
                });


                // Emissions source breakdowns.
                let emission_year = 2020
                let ghgs_indicators = drupalSettings.emissionSource
                let emission_data = []
                ghgs_indicators.forEach(ele => {
                    let entries = ele.entries
                    let name = `ID: ${ele.id} - ${ele.title}`
                    let entry = entries.filter(item => {
                        let year = moment(item.startDate).format('YYYY');
                        return year == emission_year
                    })
                    if (entry.length > 0) {
                        emission_data.push(
                            {
                                name: name,
                                y: entry[0].value
                            }
                        )
                    }
                })

                const emission_source_breakdowns = Highcharts.chart('emission_source_breakdowns', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: `${emission_year} - Emission source breakdowns`
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f} ktCO₂e</b>'
                    },
                    accessibility: {
                        point: {
                            valueSuffix: 'ktCO₂e'
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.percentage:.1f} ktCO₂e'
                            }
                        }
                    },
                    series: [{
                        name: 'GHGs',
                        colorByPoint: true,
                        data: emission_data
                    }]
                });

                // Emissions Non-mining GHGs emission by year
                let nonGhgsEmissions = drupalSettings.nonGhgsEmissions
                let nonData = nonGhgsEmissions.entries
                xAxis = []
                yValue = []
                nonData.forEach(ele => {
                    let startDate = ele.startDate
                    let year = moment(startDate).format('YYYY');
                    xAxis.push(year)
                    yValue.push(ele.value)
                })
                const non_ghgs_emissions = Highcharts.chart('non_ghgs_emission', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: `ID: ${nonGhgsEmissions.id} - ${nonGhgsEmissions.title}`
                    },
                    subtitle: {
                        text: nonGhgsEmissions.description
                    },
                    xAxis: {
                        categories: xAxis,
                        crosshair: true,
                        title: {
                            text: 'Year'
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: nonGhgsEmissions.unitOfMeasurementName
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: nonGhgsEmissions.unitOfMeasurementSymbol,
                        data: yValue
                    }]
                })

                // Renewable Energy Visualizations
                let rollingAvgRenewEleGen = drupalSettings.rollingAvgRenewEleGen
                let rollingAvgData = []
                let futureRegulatoryData = []
                let longTermAspirationalData = []
                for (let i = 2010; i <= 2030; i++) {
                    futureRegulatoryData.push(97);
                    longTermAspirationalData.push(96);
                    let entry = rollingAvgRenewEleGen.entries.filter(item => {
                        let year = moment(item.startDate).format('YYYY');
                        return year == i
                    })
                    if (entry.length > 0) {
                        rollingAvgData.push(entry[0].value)
                    }
                    else {
                        rollingAvgData.push(null)
                    }
                }
                let renewEleSupYukonItgSys = drupalSettings.renewEleSupYukonItgSys
                let renewEleSupYukonItgSysData = []
                for (let i = 2010; i <= 2030; i++) {
                    let entry = renewEleSupYukonItgSys.entries.filter(item => {
                        let year = moment(item.startDate).format('YYYY');
                        return year == i
                    })
                    if (entry.length > 0) {
                        renewEleSupYukonItgSysData.push(entry[0].value)
                    }
                    else {
                        renewEleSupYukonItgSysData.push(null)
                    }
                }

                const renewable_energy_visualization = Highcharts.chart('renewable_energy_visualization', {
                    title: {
                        text: 'Renewable Energy Visualizations'
                    },
                    yAxis: {
                        title: {
                            text: 'Percent'
                        }
                    },

                    xAxis: {
                        accessibility: {
                            rangeDescription: 'Range: 2010 to 2030'
                        }
                    },

                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle'
                    },
                    plotOptions: {
                        series: {
                            label: {
                                connectorAllowed: false
                            },
                            pointStart: 2010
                        }
                    },
                    responsive: {
                        rules: [{
                            condition: {
                                minWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    },
                    series: [{
                        name: `ID: ${rollingAvgRenewEleGen.id} - ${rollingAvgRenewEleGen.title}`,
                        data: rollingAvgData
                    }, {
                        name: `ID: ${renewEleSupYukonItgSys.id} - ${renewEleSupYukonItgSys.title}`,
                        data: renewEleSupYukonItgSysData
                    }, {
                        name: `Future regulatory requirement`,
                        data: futureRegulatoryData
                    }, {
                        name: `Long-term aspirational target`,
                        data: longTermAspirationalData
                    }],
                })

                let ghgsPerCapita = drupalSettings.ghgsPerCapita
                let ghgsPerCapitaData = ghgsPerCapita.entries
                xAxis = []
                yValue = []
                ghgsPerCapitaData.forEach(ele => {
                    let startDate = ele.startDate
                    let year = moment(startDate).format('YYYY');
                    xAxis.push(year)
                    yValue.push(ele.value)
                })
                const ghg_per_capita = Highcharts.chart('emission_per_capita', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: `ID: ${ghgsPerCapita.id} - ${ghgsPerCapita.title}`
                    },
                    subtitle: {
                        text: ghgsPerCapita.description
                    },
                    xAxis: {
                        categories: xAxis,
                        crosshair: true,
                        title: {
                            text: 'Year'
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: ghgsPerCapita.unitOfMeasurementName
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: ghgsPerCapita.unitOfMeasurementSymbol,
                        data: yValue
                    }]
                })

                let ghgsPerGdp = drupalSettings.ghgsPerGdp
                let ghgsPerGdpData = ghgsPerGdp.entries
                xAxis = []
                yValue = []
                ghgsPerGdpData.forEach(ele => {
                    let startDate = ele.startDate
                    let year = moment(startDate).format('YYYY');
                    xAxis.push(year)
                    yValue.push(ele.value)
                })
                const ghg_per_gdp = Highcharts.chart('emission_density', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: `ID: ${ghgsPerGdp.id} - ${ghgsPerGdp.title}`
                    },
                    subtitle: {
                        text: ghgsPerGdp.description
                    },
                    xAxis: {
                        categories: xAxis,
                        crosshair: true,
                        title: {
                            text: 'Year'
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: ghgsPerGdp.unitOfMeasurementName
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            `<td style="padding:0"><b>{point.y:.1f} </b></td></tr>`,
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: ghgsPerGdp.unitOfMeasurementSymbol,
                        data: yValue
                    }]
                })
            })
        }
    }

})(jQuery, Drupal, drupalSettings);