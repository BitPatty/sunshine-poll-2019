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

        @media screen and (max-width: 1000px) {
            .chart__wrapper {
                text-align: left;
            }

            .chart {
                width: 100%;
                max-width: 600px;
                min-width: initial;
            }
        }

        @media screen and (max-width: 700px) {
            .chart {
                max-width: 100%;
            }
        }
    </style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {packages: ["corechart"]});
        google.charts.setOnLoadCallback(drawChart);

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

            if (currentWidth !== lastWidth) drawChart(true);
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
                chartArea: {
                    left: '0%',
                    right: '0%',
                    top: '20%',
                    height: '70%',
                    width: '100%'
                }
            });
        }

        function drawChart(redraw = false) {
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
                    }
                },
                @endforeach
            ];

            for (let i = 0; i < data.length; i++) {
                const nodes = {
                    ind: `chart_ind_${i}`,
                    abs: `chart_abs_${i}`
                };

                if (redraw) {
                    const chartWrapper = document.getElementById(`chart_wrapper_${i}`);
                    createChart(chartWrapper, nodes.abs, data[i].data.abs, data[i].total.abs, '{{ trans('poll.total_votes_abs') }}');
                    createChart(chartWrapper, nodes.ind, data[i].data.ind, data[i].total.ind, '{{ trans('poll.total_votes_ind') }}');
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
                }
            }
        }

    </script>
@endsection
