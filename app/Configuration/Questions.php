<?php

namespace App\Configuration;

class Questions
{
  public const QUESTION_LIST = [
    self::HIDE_TIMINGS,
    self::ALLOW_MULTIPLE,
    self::TIMING_METHOD_A,
    self::TIMING_METHOD_B,
    self::TIMING_METHOD_C,
    self::TIMING_METHOD_D,
    self::TIMING_METHOD_E,
    self::COMMENT
  ];

  public const POLL_DESCRIPTION = '<b>Voting system</b>: Everyone will be voting on whether or not they agree that a timing method should be
      allowed on the leaderboard, as well as specificites contained in that, should one or more of the timing
      methods reach over 50%, the method with the highest approval rating will be implemented alongside file
      select on the leaderboard. In the event that timing method C or B wins, and other method also receives over
      50%, adding both of them will be considered.';

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
        'value' => 'Yes',
        'label' => 'Yes',
      ],
      [
        'value' => 'No',
        'label' => 'No'
      ],
      [
        'value' => 'Only B and C',
        'label' => 'Only B and C'
      ]
    ],
    'default' => 'Indifferent',
    'description' => 'In the event that more than one timing method gains over a 50 percent majority, should more than one be allowed?',
    'validation_error' => 'The value selected for "Allow multiple timing methods" is invalid'
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
    'description' => 'Timing starts on closing Peach’s textbox. The file used is a premade file saved immediately after talking to peach on the airstrip. The first cutscene is skipped. Around a minute shorter than file select.<br><br>Sample: <a href="https://www.youtube.com/watch?v=-lML1_C1mfg" target="_blank" rel="noreferrer">Youtube</a>',
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
    'description' => 'The file used is a premade file saved after having watched the Fludd cutscene on airstrip. When loading this file, the intro cutscene and the fludd cutscene may be skipped. Around 2 minutes shorter than file select.<br><br>Sample: <a href="https://www.youtube.com/watch?v=l94wg1wjuZs" target="_blank" rel="noreferrer">Youtube</a>',
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
    'description' => 'Two premade files are used. One is saved after having watched the Fludd cutscene on airstrip. The second is saved after being loaded into delfino plaza. The player would load the first file, complete airstrip, reset, load the 2nd file and continue the run. Around 3 minutes faster than file select.<br><br>Sample: <a href="https://youtu.be/h6xMV6M8MQs" target="_blank" rel="noreferrer">Youtube</a>',
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
    'description' => 'A save file that has been pre-modified and loaded onto your memory card, having set the intro cutscene, fludd cutscene, and courtroom cutscene to watched, allowing them to be skipped. Around 3 minutes faster than file select.',
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
    'description' => 'A save file that has been pre-modified and loaded onto your memory card, having set all cutscene flags to watched, allowing every cutscene to be skipped. Mashing through a cutscene adds its length to the final time to preserve in-game skips. Around 7 minutes faster than file select.',
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
