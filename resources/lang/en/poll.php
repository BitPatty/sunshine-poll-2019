<?php

return [
    'title' => 'Super Mario Sunshine',
    'subtitle' => 'Timing Method Vote 2020',
    'closed' => 'The poll is closed.',
    'voting_system' => '<b>Voting system</b>: Everyone will be voting on whether or not they agree that a timing method should be allowed on the leaderboard, as well as specificities contained in that. Any and all timing methods that receive over 50% approval will be allowed on the leaderboard. These changes will apply to all categories that currently start from a new file (Any%, 120 Shines, etc.). Note: File Select will always be allowed on the board, regardless of the poll results.',
    'voting_requirement' => 'To be able to vote you need a <a href="https://speedrun.com" target="_blank" rel="noreferrer">speedrun.com</a> account. Votes from people with runs on the Super Mario Sunshine main leaderboards are automatically verified, while all other votes will go through a process of manual verification. ',
    'preview_description' => 'The different timing methods will be separated by variables on the leaderboard:',
    'sections' => [
        'src_token' => [
            'header' => 'Speedrun.com Token',
            'description' => 'The token is required to verify your speedrun.com account. You can find your token here: <a href="https://www.speedrun.com/api/auth" target="_blank" rel="noreferrer">https://www.speedrun.com/api/auth</a>.',
            'placeholder' => 'Your token...'
        ],
        'hide_timings' => [
            'header' => 'Hide Timings',
            'description' => 'The new timings should be hidden by default on the leaderboards.',
            'options' => [
                'yes' => 'Yes',
                'no' => 'No',
                'no_vote' => 'No Vote'
            ]
        ],
        'timing_method_a' => [
            'header' => 'Timing Method A',
            'description' => 'The file used is a premade file saved after having watched the FLUDD cutscene on airstrip. When loading this file, the plane crash and FLUDD cutscene may be skipped. Runs that use this timing method will start with 2:30.20 on the timer to account for skipped cutscenes.',
            'sample' => 'Sample: <a href="https://www.youtube.com/watch?v=cLhh4d4wZbw" target="_blank" rel="noreferrer">https://www.youtube.com/watch?v=cLhh4d4wZbw</a>',
            'options' => [
                'yes' => 'Yes',
                'no' => 'No',
                'no_vote' => 'No Vote'
            ]
        ],
        'timing_method_b' => [
            'header' => 'Timing Method B',
            'description' => 'Two premade files are used. One is saved after having watched the FLUDD cutscene on airstrip. The second is saved after being loaded into delfino plaza. The player would load the first file, skip the plane crash and FLUDD cutscenes, complete airstrip, reset (save prompt must appear before the screen fades to black to be considered valid), then load the 2nd file and continue the run in delfino, skipping the courtroom and officer\'s speech cutscenes. Runs that use this timing method will start with 5:32.60 on the timer to account for skipped cutscenes.',
            'sample' => 'Sample: <a href="https://www.youtube.com/watch?v=CoAgno0ktjQ" target="_blank" rel="noreferrer">https://www.youtube.com/watch?v=CoAgno0ktjQ</a>',
            'options' => [
                'yes' => 'Yes',
                'no' => 'No',
                'no_vote' => 'No Vote'
            ]
        ],
        'timing_method_c' => [
            'header' => 'Timing Method C',
            'description' => 'A save file that has been pre-modified and loaded onto your memory card, having set the plane crash, FLUDD, courtroom, and officer\'s speech cutscenes to watched, allowing them to be skipped. Runs that use this timing method would start with 5:40.07 on the timer to account for skipped cutscenes.',
            'sample' => 'Sample: <a href="https://www.youtube.com/watch?v=iXBclBuSyew" target="_blank" rel="noreferrer">https://www.youtube.com/watch?v=iXBclBuSyew</a>',
            'options' => [
                'yes' => 'Yes',
                'no' => 'No',
                'no_vote' => 'No Vote'
            ]
        ],
        'timing_method_d' => [
            'header' => 'Timing Method D',
            'description' => 'A save file that has been pre-modified and loaded onto your memory card, having set all cutscene flags to watched (Exceptions: pinna 1 and pinna unlock cutscenes), allowing them to be skipped. Runs that use this timing method would start with 7:07.50 on the timer to account for skipped cutscenes.',
            'options' => [
                'yes' => 'Yes',
                'no' => 'No',
                'no_vote' => 'No Vote'
            ]
        ],
        'comment' => [
            'header' => 'Additional Comments',
            'description' => '(Optional) This comment will only be visible to moderators and the poll committee.'
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
