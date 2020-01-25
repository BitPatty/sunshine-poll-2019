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
            display: block;
            text-align: center;
        }

        .chart {
            display: inline-block;
        }
    </style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {packages: ["corechart"]});
        google.charts.setOnLoadCallback(drawChart);

        function createChart(parent, id, data) {
            const node = document.createElement('div');
            node.id = id;
            node.className = 'chart';
            parent.appendChild(node);

            const chart = new google.visualization.PieChart(document.getElementById(node.id));
            chart.draw(data, {
                pieHole: 0.1,
                fontName: "'Open Sans', Arial",
                fontSize: 14,
                height: 250,
                sliceVisibilityThreshold: 0
            });
        }

        function drawChart() {
            const data = [
                    @foreach($votes as $vote)
                {
                    label: '{{ trans('poll.sections.' . $vote['label'] . '.header') }}',
                    description: '{{ trans('poll.sections.' . $vote['label'] . '.description') }}',
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
                chartWrapper.className = 'chart__wrapper';
                chartNode.appendChild(chartWrapper);

                createChart(chartWrapper, nodes.abs, data[i].data.abs);
                createChart(chartWrapper, nodes.ind, data[i].data.ind);
            }
        }

    </script>
@endsection
