<?php

return [
    'title' => 'スーパーマリオサンシャイン',
    'subtitle' => 'タイマー方式投票',
    'closed' => '投票が閉まっています',
    'voting_system' => '<b>投票のしくみ</b>： タイマーの取り方がいくつか提示されているので、それを正式なやり方として認めるかどうかを投票していただきます。過半数の賛成が得られたものをhttp://Speedrun.com(以下SRC)で正式に採用します。その場合はAny%だけでなく、79枚や120枚など全ての(新規ファイルを用いる)カテゴリーで採用されることになります。',
    'voting_requirement' => 'もうspeedrun.comのリーダーボードにRTAを投稿したなら、投票がすぐに検証します。それをやったことがないなら、人間は投票を見て検証します。',
    'poll_close_time' => '投票は2月23日13:59（JST）に終了します',
    'preview_description' => '',
    'sections' => [
        'src_token' => [
            'header' => 'SRCのトークン',
            'description' => 'このサイトからトークンを見つけてそれを入力してください。 <a href="https://www.speedrun.com/api/auth" target="_blank" rel="noreferrer">https://www.speedrun.com/api/auth</a>',
            'placeholder' => 'トークン'
        ],
        'hide_timings' => [
            'header' => '方式の表示',
            'description' => '（いずれかの方式が採用された場合）従来のもの以外の方式による記録をデフォルトで非表示にするべきかどうかを選んでください。',
            'options' => [
                'yes' => 'はい（非表示にすべき）',
                'no' => 'いいえ',
                'no_vote' => '無投票'
            ]
        ],
        'timing_method_a' => [
            'header' => '方式A',
            'description' => '最初のムービーとポンプムービーを見た直後にセーブしたデータを用意します。これら二つのムービーは飛ばすことができます（裁判ムービーは見なきゃダメ）。タイマーは2:30.20からスタートします。',
            'sample' => '参考： <a href="https://www.youtube.com/watch?v=cLhh4d4wZbw" target="_blank" rel="noreferrer">https://youtu.be/cLhh4d4wZbw</a>',
            'options' => [
                'yes' => '賛成',
                'no' => '反対',
                'no_vote' => '無投票'
            ]
        ],
        'timing_method_b' => [
            'header' => '方式B',
            'description' => '方式Aのファイルと裁判ムービー後のセーブファイル（いわゆるRace file）の二つを用意します。前者のセーブを使ってスタートし、エアポートのシャインを取得した直後にリセット、後者のファイルを読み込んでドルピックタウンから再度スタートします。タイマーは5:32.60からスタートします。',
            'sample' => '参考： <a href="https://www.youtube.com/watch?v=CoAgno0ktjQ" target="_blank" rel="noreferrer">https://youtu.be/CoAgno0ktjQ</a>',
            'options' => [
                'yes' => '賛成',
                'no' => '反対',
                'no_vote' => '無投票'
            ]
        ],
        'timing_method_c' => [
            'header' => '方式C',
            'description' => 'データをpre-modifiedして、オープニング、ポンプムービー、裁判ムービーを見た状態にしてスタートします。これらのムービーは飛ばすことができます。タイマーは5:40.07からスタートします。 （訳注：ざっくり言うと、データを改造してムービーのフラグをあらかじめ立てちゃおうという話です）',
            'sample' => '参考： <a href="https://www.youtube.com/watch?v=iXBclBuSyew" target="_blank" rel="noreferrer">https://youtu.be/iXBclBuSyew</a>',
            'options' => [
                'yes' => '賛成',
                'no' => '反対',
                'no_vote' => '無投票'
            ]
        ],
        'timing_method_d' => [
            'header' => '方式D',
            'description' => 'データをpre-modifiedして、方式Cの三つのムービーの他、初見のムービーを全て（ハニスキとメカクッパを除く）飛ばせるようにしてスタートします。タイマーは7:07.50からスタートします。 （訳注：チートコードのPersistent FMV Skipsみたいな感じです。ボスゲッソーとかその辺を飛ばせるようになる）',
            'options' => [
                'yes' => '賛成',
                'no' => '反対',
                'no_vote' => '無投票'
            ]
        ],
        'comment' => [
            'header' => '意見・コメントなど',
            'description' => ''
        ],
        'custom_run' => [
            'summary' => 'speedrun.comのアカウントでRTAを見つからない。下でRTAのプルーフを投稿する。たとえば動画のURLとspeedrunsliveのURL。プルーフがないなら、君の投票を最後の投票に含みません。',
            'header' => 'RTA URL',
            'placeholder' => 'RTA URL',
            'description' => 'speedrun.comとかspeedrunsliveレースとかのURLをここに出す。URLがなかったら、このページを飛ばして\'投稿する\'のボタンを押す'
        ]
    ],
    'username' => 'ユーザ名',
    'submit' => '投稿する',
    'success' => '成功。気が変わったら、もう一度フォームに記入して、投票が変わる。',
    'verification_state' => [
        'header' => '検証状態',
        'pending' => '検証済み',
        'verified' => '保留中',
        'rejected' => '却下',
        'auto_verified' => '自動的に検証済み'
    ],
    'language_switch' => [
        'label' => 'English Version',
        'url' => 'https://q.zint.ch',
        'results_url' => 'https://q.zint.ch/results'
    ],
    'total_votes_ind' => '総投票数:',
    'total_votes_abs' => '加重投票数(賛成/反対のみ):',
    'votes_by_pb' => 'Votes by PB (Any% Leaderboard runs)',
    'votes_by_yr' => 'Votes by latest PB date (Leaderboard runs only)'
];
