<?php

namespace App\Configuration;

class Questions
{

  public static function getPoll($id)
  {
    switch ($id) {
      case 'pre_poll':
        /* Apparently not needed anymore
        return [
          'question_list' => [
            self::AFF_CATEGORIES,
            self::ALLOW_MULTIPLE
          ],
          'description' => '<b>Voting system</b>: To be able to vote you need a <a href="https://speedrun.com"
                   target="_blank" rel="noreferrer">speedrun.com</a> account. Votes from people with runs on the Super Mario Sunshine
                   main or category extension leaderboards are automatically verified. All other votes will go through a process of
                   manual verification.',
          'flag' => 'has_voted_pp',
          'from' => new \DateTime('2019-11-29 00:00:00', new \DateTimeZone('UTC')),
          'to' => new \DateTime('2019-12-30 00:00:00', new \DateTimeZone('UTC'))
        ];
        */
      case 'main_poll':
        return [
          'question_list' => [
            self::HIDE_TIMINGS,
            self::TIMING_METHOD_A,
            self::TIMING_METHOD_B,
            self::TIMING_METHOD_C,
            self::TIMING_METHOD_D,
            self::TIMING_METHOD_E,
            self::COMMENT
          ],
          'description' => '<b>Voting system</b>: Everyone will be voting on whether or not they agree
                   that a timing method should be allowed on the leaderboard, as well as specificites contained in that.
                   (Note: File Select will always be allowed on the board, regardless of the poll results.)
                   <br><br>To be able to vote you need a <a href="https://speedrun.com" target="_blank" rel="noreferrer">speedrun.com</a>
                   account. Votes from people with runs on the Super Mario Sunshine main or category extension leaderboards are automatically verified,
                   while all other votes will go through a process of manual verification.
                   <br><br>The different timing methods will be seperated by variables on the leaderboard:
                   <img src="/img/lb_preview.png" class="img-fluid mx-auto d-block mt-5" alt="Leaderboard preview">',
          'flag' => 'has_voted',
          'from' => new \DateTime('2019-11-29 00:00:00', new \DateTimeZone('UTC')),
          'to' => new \DateTime('2019-12-30 00:00:00', new \DateTimeZone('UTC'))
        ];
      default:
        return null;
    }
  }

  private const AFF_CATEGORIES = [
    'id' => 'v_aff_categories',
    'title' => 'Affected Categories',
    'type' => 'select',
    'required' => true,
    'options' => [
      [
        'value' => 'Indifferent',
        'label' => 'Indifferent',
      ],
      [
        'value' => 'All main categories',
        'label' => 'All main categories',
      ],
      [
        'value' => 'Any% Only',
        'label' => 'Any% Only'
      ]
    ],
    'default' => 'Indifferent',
    'description' => 'What categories should be affected in case of a new timing method being implemented?',
    'validation_error' => 'The option chosen for "Affected Categories" is invalid'
  ];

  private const ALLOW_MULTIPLE = [
    'id' => 'v_allow_multiple',
    'title' => 'Allow multiple timing methods',
    'type' => 'select',
    'required' => true,
    'options' => [
      [
        'value' => 'Indifferent',
        'label' => 'Indifferent',
      ],
      [
        'value' => 'Any that gain 50% or more',
        'label' => 'Any that gain 50% or more',
      ],
      [
        'value' => 'Only the most voted for',
        'label' => 'Only the most voted for'
      ],
      [
        'value' => 'Peach file if it gets 50% or more and the most voted of the others',
        'label' => 'Peach file if it gets 50% or more and the most voted of the others'
      ]
    ],
    'default' => 'Indifferent',
    'description' => 'In the event that more than one timing method gains over a 50 percent majority, should more than one be allowed?',
    'validation_error' => 'The value selected for "Allow multiple timing methods" is invalid'
  ];


  private const HIDE_TIMINGS = [
    'id' => 'v_hide_timings',
    'title' => 'Hide Timings',
    'type' => 'select',
    'required' => true,
    'options' => [
      [
        'value' => 'Indifferent',
        'label' => 'Indifferent',
      ],
      [
        'value' => 'Yes',
        'label' => 'Yes',
      ],
      [
        'value' => 'No',
        'label' => 'No'
      ]
    ],
    'default' => 'Indifferent',
    'description' => 'The new timings should be hidden by default on the leaderboards.',
    'validation_error' => 'The option chosen for "Hide Timings" is invalid'
  ];

