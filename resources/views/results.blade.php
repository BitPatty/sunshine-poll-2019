@extends('partials.master')

@section('content')
    <section class="section has-text-centered">
        <h1 class="title is-h1">{{ trans('poll.title') }}</h1>
        <h2 class="subtitle">{{ trans('poll.subtitle') }}</h2>
        <a title="Language Switch"
           href="{{ trans('poll.language_switch.results_url') }}">{{ trans('poll.language_switch.label') }}</a>
    </section>
    <section class="section">
        <div class="chart_collection" id="charts">
        </div>
    </section>
@endsection
@section('scripts')
    <style>
        @if(env('APP_ENV') === 'local')

        * {
            border: 1px solid #f00 !important;
        }

        @endif

        .chart_collection > div {
            display: block;
        }

        .chart__wrapper {
            padding: 30px;
            display: block;
            text-align: center;
        }

        .chart {
            display: inline-block;
            padding: 30px;
            width: 30%;
            min-width: 400px;
            max-width: 100%;
        }

        .chart.single {
            display: inline-block;
            width: calc(60% + 60px);
        }

        @media screen and (max-width: 1000px) {
            .chart__wrapper {
                text-align: left;
            }

            .chart {
                width: 100%;
                max-width: 600px;
                min-width: initial;
                height: auto;
                padding: 30px 0px;
            }

            .chart.single {
                width: 100%;
            }
        }

        @media screen and (max-width: 700px) {

            .section {
                padding-left: 0px;
                padding-right: 0px;
            }

            .chart__wrapper {
                padding: 0px;
            }

            .chart {
                max-width: 100%;
                height: auto;
            }
        }
    </style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {packages: ["corechart"]});
        google.charts.setOnLoadCallback(drawCharts);

        function getWindowStep() {
            return Math.floor(window.outerWidth / 100);
        }

        function debounce(func, wait, immediate) {
            var timeout;
            return function () {
                var context = this, args = arguments;
                var later = function () {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        }

        const REDRAW_THRESHOLD = 7;
        var lastWindowWidth = getWindowStep();
        const resizeHandler = debounce(() => {
            const lastWidth = lastWindowWidth;
            const currentWidth = getWindowStep();
            lastWindowWidth = currentWidth;

            if (currentWidth !== lastWidth) drawCharts(true);
        }, 100);

        window.addEventListener('resize', resizeHandler);

        function createChart(parent, id, data, total_votes, title) {
            const chartNode = document.getElementById(id);

            if (!chartNode) {
                const node = document.createElement('div');
                node.id = id;
                node.className = 'chart';
                parent.appendChild(node);
            }

            const chart = new google.visualization.PieChart(document.getElementById(id));
            chart.draw(data, {
                title: `${title} ${total_votes}`,
                pieHole: lastWindowWidth <= REDRAW_THRESHOLD ? 0 : 0.3,
                fontName: "'Open Sans', Arial",
                fontSize: 14,
                height: 'auto',
                width: '100%',
                sliceVisibilityThreshold: 0,
                tooltip: lastWindowWidth > REDRAW_THRESHOLD ? {trigger: 'none'} : {trigger: 'focus'},
                pieSliceText: lastWindowWidth <= REDRAW_THRESHOLD ? 'percentage' : 'none',
                legend: {
                    position: lastWindowWidth > REDRAW_THRESHOLD ? 'labeled' : 'bottom',
                    labeledValueText: 'both',
                    maxLines: 3,
                },
                areaOpacity: 0.5,

                chartArea: {
                    left: '0%',
                    right: '0%',
                    top: '20%',
                    height: '75%',
                    width: '100%'
                }
            });
        }

        function createStatsChart(parent, id, data, title, relative = false) {
            const chartNode = document.getElementById(id);

            if (!chartNode) {
                const node = document.createElement('div');
                node.id = id;
                node.className = 'chart single';
                parent.appendChild(node);
            }

            const chart = new google.visualization.SteppedAreaChart(document.getElementById(id));

            const options = {
                title: title,
                vAxis: {title: 'Accumulated Votes', titleTextStyle: {italic: false}},
                fontName: 'Open Sans',
                connectSteps: false,
                isStacked: relative ? 'percent' : true,
                areaOpacity: 0.5,
                height: '200',
                width: '100%',
                legend: {
                    position: lastWindowWidth > REDRAW_THRESHOLD ? 'labeled' : 'bottom',
                    labeledValueText: 'both',
                    maxLines: 3,
                },
                chartArea: {
                    left: '0%',
                    right: '0%',
                    top: '20%',
                    height: '70%',
                    width: '100%'
                }
            };

            chart.draw(data, options);
        }

        function drawCharts(redraw = false) {
            const data = [
                    @foreach($votes as $vote)
                {
                    label: '{{ trans('poll.sections.' . $vote['label'] . '.header') }}',
                    description: '{{ trans('poll.sections.' . $vote['label'] . '.description') }}',
                    total: {
                        ind: '{{ $vote['Yes'] + $vote['No'] + $vote['No Vote'] }}',
                        abs: '{{ $vote['Yes'] + $vote['No']  }}',
                    },
                    data: {
                        ind:
                            google.visualization.arrayToDataTable([
                                ['Vote', 'Vote count'],
                                ['{{ trans('poll.sections.' . $vote['label'] . '.options.yes') }}', {{ $vote['Yes'] }}],
                                ['{{ trans('poll.sections.' . $vote['label'] . '.options.no') }}', {{ $vote['No'] }}],
                                ['{{ trans('poll.sections.' . $vote['label'] . '.options.no_vote') }}', {{ $vote['No Vote'] }}],
                            ]),
                        abs:
                            google.visualization.arrayToDataTable([
                                ['Vote', 'Vote count'],
                                ['{{ trans('poll.sections.' . $vote['label'] . '.options.yes') }}', {{ $vote['Yes'] }}],
                                ['{{ trans('poll.sections.' . $vote['label'] . '.options.no') }}', {{ $vote['No'] }}],
                            ]),
                        aggr_pb:
                            google.visualization.arrayToDataTable([
                                ['PB', 'Yes', 'No', 'No Vote'],
                                    @foreach($aggregated_votes['pb'] as $aggr_vote)
                                ['< {{ $aggr_vote['pb'] }}', {{ $aggr_vote[$vote['label']. '.options.yes'] }}, {{ $aggr_vote[$vote['label']. '.options.no'] }}, {{ $aggr_vote[$vote['label']. '.options.no_vote'] }} ],
                                @endforeach
                            ]),
                        aggr_yr:
                            google.visualization.arrayToDataTable([
                                ['PB', 'Yes', 'No', 'No Vote'],
                                    @foreach($aggregated_votes['yr'] as $aggr_vote)
                                ['{{ $aggr_vote['year'] }}', {{ $aggr_vote[$vote['label']. '.options.yes'] }}, {{ $aggr_vote[$vote['label']. '.options.no'] }}, {{ $aggr_vote[$vote['label']. '.options.no_vote'] }} ],
                                @endforeach
                            ]),
                    }
                },
                @endforeach
            ];

            for (let i = 0; i < data.length; i++) {
                const nodes = {
                    ind: `chart_ind_${i}`,
                    abs: `chart_abs_${i}`,
                    aggr_pb: `chart_aggr_pb_${i}`,
                    aggr_yr: `chart_aggr_yr_${i}`,
                };

                if (redraw) {
                    const chartWrapper = document.getElementById(`chart_wrapper_${i}`);

                    createChart(chartWrapper, nodes.abs, data[i].data.abs, data[i].total.abs, '{{ trans('poll.total_votes_abs') }}');
                    createChart(chartWrapper, nodes.ind, data[i].data.ind, data[i].total.ind, '{{ trans('poll.total_votes_ind') }}');

                    const statsWrapper = document.getElementById(`stats_wrapper_${i}`);

                    createStatsChart(statsWrapper, nodes.aggr_pb, data[i].data.aggr_pb, '{{ trans('poll.votes_by_pb') }}');
                    createStatsChart(statsWrapper, nodes.aggr_yr, data[i].data.aggr_yr, '{{ trans('poll.votes_by_yr') }}');
                } else {
                    const chartNode = document.createElement('div');
                    document.getElementById('charts').appendChild(chartNode);

                    const header = document.createElement('h3');
                    header.innerHTML = data[i].label;
                    header.className = 'title is-4'
                    chartNode.appendChild(header);

                    const description = document.createElement('p');
                    description.innerHTML = data[i].description;
                    chartNode.appendChild(description);

                    const chartWrapper = document.createElement('div');
                    chartWrapper.id = `chart_wrapper_${i}`;
                    chartWrapper.className = 'chart__wrapper';
                    chartNode.appendChild(chartWrapper);

                    createChart(chartWrapper, nodes.abs, data[i].data.abs, data[i].total.abs, '{{ trans('poll.total_votes_abs') }}');
                    createChart(chartWrapper, nodes.ind, data[i].data.ind, data[i].total.ind, '{{ trans('poll.total_votes_ind') }}');

                    const statsWrapper = document.createElement('div');
                    statsWrapper.id = `stats_wrapper_${i}`;
                    statsWrapper.className = 'chart__wrapper';
                    chartNode.appendChild(statsWrapper);

                    createStatsChart(statsWrapper, nodes.aggr_pb, data[i].data.aggr_pb, '{{ trans('poll.votes_by_pb') }}');
                    createStatsChart(statsWrapper, nodes.aggr_yr, data[i].data.aggr_yr, '{{ trans('poll.votes_by_yr') }}');
                }
            }
        }

    </script>
@endsection
