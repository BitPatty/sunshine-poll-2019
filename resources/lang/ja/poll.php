<?php

return [
    'title' => 'スーパーマリオサンシャイン　タイマー方式投票',
    'subtitle' => '',
    'closed' => 'The poll is closed.',
    'voting_system' => '<b>投票のしくみ</b>： タイマーの取り方がいくつか提示されているので、それを正式なやり方として認めるかどうかを投票していただきます。過半数の賛成が得られたものをhttp://Speedrun.com(以下SRC)で正式に採用します。その場合はAny%だけでなく、79枚や120枚など全ての(新規ファイルを用いる)カテゴリーで採用されることになります。',
    'voting_requirement' => '',
    'preview_description' => '',
    'sections' => [
        'src_token' => [
            'header' => 'SRCのトークン',
            'description' => 'このサイトからトークンを見つけてそれを入力してください。 <a href="https://www.speedrun.com/api/auth" target="_blank" rel="noreferrer">https://www.speedrun.com/api/auth</a>',
            'placeholder' => 'Your token...'
        ],
        'hide_timings' => [
            'header' => '方式の表示',
            'description' => '（いずれかの方式が採用された場合）従来のもの以外の方式による記録をデフォルトで非表示にするべきかどうかを選んでください。',
            'options' => [
                'yes' => 'はい（非表示にすべき）',
                'no' => 'いいえ',
                'no_vote' => 'どちらでもいい'
            ]
        ],
        'timing_method_a' => [
            'header' => '方式A',
            'description' => '最初のムービーとポンプムービーを見た直後にセーブしたデータを用意します。これら二つのムービーは飛ばすことができます（裁判ムービーは見なきゃダメ）。タイマーは2:30.20からスタートします。',
            'sample' => '参考： <a href="https://www.youtube.com/watch?v=cLhh4d4wZbw" target="_blank" rel="noreferrer">https://youtu.be/cLhh4d4wZbw</a>',
            'options' => [
                'yes' => '賛成',
                'no' => '反対',
                'no_vote' => 'どちらでもいい'
            ]
        ],
        'timing_method_b' => [
            'header' => '方式B',
            'description' => '方式Aのファイルと裁判ムービー後のセーブファイル（いわゆるRace file）の二つを用意します。前者のセーブを使ってスタートし、エアポートのシャインを取得した直後にリセット、後者のファイルを読み込んでドルピックタウンから再度スタートします。タイマーは5:32.60からスタートします。',
            'sample' => '参考： <a href="https://www.youtube.com/watch?v=CoAgno0ktjQ" target="_blank" rel="noreferrer">https://youtu.be/CoAgno0ktjQ</a>',
            'options' => [
                'yes' => '賛成',
                'no' => '反対',
                'no_vote' => 'どちらでもいい'
            ]
        ],
        'timing_method_c' => [
            'header' => '方式C',
            'description' => 'データをpre-modifiedして、オープニング、ポンプムービー、裁判ムービーを見た状態にしてスタートします。これらのムービーは飛ばすことができます。タイマーは5:40.07からスタートします。 （訳注：ざっくり言うと、データを改造してムービーのフラグをあらかじめ立てちゃおうという話です）',
            'sample' => '参考： <a href="https://www.youtube.com/watch?v=iXBclBuSyew" target="_blank" rel="noreferrer">https://youtu.be/iXBclBuSyew</a>',
            'options' => [
                'yes' => '賛成',
                'no' => '反対',
                'no_vote' => 'どちらでもいい'
            ]
        ],
        'timing_method_d' => [
            'header' => '方式D',
            'description' => 'データをpre-modifiedして、方式Cの三つのムービーの他、初見のムービーを全て（ハニスキとメカクッパを除く）飛ばせるようにしてスタートします。タイマーは7:07.50からスタートします。 （訳注：チートコードのPersistent FMV Skipsみたいな感じです。ボスゲッソーとかその辺を飛ばせるようになる）',
            'options' => [
                'yes' => '賛成',
                'no' => '反対',
                'no_vote' => 'どちらでもいい'
            ]
        ],
        'comment' => [
            'header' => '意見・コメントなど',
            'description' => ''
        ],
        'custom_run' => [
            'summary' => 'No runs found for your profile. You can submit a proof of you performing a run below, or submit again to skip this step. A previous SRL race or a video can be considered proof. If you feel you can prove you\'ve done a run through another medium, feel free to put it here. If you can not prove you’ve run the game, you can still vote, but it will not be weighed when the poll is finished. Your vote has not been updated yet!',
            'header' => 'Run URL',
            'placeholder' => 'Link to one of your runs..',
            'description' => 'Provide a URL to one of your runs/SRL races or skip this step by clicking \'Submit\'.'
        ]
    ],
    'submit' => 'Submit',
    'success' => 'Your vote has been registered. Changed your mind? Fill in <a href="/" title="Poll">the form</a> again to update your vote.'
];