  private const TIMING_METHOD_A = [
    'id' => 'v_option_a',
    'title' => 'Timing Method A',
    'type' => 'select',
    'required' => true,
    'options' => [
      [
        'value' => 'Indifferent',
        'label' => 'Indifferent',
      ],
      [
        'value' => 'Yes',
        'label' => 'Yes',
      ],
      [
        'value' => 'No',
        'label' => 'No'
      ]
    ],
    'default' => 'Indifferent',
    'description' => 'Time starts on closing peach\'s textbox (first input). This is 1 minute and 13 seconds shorter than a file select run. 
        Should this timing method gain over 50% support, all runs on sms leaderboards that use file select would be converted to this timing 
        (ex: The current any% world record, 1:14:18, would become a 1:13:05. All runs in all main categories would follow suit.)
        <br><br>Sample: <a href="https://www.youtube.com/watch?v=j5_G15R5Uxo" target="_blank" rel="noreferrer">Youtube</a>',
    'validation_error' => 'The option chosen for "Timing Method A" is invalid'
  ];

  private const TIMING_METHOD_B = [
    'id' => 'v_option_b',
    'title' => 'Timing Method B',
    'type' => 'select',
    'required' => true,
    'options' => [
      [
        'value' => 'Indifferent',
        'label' => 'Indifferent',
      ],
      [
        'value' => 'Yes',
        'label' => 'Yes',
      ],
      [
        'value' => 'No',
        'label' => 'No'
      ]
    ],
    'default' => 'Indifferent',
    'description' => 'The file used is a premade file saved after having watched the Fludd cutscene on airstrip. 
          When loading this file, the intro cutscene and the fludd cutscene may be skipped. Around 2 minutes 
          shorter than file select.<br><br>Sample: <a href="https://www.youtube.com/watch?v=l94wg1wjuZs" 
          target="_blank" rel="noreferrer">Youtube</a>',
    'validation_error' => 'The option chosen for "Timing Method B" is invalid'
  ];

  private const TIMING_METHOD_C = [
    'id' => 'v_option_c',
    'title' => 'Timing Method C',
    'type' => 'select',
    'required' => true,
    'options' => [
      [
        'value' => 'Indifferent',
        'label' => 'Indifferent',
      ],
      [
        'value' => 'Yes',
        'label' => 'Yes',
      ],
      [
        'value' => 'No',
        'label' => 'No'
      ]
    ],
    'default' => 'Indifferent',
    'description' => 'Two premade files are used. One is saved after having watched the Fludd cutscene on airstrip. 
          The second is saved after being loaded into delfino plaza. The player would load the first file, 
          complete airstrip, reset, load the 2nd file and continue the run. Around 3 minutes faster than file 
          select.<br><br>Sample: <a href="https://youtu.be/h6xMV6M8MQs" target="_blank" rel="noreferrer">Youtube</a>',
    'validation_error' => 'The option chosen for "Timing Method C" is invalid'
  ];

  private const TIMING_METHOD_D = [
    'id' => 'v_option_d',
    'title' => 'Timing Method D',
    'type' => 'select',
    'required' => true,
    'options' => [
      [
        'value' => 'Indifferent',
        'label' => 'Indifferent',
      ],
      [
        'value' => 'Yes',
        'label' => 'Yes',
      ],
      [
        'value' => 'No',
        'label' => 'No'
      ]
    ],
    'default' => 'Indifferent',
    'description' => 'A save file that has been pre-modified and loaded onto your memory card, having set the intro cutscene, 
    fludd cutscene, and courtroom cutscene to watched, allowing them to be skipped. Around 3 minutes faster than file select.',
    'validation_error' => 'The option chosen for "Timing Method D" is invalid'
  ];

  private const TIMING_METHOD_E = [
    'id' => 'v_option_e',
    'title' => 'Timing Method E',
    'type' => 'select',
    'required' => true,
    'options' => [
      [
        'value' => 'Indifferent',
        'label' => 'Indifferent',
      ],
      [
        'value' => 'Yes',
        'label' => 'Yes',
      ],
      [
        'value' => 'No',
        'label' => 'No'
      ]
    ],
    'default' => 'Indifferent',
    'description' => 'A save file that has been pre-modified and loaded onto your memory card, having set all cutscene flags to watched, 
        allowing every cutscene to be skipped. Mashing through a cutscene adds its length to the final time to preserve in-game skips.
        Around 7 minutes faster than file select.',
    'validation_error' => 'The option chosen for "Timing Method E" is invalid'
  ];

  private const COMMENT = [
    'id' => 'comment',
    'title' => 'Additional Comments',
    'type' => 'textbox',
    'required' => 'false',
    'description' => 'This comment will only be visible to moderators'
  ];
}
