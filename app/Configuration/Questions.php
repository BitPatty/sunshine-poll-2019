<?php

namespace App\Configuration;

class Questions
{

  public static function getPoll()
  {
    return [
      'question_list' => [
        self::TIMING_METHOD_A,
        self::TIMING_METHOD_B,
        self::TIMING_METHOD_C,
        self::TIMING_METHOD_D,
        self::COMMENT
      ],
      'description' => '<b>Voting system</b>: Everyone will be voting on whether or not they agree
           that a timing method should be allowed on the leaderboard, as well as specificites contained in that.
           Any and all timing methods that receive over 50% approval will be allowed on the leaderboard.
           These changes will apply to all categories that currently start from a new file (Any%, 120 Shines, etc.).
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
  }

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
    'description' => 'The file used is a premade file saved after having watched the FLUDD cutscene on airstrip.
          When loading this file, the plane crash cutscene and the FLUDD cutscene may be skipped. Runs that use 
          this timing method will start with 2:30.20 on the timer to account for skipped cutscenes.
          <br><br>Sample: <a href="https://www.youtube.com/watch?v=cLhh4d4wZbw" target="_blank" rel="noreferrer">Youtube</a>',
    'validation_error' => 'The option chosen for "Timing Method B" is invalid'
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
    'description' => 'Two premade files are used. One is saved after having watched the FLUDD cutscene on airstrip.
        The second is saved after being loaded into delfino plaza. The player would load the first file, skip the 
        plane crash and FLUDD cutscenes, complete airstrip, reset (save prompt must appear before the screen fades 
        to black to be considered valid), then load the 2nd file and continue the run in delfino, skipping the court 
        and officer\'s speech cutscenes. Runs that use this timing method will start with 5:32.60 on the timer to 
        account for skipped cutscenes.
        <br><br>Sample: <a href="https://www.youtube.com/watch?v=CoAgno0ktjQ" target="_blank" rel="noreferrer">Youtube</a>',
    'validation_error' => 'The option chosen for "Timing Method C" is invalid'
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
    'description' => 'A save file that has been pre-modified and loaded onto your memory card, having set the intro cutscene, 
        FLUDD cutscene, courtroom cutscene  and officer\'s speech cutscene to watched, allowing them to be skipped. Runs that 
        use this timing method would start with 5:39.96 on the timer to account for skipped cutscenes.
        <br><br>Sample: <a href="https://www.youtube.com/watch?v=iXBclBuSyew" target="_blank" rel="noreferrer">Youtube</a>',
    'validation_error' => 'The option chosen for "Timing Method D" is invalid'
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
    'description' => 'A save file that has been pre-modified and loaded onto your 
      memory card, having set all cutscene flags to watched (Exceptions: pinna 1 
      and pinna unlock cutscenes), allowing them to be skipped. Runs that use this 
      timing method would start with 7:07.08 on the timer to account for skipped 
      cutscenes.',
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
